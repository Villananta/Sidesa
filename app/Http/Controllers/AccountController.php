<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account_request_view(){

        $users = User::whereIn('status', ['submitted', 'rejected'])->get();
        return view("pages.account-request.index",
        ["users"=>$users,
        ]);
        
    }

    public function approve($id)
{
    $user = User::findOrFail($id);
    $user->status = 'approved';
    $user->save();

    return redirect()->route('account.request')->with('success', 'Akun berhasil disetujui.');
}

public function reject($id)
{
    $user = User::findOrFail($id);
    $user->status = 'rejected';
    $user->save();

    return redirect()->route('account.request')->with('success', 'Akun berhasil ditolak.');
}

public function activate($id)
{
    $user = User::findOrFail($id);
    $user->status = 'approved';
    $user->save();

    return back()->with('success', 'Akun berhasil diaktifkan.');
}

public function deactivate($id)
{
    $user = User::findOrFail($id);
    $user->status = 'rejected';
    $user->save();

    return back()->with('success', 'Akun berhasil dinonaktifkan.');
}

public function account_list_view()
{
     $users = User::where('role_id', '2')->where( 'status', '!=', 'submitted')->get();
        return view("pages.account-list.index",
        ["users"=>$users,
        ]);
}

public function profile_view(){


    return view('pages.profile.index');

}

public function updateProfile(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => ['required', 'max:100'],
    ]);

    $user->name = $validated['name'];
    $user->save();

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
}

public function change_password(){
    return view('pages.profile.change-password');
}
}
