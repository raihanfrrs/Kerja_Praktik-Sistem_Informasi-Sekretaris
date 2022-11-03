<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\detail_role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.master.role')->with([
            'role' => role::all(),
            'detail_role' => detail_role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.master.create.create_role')->with([
            'title' => 'Role'
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
            'role' => 'required|min:2|max:255|unique:roles'
        ]);

        role::create($validateData);

        return redirect('master/role')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Add Role successfull!.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $detail = role::firstWhere('slug', $slug);
        return view('superadmin.master.show.show_role')->with([
            'title' => 'Role',
            'roles' => detail_role::all()->where('role_id', $detail->id),
            'subtitle' => $detail->role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('superadmin.master.edit.edit_role')->with([
            'title' => 'Role',
            'role' => role::where('slug', $slug)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        $validateData = $request->validate([
            'role' => 'required|min:2|max:255|unique:roles'
        ]);

        role::where('id', $role->id)
                    ->update($validateData);
        
        return redirect('master/role')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Edit Role Successfull!.'
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
        detail_role::where('role_id', $id)->delete();

        role::destroy($id);

        return redirect('master/role')->with([
            'case' => 'default',
            'type' => 'success',
            'message' => 'Delete Role Successfull!.'
        ]);;
    }
}
