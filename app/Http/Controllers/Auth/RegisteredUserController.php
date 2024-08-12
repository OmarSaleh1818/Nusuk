<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:255'],
            'organization_email' => ['required', 'string', 'email', 'max:255'],
            'organization_region' => ['required', 'string', 'max:255'],
            'organization_city' => ['required', 'string', 'max:255'],
            'manager_name' => ['required', 'string', 'max:255'],
            'manager_mobile' => ['required', 'string', 'max:255'],
            'manager_email' => ['required', 'string', 'email', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_mobile' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'contact_job_title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'organization_name' => $request->organization_name,
            'license_number' => $request->license_number,
            'organization_email' => $request->organization_email,
            'organization_region' => $request->organization_region,
            'organization_city' => $request->organization_city,
            'manager_name' => $request->manager_name,
            'manager_mobile' => $request->manager_mobile,
            'manager_email' => $request->manager_email,
            'contact_name' => $request->contact_name,
            'contact_mobile' => $request->contact_mobile,
            'email' => $request->email,
            'contact_job_title' => $request->contact_job_title,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
