<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateures;
use App\Models\Document;
use App\Models\News;
use App\Models\Leave;
use App\Models\Attendance;
use App\Models\logs;
use Carbon\Carbon;

class Employe extends Controller
{
    public function dashboard()
    {
        $employeeId = session('employe_id');
        $employee = Utilisateures::find($employeeId);
        $employeDepartement = $employee['Departement'];
        $teammembers = Utilisateures::where('Departement', $employeDepartement)->count();
        $documentreqs = Document::where('status', 'pending')
                                ->where('employee_id', $employeeId)
                                ->count();
        $leavereqs = Leave::where('status', 'pending')
                                ->where('employee_id', $employeeId)
                                ->count();
        $news = News::latest()->take(3)->get();
        return view('Employe.layouts.dashboard' , compact('employee','teammembers','documentreqs','leavereqs','news'));
    }
    public function logs()
    {
        $logs = logs::where('user_id', session('employe_id'))->latest()->paginate(10);
        return view('Employe.layouts.logs', compact('logs'));
    }
    public function allnews(){
        $news = News::paginate(2);
        return view('Employe.layouts.allnewsemp', compact('news'));
    }
    public function profile(){
         $employee = Utilisateures::findOrFail(session('employe_id'));
         return view('Employe.layouts.profile', compact('employee'));
    }
    public function profileview()
    {
        $employee = Utilisateures::findOrFail(session('employe_id'));
        return view('Employe.layouts.profileview', compact('employee'));
    }
    public function editprofilesection()
    {
        $employee = Utilisateures::find(session('employe_id'));
        return view('Employe.layouts.editempsection', compact('employee'));
    }
    public function updateemployeesection(Request $request){
        $employee = Utilisateures::findOrFail(session('employe_id'));

        $validated = $request->validate([
            'nomComplet' => 'required|string|max:255',
            'CIN' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'dateNaissance' => 'nullable|date',
            'statutMarital' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $originalName = $file->getClientOriginalName();
                $destination = public_path('images');

                if (!\File::exists($destination)) {
                    \File::makeDirectory($destination, 0755, true);
                }
                if ($employee->photo && \File::exists(public_path($employee->photo))) {
                    \File::delete(public_path($employee->photo));
                }
                $file->move($destination, $originalName);

                $validated['photo'] = 'images/' . $originalName;
            }

            $employee->update($validated);

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Profile Updated',
                'details' => "User updated their profile: {$employee->nomComplet} (Email: {$employee->email})",
                'status' => 'success',
            ]);

            return view('Employe.layouts.profileview', compact('employee'));
    }
    public function index()
    {
        $attendances = Attendance::where('user_id', session('employe_id'))->get();
        return view('Employe.layouts.attendance', compact('attendances'));
    }

    public function attendancestore(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
        ]);
        
            if ($validated['date'] > now()->toDateString()) {
                return redirect()->route('EMattendance.index')->with('error', 'Day chosen is incorrect.');
            }

            $attendance = Attendance::create([
                'user_id' => session('employe_id'),
                'date' => $validated['date'],
                'status' => $validated['status'],
            ]);

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Attendance Marked',
                'details' => "Marked attendance for date {$validated['date']} as {$validated['status']}",
                'status' => 'success',
            ]);

            return redirect()->route('EMattendance.index')->with('success', 'Attendance marked successfully.');
    }
    public function create()
    {
        return view('Employe.layouts.submit-leave');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_reason' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Leave::create([
            'employee_id' =>  session('employe_id'),
            'employee_name' =>  session('name'),
            'leave_reason' => $request->leave_reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);
        logs::create([
            'user_id' => session('employe_id'),
            'action' => 'Leave Request',
            'details' => "Leave requested on " . now()->format('Y-m-d') . " from {$request->start_date} to {$request->end_date}.",
            'status' => 'success',
        ]);

        return redirect()->route('employee.leave-requests')->with('success', 'Leave request submitted successfully.');
    }

    public function leaves()
    {
        $leaves = Leave::where('employee_id',  session('employe_id'))->latest()->paginate(10);
        return view('Employe.layouts.leave-requests', compact('leaves'));
    }
    public function cancel(Leave $leave)
    {
        if ($leave->employee_id !== session('employe_id')) {
            return redirect()->route('employee.leave-requests')->with('error', 'Unauthorized action.');
        }

        if ($leave->status !== 'pending') {
            return redirect()->route('employee.leave-requests')->with('error', 'Only pending leave requests can be canceled.');
        }

        $leave->delete();

        logs::create([
        'user_id' => session('employe_id'),
        'action' => 'Cancel Leave Request',
        'details' => "Canceled leave request from {$leave->start_date} to {$leave->end_date} on " . now()->format('Y-m-d') . ".",
        'status' => 'success',
        ]);

        return redirect()->route('employee.leave-requests')->with('success', 'Leave request canceled successfully.');
    }

    public function createdoc()
    {
        return view('Employe.layouts.submit-document');
    }

    public function storedoc(Request $request)
    {
        $request->validate([
            'document_title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Document::create([
            'employee_id' => session('employe_id'),
            'employee_name' => session('name'),
            'document_title' => $request->document_title,
            'description' => $request->description,
            'status' => 'pending',
        ]);
        logs::create([
        'user_id' => session('employe_id'),
        'action' => 'Document Request',
        'details' => "Requested document '{$request->document_title}' on " . now()->format('Y-m-d') . ".",
        'status' => 'success',
        ]);

        return redirect()->route('employee.document-requests')->with('success', 'Document request submitted successfully.');
    }

    public function docs()
    {
        $documents = Document::where('employee_id', session('employe_id'))->latest()->paginate(9);
        return view('Employe.layouts.document-requests', compact('documents'));
    }

    public function canceldoc(Document $document)
    {
        if ($document->employee_id !== session('employe_id')) {
            return redirect()->route('employee.document-requests')->with('error', 'Unauthorized action.');
        }

        if ($document->status !== 'pending') {
            return redirect()->route('employee.document-requests')->with('error', 'Only pending document requests can be canceled.');
        }

        $document->delete();

        logs::create([
        'user_id' => session('employe_id'),
        'action' => 'Cancel Document Request',
        'details' => "Canceled document request '{$document->document_title}' on " . now()->format('Y-m-d') . ".",
        'status' => 'success',
        ]);

        return redirect()->route('employee.document-requests')->with('success', 'Document request canceled successfully.');
    }
    public function teammembers(){
        $employee = Utilisateures::find(session('employe_id'));
        $employeDepartement = $employee['Departement'];
        $employees = Utilisateures::where('Departement', $employeDepartement)->paginate(10);
        return view('Employe.layouts.teammembers', compact('employees'));
    }
    public function incomdocs(){
        $documents = Document::whereIn('status', ['pending' , 'in_progress' , 'approved'])
                               ->where('employee_id', session('employe_id'))
                               ->latest()
                               ->paginate(10);
        return view('Employe.layouts.incomdocs', compact('documents'));
    }
    public function pendingleaves(){
        $leaves = Leave::where('status', 'pending')
                        ->where('employee_id',  session('employe_id'))
                        ->latest()
                        ->paginate(10);
        return view('Employe.layouts.pendingleaves', compact('leaves'));
    }
    
}
