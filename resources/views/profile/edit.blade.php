@extends('layouts.admin-master')

@section('page-title', 'Account Setting')

@push('styles')
<style>
    .account-form section header h2 { font-size: 1.05rem; font-weight: 700; color: #0f172a; margin: 0 0 0.25rem; }
    .account-form section header p { font-size: 0.8rem; color: #64748b; margin: 0 0 1.25rem; }
    .account-form label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.375rem; text-transform: uppercase; }
    .account-form input[type="text"],
    .account-form input[type="email"],
    .account-form input[type="password"] {
        width: 100%; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; border-radius: 0.75rem;
        font-size: 0.875rem; color: #1e293b; background: #fff; margin-bottom: 1rem;
    }
    .account-form .field-error { color: #ef4444; font-size: 0.75rem; margin-top: -0.6rem; margin-bottom: 0.75rem; }
    .account-form button[type="submit"] { margin-top: 0.25rem; }
</style>
@endpush

@section('content')

    <div class="card-premium account-form">
        <section>
            <header>
                <h2>Profile Information</h2>
                <p>Update your account's name and email address.</p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <label for="name">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->full_name) }}" required autofocus autocomplete="name">
                @error('name') <p class="field-error">{{ $message }}</p> @enderror

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <p class="field-error">{{ $message }}</p> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p style="font-size:0.8rem; color:#64748b; margin-bottom:1rem;">
                        Your email address is unverified.
                        <button form="send-verification" style="background:none;border:none;color:#046307;text-decoration:underline;cursor:pointer;font-size:0.8rem;">Click here to re-send the verification email.</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size:0.8rem; color:#16a34a; margin-bottom:1rem;">A new verification link has been sent.</p>
                    @endif
                @endif

                <button type="submit" class="btn-premium btn-premium-emerald">Save</button>

                @if (session('status') === 'profile-updated')
                    <span style="font-size:0.8rem; color:#16a34a; margin-left:1rem;">Saved.</span>
                @endif
            </form>
        </section>
    </div>

    <div class="card-premium account-form">
        <section>
            <header>
                <h2>Update Password</h2>
                <p>Ensure your account is using a long, random password to stay secure.</p>
            </header>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <label for="update_password_current_password">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                @error('current_password', 'updatePassword') <p class="field-error">{{ $message }}</p> @enderror

                <label for="update_password_password">New Password</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                @error('password', 'updatePassword') <p class="field-error">{{ $message }}</p> @enderror

                <label for="update_password_password_confirmation">Confirm Password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword') <p class="field-error">{{ $message }}</p> @enderror

                <button type="submit" class="btn-premium btn-premium-emerald">Save</button>

                @if (session('status') === 'password-updated')
                    <span style="font-size:0.8rem; color:#16a34a; margin-left:1rem;">Saved.</span>
                @endif
            </form>
        </section>
    </div>

    <div class="card-premium account-form">
        <section>
            <header>
                <h2>Delete Account</h2>
                <p>Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            </header>

            <button type="button" class="btn-premium btn-premium-red" onclick="document.getElementById('confirm-account-deletion').style.display='block'; this.style.display='none';">
                Delete Account
            </button>

            <form id="confirm-account-deletion" method="post" action="{{ route('profile.destroy') }}" style="display:none; margin-top: 1rem;">
                @csrf
                @method('delete')

                <label for="password_for_delete">Password</label>
                <input id="password_for_delete" name="password" type="password" placeholder="Enter your password to confirm" required>
                @error('password', 'userDeletion') <p class="field-error">{{ $message }}</p> @enderror

                <button type="submit" class="btn-premium btn-premium-red" onclick="return confirm('Adakah anda pasti mahu memadam akaun ini secara kekal?')">Confirm Delete Account</button>
            </form>
        </section>
    </div>

@endsection