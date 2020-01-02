<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

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

    use VerifiesEmails;


    protected $redirectTo = '/';

    /**
     * Where to redirect users after verification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */


    /**
     * VerificationController constructor.
     */
    public function __construct()
    {
        try {
            $this->middleware('auth');
            $this->middleware('signed')->only('verify');
            $this->middleware('throttle:6,1')->only('verify', 'resend');
        } catch (\Exception $e) {
            \Log::error($e);

            return back();
        }
    }

}
