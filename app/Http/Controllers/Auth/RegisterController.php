<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Rules\GoogleRecaptcha;
use App\Services\Base\RegexService;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name'                 => [
                'regex:'.RegexService::regex('name'),
                'required',
                'string',
                'between:3,30',
                'unique:users,name',
            ],
            'email'                => [
                'required',
                'email',
                'string',
                'max:30',
                'unique:users,email',
            ],
            'password'             => [
                'required',
                'string',
                'between:8,30',
                'confirmed',
            ],
            'country'              => [
                'exists:countries,id',
            ],
            'race'                 => [
                'exists:races,id',
            ],
            'g-recaptcha-response' => ['required', new GoogleRecaptcha],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'country_id' => (int) $data['country'],
            'race_id'    => (int) $data['race'],
            'role_id'    => Role::where('name', 'user')->value('id'),
            'password'   => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        return redirect()->route('home.index');
    }

    public function register(Request $request)
    {
        Session::flash('showModal', 'registration');

        $this->validator($request->all())->validate();

        try {
            /**
             * On this Event send mail
             */
            event(new Registered($user = $this->create($request->all())));
        } catch (\Exception $e) {
            \Log::error($e);
        }

        $this->guard()->login($user);


        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

}
