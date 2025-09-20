<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateures;
use App\Models\logs;

class CheckINController extends Controller
{
    public function login(Request $request)
    {
        session()->forget(['errorPassword', 'messagePassword']);
        $request->validate([
            'matricule' => 'required',
            'password' => 'required'
        ]);

        $matricule = $request->input('matricule');
        $password = $request->input('password');

        $employe = Utilisateures::where('matricule', $matricule)->first();

        if (!$employe) {
            $messageE = 'Account not found';
            return view('auth.login', compact('messageE', 'matricule'));
        } elseif ($employe->motdepasse === $password) {
            session([
                'employe_id' => $employe->id,
                'name' => $employe->nomComplet,
                'profile' => $employe->profile,
            ]);

            logs::create([
                'user_id' => $employe->id,
                'action' => 'Login',
                'details' => "User {$employe->nomComplet} logged in",
                'status' => 'success',
            ]);

            switch ($employe->profile) {
                case 'RH':
                    return redirect('/RHdashboard');
                case 'Manager':
                    return redirect('/MAdashboard');
                case 'employe':
                    return redirect('/EMdashboard');
                default:
                    logs::create([
                        'user_id' => $employe->id,
                        'action' => 'Login Failed',
                        'details' => "Unknown role for user {$employe->nomComplet}",
                        'status' => 'failed',
                    ]);
                    return redirect()->back()->with('message', 'Unknown role');
            }
        } else {
            logs::create([
                'user_id' => $employe->id,
                'action' => 'Login Failed',
                'details' => "Incorrect password for matricule: {$matricule}",
                'status' => 'failed',
            ]);
            $messageP = 'Mot de passe incorrect.';
            return view('auth.login', compact('messageP', 'matricule'));
        }
    }

    public function logout(Request $request)
    {
        $userId = session('employe_id');
        if ($userId) {
            $user = Utilisateures::find($userId);
            if ($user) {
                logs::create([
                    'user_id' => $userId,
                    'action' => 'Logout',
                    'details' => "User {$user->nomComplet} logged out",
                    'status' => 'success',
                ]);
            }
        }
        $request->session()->forget(['employe_id', 'name', 'profile']);
        return redirect('/login');
    }

    public function forgotpass()
    {
        return view('auth.forgotpass');
    }

    public function handlerforgotmatricule(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string',
        ]);

        $user = Utilisateures::where('matricule', $request->input('matricule'))->first();

        if ($user) {
            return redirect()->route('forgotpass.handler', ['id' => $user->id]);
        } else {
            $messageE = "This matricule was not found";
            return view('auth.forgotpass', compact('messageE'));
        }
    }

    public function handlerforgotpass(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        $user = Utilisateures::findOrFail($id);

        if ($request->input('password') != $request->input('password_confirmation')) {
            logs::create([
                'user_id' => $user->id,
                'action' => 'Password Reset Failed',
                'details' => "Passwords do not match for user {$user->nomComplet}",
                'status' => 'failed',
            ]);
            session([
                'errorPassword' => 'Passwords do not match.',
            ]);
            return redirect()->back();
        }

        $user->motdepasse = $request->input('password');
        $user->save();

        logs::create([
            'user_id' => $user->id,
            'action' => 'Password Reset',
            'details' => "Password updated for user {$user->nomComplet}",
            'status' => 'success',
        ]);

        session()->flush();
        session([
            'messagePassword' => 'Password updated successfully!',
        ]);
        return redirect()->route('login');
    }

    public function showUpdatePassForm($id)
    {
        $user = Utilisateures::findOrFail($id);
        return view('auth.updatepass', compact('user'));
    }
}