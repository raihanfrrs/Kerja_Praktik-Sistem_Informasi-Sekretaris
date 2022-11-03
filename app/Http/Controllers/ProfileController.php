<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\detail_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->level == 'mahasiswa'){
            $data = [
                'data' => mahasiswa::all()->where('user_id', auth()->user()->id)
            ];
        }else{
            $data = [
                'data' => dosen::all()->where('user_id', auth()->user()->id),
                'roles' => detail_role::all()->where('dosen_id', auth()->user()->id)
            ];
        }

        return view('profile')->with([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mahasiswa $mahasiswa, dosen $dosen)
    {
        $rules =[
            'name' => 'required|max:225|min:3|regex:/^[\pL\s\-]+$/u',
            'birthPlace' => 'required|max:225|min:3',
            'birthDate' => 'required',
            'gender' => 'required'
        ];

        if(auth()->user()->level == 'mahasiswa'){
            if($request->npm != $mahasiswa->npm){
                $rules['npm'] = 'required|numeric|unique:mahasiswas';
            }
            if($request->email != $mahasiswa->email){
                $rules['email'] = 'required|email:dns|max:255|unique:mahasiswas';
            }
            if($request->phone != $mahasiswa->phone){
                $rules['phone'] = 'required|numeric|unique:mahasiswas';
            }
        }else{
            if($request->nip != $dosen->nip){
                $rules['nip'] = 'required|numeric|unique:dosens';
            }
            if($request->email != $dosen->email){
                $rules['email'] = 'required|email:dns|max:255|unique:dosens';
            }
            if($request->phone != $dosen->phone){
                $rules['phone'] = 'required|numeric|unique:dosens';
            }
        }

        $validateData = $request->validate($rules);

        if(auth()->user()->level == 'mahasiswa'){
            
            mahasiswa::where('user_id', auth()->user()->id)
                        ->update($validateData);
            
            return redirect('mahasiswa/profile');
        }else{
            dosen::where('user_id', auth()->user()->id)
                        ->update($validateData);
            
            return redirect(auth()->user()->level.'/profile');
        }
    }

    public function updatePassword(Request $request){
        $request->validate([
            'oldPassword' => 'required',
            'password' => ['required', Password::min(5)->mixedCase()->letters()->numbers()->symbols()->uncompromised()]
        ]);

        if(!Hash::check($request->oldPassword, auth()->user()->password)){
            return back()->with([
                'case' => 'default',
                'type' => 'danger',
                'message' => "Old Password Doesn't match!"
            ]);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Password changed successfully'
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
        //
    }
}
