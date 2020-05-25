<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    // use VerifiesEmails; non uso questo

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->mi ddleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user) {
        // check if url is valid signed in laravel
        if( !URL::hasValidSignedIn($request)){
            return response()->json(
                ['errors' =>
                    ['message' => 'invalid verificaion link']
                ],
            422);
        }

        // verify the account
        if ($user->hasVerifiedEmail()){
            return response()->json(
                [
                    'errors' =>
                    ['message' => 'email already verified']
                ],
                422
            );
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        return response()->json(['message' => 'successo!'],200);

    }

    public function resend(Request $request) {
        $this->validate($request, [
            'email' => ['email', 'required']
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(
                [
                    'errors'=> [
                        'email' => 'no user could be found with this email address'
                    ]
                ], 422
            );
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(
                [
                    'errors' =>
                    ['message' => 'email already verified']
                ],
                422
            );
        }

        $user->sendEmailVerificationNotification();
        return response()->json(['status' => 'link resent']);
    }
}
