<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Helper;
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
use Web;
use Guzzlehttp\Client;
use Laravel\Cashier\Billable;

class BrandingController extends Controller
{
    use Billable;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    /* First Landing Page, Home Evaluation*/
    public function branding(){

        $thisUser = DB::table('users')->where('randomUserLink', $code)->first();
        $landingPageNumber = '1';
        $lp = DB::table("landingPages")->where('user_id', $thisUser->id)->where('type', 'Home Valuation')->take(1)->get();
        $lp = $lp[0];

        $userId = $thisUser->id;

        $authorUser = User::find($thisUser->id);
        
        //var_dump($authorUser->onPlan('monthlyPremium'));
        //var_dump($authorUser->onPlan('monthlyPremium'));

        //check if owner is subscribed    
        if($authorUser->onPlan('monthlyPremium') == true){// author is subscribed, and current
          DB::table('landingPages')->where('user_id', $thisUser->id)->where('type', 'Home Valuation')->increment('views');
          return view('landingPage', compact('lp', 'userId', 'code'));
        }

        //If unsubscribed, only allow access if logged in.
        if(Auth::user()){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";          
          
          return view('landingPage', compact('lp', 'userId', 'code', 'warningTitle', 'landingPageNumber'));
        }
        return "These aren't the droids you're looking for.";// stop non-logged user.
    }

}