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

                    
                    /* Create  default landing pages in landingPages table. */
                    $countHomeValuation = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->count();
                    if($countHomeValuation == 0){
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "What's my home worth?", 'secondaryTitle' => 'Fill out the address form to find out.', 'type' => 'Home Valuation']);
                    }

                    $countPropertyDetails = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Property Details'])->count();
                    if($countPropertyDetails == 0){
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "The best way to find your home", 'secondaryTitle' => 'With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States', 'type' => 'Property Details']);
                    }

                    $countOpenHouses = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Open Houses'])->count();
                    if($countOpenHouses == 0){
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Maximize your time by advertising your open houses", 'secondaryTitle' => 'This is the secondary title of the third landing page, this should probably be changed before going live, check activateController', 'type' => 'Open Houses']);
                    }
                    

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

                    $countCountdown = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->count();

                    if($countCountdown == 0){
                        /* Create  default landing pages in landingPages table for ecommerce landing pages. */
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Product Launch Countdown", 'secondaryTitle' => 'Our new product will launch in', 'type' => 'New Product Countdown']);
                    }

                    $countCoupon = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->count();
                    if($countCoupon == 0){
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product Coupon", 'secondaryTitle' => 'Use this coupon to get a deal on our new product', 'type' => 'New Product Coupon']);
                    }

                    $countSingleCart = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Single Item Shopping Cart'])->count();
                    if($countSingleCart == 0){
                        DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product For Sale", 'secondaryTitle' => 'Secondary Title', 'type' => 'Single Item Shopping Cart']);
                    }

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
        /*
        echo '<pre>';
        var_dump($user);
        echo '<pre>';*/
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserPassword(Request $request, $id)
    {

        $currentUser = \Auth::user();
        $user        = User::findOrFail($id);
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

        return redirect('profile/'.$user->name.'/edit')->with('success', trans('profile.updatePWSuccess'));

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

    public function dashboard(){

        //Count number of pages, per industry, + each open house, if realestate
        $user = Auth::user();
        $landingPages = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        $landingPagesArray = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        $userIndos = DB::table('userAssignedIndustries')->where(['userId' => $user->id ])->pluck('industryNumber')->toArray();

        $leads = DB::table('leads')->where('user_id', $user->id)->count();

        $hintText = DB::table('hintText')->get();
     
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
          $timeStamps1;
          //positive, if industry real estate
          if( in_array(1, $userIndos) == true ){
            $isRealestate = true;
            $homeValuationViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->count();
            $propertyDetailsViews = DB::table('views')->where(['userId' => $user->id, 'type' => 'Property Details'])->count();
            //Get all properties to construct array of ids to get lead and views from openHouseLeads table.
            $propertiesIds = DB::table('properties')->where(['userId' => $user->id])->pluck('id')->toArray();
            $openHouseViews = DB::table('openHouseLeads')->where(['hitType' => 'visit'])->whereIn('id', $propertiesIds)->count();
            $totalViews = ($homeValuationViews + $propertyDetailsViews + $openHouseViews);

            // Construct two speical arrays to use as data and label in graph
            $timeStamps1 = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('timeStamp')->toArray();
            $timeStamps2 = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('timeStamp')->toArray();
            $timeStamps3 = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('timeStamp')->toArray();
            
            //$graphData1 = DB::table('views')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('')->toArray();
          }

          if( in_array(2, $userIndos) == true ){// is ecommerce
            $isEcommerce = true;
          }

        }

        //cut off all after space in timeStamps
        for ($i=0; $i < count($timeStamps1); $i++) { 
            $timeStamps1[$i] = substr($timeStamps1[$i], 0, strpos($timeStamps1[$i], " "));
        }
        

        $graphData = []; $tempTimeStamp = '';$alreadyTimestamp=[];
        for ($i=0; $i < count($timeStamps1); $i++) { // foreach timestamp
            $tempCount=0;
            $tempTimeStamp = (String)$timeStamps1[$i];
            foreach ($timeStamps1 as $timeStamp) { // count occurences of this timestamp
                $timeStamp = (String)$timeStamp;
                if($tempTimeStamp == $timeStamp){
                    //echo $tempTimeStamp .' ---- '. $timeStamp.'<br><br>';
                    $tempCount++;
                }
            }
            if(!in_array($timeStamps1[$i], $alreadyTimestamp)){
                array_push($alreadyTimestamp, $timeStamps1[$i]);
                array_push($graphData, $tempCount); 
            }
            
        }
        $timeStamps1 = $alreadyTimestamp;
       
        $graphData = json_encode($graphData);
        $graphData = trim($graphData, '"');

        $timeStamps1 = json_encode($timeStamps1);
        $timeStamps1 = trim($timeStamps1, '"');

        $countPages = count($landingPagesArray);
        if($isRealestate == true){
            //since the user might have open houses, add hopen houses to pagecount
            $countPages = $countPages + count($propertiesIds);
        }

        $orders = DB::table('orders')->where(['userId' => $user->id])->count();
        $userHintState = DB::table('users')->where(['id' => $user->id])->pluck('helpBubbleState');
        
        return view('pages.user.dashboard', compact('hintText' ,'userHintState','user', 'countPages', 'totalViews', 'isRealestate', 'orders', 'timeStamps1', 'leads','graphData'));

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
      }

      return "success";
    }

    public function neverShowHints(Request $request){
      $user = Auth::user();
      
      DB::table('users')->where(['id' => $user->id])->update(['helpBubbleToggle' => 0]);

      return "success";
    }

}
