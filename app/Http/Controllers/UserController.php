<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected function guard() {
        return Auth::guard();
    }

    /**
     * @param array $data
     * @return Application|Factory|Validator
     */
    protected function validator(array $data)
    {
        return Validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['requided', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Team::create([
            'user_id' => $user->id,
            'name' => 'Personal',
            'personal_team' => true
        ]);

        $this->guard()->login($user);

        return response()->json([
            'user' => $user,
            'message' => 'Registration Successful!'
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
           return response()->json([
               'message' => 'Login Successful'
           ], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logout Successful'
        ], 200);
    }

}
