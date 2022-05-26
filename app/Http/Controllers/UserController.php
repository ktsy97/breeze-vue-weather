<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return Inertia::render('UserShow', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->password) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => [Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable'],
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return Redirect::back()->with('success', 'User updated.');
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }
}
