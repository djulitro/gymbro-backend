<?php

namespace App\Http\Controllers\Auth;

use App\Constants\UserTypeConst;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            // Cargamos la organización y el tipo de usuario
            $user->load('organization', 'userType');

            return response()->json([
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'user_type_id' => 'required|exists:user_types,id',
        ]);

        $organization = auth()->user()->organization;

        $user = new User();
        $user->organization_id = $organization->id;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->user_type_id = $request->user_type_id;
        $user->save();

        return response()->json([
            'message' => 'User created successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        $user->load('organization', 'userType');

        return response()->json([
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $authUser = auth()->user();

        $user = User::find($id);

        if ($authUser->user_type_id == UserTypeConst::ADMIN && $user->user_type_id == UserTypeConst::SUPER_ADMIN) {
            return response()->json([
                'error' => 'You do not have permission to delete this user'
            ], 403);
        }

        if ($user) {
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        }

        return response()->json([
            'error' => 'User not found'
        ], 404);
    }
}
