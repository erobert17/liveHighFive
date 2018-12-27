<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use Laravel\Cashier\Billable;
use DB;
use Carbon\Carbon;

class UsersManagementController extends Controller
{
    use Billable;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        foreach ($users as $user) {// add subscribed variable to user array
            $thisUser = User::find($user->id);
            $user->subscribed = $thisUser->onPlan('monthlyPremium');
            $user->subscriptionsTableCount = DB::table('subscriptions')->where('user_id', '=', $user->id)->count();
            $allViews = 0;
            $views = DB::table('landingPages')->where('user_id', $user->id)->pluck('views');
            $ohViews = DB::table('openHouseLeads')->where(['userId' => $user->id, 'hitType' => 'visit'])->count();
            foreach ($views as $viewcount) {
                $allViews = $allViews + $viewcount;
            }
            $allViews = $allViews + $ohViews;
            $user->allViews = $allViews;

            $allLeads = 0;
            $leads = DB::table('leads')->where('user_id', '=', $user->id)->count();

            $ohLeads = DB::table('openHouseLeads')->where(['userId' => $user->id, 'hitType' => 'message'])->count();
            $userLeads = $leads + $ohLeads;
            $user->userLeads = $userLeads;

        }
        
        return View('usersmanagement.show-users', compact('users', 'roles'));

    }

    public function giveFreeYear(Request $request){
        $userId = $request->userId;
        
        DB::table('subscriptions')->insert(['user_id' => $userId, 'name' => 'main', 'quantity' => 1, 'ends_at' => Carbon::now()->addDays(365), 'created_at' => Carbon::now()->addDays(1), 'updated_at' => Carbon::now()->addDays(1), 'freeTrial' => 1]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::all();

        $data = [
            'roles' => $roles
        ];

        return view('usersmanagement.create-user')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255|unique:users',
                'first_name'            => '',
                'last_name'             => '',
                'phone'                 => '',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required'
            ],
            [
                'name.unique'           => trans('auth.userNameTaken'),
                'name.required'         => trans('auth.userNameRequired'),
                'first_name.required'   => trans('auth.fNameRequired'),
                'last_name.required'    => trans('auth.lNameRequired'),
                'email.required'        => trans('auth.emailRequired'),
                'email.email'           => trans('auth.emailInvalid'),
                'password.required'     => trans('auth.passwordRequired'),
                'password.min'          => trans('auth.PasswordMin'),
                'password.max'          => trans('auth.PasswordMax'),
                'role.required'         => trans('auth.roleRequired')
            ]
        );

        if ($validator->fails()) {

            $this->throwValidationException(
                $request, $validator
            );

        } else {

            $ipAddress  = new CaptureIpTrait;
            $profile    = new Profile;

            $user =  User::create([
                'name'              => $request->input('name'),
                'first_name'        => $request->input('first_name'),
                'last_name'         => $request->input('last_name'),
                'phone'             => $request->input('phone'),
                'email'             => $request->input('email'),
                'password'          => bcrypt($request->input('password')),
                'token'             => str_random(64),
                'admin_ip_address'  => $ipAddress->getClientIp(),
                'activated'         => 1
            ]);

            if($request->users_industries1 == 1){
                DB::table('userAssignedIndustries')->insert(['userId' => $user->id, 'industryNumber' => 1]);
                //Realestate
                /* Create  default landing pages in landingPages table. */
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "What's my home worth?", 'secondaryTitle' => 'Fill out the address form to find out.', 'type' => 'Home Valuation']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "The best way to find your home", 'secondaryTitle' => 'With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States', 'type' => 'Property Details']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Maximize your time by advertising your open houses", 'secondaryTitle' => 'This is the secondary title of the third landing page, this should probably be changed before going live, check activateController', 'type' => 'Open Houses']);
            }
            if($request->users_industries2 == 1){
                DB::table('userAssignedIndustries')->insert(['userId' => $user->id, 'industryNumber' => 2]);
                /* Create  default landing pages in landingPages table for ecommerce landing pages. */
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Product Launch Countdown", 'secondaryTitle' => 'Our new product will launch in', 'type' => 'New Product Countdown']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product Coupon", 'secondaryTitle' => 'Use this coupon to get a deal on our new product', 'type' => 'New Product Coupon']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product For Sale", 'secondaryTitle' => 'Secondary Title', 'type' => 'Single Item Shopping Cart']);
            }

            
            if($request->freeTrial == 1){
                DB::table('subscriptions')->insert(['user_id' => $user->id, 'name' => 'main', 'quantity' => 1, 'ends_at' => Carbon::now()->addDays(365), 'created_at' => Carbon::now()->addDays(1), 'updated_at' => Carbon::now()->addDays(1), 'freeTrial' => 1]);
            }

            $user->profile()->save($profile);
            $user->attachRole($request->input('role'));
            $user->save();

            
            return redirect('users')->with('success', trans('usersmanagement.createSuccess'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);

        return view('usersmanagement.show-user')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::all();

        foreach ($user->roles as $user_role) {
            $currentRole = $user_role;
        }

        $data = [
            'user'          => $user,
            'roles'         => $roles,
            'currentRole'   => $currentRole
        ];

        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $currentUser = Auth::user();
        $user        = User::find($id);
        $emailCheck  = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress   = new CaptureIpTrait;

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:255',
                'email'     => 'email|max:255|unique:users',
                'password'  => 'present|confirmed|min:6'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:255',
                'password'  => 'nullable|confirmed|min:6'
            ]);
        }
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        } else {
            $user->name = $request->input('name');

            if ($emailCheck) {
                $user->email = $request->input('email');
            }

            if ($request->input('password') != null) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->detachAllRoles();
            $user->attachRole($request->input('role'));
            //$user->activated = 1;

            $user->updated_ip_address = $ipAddress->getClientIp();

            $user->save();
            return back()->with('success', trans('usersmanagement.updateSuccess'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $currentUser = Auth::user();
        $user        = User::findOrFail($id);
        $ipAddress   = new CaptureIpTrait;

        if ($user->id != $currentUser->id) {

            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();
            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        }
        return back()->with('error', trans('usersmanagement.deleteSelfError'));

    }
}
