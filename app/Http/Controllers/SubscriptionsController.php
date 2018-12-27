<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Billable;
use DB;
use Carbon\Carbon;


class SubscriptionsController extends Controller
{
 
   
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function subscribe()
    {
        $user = Auth::user();
        $price = null;$term = null;$freeTrial = false; $ends_at = null;
        $endsAt = DB::table('subscriptions')->where('user_id', $user->id)->pluck('ends_at');
        //return $user->subscription('main')->cancelled();
        $subscribed = Auth::user()->onPlan('monthlyPremium');
        $price = '44.95';
        $term = "monthly";
        if($subscribed == false){
            $subscribed = Auth::user()->onPlan('Monthly_Unlimited_Users');
            $price = '79.95';
            $term = "monthly";
        }
        if($subscribed == false){
            $subscribed = Auth::user()->onPlan('Yearly_Premium');
            $price = '495.00';
            $term = "yearly";
        }
        if($subscribed == false){
            $subscribed = Auth::user()->onPlan('Yearly_Unlimited_Users');
            $price = '950.00';
            $term = "yearly";
        }

        $freeTrialBool = false;
        if($subscribed == false){
            $freeTrialBool = DB::table('subscriptions')->where('user_id', '=', Auth::user()->id)->pluck('freeTrial');
        }
        
        
        if(isset($freeTrialBool[0])){
            if($freeTrialBool[0] == '1'){
                $ends_at = DB::table('subscriptions')->where('user_id', '=', Auth::user()->id)->pluck('ends_at');
                $ends_at = str_replace('[', '', $ends_at);
                $ends_at = str_replace(']', '', $ends_at);
                $ends_at = str_replace('"', '', $ends_at);
                $now = Carbon::now();
                $now = (string)$now;
                //echo $ends_at.' > '.$now.'<br>';
                if ($ends_at > $now){
                    $freeTrial = true;
                    $subscribed = true;
                }
            }
        }

        if($user->subscription('main') && $user->subscription('main')->onGracePeriod()){
            $grace = true;
        }else{
            $grace = false;
        }

        //$canceled = $user->subscription('monthlyPremium')->cancelled();
        $subscriptionTypes = DB::table('subscriptionTypes')->get();

        return view('subscribe', compact('user', 'subscribed', 'grace', 'subscriptionTypes', 'price', 'term', 'endsAt', 'freeTrial'));
    }

       
}