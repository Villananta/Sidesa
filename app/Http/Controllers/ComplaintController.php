<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(){

        $user = auth()->user();
        
        if($user->role->name == 'Admin'){
            $complaint = Complaint::with('resident')->latest('complaint_date')->paginate(10);

            return view('pages.complaint.index', ['complaints' => $complaint]);

        }

        $resident = $user->resident;
        $complaint = $resident
        ? complaint::where("resident_id", $resident->id)->latest('complaint_date')->paginate(10) : null;
        return view('pages.complaint.index', ['complaints' => $complaint]);
    }

    public function update_status(Request $request, $id){
        $user = auth()->user();
        if($user->role->name !== 'Admin'){
            abort(403);
        }
        $complaint = Complaint::find($id);
        $validate = $request->validate([
            'status' => ['required','in:confirmed,processing,completed,rejected'],
            'response'=> ['nullable','min:10'],
        ]);
        $complaint->update($validate);

        return redirect()->route('complaint.index')->with('success','Pengaduan berhasil diperbarui.');
    }
    
    public function store(Request $request){
    $resident = auth()->user()->resident;

    if(!$resident){
        return back()->with('error','Akun anda belum terkait dengan data penduduk');
    }

    $validated = $request->validate([
        'title' => ['required'],
        'content' => ['required'],
        'photo_prove' => ['nullable', 'image', 'max:2048'], 
    ]);

    if($request->hasFile('photo_prove')){
        $validated['photo_prove'] = $request->file('photo_prove')->store('complaint', 'public');
    }

    $validated['resident_id'] = $resident->id;

    Complaint::create($validated);

    return redirect()->route('complaint.index')->with('success', 'Pengaduan berhasil dikirim.');
}

    public function update(Request $request, $id){
        $complaint = Complaint::findOrFail($id);
        $resident = auth()->user()->resident;

        if (!$resident || $complaint->resident_id !== $resident->id) {
            abort(403);
        }

        if ($complaint->status !== 'confirmed') {
            return back()->with('error', 'Pengaduan yang sudah diproses tidak bisa diedit.');
        }

        $validated = $request->validate([
            'title' => ['required', 'max:150'],
            'content' => ['required'],
            'photo_prove' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo_prove')) {
            if ($complaint->photo_prove) {
                Storage::disk('public')->delete($complaint->photo_prove);
            }
            $validated['photo_prove'] = $request->file('photo_prove')->store('complaints', 'public');
        }

        $complaint->update($validated);

        return redirect()->route('complaint.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $resident = auth()->user()->resident;

        if (!$resident || $complaint->resident_id !== $resident->id) {
            abort(403);
        }

        if ($complaint->status !== 'confirmed') {
            return back()->with('error', 'Pengaduan yang sudah diproses tidak bisa dihapus.');
        }

        if ($complaint->photo_prove) {
            Storage::disk('public')->delete($complaint->photo_prove);
        }

        $complaint->delete();

        return redirect()->route('complaint.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
