<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return Inertia::render('UserShow', [
            'user' => $user,
        ]);
    }

    public function update(User $user)
    {
        Request::validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
        ]);

        if (Request::get('password')) {
            Request::validate([
                'password' => [Rules\Password::defaults()],
            ]);

            $user->update(['password' => Hash::make(Request::get('password'))]);
        }

        $user->update(Request::only('name', 'email'));

        return Redirect::back()->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }
}
