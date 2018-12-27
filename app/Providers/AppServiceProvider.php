<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        

        Schema::defaultStringLength(191);

        
                view()->composer('*', function($view) {
                    $captchaQuestions = DB::table('captchaQuestions')->get();
                    /*
                    echo '<pre>';
                    var_dump($captchaQuestions);
                    echo '</pre>';
                    */
                    if(auth::check() == true){ 
                        $thisUser = auth()->user();
                        $userHintState = DB::table('users')->where('id', $thisUser->id)->pluck('helpBubbleState');
                        $userIndustries = DB::table('userAssignedIndustries')->where('userId', '=', $thisUser->id)->pluck('industryNumber');
                        $userIndustries = $userIndustries->toArray();

                        $view->with(['userIndustries' => $userIndustries,
                            'userHintState' => $userHintState, 
                            'captchaQuestions' => $captchaQuestions]);
                    }else{
                        $view->with(['userIndustries' => null, 'captchaQuestions' => $captchaQuestions] );
                    }
                });
            
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
