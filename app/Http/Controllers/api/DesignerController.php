<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DesignerController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'userId' => 'required'
        ]);

        $user = User::findOrFail($request->userId);

        $user->assignRole('designer');

        $referral = Referral::create([
            'user_id' => $request->userId,
            'referral_code' => Str::random(6)
        ]);

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'referral_code' => $referral->referral_code
            ],
            'message' => 'referral link created'
        ], Response::HTTP_OK);
    }
}
