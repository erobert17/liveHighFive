<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Models\User;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use App\Traits\ActivationTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use DB;

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

    use ActivationTrait;
    use CaptchaTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        /*
        $data['captcha'] = $this->captchaCheck();

        if (App::environment('local')) {
            $data['captcha'] = true;
        }*/

        return Validator::make($data,
            [
                
                'first_name'            => '',
                'last_name'             => '',
                'company'             => 'required|min:1',
                'phone'             => '',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'captchaQuestion' => 'required'/*,
                'g-recaptcha-response'  => '',
                'captcha'               => 'required|min:1'*/
            ],
            [
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'phone'                         => trans('auth.phoneRequired'),
                'company.required'            => trans('auth.cNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax')/*,
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong')*/
            ]
        );

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $ipAddress  = new CaptureIpTrait;
        $role       = Role::where('name', '=', 'Unverified')->first();

        $randomUserLink = genRandLink();
        $industry = 1;

        $name = $data['first_name'].' '.$data['last_name'];

        $user =  User::create([
            'name'              => $name,
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'company'         => $data['company'],
            'phone'         => $data['phone'],
            'industry'         => $industry,
            'email'             => $data['email'],
            'randomUserLink'    => $randomUserLink,
            'password'          => bcrypt($data['password']),
            'token'             => str_random(64),
            'signup_ip_address' => $ipAddress->getClientIp(),
            'activated'         => !config('settings.activation')
        ]);

        $newUser = DB::table('users')->where(['name' => $name, 
            'first_name' => $data['first_name'], 
            'company' => $data['company'], 
            'randomUserLink' => $randomUserLink
        ])->take(1)->get();

        //Must update this if we add more industries

        // Custom validation, if they don't fill it out, give them both industries.
        if(!isset($data['industry_2']) && !isset($data['industry_1'])){
            DB::table('userAssignedIndustries')->insert(['userId' => $newUser[0]->id, 'industryNumber' => 1]);
            DB::table('userAssignedIndustries')->insert(['userId' => $newUser[0]->id, 'industryNumber' => 2]);
        }else{
            if(isset($data['industry_1']) && $data['industry_1'] === '1'){
            DB::table('userAssignedIndustries')->insert(['userId' => $newUser[0]->id, 'industryNumber' => 1]);
            }
            if(isset($data['industry_2']) &&  $data['industry_2'] === '2'){
                DB::table('userAssignedIndustries')->insert(['userId' => $newUser[0]->id, 'industryNumber' => 2]);
            }
        }
        

        $user->attachRole($role);
        $this->initiateEmailActivation($user);

        return $user;

    }
}

function genRandLink(){
    for ($i=0; $i < 100; $i++) {// Random Generate Code
        $length = 22;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $codes = DB::table('users')->where('randomUserLink', '=', $randomString)->get();
        if(count($codes) == 0){
            $i = 101;
            return $randomString;
        }

    }
}