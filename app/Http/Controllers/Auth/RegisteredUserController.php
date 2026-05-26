<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $classes = \App\Models\EduClass::all();
        return view('auth.register', compact('classes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:teacher,student'],
            'institution_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'class_id' => ['nullable', 'exists:edu_classes,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'institution_name' => $request->institution_name,
            'phone_number' => $request->phone_number,
        ]);

        // Create the related profile record
        if ($user->role === 'teacher') {
            \App\Models\Teacher::create(['user_id' => $user->id]);
        } elseif ($user->role === 'student') {
            \App\Models\Student::create([
                'user_id' => $user->id,
                'edu_class_id' => $request->class_id ?? (\App\Models\EduClass::first()->id ?? null),
                'roll_number' => 'REG-' . rand(1000, 9999),
                'risk_score' => 0,
                'risk_level' => 'New Student'
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
