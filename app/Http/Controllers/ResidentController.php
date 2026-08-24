<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Resident;

class ResidentController extends Controller
{
   public function index()
{
    $residents = Resident::with('user')->paginate(10);
    $residentCount = $residents->count();
    return view('pages.resident.index', ['residents' => $residents, 'residentCount' => $residentCount]);
}
    public function create()
    {
        return view('pages.resident.create');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'unique:residents,nik','min:10','max:25'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'place_of_birth' => ['required', 'max:50'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'max:200'],    
            'religion' => ['required', 'in:islam,katholik,kristen,hindu,budha,khonghucu'],
            'marital_status' => ['required', 'in:single,married,widower,widow'],
            'occupation' => ['nullable', 'max:100'],
            'phone' => ['required', 'max:15'],
            'status' => ['required', 'in:aktif,pindahan,meninggal']
        ]);

        Resident::create($validatedData);

        return redirect('/resident')->with('success', 'Resident created successfully.');
    }

    public function update(Request $request, $id)
{
    $resident = Resident::findOrFail($id);

    $validatedData = $request->validate([
        'nik' => ['required', 'unique:residents,nik,' . $resident->id, 'min:10', 'max:25'],
        'name' => ['required', 'max:100'],
        'gender' => ['required', 'in:male,female'],
        'place_of_birth' => ['required', 'max:50'],
        'date_of_birth' => ['required', 'date'],
        'address' => ['required', 'max:200'],
        'religion' => ['required', 'in:islam,katholik,kristen,hindu,budha,khonghucu'],
        'marital_status' => ['required', 'in:single,married,widower,widow'],
        'occupation' => ['nullable', 'max:100'],
        'phone' => ['required', 'max:15'],
        'status' => ['required', 'in:aktif,pindahan,meninggal'],
    ]);

    $resident->update($validatedData);

    return redirect()->route('resident.index')->with('success', 'Resident updated successfully.');
}

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('pages.resident.edit', ['resident' => $resident]);
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
        return redirect('/resident')->with('success', 'Resident deleted successfully.');
    }
}
