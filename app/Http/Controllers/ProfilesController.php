<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Image;
use Webpatser\Uuid\Uuid;
use Validator;
use View;
use DB;
use Auth;
use Carbon\Carbon;
use DateTime;

class ProfilesController extends Controller
{

    protected $idMultiKey     = '618423'; //int
    protected $seperationKey  = '****';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function profile_validator(array $data)
    {
        return Validator::make($data, [
            'theme_id'          => '',
            'location'          => '',
            'bio'               => 'max:500',
            'twitter_username'  => 'max:50',
            'github_username'   => 'max:50',
            'avatar'            => '',
            'avatar_status'     => '',
        ]);
    }

    /**
     * Fetch user
     * (You can extract this to repository method)
     *
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username)
    {
        return User::with('profile')->wherename($username)->firstOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param string $username
     * @return Response
     */
    public function show($username, Request $request)
    {
        try {

            $user = $this->getUserByUsername($username);

        } catch (ModelNotFoundException $exception) {

            abort(404);

        }

        //$currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user' => $user,
            'currentTheme' => null
        ];

        return view('profiles.show')->with($data);

    }

    public function accountSettings()
    {
        $user = Auth::user();

        $industries = DB::table('industries')->get();

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme,
            'industries' => $industries

        ];

        return view('profiles.accountSettings')->with($data);

    }

    public function updateAccountSettings(Request $request)
    {
        $user = Auth::user();
        $alreadyExists = DB::table('userAssignedIndustries')->where('userId', '=', $user->id)->where('industryNumber', '=', 1)->count();
        //Realestate
        if( isset($request['RealEstate']) ){// checked
            if($alreadyExists == 0){// not already in table
                    DB::table('userAssignedIndustries')->insert(['userId' => $user->id, 'industryNumber' => 1]);

            }
        }else{// not checked
            if($alreadyExists > 0){// already in table
                DB::table('userAssignedIndustries')->where([
                        ['industryNumber', '=', 1],
                        ['userId', '=', $user->id] ])->delete();
            }
        }
        //ecommerce
        $alreadyExists = DB::table('userAssignedIndustries')->where('userId', '=', $user->id)->where('industryNumber', '=', 2)->count();
        if( isset($request['E-Commerce']) ){// checked
            if($alreadyExists == 0){// not already in table
                    DB::table('userAssignedIndustries')->insert(['userId' => $user->id, 'industryNumber' => 2]);

            }
        }else{// not checked
            if($alreadyExists > 0){// already in table
                DB::table('userAssignedIndustries')->where([
                        ['industryNumber', '=', 2],
                        ['userId', '=', $user->id] ])->delete();
            }
        }
        
        $industries = DB::table('industries')->get();

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme,
            'industries' => $industries

        ];

        return view('profiles.accountSettings')->with($data);

    }


    /**
     * /profiles/username/edit
     *
     * @param $username
     * @return mixed
     */
    public function edit($username)
    {
        try {

            $user = $this->getUserByUsername($username);

        } catch (ModelNotFoundException $exception) {
            return view('pages.status')
                ->with('error', trans('profile.notYourProfile'))
                ->with('error_title', trans('profile.notYourProfileTitle'));
        }

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);

        

        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme

        ];

        return view('profiles.edit')->with($data);

    }

    public function branding()
    {
        $user = Auth::user();

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);

        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme

        ];

        return view('profiles.branding')->with($data);
    }

    public function updateUserBranding(Request $request) {

        $user = Auth::user();

        DB::table('users')->where('id' , '=', $request->userID)->update(['name' => $request->name, 
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'Phone' => $request->Phone]);

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);


        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme

        ];

        return redirect()->route('branding', $data);
        //return view('profiles.branding')->with($data);

    }

    public function updateCompanyBranding(Request $request) {

        $user = Auth::user();

        /*
        echo '<pre>';
        var_dump($user);
        echo '<pre>';*/
        DB::table('users')->where('id' , '=', $request->userID)->update(['company' => $request->company, 'companyUrl' => $request->websiteUrl]);
        

        $themes = Theme::where('status', 1)
                       ->orderBy('name', 'asc')
                       ->get();

        $currentTheme = Theme::find($user->profile->theme_id);
        //return redirect()->route('profile/{username}/edit', ['username' => $user->name]);
        //return redirect('profile/'.$user->name.'/edit')->with('success', trans('profile.updateSuccess'));
        $data = [
            'user'          => $user,
            'themes'        => $themes,
            'currentTheme'  => $currentTheme

        ];

        return redirect()->route('branding', $data);
    }

    public function uploadUserAvatar() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP1.' . $background->getClientOriginalExtension();
          $filename     = 'userImg.png';
          $save_path    = storage_path() . '/uploads/users/id/' . $currentUser->id . '/avatar/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/avatar/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/uploads/users/id/' . $currentUser->id . '/avatar/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
           
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('users')->where(['id' => $currentUser->id])->update(['userAvatar' => $public_path]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }


    public function uploadCompanyLogo() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP1.' . $background->getClientOriginalExtension();
          $filename     = 'avatar.png';
          $save_path    = storage_path() . '/uploads/users/id/' . $currentUser->id . '/avatar/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/avatar/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/uploads/users/id/' . $currentUser->id . '/avatar/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');

            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('profiles')->where(['user_id' => $currentUser->id])->update(['avatar' => '/uploads/users/id/' . $currentUser->id . '/avatar/'.$filename]);
            DB::table('profiles')->where(['user_id' => $currentUser->id])->update(['avatar_status' => 1]);
            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    /**
     * Update a user's profile
     *
     * @param $username
     * @return mixed
     * @throws Laracasts\Validation\FormValidationException
     */
    public function update($username, Request $request)
    {
        $user = $this->getUserByUsername($username);

        $input = Input::only('theme_id', 'location', 'bio', 'twitter_username', 'github_username', 'avatar_status');

        $ipAddress = new CaptureIpTrait;

        $profile_validator = $this->profile_validator($request->all());

        if ($profile_validator->fails()) {

            $this->throwValidationException(
                $request, $profile_validator
            );

            return redirect('profile/'.$user->name.'/edit')->withErrors($validator)->withInput();
        }

        if ($user->profile == null) {

            $profile = new Profile;
            $profile->fill($input);
            $user->profile()->save($profile);

        } else {

            $user->profile->fill($input)->save();

        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return redirect('profile/'.$user->name.'/edit')->with('success', trans('profile.updateSuccess'));

    }


    /**
     * Get a validator for an incoming update user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'              => 'required|max:255',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserAccount(Request $request, $id)
    {

        $currentUser = \Auth::user();
        $user        = User::findOrFail($id);
        $emailCheck  = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress   = new CaptureIpTrait;

        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
        ]);

        $rules = [];

        if ($emailCheck) {
            $rules = [
                'email'     => 'email|max:255|unique:users'
            ];
        }

        $validator = $this->validator($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user->name         = $request->input('name');
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->company    = $request->input('company');

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return redirect('profile/'.$user->name.'/edit')->with('success', trans('profile.updateAccountSuccess'));

    }

    public function updateUserPasswordDone(){
      return redirect('/accountSettings');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserPassword(Request $request)
    {
      
        $currentUser = \Auth::user();
        #echo '<pre>';
        #var_dump($currentUser);
        #echo '</pre>';
        $user        = User::findOrFail($currentUser->id);
        $ipAddress   = new CaptureIpTrait;

        $validator = Validator::make($request->all(),
            [
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'password.required'     => trans('auth.passwordRequired'),
                'password.min'          => trans('auth.PasswordMin'),
                'password.max'          => trans('auth.PasswordMax'),
            ]
        );

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();
        return redirect('/home');
        //return redirect('profile/'.$user->name.'/edit')->with('success', trans('profile.updatePWSuccess'));

    }

    /**
     * Upload and Update user avatar
     *
     * @param $file
     * @return mixed
     */
    public function upload() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $avatar       = Input::file('file');
          $filename     = 'avatar.' . $avatar->getClientOriginalExtension();
          //$save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/avatar/';
          $save_path    = '/uploads/users/id/' . $currentUser->id . '/avatar/';
          $path         = $save_path . $filename;
          //$public_path  = '/images/profile/' . $currentUser->id . '/avatar/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);

          // Save the file to the server
          Image::make($avatar)->save($save_path . $filename);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            $currentUser->profile->avatar = $save_path. $filename;
            $currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAccount(Request $request, $id)
    {

        $currentUser = \Auth::user();
        $user        = User::findOrFail($id);
        $ipAddress   = new CaptureIpTrait;

        $validator = Validator::make($request->all(),
            [
                'checkConfirmDelete'            => 'required',
            ],
            [
                'checkConfirmDelete.required'   => trans('profile.confirmDeleteRequired'),
            ]
        );

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if ($user->id != $currentUser->id) {

            return redirect('profile/'.$user->name.'/edit')->with('error', trans('profile.errorDeleteNotYour'));

        }

        // Create and encrypt user account restore token
        $sepKey       = $this->getSeperationKey();
        $userIdKey    = $this->getIdMultiKey();
        $restoreKey   = config('settings.restoreKey');
        $encrypter    = config('settings.restoreUserEncType');
        $level1       = $user->id * $userIdKey;
        $level2       = urlencode(Uuid::generate(4) . $sepKey . $level1);
        $level3       = base64_encode($level2);
        $level4       = openssl_encrypt($level3, $encrypter, $restoreKey);
        $level5       = base64_encode($level4);

        // Save Restore Token and Ip Address
        $user->token  = $level5;
        $user->deleted_ip_address = $ipAddress->getClientIp();
        $user->save();

        // Send Goodbye email notification
        $this->sendGoodbyEmail($user, $user->token);

        // Soft Delete User
        $user->delete();

        // Clear out the session
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/login/')->with('success', trans('profile.successUserAccountDeleted'));

    }

    /**
     * Send GoodBye Email Function via Notify
     *
     * @param array $user
     * @param string $token
     * @return void
     */
    public static function sendGoodbyEmail(User $user, $token) {
        $user->notify(new SendGoodbyeEmail($token));
    }

    /**
     * Get User Restore ID Multiplication Key
     *
     * @return string
     */
    public function getIdMultiKey() {
        return $this->idMultiKey;
    }

    /**
     * Get User Restore Seperation Key
     *
     * @return string
     */
    public function getSeperationKey() {
        return $this->seperationKey;
    }

    public function dashboard(Request $request){
        $allRealestatePrefabs = DB::table('landingpagePrefabs')->where(['id' => 'id'])->get();
   
        //Count number of pages, per industry, + each open house, if realestate
        $user = Auth::user();
        $landingPages = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        $landingPagesArray = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        $userIndos = DB::table('userAssignedIndustries')->where(['userId' => $user->id ])->pluck('industryNumber')->toArray();

        $user = Auth::user();

        //Check if user subscription has a end point that has pasted. If so, delete the entry in the database to clean up records
        // and trigger "new subscription needed" messages.
        $queryReturn = DB::table('subscriptions')->where('user_id', '=', $user->id)->get()->toArray();
        if($queryReturn != null){

          $ends_at = str_replace('[', '', $queryReturn[0]->ends_at);
          $ends_at = str_replace(']', '', $ends_at);
          $ends_at = str_replace('"', '', $ends_at);
          $now = Carbon::now();

          $now = (string)$now;
          //echo $ends_at.' > '.$now.'<br>';
          if ($ends_at < $now){
            DB::table('subscriptions')->where('id', '=', $queryReturn[0]->id)->delete();
          }

        }
        
        // Retrieve leads from leadsLastLogin table
        //This will take place everytime user login and redirect to /home 
        $difference1 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->orderBy('date', 'desc')->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
         DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => $difference1, 'type' => 'Home Valuation']);
        }
        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference1 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->update(['leads' => $storedLastLeads, 'difference' => $difference1]);
        }

        //lp2 leads
        $difference2 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Property Details'])->orderBy('date', 'desc')->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => $difference2, 'type' => 'Property Details']);
        }
        
        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference2 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->update(['leads' => $storedLastLeads, 'difference' => $difference2]);
        }

        //lp3 leads Open House
        $difference3 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('openHouseLeads')->where(['userId' => $user->id, 'hitType' => 'message'])->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{// if row for open house doesnt exist in leadsLastLogin, create it for this user
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => 0, 'type' => 'Open House']);
          $storedLeads = 0;
        }

        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference3 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->update(['leads' => $storedLastLeads, 'difference' => $difference3]);
        }

        //LP4  contdown
        $difference4 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
         DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => $difference4, 'type' => 'New Product Countdown']);
        }
        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference4 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->update(['leads' => $storedLastLeads, 'difference' => $difference4]);
        }

        //LP5 New Product Countdown
        $difference5 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->orderBy('date', 'desc')->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
         DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => $difference5, 'type' => 'New Product Coupon']);
        }
        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference5 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->update(['leads' => $storedLastLeads, 'difference' => $difference5]);
        }

        //LP6 New Product Coupon
        $difference6 = 0;
        $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->pluck('leads')->toArray();
        $storedLastLeads = DB::table('orders')->where(['userId' => $user->id])->count();
        if( count($storedLeads) > 0){
          $storedLeads = $storedLeads[0];
        }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
         DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->insert(['userId' =>$user->id, 'leads' => $storedLastLeads, 'difference' => $difference6, 'type' => 'Shopping Cart']);
        }
        if($storedLeads < $storedLastLeads){//Leads have changed
          $difference6 = ($storedLeads - $storedLastLeads) * -1;
          DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->update(['leads' => $storedLastLeads, 'difference' => $difference6]);
        }

        $leads = DB::table('leads')->where('user_id', $user->id)->count();

        $hintText = DB::table('hintText')->get();

        // remove duplicate dates
        $one_week_ago = Carbon::now()->subWeeks(1); 

        $timeStampsViews = DB::table('views')->orderBy('timeStamp', 'ASC')->where([ ['userId', '=', $user->id],['timeStamp', '>',$one_week_ago] ])->pluck('timeStamp')->toArray();

        $timeStampsLeads = DB::table('leads')->orderBy('date', 'ASC')->where([ ['user_id', '=', $user->id], ['date','>',$one_week_ago] ])->pluck('date')->toArray();

        $timeStampsOrders = DB::table('orders')->orderBy('created', 'ASC')->where([['userId', '=', $user->id], ['created', '>', $one_week_ago] ] )->pluck('created')->toArray();

        //Combine all three arrays
        $timeStampsRaw = array_merge($timeStampsViews, $timeStampsLeads);
        $timeStampsRaw = array_merge($timeStampsRaw, $timeStampsOrders);
        #$timeStampsRaw = $timeStampsViews->merge($timeStampsLeads);
        #$timeStampsRaw = $timeStampsRaw->merge($timeStampsOrders);
        sort($timeStampsRaw);

        #echo '$timeStampsRaw: count: '.count($timeStampsRaw).'<br>';
        //Remove duplicate dates in raw after ordering
        
        $timeStamps = [];
        foreach ($timeStampsRaw as $thisTimeStamp) {
          $thisDate = substr($thisTimeStamp, 0, strpos($thisTimeStamp, ' '));
          if(!in_array($thisDate, $timeStamps)){
            array_push($timeStamps, $thisDate);
          }
        }

        $timeStamps = json_encode($timeStamps);
        $timeStamps = trim($timeStamps, '"');


        for ($i=0; $i <= count($landingPages); $i++) {
          if( in_array(1, $userIndos) == false ){
            if(isset($landingPages[$i])){
              if($landingPages[$i]->type == 'Home Valuation' || $landingPages[$i]->type == 'Property Details' || $landingPages[$i]->type == 'Open Houses'){
                unset($landingPagesArray[$i]);
              }
            }  
          }else if( in_array(2, $userIndos) == false ){
            if(isset($landingPages[$i])){
              if($landingPages[$i]->type == 'New Product Countdown' || $landingPages[$i]->type == 'New Product Coupon' || $landingPages[$i]->type == 'Single Item Shopping Cart'){
                unset($landingPagesArray[$i]);
              }
            }
          }

          $totalViews = 0;
          $isRealestate = false;
          $isEcommerce = false;
          $propertiesIds = [];
          $timeStampsViews;
          //positive, if industry real estate
          
            $isRealestate = true;
            $homeValuationViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->count();
            $propertyDetailsViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'Property Details'])->count();
            //Get all properties to construct array of ids to get lead and views from openHouseLeads table.
            $propertiesIds = DB::table('properties')->where(['userId' => $user->id])->pluck('id')->toArray();
            
            $openHouseViews = DB::table('openHouseLeads')->where(['hitType' => 'visit', 'userId' => $user->id])->count();

            $newProductCouponViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->count();
            $newProductCountdownViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->count();
            //Get all properties to construct array of ids to get lead and views from openHouseLeads table.
            $singleItemShoppingCartViews = DB::table('views')->where(['userId' => $user->id, 'type'=>'Single Item Shopping Cart'] )->count();
            
            $totalViews = ($singleItemShoppingCartViews + $newProductCouponViews + $newProductCountdownViews + $homeValuationViews + $propertyDetailsViews + $openHouseViews);

        }

        $timeStampsDecoded = json_decode($timeStamps);
        $timeStampsAdded = [];

        //Views
        $saveGraphViewsDataDates = [];
        if(isset($timeStampsViews)){
          //cut off all after space in timeStamps
          for ($i=0; $i < count($timeStampsViews); $i++) { 
              $timeStampsViews[$i] = substr($timeStampsViews[$i], 0, strpos($timeStampsViews[$i], " "));
          }
          $graphViewsData = []; $tempTimeStamp = '';$alreadyTimestamp=[];
          for ($i=0; $i < count($timeStampsViews); $i++) { // foreach timestamp
              $tempCount=0;
              $tempTimeStamp = (String)$timeStampsViews[$i];
              foreach ($timeStampsViews as $timeStamp) { // count occurences of this timestamp
                  $timeStamp = (String)$timeStamp;
                  if($tempTimeStamp == $timeStamp){
                      //echo $tempTimeStamp .' ---- '. $timeStamp.'<br><br>';
                      $tempCount++;
                  }
              }
              if(!in_array($timeStampsViews[$i], $alreadyTimestamp)){
                  array_push($alreadyTimestamp, $timeStampsViews[$i]);
                  array_push($graphViewsData, $tempCount); 
                  array_push($saveGraphViewsDataDates, $timeStampsViews[$i]);
                  //echo 'TempCount: '.$tempCount;
              }
              
          }

          $timeStampsViews = $alreadyTimestamp;
         
          $graphViewsData = json_encode($graphViewsData);
          $graphViewsData = trim($graphViewsData, '"');

          $timeStampsViews = json_encode($timeStampsViews);
          $timeStampsViews = trim($timeStampsViews, '"');
        }else{
          $timeStampsViews = null;
          $graphViewsData = null;
        }
        $countPages = count($landingPagesArray);
        if($isRealestate == true){
            //since the user might have open houses, add hopen houses to pagecount
            $countPages = $countPages + count($propertiesIds);
        }

        //Leads
        $saveGraphLeadsDates =[];
        if(isset($timeStampsLeads)){
          //cut off all after space in timeStamps
          for ($i=0; $i < count($timeStampsLeads); $i++) { 
              $timeStampsLeads[$i] = substr($timeStampsLeads[$i], 0, strpos($timeStampsLeads[$i], " "));
          }
          $graphLeadsData = []; $tempTimeStamp = '';$alreadyTimestamp=[];
          for ($i=0; $i < count($timeStampsLeads); $i++) { // foreach timestamp
              $tempCount=0;
              $tempTimeStamp = (String)$timeStampsLeads[$i];
              foreach ($timeStampsLeads as $timeStamp) { // count occurences of this timestamp
                  $timeStamp = (String)$timeStamp;
                  if($tempTimeStamp == $timeStamp){
                      //echo $tempTimeStamp .' ---- '. $timeStamp.'<br><br>';
                      $tempCount++;
                  }
              }
              if(!in_array($timeStampsLeads[$i], $alreadyTimestamp)){
                  array_push($alreadyTimestamp, $timeStampsLeads[$i]);
                  array_push($graphLeadsData, $tempCount); 
                  array_push($saveGraphLeadsDates, $timeStampsLeads[$i]);
                  //echo 'TempCount: '.$tempCount;
              }
              
          }

          $timeStampsLeads = $alreadyTimestamp;
         
          $graphLeadsData = json_encode($graphLeadsData);
          $graphLeadsData = trim($graphLeadsData, '"');

          $timeStampsLeads = json_encode($timeStampsLeads);
          $timeStampsLeads = trim($timeStampsLeads, '"');
        }else{
          $timeStampsLeads = null;
          $graphLeadsData = null;
        }
        $countPages = count($landingPagesArray);
        if($isRealestate == true){
            //since the user might have open houses, add hopen houses to pagecount
            $countPages = $countPages + count($propertiesIds);
        }

        //Orders

        $saveGraphOrdersDates =[];
        if(isset($timeStampsOrders)){
          //cut off all after space in timeStamps
          for ($i=0; $i < count($timeStampsOrders); $i++) { 
              $timeStampsOrders[$i] = substr($timeStampsOrders[$i], 0, strpos($timeStampsOrders[$i], " "));
          }
          $graphOrdersData = []; $tempTimeStamp = '';$alreadyTimestamp=[];
          for ($i=0; $i < count($timeStampsOrders); $i++) { // foreach timestamp
              $tempCount=0;
              $tempTimeStamp = (String)$timeStampsOrders[$i];
              foreach ($timeStampsOrders as $timeStamp) { // count occurences of this timestamp
                  $timeStamp = (String)$timeStamp;
                  if($tempTimeStamp == $timeStamp){
                      //echo $tempTimeStamp .' ---- '. $timeStamp.'<br><br>';
                      $tempCount++;
                  }
              }
              if(!in_array($timeStampsOrders[$i], $alreadyTimestamp)){
                  array_push($alreadyTimestamp, $timeStampsOrders[$i]);
                  array_push($graphOrdersData, $tempCount);
                  array_push($saveGraphOrdersDates, $timeStampsOrders[$i]);
                  //echo 'TempCount: '.$tempCount;
              }
              
          }


          $timeStampsOrders = $alreadyTimestamp;
         
          $graphOrdersData = json_encode($graphOrdersData);
          $graphOrdersData = trim($graphOrdersData, '"');

          $timeStampsOrders = json_encode($timeStampsOrders);
          $timeStampsOrders = trim($timeStampsOrders, '"');
        }else{
          $timeStampsOrders = null;
          $graphOrdersData = null;
        }
        $countPages = count($landingPagesArray);
        if($isRealestate == true){
            //since the user might have open houses, add hopen houses to pagecount
            $countPages = $countPages + count($propertiesIds);
        }


        $timeStamps = json_decode($timeStamps);
        $graphViewsData = json_decode($graphViewsData);
        $graphLeadsData = json_decode($graphLeadsData);
        $graphOrdersData = json_decode($graphOrdersData);

        #create list of last seven days
        $lastSevenDays = [];
        #We need to have seven days in the graph, so create a list of the last seven days without hours and minutes
        for ($i=6; $i > 0 ; $i--) { 
            $tempDay = Carbon::now()->subDays($i)->format('Y-m-d');
            #echo $tempDay.' --- ';
            if(!in_array($tempDay, $timeStamps)){ #if this day isn't in timeStamps, n
              array_push($timeStamps, $tempDay);
            }
        }

        sort($timeStamps);
        sort($saveGraphLeadsDates);
        sort($saveGraphOrdersDates);
        #should have all 7 past days including today, sorted and ready
        
        # create trigger values to detect if there's no values. this is used in loops below to add all zeros to graph list if no views,leads or orders in last 7 days
        $atLeastOneView = False;
        if(count($saveGraphViewsDataDates)>0){
          $atLeastOneView = True;
        }

        $atLeastOneLead = False;
        if(count($saveGraphLeadsDates)>0){
          $atLeastOneLead = True;
        }

        $today = Carbon::now()->format('Y-m-d');
        

        $atLeastOneOrder = False;
        if(count($saveGraphOrdersDates) > 0){
          $atLeastOneOrder = True;
        }


        #Go through past 7 days, add zero values for each day that has no value
        foreach ($timeStamps as $timeStamp) {
          #views
          if(!in_array($timeStamp, $saveGraphViewsDataDates)){# if this day isn't in the array of timeStamps to be displayed on bottom of graph
            #go through timeStamps and find what dates it's less than or more than and place inbetween
            #we must do it this way instead of just sorting dates because we have to add a zero value to the corrisponding place in $graphViewsData
              if($atLeastOneView != False){
                
                for ($t=0; $t < count($saveGraphViewsDataDates); $t++) {
                  if (new DateTime($timeStamp) < new DateTime($saveGraphViewsDataDates[$t])){
                    array_splice($graphViewsData, $t, 0, 0);
                    array_splice($saveGraphViewsDataDates, $t, 0, $timeStamp);
                    $t = count($saveGraphViewsDataDates) +1;
                  }else if ( ($t+1) < count($saveGraphViewsDataDates) and 
                    new DateTime($timeStamp) < new DateTime($saveGraphViewsDataDates[$t]) and
                    new DateTime($timeStamp) > new DateTime($saveGraphViewsDataDates[$t+1])){
                      array_splice($graphViewsData, $t, 0, 0);
                      array_splice($saveGraphViewsDataDates, $t, 0, $timeStamp);
                      $t = count($saveGraphViewsDataDates) +1;
                  }else if(new DateTime($timeStamp) > new DateTime($saveGraphViewsDataDates[$t]) and $t == count($saveGraphViewsDataDates) ){
                    
                    array_push($graphViewsData, 0);
                    array_push($saveGraphViewsDataDates, $timeStamp);
                    
                  }else if ( new DateTime($timeStamp) == new DateTime($today) and !in_array($timeStamp, $saveGraphViewsDataDates) ){
                    array_push($graphViewsData, 0);
                    array_push($saveGraphViewsDataDates, $timeStamp);
                  }


                  sort($saveGraphViewsDataDates);

                }#endforloop

              }else{
                array_push($graphViewsData, 0);
                array_push($saveGraphViewsDataDates, $timeStamp);
              }
          }#ends views for loop

          #Leads
          if(!in_array($timeStamp, $saveGraphLeadsDates)){# if this day isn't in the array of timeStamps to be displayed on bottom of graph
            #go through timeStamps and find what dates it's less than or more than and place inbetween
            #we must do it this way instead of just sorting dates because we have to add a zero value to the corrisponding place in $graphViewsData
              if($atLeastOneLead != False){
                for ($t=0; $t < count($saveGraphLeadsDates); $t++) {

                  if (new DateTime($timeStamp) < new DateTime($saveGraphLeadsDates[$t])){
                    array_splice($graphLeadsData, $t, 0, 0);
                    array_splice($saveGraphLeadsDates, $t, 0, $timeStamp);
                    $t = count($saveGraphLeadsDates) +1;
                  }else if ( ($t+1) < count($saveGraphLeadsDates) and new DateTime($timeStamp) < new DateTime($saveGraphLeadsDates[$t]) and new DateTime($timeStamp) > new DateTime($saveGraphLeadsDates[$t+1])){
                      array_splice($graphLeadsData, $t, 0, 0);
                      array_splice($saveGraphLeadsDates, $t, 0, $timeStamp);
                      $t = count($saveGraphLeadsDates) +1;
                  }else if(new DateTime($timeStamp) > new DateTime($saveGraphLeadsDates[$t]) and $t == count($saveGraphLeadsDates) ){
                    array_push($graphLeadsData, 0);
                    array_push($saveGraphLeadsDates, $timeStamp);
                  }else if ( new DateTime($timeStamp) == new DateTime($today) and !in_array($timeStamp, $saveGraphLeadsDates) ){
                    array_push($graphLeadsData, 0);
                    array_push($saveGraphLeadsDates, $timeStamp);
                  }

                  sort($saveGraphLeadsDates);

                }

              }else{
                array_push($graphLeadsData, 0);
                array_push($saveGraphLeadsDates, $timeStamp);
              }

          }#ends views for loop


          #Orders
          if(!in_array($timeStamp, $saveGraphOrdersDates)){# if this day isn't in the array of timeStamps to be displayed on bottom of graph
            #go through timeStamps and find what dates it's less than or more than and place inbetween
            #we must do it this way instead of just sorting dates because we have to add a zero value to the corrisponding place in $graphViewsData
              if($atLeastOneOrder != False){
                for ($t=0; $t < count($saveGraphOrdersDates); $t++) {
                  #echo $saveGraphOrdersDates[$t].'****';

                  if (new DateTime($timeStamp) < new DateTime($saveGraphOrdersDates[$t])){
                    array_splice($graphOrdersData, $t, 0, 0);
                    array_splice($saveGraphOrdersDates, $t, 0, $timeStamp);
                    $t = count($saveGraphOrdersDates) +1;
                  }else if ( ($t+1) < count($saveGraphOrdersDates) and new DateTime($timeStamp) < new DateTime($saveGraphOrdersDates[$t]) and new DateTime($timeStamp) > new DateTime($saveGraphOrdersDates[$t+1])){
                      array_splice($graphOrdersData, $t, 0, 0);
                      array_splice($saveGraphOrdersDates, $t, 0, $timeStamp);
                      $t = count($saveGraphOrdersDates) +1;
                  }else if(new DateTime($timeStamp) > new DateTime($saveGraphOrdersDates[$t]) and $t == count($saveGraphOrdersDates) ){
                    array_push($graphOrdersData, 0);
                    array_push($saveGraphOrdersDates, $timeStamp);
                  }else if ( new DateTime($timeStamp) == new DateTime($today) and !in_array($timeStamp, $saveGraphOrdersDates) ){
                    array_push($graphOrdersData, 0);
                    array_push($saveGraphOrdersDates, $timeStamp);
                  }

                  sort($saveGraphOrdersDates);

                }

              }else{
                array_push($graphOrdersData, 0);
                array_push($saveGraphOrdersDates, $timeStamp);
              }

          }#ends views for loop

        }
        #last of graph stuff
        #double checking the views, leads and orders have at least the same number of entries as timestamp days, should be 7 days
        if(count($graphViewsData) < count($timeStamps) ){
          for ($i=count($graphViewsData); $i < count($timeStamps) ; $i++) { 
            array_push($graphViewsData, 0);
          }
        }
        if(count($graphLeadsData) < count($timeStamps) ){
          for ($i=count($graphLeadsData); $i < count($timeStamps) ; $i++) { 
            array_push($graphLeadsData, 0);
          }
        }
        if(count($graphOrdersData) < count($timeStamps) ){
          for ($i=count($graphOrdersData); $i < count($timeStamps) ; $i++) { 
            array_push($graphOrdersData, 0);
          }
        }

        #Landing pages available
        
        #create all default lps for user
        $allPrefabLBs = DB::table('landingpagePrefabs')->get();
        

        #delete any default subscriptions created by file system. This is not where admin created users are activated
        DB::table('subscriptions')->where('user_id', '=', $user->id)->delete();
        /*
        foreach ($allPrefabLBs as $prefab) {
               
                DB::table('landingPages')->insert(['user_id' => $user->id, 'title' => $prefab->title, 'secondaryTitle' => $prefab->secondTitle, 'type' => $prefab->typeName]);
        }
        */

        $timeStamps = json_encode($timeStamps);
        $graphViewsData = json_encode($graphViewsData);
        $graphLeadsData = json_encode($graphLeadsData);
        $graphOrdersData = json_encode($graphOrdersData);

        $orders = DB::table('orders')->where(['userId' => $user->id])->count();
        $userHintState = DB::table('users')->where(['id' => $user->id])->pluck('helpBubbleState');
        

        return view('pages.user.dashboard', compact('hintText' ,'userHintState','user', 'countPages', 'totalViews', 'isRealestate', 'orders', 'timeStamps', 'timeStampsOrders', 'timeStampsViews', 'graphLeadsData', 'graphOrdersData', 'leads','graphViewsData', 'difference1', 'difference2', 'difference3'));
    }

    public function changeHintState(Request $request){
      $user = Auth::user();
      $hintNumber = $request->hintNumber;

      $userHintState = DB::table('users')->where('id', $user->id)->pluck('helpBubbleState');

      if($hintNumber == 0){
        DB::table('users')->where(['id' => $user->id])->update(['helpBubbleState' => 1]);
        return "Help Bubble State Changed to 1";
      }else if($hintNumber == 1){
        DB::table('users')->where(['id' => $user->id])->update(['helpBubbleState' => 2]);
        return "Help Bubble State Changed to 2";
      }else if($hintNumber == 2){
        DB::table('users')->where(['id' => $user->id])->update(['helpBubbleState' => 3]);
        return "Help Bubble State Changed to 3";
      }else if($hintNumber == 3){
        DB::table('users')->where(['id' => $user->id])->update(['helpBubbleState' => 4]);
        return "Help Bubble State Changed to 3";
      }

      return "success";
    }

    public function neverShowHints(Request $request){
      $user = Auth::user();
      
      DB::table('users')->where(['id' => $user->id])->update(['helpBubbleToggle' => 0]);

      return "success";
    }

}
