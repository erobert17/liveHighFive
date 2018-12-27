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
            $user = Auth::user();
            if($user != Null){
                $userHintState = DB::table('users')->where('id', $user->id)->pluck('helpBubbleState');
                
                $difference1 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Home Valuation'])->pluck('difference');
                if(!count($difference1) > 0){
                    $difference1 = 0;
                }else{
                    $difference1 = $difference1[0];
                }
                
                $difference2 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Property Details'])->pluck('difference');
                if(!count($difference2) > 0){
                    $difference2 = 0;
                }else{
                    $difference2 = $difference2[0];
                }

                $difference3 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'Open House'])->pluck('difference');
                if(!count($difference3) > 0){
                    $difference3 = 0;
                }else{
                    $difference3 = $difference3[0];
                }

                $difference4 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->pluck('difference');
                if(!count($difference4) > 0){
                    $difference4 = 0;
                }else{
                    $difference4 = $difference4[0];
                }

                $difference5 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Coupon'])->pluck('difference');
                if(!count($difference5) > 0){
                    $difference5 = 0;
                }else{
                    $difference5 = $difference5[0];
                }

                $difference5 = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->pluck('difference');
                if(!count($difference5) > 0){
                    $difference5 = 0;
                }else{
                    $difference5 = $difference5[0];
                }
                
                $userHintState = $userHintState[0];
                $view->with(['userHintState' => $userHintState, 
                    'difference1' => $difference1, 
                    'difference2' => $difference2,
                    'difference3' => $difference3,
                    'difference4' => $difference4,
                    'difference5' => $difference5,
                    'difference6' => $difference6]);
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
