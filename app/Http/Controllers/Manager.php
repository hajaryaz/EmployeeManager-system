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

class Manager extends Controller
{
    public function dashboard()
    {
        $employeeId = session('employe_id');
        $employee = Utilisateures::find($employeeId);
        $activeEmployees = Utilisateures::whereIn('etat', ['Actif'])->count();
        $inactiveemployees = Utilisateures::whereIn('etat', ['Inactif'])->count();
        $documentreqs = Document::whereIn('status', ['pending'])->count();
        $news = News::latest()->take(3)->get();
        return view('Manager.layouts.dashboard', compact('employee', 'activeEmployees', 'documentreqs', 'inactiveemployees', 'news'));
    }
    public function allemployees()
{
    $department = Utilisateures::where('id', session('employe_id'))->value('Departement');

    $employees = Utilisateures::where('Departement', $department)->paginate(6);

    return view('Manager.layouts.allemployees', compact('employees'));
}

    public function viewprofile($id)
    {
        $employee = Utilisateures::find($id);
        return view('Manager.layouts.viewprofile', compact('employee'));
    }
   public function searchEmployees(Request $request)
{
    $department = Utilisateures::where('id', session('employe_id'))->value('Departement');

    $search = $request->query('search', '');

    $employees = Utilisateures::where('Departement', $department)
        ->when($search, function ($query, $search) {
            return $query->where('nomComplet', 'like', '%' . $search . '%');
        })->paginate(6);

    $employees->appends(['search' => $search]);

    return view('Manager.layouts.searchresults', compact('employees', 'search'));
}

    public function documentsreqs()
{
    $department = Utilisateures::where('id', session('employe_id'))->value('Departement');

    $documents = Document::whereIn('status', ['pending', 'in_progress', 'approved'])
        ->whereHas('employee', function ($query) use ($department) {
            $query->where('Departement', $department);
        })
        ->paginate(8);

    return view('Manager.layouts.documentRequests', compact('documents'));
}

    public function leavesreqs()
{
    $department = Utilisateures::where('id', session('employe_id'))->value('Departement');

    $today = Carbon::today();

    $leaves = Leave::whereDate('end_date', '>=', $today)
        ->whereHas('employee', function ($query) use ($department) {
            $query->where('Departement', $department);
        })
        ->paginate(8);

    return view('Manager.layouts.allleaves', compact('leaves'));
}

        public function mylogs()
    {
        $logs = logs::where('user_id', session('employe_id'))->latest()->paginate(8);
        return view('Manager.layouts.mylogs', compact('logs'));
    }
        public function alllogs()
    {
        $myDepartment = Utilisateures::where('id', session('employe_id'))->value('Departement');

        $logs = logs::whereHas('user', function ($query) use ($myDepartment) {
            $query->where('Departement', $myDepartment);
        })->with('user') 
        ->latest()
        ->paginate(8);
        return view('Manager.layouts.alllogs', compact('logs'));
    }
     public function index()
    {
        $attendances = Attendance::where('user_id', session('employe_id'))->get();
        return view('Manager.layouts.attendance', compact('attendances'));
    }

    public function attendancestore(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
        ]);
        
            if ($validated['date'] > now()->toDateString()) {
                return redirect()->route('MAattendance.index')->with('error', 'Day chosen is incorrect.');
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

            return redirect()->route('MAattendance.index')->with('success', 'Attendance marked successfully.');
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
        return view('Manager.layouts.allnews', compact('news'));
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

        $news = News::paginate(4);
        return view('Manager.layouts.allnews', compact('news'));
    }

    public function editnewsview($id)
    {
        $news = News::find($id);
        return view('Manager.layouts.editnews', compact('news'));
    }

    public function updatenews(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'published_at' => 'required|date',
            'author' => 'nullable|string|max:255',
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
    public function showaattendences(Request $request)
    {
        $department = Utilisateures::where('id', session('employe_id'))->value('Departement');

        $validated = $request->validate([
            'date' => 'nullable|date_format:Y-m-d',
        ]);

        $date = $validated['date'] ?? null;

        $query = Attendance::with('user')
            ->whereHas('user', function ($q) use ($department) {
                $q->where('Departement', $department);
            });

        if ($date) {
            $query->whereDate('date', $date);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(8);
        $attendances->appends(['date' => $date]);

        return view('Manager.layouts.attendancess', compact('attendances'));
    }
    public function profile()
    {
        $employee = Utilisateures::findOrFail(session('employe_id'));
        return view('Manager.layouts.profile', compact('employee'));
    }
        public function profilesection()
    {
        $employee = Utilisateures::find(session('employe_id'));
        return view('Manager.layouts.profilesection', compact('employee'));
    }
    public function editemployeesection()
    {
        $employee = Utilisateures::find(session('employe_id'));
        return view('Manager.layouts.editempsection', compact('employee'));
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

            return view('Manager.layouts.profilesection', compact('employee'));
    }

}
