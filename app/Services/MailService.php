<?php

namespace App\Services;

use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendWelcome(User $user)
    {
        $unsub_url = $this->getUnSubUrl($user);

        Mail::to($user->email)->send(new Welcome($user->name, $unsub_url));

        return response()->json([
            'message' => 'email sent'
        ], Response::HTTP_OK);
    }

    public function sendCongratulations(User $user)
    {
        // $unsub_url = $this->getUnSubUrl($user);

        // Mail::to($user->email)->send(new Congratulations($user->name, $unsub_url));

        // return response()->json([
        //     'message' => 'email sent'
        // ], Response::HTTP_OK);
    }

    public function sendInvoice()
    {
        //
    }

    protected function getUnSubUrl(User $user)
    {
        $unsub_url = url()->query(config('app.frontend_url') . config('app.frontend_unsubscribe_route') . "/", ['id' => $user->id, 'hash' => sha1($user->email), 'is_subscribed' => $user->unsubscribed]);

        return $unsub_url;
    }
}
