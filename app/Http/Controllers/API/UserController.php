<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        // return ['my-message'=> 'This is my message'];
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return ['message'=> 'I have your data'];
        // return $request->all();

       $this->validateData(0); // I put an 0 params just to read the validation, 0 has nothing to do with this

        return User::create([
            'name' => $request['name'],
            'position' => $request['position'],
            'email' => $request['email'],
            'bio' => $request['bio'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]);

    }


    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        // return $request->photo; //same with $request['photo']

        $this->validateData($user->id);

        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            // use the class image for intervention then the make function
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            // $request->photo = $name; //or this one
            $request->merge(['photo'=>$name]);

        }

        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);    
        }

        $user->update($request->all());

        return ["message" => "Successfully updated profile"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validateData($id);

        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);    
        }
        

        $user->update($request->all());

        return ['message' => 'Successfully updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    private function validateData($id)
    {
        // $user = User::findOrFail($id);
            request()->validate([
            'name' => 'required',
            'position' => 'required',
            'email' => 'required|string|email|unique:users,email,'.$id,
            'type' => 'required',
            'password' => 'sometimes|min:6',
        ]);
    }
}
