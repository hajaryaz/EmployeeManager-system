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

class RH extends Controller
{
    public function dashboard()
    {
        $employeeId = session('employe_id');
        $employee = Utilisateures::find($employeeId);
        $activeEmployees = Utilisateures::whereIn('etat', ['Actif'])->count();
        $inactiveemployees = Utilisateures::whereIn('etat', ['Inactif'])->count();
        $documentreqs = Document::whereIn('status', ['pending'])->count();
        $news = News::latest()->take(3)->get();
        return view('RH.layouts.dashboard', compact('employee', 'activeEmployees', 'documentreqs', 'inactiveemployees', 'news'));
    }

    public function allemployees()
    {
        $employees = Utilisateures::paginate(6);
        return view('RH.layouts.allemployees', compact('employees'));
    }

    public function searchEmployees(Request $request)
    {
        $search = $request->query('search', '');
        $employees = Utilisateures::when($search, function ($query, $search) {
            return $query->where('nomComplet', 'like', '%' . $search . '%');
        })->paginate(2);

        $employees->appends(['search' => $search]);

        return view('RH.layouts.searchresults', compact('employees', 'search'));
    }

    public function viewprofile($id)
    {
        $employee = Utilisateures::find($id);
        return view('RH.layouts.viewprofile', compact('employee'));
    }

    public function deleteemployee($id)
    {
        $employee = Utilisateures::findOrFail($id);
        $employeeName = $employee->nomComplet;
        $employee->delete();

        logs::create([
            'user_id' => session('employe_id'),
            'action' => 'Employee Deleted',
            'details' => "Deleted employee: {$employeeName}",
            'status' => 'success',
        ]);

        $employees = Utilisateures::paginate(6);
        return view('RH.layouts.allemployees', compact('employees'));
    }

    public function editemployee($id)
    {
        $employee = Utilisateures::find($id);
        return view('RH.layouts.editemployee', compact('employee'));
    }

    public function updateemployee(Request $request, $id)
    {
        $employee = Utilisateures::findOrFail($id);

        $validated = $request->validate([
            'nomComplet' => 'required|string|max:255',
            'CIN' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'dateNaissance' => 'nullable|date',
            'sexe' => 'nullable|in:Homme,Femme',
            'dateEmbauche' => 'nullable|date',
            'statutMarital' => 'nullable|string|max:50',
            'salaire' => 'nullable|numeric',
            'typeContrat' => 'nullable|string|max:50',
            'niveauEtude' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'Fonction' => 'nullable|string|max:255',
            'Departement' => 'nullable|string|max:255',
            'etat' => 'required|in:Actif,Inactif,Suspendu',
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
                'action' => 'Employee Updated',
                'details' => "Updated employee: {$employee->nomComplet} (Email: {$employee->email})",
                'status' => 'success',
            ]);

            return view('RH.layouts.viewprofile', compact('employee'));
    }

    public function addemp(Request $request)
    {
        $validated = $request->validate([
            'profile' => 'nullable|in:employe,RH,Manager',
            'nomComplet' => 'required|string|max:255',
            'CIN' => 'required|string|max:255|unique:utilisateures,CIN',
            'email' => 'required|email|max:255',
            'motdepasse' => 'required|nullable|string|min:6',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'dateNaissance' => 'nullable|date',
            'sexe' => 'nullable|in:Homme,Femme',
            'dateEmbauche' => 'nullable|date',
            'statutMarital' => 'nullable|string|max:50',
            'salaire' => 'nullable|numeric',
            'typeContrat' => 'nullable|string|max:50',
            'niveauEtude' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'Fonction' => 'required|string|max:255',
            'Departement' => 'required|string|max:255',
            'etat' => 'required|in:Actif,Inactif,Suspendu',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $originalName = $file->getClientOriginalName();
                $destination = public_path('images');

                if (!\File::exists($destination)) {
                    \File::makeDirectory($destination, 0755, true);
                }
                $file->move($destination, $originalName);

                $validated['photo'] = 'images/' . $originalName;
            }

            $employee = new Utilisateures($validated);
            $employee->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Employee Added',
                'details' => "Added employee: {$employee->nomComplet} (Email: {$employee->email})",
                'status' => 'success',
            ]);

