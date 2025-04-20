<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MailController extends Controller
{
    // public function verify($id, $hash)
    // {
    //     $user = User::find($id);

    //     abort_if(!$user, Response::HTTP_FORBIDDEN);

    //     abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())), Response::HTTP_FORBIDDEN);

    //     if (!$user->hasVerifiedEmail()) {
    //         $user->markEmailAsVerified();

    //         event(new Verified($user));

    //         $this->sendWelcome($user);
    //     }

    //     return response()->json([
    //         'message' => 'email verified'
    //     ], Response::HTTP_OK);
    // }

    // public function verifyResend(Request $request)
    // {
    //     $request->user()->sendEmailVerificationNotification();

    //     return response()->json([
    //         'message' => 'verification link sent'
    //     ], Response::HTTP_OK);
    // }

    public function unsubscribe($id, $hash)
    {
        $user = User::find($id);

        abort_if(!$user, Response::HTTP_FORBIDDEN);

        abort_if(!hash_equals($hash, sha1($user->email)), Response::HTTP_FORBIDDEN);

        $user->unsubscribe = true;
        $user->save();

        return response()->json([
            'message' => 'unsubscribed to mail'
        ], Response::HTTP_OK);
    }

    public function subscribe($id, $hash)
    {
        $user = User::find($id);

        abort_if(!$user, Response::HTTP_FORBIDDEN);

        abort_if(!hash_equals($hash, sha1($user->email)), Response::HTTP_FORBIDDEN);

        $user->unsubscribe = false;
        $user->save();

        return response()->json([
            'message' => 'subscribed to mail'
        ], Response::HTTP_OK);
    }
}
