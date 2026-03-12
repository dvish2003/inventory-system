<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use ApiResponse;


    //save user
    public function saveUser(Request $request){
       try {
     $request -> validate([
             'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:Admin,Staff',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return $this->error('Email already exists', 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        return $this->success($user, 'User created successfully');
       } catch (Exception $e) {
        return $this->error($e->getMessage(), 500);
       }
    }

    // login user and send token
 public function loginUser(Request $request){
    try {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->error('Invalid email or password', 401);
        }

        // Get user data by email
        $user = User::where('email', $request->email)->first();

        return $this->success([
            'token' => $token,
            'userData' => $user
        ], 'Login successful');

    } catch (Exception $e) {
        return $this->error($e->getMessage(), 500);
    }
}

    //get All User. use check jwt token in middleware
    public function getAllUsers(){
        $users = User::all();
        return $this->success($users, 'Users retrieved successfully');
    }

    // update User
    public function updateUser(Request $request) {
       try {
         $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:users,email,' . $request->id,
            'password' => 'sometimes|required|string|min:6',
            'role' => 'sometimes|required|string|in:Admin,Staff',
        ]);

        $user = User::find($request->id);
        if (!$user) {
            return $this->error('User not found', 404);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        $user->save();

        return $this->success($user, 'User updated successfully');

       } catch (Exception $e) {
        return $this->error($e->getMessage(), 500);
       }    }

    // delete User
    public function deleteUser(Request $request){
     try {
$user = User::where('email', $request->email)->first();        if (!$user) {
            return $this->error('User not found', 404);
        }
        $user->delete();
        return $this->success(null, 'User deleted successfully');
     } catch (Exception $e) {
        return $this->error($e->getMessage(), 500);
     }
    }

}
