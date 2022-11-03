<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use App\Models\dosen;
use App\Models\detail_role;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.master.dosen')->with([
            'dosen' => dosen::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.master.create.create_dosen')->with([
            'title' => 'Dosen',
            'roles' => role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|min:5|max:255|unique:users|alpha_num',
            'password' => ['required', Password::min(5)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'name' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'nip' => 'required|numeric|unique:dosens',
            'email' => 'required|min:5|max:255|unique:mahasiswas|email:dns',
            'phone' =>'required|numeric|unique:dosens',
            'birthPlace' => 'required|max:225|min:3',
            'birthDate' => 'required',
            'gender' => 'required',
            'role' => 'required' 
        ]);

        $validateData['level'] = 'dosen';
        $validateData['password'] = bcrypt($validateData['password']);

        $user = User::create($validateData);

        $validateData['user_id'] = $user->id;

        $dosen = dosen::create($validateData);

        for ($i=0; $i < count($request->role); $i++) { 
            $roles['role_id'] = $request->role[$i];
            $roles['dosen_id'] = $dosen->id;
            detail_role::create($roles);
        }

        return redirect('master/dosen')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Add Dosen successfull!.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nip)
    {
        $detail = dosen::firstWhere('nip', $nip);
        return view('superadmin.master.show.show_dosen')->with([
            'title' => 'Dosen',
            'subtitle' => 'Details',
            'dosen' => dosen::all()->where('nip', $nip),
            'roles' => collect(detail_role::all()->where('dosen_id', $detail->id))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nip)
    {
        $detail = dosen::firstWhere('nip', $nip);
        return view('superadmin.master.edit.edit_dosen')->with([
            'title' => 'Dosen',
            'dosen' => dosen::where('nip', $nip)->get(),
            'roles' => role::all(),
            'detail_roles' => detail_role::all()->where('dosen_id', $detail->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dosen $dosen)
    {
        $rules = [
            'name' => 'required|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'birthPlace' => 'required|max:225|min:3',
            'birthDate' => 'required',
            'gender' => 'required'
        ];

        if($request->nip != $dosen->nip){
            $rules['nip'] = 'required|numeric|unique:dosens';
        }

        if($request->email != $dosen->email){
            $rules['email'] = 'required|min:5|max:255|unique:mahasiswas|email:dns';
        }

        if($request->phone != $dosen->phone){
            $rules['phone'] = 'required|numeric|unique:dosens';
        }

        $validateData = $request->validate($rules);
            
        dosen::where('id', $dosen->id)
                    ->update($validateData);

        detail_role::where('dosen_id', $dosen->id)->delete();
        
        for ($i=0; $i < count($request->role); $i++) { 
            $roles['role_id'] = $request->role[$i];
            $roles['dosen_id'] = $dosen->id;
            detail_role::create($roles);
        }

        return redirect('master/dosen')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Edit Dosen Successfull!.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        detail_role::where('dosen_id', $id)->delete();

        dosen::destroy($id);

        return redirect('master/dosen')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Delete Dosen Successfull!.'
        ]);
    }
}
