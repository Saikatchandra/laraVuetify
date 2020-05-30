<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Profile;
use Auth;
use Illuminate\Support\Str;
use App\Http\Resources\User as UserResource; //this is for single record
use App\Http\Resources\UserCollection;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $per_page = $request->per_page;
        return response()->json([
            'users'=> new UserCollection(User::paginate($per_page)), 
            'roles' => Role::pluck('name')->all() 
        ],200);
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
       $role = Role::where('name', $request->role)->first();  
       $user = new User ([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->role()->associate($role);
        $user->save();
        $user->profile()->save(new Profile());
        return response()->json(['user'=>  new UserResource($user)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::where('name', 'LIKE', "%$id%")->paginate();
         return response()->json(['users' => $users], 200);
    }



    public function update(Request $request, $id)
    {
        $role = Role::where('name', $request->role)->first();
        $user = User::find($id);
        $user->name = $request->name;
        $user->role()->dissociate($user->role);
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();
        Profile::where('user_id',$id)->delete();
        return response()->json(['user' => $user], 200);

    }
    
    public function deleteAll(Request $request){
       $user =  User::whereIn('id', $request->users);
        $user->delete();
        return response()->json(['message' => 'Records Deleted Successfully'], 200);
    }




    public function login(Request $request){
    	// when we send ajax request then we debug by this 
    	// echo json_encode($request->all());exit;
    	$credentials = $request->only('email','password');

    	 if(Auth::attempt($credentials)){
    	 	$token = Str::random(80);
    	 	Auth::user()->api_token = $token;
    	 	Auth::user()->save();
    	   $admin = Auth::user()->isAdmin();
    	    return response()->json(['token'=> $token, 'isAdmin' => $admin],200);
    	 }
        	
    	return response()->json(['status'=> 'Email Or Password is wrong '],403);
    	
    }

    public function verify(Request $request){
    	return $request->user()->only('name','email');
    }

    public function changeRole(Request $request){
        $user = User::find($request->user);
        $loggedInUser = $request->user();
        if($user->id == $loggedInUser->id){
           return response()->json(['user' => new UserResource($loggedInUser)], 422);
        }
        $role = Role::where('name', $request->role)->first();
        $user->role()->associate($role);
        $user->save();
        return response()->json(['user' => new UserResource($user)], 200);
    }

    public function verifyEmail(Request $request){
       $request->validate([
          'email' => 'required|unique:users',
       ]);
       return response()->json(['message' => 'Valid Email'], 200);
    }
}