            return redirect()->back()->with('success', 'Employee registered successfully!');
    }

    public function documentsreqs()
    {
        $documents = Document::whereIn('status', ['pending', 'in_progress', 'approved'])->paginate(8);
        return view('RH.layouts.documentRequests', compact('documents'));
    }

    public function updatedocsstatus(Request $request, $documentId)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,approved,rejected,completed',
            'rejection_reason' => 'required_if:status,rejected|string|nullable',
        ]);

            $document = Document::findOrFail($documentId);
            $document->status = $validated['status'];
            $document->rejection_reason = $validated['rejection_reason'] ?? null;
            $document->processed_by = session('employe_id');
            $document->processed_at = now();
            $document->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Document Status Updated',
                'details' => "Updated document ID {$documentId} to status: {$validated['status']}",
                'status' => 'success',
            ]);

            return redirect()->route('documentsreqs')->with('success', 'Document status updated successfully');
    }

    public function updatecompletedocsstatus(Request $request, $documentId)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,approved,rejected,completed',
            'rejection_reason' => 'required_if:status,rejected|string|nullable',
        ]);

            $document = Document::findOrFail($documentId);
            $document->status = $validated['status'];
            $document->rejection_reason = $validated['rejection_reason'] ?? null;
            $document->processed_by = session('employe_id');
            $document->processed_at = now();
            $document->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Completed Document Status Updated',
                'details' => "Updated completed document ID {$documentId} to status: {$validated['status']}",
                'status' => 'success',
            ]);

         return redirect()->route('completeddocsreqs')->with('success', 'Document status updated successfully');
    }

    public function completeddocs()
    {
        $documents = Document::whereIn('status', ['completed'])->paginate(8);
        return view('RH.layouts.completeddocs', compact('documents'));
    }

    public function pubnews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'published_at' => 'required|date',
            'author' => 'required|string|max:255',
        ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $destination = public_path('images');

                if (!\File::exists($destination)) {
                    \File::makeDirectory($destination, 0755, true);
                }
                $file->move($destination, $originalName);

                $validated['image'] = 'images/' . $originalName;
            }
            $validated['author_id'] = session('employe_id');
            $news = new News($validated);
            $news->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'News Published',
                'details' => "Published news: {$validated['title']}",
                'status' => 'success',
            ]);

        return redirect()->back()->with('success', 'News published successfully!');
    }

    public function allnews()
    {
        $news = News::paginate(4);
        return view('RH.layouts.allnews', compact('news'));
    }

    public function inactiveemp()
    {
        $employees = Utilisateures::whereIn('etat', ['Inactif'])->paginate(6);
        return view('RH.layouts.inactiveemp', compact('employees'));
    }

    public function activeemp()
    {
        $employees = Utilisateures::whereIn('etat', ['actif'])->paginate(6);
        return view('RH.layouts.activeemp', compact('employees'));
    }

    public function deletenews($id)
    {
        $news = News::findOrFail($id);
        $newsTitle = $news->title;
        $news->delete();

        logs::create([
            'user_id' => session('employe_id'),
            'action' => 'News Deleted',
            'details' => "Deleted news: {$newsTitle}",
            'status' => 'success',
        ]);

        $news = News::paginate(2);
        return view('RH.layouts.allnews', compact('news'));
    }

    public function editnewsview($id)
    {
        $news = News::find($id);
        return view('RH.layouts.editnews', compact('news'));
    }

    public function updatenews(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'published_at' => 'required|date',
            'author' => 'required|string|max:255',
        ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = $file->getClientOriginalName();
                $destination = public_path('images');

                if (!\File::exists($destination)) {
                    \File::makeDirectory($destination, 0755, true);
                }
                $file->move($destination, $originalName);

                $validated['image'] = 'images/' . $originalName;
            }
            $validated['author_id'] = session('employe_id');
            $news = News::findOrFail($id);
            $news->update($validated);

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'News Updated',
                'details' => "Updated news: {$validated['title']}",
                'status' => 'success',
            ]);

            return redirect()->back()->with('success', 'News updated successfully!');
    }

    public function leavesreqs()
    {
        $today = Carbon::today();
        $leaves = Leave::whereDate('end_date', '>=', $today)->paginate(8);
        return view('RH.layouts.allleaves', compact('leaves'));
    }

    public function updateleaves(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejected_reason' => 'required_if:status,rejected|string|nullable',
        ]);

            $leave = Leave::findOrFail($id);
            $leave->status = $validated['status'];
            $leave->rejected_reason = $validated['rejected_reason'] ?? null;
            if ($validated['status'] === "pending" || $validated['status'] === "approved") {
                $leave->rejected_reason = null;
            }
            if ($validated['status'] === "approved") {
                $employee = Utilisateures::find($leave->employee_id);
                $employee->etat = 'Inactif';
                $employee->save();
            }
            if ($validated['status'] === "pending" || $validated['status'] === "rejected") {
                $employee = Utilisateures::find($leave->employee_id);
                $employee->etat = 'Actif';
                $employee->save();
            }

            $leave->processed_by = session('employe_id');
            $leave->processed_at = now();
            $leave->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Leave Request Updated',
                'details' => "Updated leave request ID {$id} to status: {$validated['status']}",
                'status' => 'success',
            ]);

            return redirect()->route('leavesreqs')->with('success', 'Leave request updated successfully');
    }

    public function updateapprovedleaves(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejected_reason' => 'required_if:status,rejected|string|nullable',
        ]);

            $leave = Leave::findOrFail($id);
            $leave->status = $validated['status'];
            $leave->rejected_reason = $validated['rejected_reason'] ?? null;
            if ($validated['status'] === "pending" || $validated['status'] === "approved") {
                $leave->rejected_reason = null;
            }
            if ($validated['status'] === "approved") {
                $employee = Utilisateures::find($leave->employee_id);
                $employee->etat = 'Inactif';
                $employee->save();
            }
            if ($validated['status'] === "pending" || $validated['status'] === "rejected") {
                $employee = Utilisateures::find($leave->employee_id);
                $employee->etat = 'Actif';
                $employee->save();
            }

            $leave->processed_by = session('employe_id');
            $leave->processed_at = now();
            $leave->save();

            logs::create([
                'user_id' => session('employe_id'),
                'action' => 'Approved Leave Request Updated',
                'details' => "Updated approved leave request ID {$id} to status: {$validated['status']}",
                'status' => 'success',
            ]);

            return redirect()->route('approvedleavesreqs')->with('success', 'Leave request updated successfully');
    }

    public function approvedleaves()
    {
        $today = Carbon::today();
        $leaves = Leave::where('status', 'approved')
                       ->whereDate('end_date', '>=', $today)
                       ->paginate(8);
        return view('RH.layouts.approvedleaves', compact('leaves'));
    }

    public function index()
    {
        $attendances = Attendance::where('user_id', session('employe_id'))->get();
        return view('RH.layouts.attendance', compact('attendances'));
    }

    public function attendancestore(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
        ]);
        
            if ($validated['date'] > now()->toDateString()) {
                return redirect()->route('attendance.index')->with('error', 'Day chosen is incorrect.');
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

            return redirect()->route('attendance.index')->with('success', 'Attendance marked successfully.');
    }

    public function profile()
    {
        $employee = Utilisateures::findOrFail(session('employe_id'));
        return view('RH.layouts.profile', compact('employee'));
    }

    public function profilesection()
    {
        $employee = Utilisateures::find(session('employe_id'));
        return view('RH.layouts.profilesection', compact('employee'));
    }

    public function editemployeesection()
    {
        $employee = Utilisateures::find(session('employe_id'));
        return view('RH.layouts.editempsection', compact('employee'));
    }

    public function updateemployeesection(Request $request)
    {
        $employee = Utilisateures::findOrFail(session('employe_id'));

        $validated = $request->validate([
            'nomComplet' => 'required|string|max:255',
            'CIN' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'dateNaissance' => 'nullable|date',
            'sexe' => 'nullable|in:Homme,Femme',
            'dateEmbauche' => 'nullable|date',
            'statutMarital' => 'nullable|string|max:50',
            'salaire' => 'nullable|numeric',
            'typeContrat' => 'nullable|string|max:50',
            'niveauEtude' => 'nullable|string|max:255',
            'competences' => 'nullable|string',
            'Fonction' => 'required|string|max:255',
            'Departement' => 'required|string|max:255',
            'etat' => 'required|in:Actif,Inactif,Suspendu',
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

            return view('RH.layouts.profilesection', compact('employee'));
    }

    public function logs()
    {
        $logs = logs::where('user_id', session('employe_id'))->latest()->paginate(10);
        return view('RH.layouts.logs', compact('logs'));
    }
    public function showaattendences(Request $request){
        $validated = $request->validate([
                'department' => 'nullable|string|max:255',
                'date' => 'nullable|date_format:Y-m-d',
            ]);

            $department = $validated['department'] ?? null;
            $date = $validated['date'] ?? null;

            $query = Attendance::with('user');

            if ($department) {
                $query->whereHas('user', function ($q) use ($department) {
                    $q->where('Departement', $department);
                });
            }
            if ($date) {
                $query->whereDate('date', $date);
            }

            $attendances = $query->orderBy('date', 'desc')->paginate(8);
            $attendances->appends(['department' => $department, 'date' => $date]);

        return view('RH.layouts.attendancess', compact('attendances'));
    }
}