<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // encript dengan hash
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // upload data gambar ke server 

class UserController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
            'phone'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'image'     => $request->image,
            'phone'     => $request->phone,
            'pin'       => $request->pin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data'    => $user  
        ]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Success!',
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken    
        ]);
    }

    public function logout(Request $request){
        $removeToken = $request->user()->tokens()->delete();

        if($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',  
            ]);
        }
    }

    // public function uploadImage(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'image' => 'required|image|max:2048|mimes:png,jpg,jpeg',
    //     ]);

    //     // upload image
    //     $image = $request->file('image');
    //     $image->storeAs('public/users', $image->hashName());

    //     $user = User::create([
    //         'image' => $image->hashName(),
    //     ]);

    //     if($user) {
    //         // redirect pesan sukses
    //         return redirect()->route('dashboard.Index')->with([
    //             'success' => 'Data berhasil disimpan'
    //         ]);
    //     } else {
    //         // pesan error
    //         return redirect()->route('dasboard.Index')->with([
    //             'error' => 'Data gagal disimpan!'
    //         ]);
    //     }


    // }
}