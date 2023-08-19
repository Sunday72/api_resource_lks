<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->get();
        return response()->json($users);
    }

    public function login(Request $request){
        if(Auth::attempt(["email" => $request->email, "password" => $request->password])){
            $auth = Auth::user();
            $success["token"] = $auth->createToken("auth_token")->accessToken;
            $id_user = $success["token"]->id;
            $user = DB::table('personal_access_tokens')->where('id', $id_user)->get();
            $success["name"] = $auth->name;

            return response()->json([
                "success" => true,
                "message" => "Login Berhasil",
                "data" => $user
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Akun tidak ditemukan!",
                "data" => null
            ]);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'failed to register',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input["password"] = Hash::make($input["password"]);
        $user = User::create($input);

        $success["token"] = $user->createToken("auth_token")->plainTextToken;
        $success["name"] = $user->name;

        return response()->json([
            "success" => true,
            "message" => "Registrasi Berhasil!",
            "data" => $success
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            "message" => "Logout berhasil dan token telah dihapus"
        ]);
    }
}
