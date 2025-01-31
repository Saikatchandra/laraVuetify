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
    public function index(Request $request)
    {
        $per_page = $request->per_page;
        return response()->json(['roles'=> Role::paginate($per_page)],200);
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
        $roles = Role::where('name', 'LIKE', "%$id%")->paginate();
         return response()->json(['roles' => $roles], 200);
    }



    public function update(Request $request, $id)
    {

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        return response()->json(['role' => $role], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $role = Role::find($id);
        $role->delete();
        return response()->json(['role' => $role], 200);

    }
    
    public function deleteAll(Request $request){
       $role =  Role::whereIn('id', $request->roles);
        $role->delete();
        return response()->json(['message' => 'Records Deleted Successfully'], 200);
    }
}
