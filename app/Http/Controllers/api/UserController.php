<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Auth\Events\PasswordReset;
// use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request, MailService $mailService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($request->only('name', 'email', 'password', 'password_confirmation'));

        $user->assignRole('user');

        $value  = $user->name . " " . Str::random(4) . $user->id;

        $slug = Str::slug($value);

        $user->slug = $slug;
        $user->save();

        // event(new Registered($user));

        $mailService->sendWelcome($user);

        return response()->json([
            'data' => $user,
        ], Response::HTTP_CREATED);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'slug' => $user->slug,
                'image' => $user->image,
                'roles' => $user->roles->pluck('name'),
                'referral' => $user->referral->referral_code,
            ]
        ], Response::HTTP_OK);
    }

    public function update(Request $request, User $user)
    {
        $$request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users',
        ]);

        $user->update($request->only('name', 'email'));

        $value = $user->name . " " . Str::random(4) . $user->id;

        $slug = Str::slug($value);

        $user->slug = $slug;
        $user->save();

        return response()->json([
            'data' => $user,
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {


        $user->delete();

        return response()->json([
            'message' => "user {$user->id} deleted"
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        abort_if($user->deactivated, Response::HTTP_FORBIDDEN, 'user account is deactivated. Please contact us!');

        abort_if(!$user || !Hash::check($request->password, $user->password), Response::HTTP_UNAUTHORIZED, 'invalid credentials');

        $token = $request->user()->createToken($request->email, ['*'], now()->addWeek());

        return response([
            'token' => $token->plainTextToken
        ], Response::HTTP_OK);
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        abort_if($status !== Password::ResetLinkSent, Response::HTTP_BAD_REQUEST, __($status));

        return response()->json([
            'message' => __($status)
        ], Response::HTTP_OK);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('token', 'email', 'password', 'password_confirmation'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        abort_if($status !== Password::PasswordReset, Response::HTTP_BAD_REQUEST, __($status));

        return response()->json([
            'message' => __($status)
        ], Response::HTTP_OK);
    }

    public function updateRoleToDesigner(Request $request)
    {
        $user = $request->user();

        abort_if($user->hasRole('designer'), Response::HTTP_FORBIDDEN, 'user is already a designer');

        $user->assignRole('designer');

        $referral_code = Str::random(4) . $user->id;

        $user->referral()->create([
            'referral_code' => $referral_code,
        ]);

        return response()->json([
            'message' => 'promoted to designer'
        ], Response::HTTP_OK);
    }

    public function uploadPicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:15360'
        ]);

        $user = $request->user();

        abort_if(!$user->hasRole('designer'), Response::HTTP_UNAUTHORIZED, 'this user cannot have a profile picture');

        $image = $request->file('image');

        $image_path = $image->store('images/users');

        $user->update([
            'image' => $image_path
        ]);

        return response()->json([
            'image' => $image_path,
            'message' => 'profile picture uploaded'
        ], Response::HTTP_OK);
    }
}
