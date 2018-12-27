<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Auth;

class SendToAllProvider extends ServiceProvider
{
     /**
     * Bootstrap the application services.
     * @return void
     */
    
    public function boot()
    {

        view()->composer('*', function ($view)
        {
            $view_name = str_replace('.', '-', $view->getName());#used to get view file name so we can make sure differnces code doesn't run more than once
            
            if($view_name === 'layouts-default'){
                $user = Auth::user();
                if($user != Null){
                    $userHintState = DB::table('users')->where('id', $user->id)->pluck('helpBubbleState');
                      
                  // Retrieve leads from leadsLastLogin table
                  //This will take place everytime user login and redirect to /home 
                  $difference1 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference1, 'type' => 'Home Valuation']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference1 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->update(['difference' => $difference1]);
                  }

                  //lp2 leads 
                  $difference2 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Property Details'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference2, 'type' => 'Property Details']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference2 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->update(['difference' => $difference2]);
                  }

                  //lp3 leads Open House
                  $difference3 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('openHouseLeads')->where(['userId' => $user->id, 'hitType' => 'message'])->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{ // if row for open house doesnt exist in leadsLastLogin, create it for this user
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => 0, 'type' => 'Open House']);
                    $storedLeadsSinceLastLogin = 0;
                  }

                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference3 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->update(['difference' => $difference3]);
                  }

                  //LP4  contdown
                  $difference4 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->count();

                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference4, 'type' => 'New Product Countdown']);
                  }

                  
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference4 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->update([ 'difference' => $difference4]);
                  }

                  //LP5 New Product Coupon
                  $difference5 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference5, 'type' => 'New Product Coupon']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference5 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->update([ 'difference' => $difference5]);
                  }

                  //LP6 New Product Coupon
                  $difference6 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('orders')->where(['userId' => $user->id])->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference6, 'type' => 'Shopping Cart']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference6 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Shopping Cart'])->update([ 'difference' => $difference6]);
                  }

                  //LP7 Digital Download
                  $difference7 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Digital Download'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Digital Download'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Digital Download'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference7, 'type' => 'Digital Download']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference7 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Digital Download'])->update([ 'difference' => $difference7]);
                  }

                  //LP8 Appointment
                  $difference8 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Appointment'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Appointment'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Appointment'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference8, 'type' => 'Appointment']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference8 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Appointment'])->update([ 'difference' => $difference8]);
                  }

                  //LP9 Mailing List
                  $difference9 = 0;
                  $storedLeadsSinceLastLogin = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Mailing List'])->pluck('leads')->toArray();
                  $countAllLeadsOfThisType = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Mailing List'])->orderBy('date', 'desc')->count();
                  if( count($storedLeadsSinceLastLogin) > 0){
                    $storedLeadsSinceLastLogin = $storedLeadsSinceLastLogin[0];
                  }else{// if row doesn't exist in leadsLastLogin, add this lp type to row
                   DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Mailing List'])->insert(['userId' =>$user->id, 'leads' => $countAllLeadsOfThisType, 'difference' => $difference9, 'type' => 'Mailing List']);
                  }
                  if($storedLeadsSinceLastLogin < $countAllLeadsOfThisType){//Leads have changed
                    $difference9 = ($storedLeadsSinceLastLogin - $countAllLeadsOfThisType) * -1;
                    DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Mailing List'])->update([ 'difference' => $difference9]);
                  }

                  //get all questions
                  $captchaQuestions = DB::table('captchaQuestions')->get();
                          
                          $userHintState = $userHintState[0];
                          $view->with(['userHintState' => $userHintState, 
                              'difference1' => $difference1, 
                              'difference2' => $difference2,
                              'difference3' => $difference3,
                              'difference4' => $difference4,
                              'difference5' => $difference5,
                              'difference6' => $difference6,
                              'difference7' => $difference7,
                              'difference8' => $difference8,
                              'difference9' => $difference9,
                              'captchaQuestions' => $captchaQuestions]);
                }
            }

        });
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}