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
}
