<?php

namespace App\Modules\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ];

    private array $credentailRules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    public function registerUser($data) : bool
    {
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) { return false; }
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return true;
    }

    public function login($data) : ?string
    {
        $validator = Validator::make($data, $this->credentailRules);
        if ($validator->fails()) { return null; }
        $request = new Request($data);
        $credentials = $request->only('email', 'password');
        return auth()->attempt($credentials);
    }
}
