<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function account_request_view(){

        $users = User::whereIn('status', ['submitted', 'rejected'])->get();
        $residents = Resident::whereNull('user_id', 'null')->get();
        return view("pages.account-request.index",
        ["users"=>$users,
        "residents"=>$residents
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

public function change_password_view(){
    return view('pages.profile.change-password');
}
public function change_password(Request $request, $userid)
{
    $user = User::findOrFail($userid);

    $validated = $request->validate([
        'old_password' => ['required'],
        'new_password' => ['required', 'min:8'],
    ]);

    if (!Hash::check($validated['old_password'], $user->password)) {
        return back()->with('error', 'Password lama salah.');
    }

    $user->password = Hash::make($validated['new_password']);
    $user->save();

    return redirect()->route('profile')->with('success', 'Password berhasil diubah.');
}
}