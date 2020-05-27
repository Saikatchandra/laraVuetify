<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['roles'=> Role::all()],200);
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
       $role =  Role::create([
            'name' => $request->name,
        ]);
        return response()->json(['role'=>$role], 200);
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

<<<<<<< HEAD
    
=======
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

>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
<<<<<<< HEAD
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        return response()->json(['role' => $role], 200);
=======
        //
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
<<<<<<< HEAD
        $role = Role::find($id);
        $role->delete();
        return response()->json(['role' => $role], 200);
=======
        //
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
    }
}
