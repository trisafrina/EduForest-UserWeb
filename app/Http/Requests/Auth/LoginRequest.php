<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = $this->string('email')->trim();
        $password = $this->string('password');

        // CHECK 1: Search inside the 'admins' table first
        $account = DB::table('admins')->where('email', $email)->first();
        $isAdmin = true;

        // CHECK 2: If not found in 'admins', search inside the 'users' table
        if (! $account) {
            $account = DB::table('users')->where('email', $email)->first();
            $isAdmin = false;
        }

        // Error if the email does not exist in either table
        if (! $account) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'The email address provided is not registered in our system.',
            ]);
        }

        // PASSWORD VERIFICATION (Supports plain text for easy prototyping testing)
        $isPasswordCorrect = false;
        if (Hash::check($password, $account->password)) {
            $isPasswordCorrect = true; 
        } elseif ($password === $account->password) {
            $isPasswordCorrect = true; 
        }

        if (! $isPasswordCorrect) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // SESSION REGISTRATION
        if ($isAdmin) {
            session([
                'admin_logged_in' => true,
                'admin_id'        => $account->id,
                'admin_email'     => $account->email,
                'admin_name'      => $account->full_name ?? 'Admin'
            ]);
        } else {
            session([
                'user_logged_in' => true,
                'user_id'        => $account->id,
                'user_email'     => $account->email,
                'user_name'      => $account->name ?? 'User'
            ]);
        }

        // Log into Laravel standard Auth Guard dynamically if user model matches
        $userModel = \App\Models\User::where('email', $account->email)->first();
        if ($userModel) {
            Auth::login($userModel, $this->boolean('remember'));
        } else {
            Auth::shouldUse('web');
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}