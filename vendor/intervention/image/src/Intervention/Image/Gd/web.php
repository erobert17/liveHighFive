<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
//Route::get('/', 'WelcomeController@welcome')->name('welcome');

Route::get('/', 'WelcomeController@welcome')->name('welcome');

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => 'web'], function() {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);

    Route::get('storage/{filename}', function ($filename)
    {
        return Image::make(storage_path('public/' . $filename))->response();
    });

    /* user unique link */
    
    //Route::get('/link/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link']);
    Route::get('/link/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link']);

    Route::get('/link1/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link1']);
    Route::get('/link2/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link2']);

    Route::get('/link4/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link4']);
    Route::get('/link5/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link5']);
    // Shopping cart links
    Route::get('/link6/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link6']);
    Route::post('/singleItemCheckoutStepTwo', ['as' => 'singleItemCheckoutStepTwo', 'uses' => 'LandingPageController@singleItemCheckoutStepTwo']);
    Route::post('/singleItemCheckoutStepThree', ['as' => 'singleItemCheckoutStepThree', 'uses' => 'LandingPageController@singleItemCheckoutStepThree']);

    Route::post('/checkoutFinal', ['as' => 'singleItemCheckoutStepThree', 'uses' => 'LandingPageController@checkoutFinal']);

    //LP 7 Digital Download
    Route::get('/link7/{code}', ['as' => 'link', 'uses' => 'LandingPageController@link7']);

    Route::get('/openHouseLink/{userId}/{propertyId}', ['as' => 'openHouseLink', 'uses' => 'LandingPageController@openHouseLink']);
    //Auth::user()->onPlan('monthlyPremium')

    /*landing page routes */
    Route::any('/submitAddress/', ['uses' => 'LandingPageController@searchAddress']);
    Route::post('/submitContactInfo', ['uses' => 'LandingPageController@saveContactInfo']);
    Route::get('/viewHomeValue', ['as' => 'viewHomeValue', 'uses' => 'LandingPageController@viewHomeValue']);

    /* landing page 2*/
    Route::post('/submittedContactLP2', ['as' => 'submittedContactLP2', 'uses' => 'LandingPageController@submittedContactLP2']);//step 2

    /* landing page 3 */
    Route::post('/lp3/createProperty', ['as' => 'createProperty', 'uses' => 'LandingPageController@createProperty']);
    Route::post('/lp3/editProperty', ['as' => 'editProperty', 'uses' => 'LandingPageController@editProperty']);
    Route::post('/deleteOpenhouse', ['as' => 'deleteOpenhouse', 'uses' => 'LandingPageController@deleteOpenhouse']);
    Route::post('/saveShowingInquiry', ['as' => 'saveShowingInquiry', 'uses' => 'LandingPageController@saveShowingInquiry']);

    // Route to show user avatar
    Route::get('/uploads/users/id/{id}/avatar/{image}', [
        'uses'      => 'LandingPageController@userProfileAvatar'
    ]);

    Route::post('/submitEmailLp4', ['uses' => 'LandingPageController@submitEmailLp4']);
    Route::post('/submitEmailLp5', ['uses' => 'LandingPageController@submitEmailLp5']);
     
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated']], function() {

    Route::get('/testDash', function () {
        return view('testDash');
    });
    
    /* Noob Help Pop Ups*/
    Route::post('/changeHintState', ['uses' => 'ProfilesController@changeHintState']);
    Route::post('/neverShowHints', ['uses' => 'ProfilesController@neverShowHints']);

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout']);

    //  Homepage Route - Redirect based on user role is in controller.
    #Route::get('/home', ['as' => 'public.home',   'uses' => 'ProfilesController@dashboard']);
    Route::get('/home', ['as' => 'public.home', 'uses' => 'ProfilesController@dashboard']);
    Route::get('/externalDashboardElements', ['uses' => 'UserController@externalDashboardElements']);

   
    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@show'
    ]);

    /*Cashier*/
    Route::get('/test', function(){
        $user = Auth::user();
        return view('cart', compact('user'));
    });

    Route::post('/', function(){// single one time charge example, working with api
        $total = Auth::user()->cart->sum(function($cart){
            return $cart->product->price * $cart->quantity;
        });

        //charge(amount in cents)
        Auth::user()->charge($total * 100, ['source' => Input::get('stripeToken')]);

        return 'Charged';
    });

    Route::get('subscribe', ['uses' => 'SubscriptionsController@subscribe']);

    /*Route::get('subscribe', function () {
        $user = Auth::user();

        return view('subscribe', compact('user'));
    });*/

    Route::post('subscribe', function (Request $request) {//this reciveses data from stripe form and created subscription.
        $user = Auth::user();

        //$user->newSubscription('main', 'monthlyPremium')->withCoupon('special')->create(Input::get('stripeToken'));
        $thisPlansPrice = $request->price;
        if($thisPlansPrice == '44.95'){
            $user->newSubscription('main', 'monthlyPremium')->create(Input::get('stripeToken'));
        }else if($thisPlansPrice == '495.00'){
            $user->newSubscription('main', 'Yearly_Premium')->create(Input::get('stripeToken'));
        }else if($thisPlansPrice == '79.95'){
            $user->newSubscription('main', 'Monthly_Unlimited_Users')->create(Input::get('stripeToken'));
        }else if($thisPlansPrice == '950.00'){
            $user->newSubscription('main', 'Yearly_Unlimited_Users')->create(Input::get('stripeToken'));
        }

        return redirect()->action('SubscriptionsController@subscribe');

        //return view('subscribe');/// finished subscribing
    });

    Route::get('cancel',function(){
        Auth::user()->subscription('main')->cancel();
        $canceled = true;
        return view('subscriptions.cancel', compact('canceled'));
    
    });

    Route::get('testing', function(){
        //dd(Auth::user()->onPlan('monthlyPremium') );// correct way of checking if user is subscribed, with correct name
        //dd(Auth::user()->subscription('main')->cancelled());
        dd(Auth::user()->subscription('main')->onGracePeriod() ); //has user canceled
        //dd(Auth::user()->subscribed('main'));
    });

});

// Registered, activated, and is current user routes.
Route::group(['middleware'=> ['auth', 'activated', 'currentUser']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only'  => [
                'show',
                'edit',
                'update',
                'create'
            ]
        ]
    );

    Route::delete('profile/{username}/edit', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@edit'
    ]);

    Route::put('profile/{username}/updateUserAccount', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@updateUserAccount'
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@updateUserPassword'
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@deleteUserAccount'
    ]);

    // Route to show user avatar
    /* Route::get('/uploads/users/id/{id}/avatar/{image}', [
        'uses'      => 'ProfilesController@userProfileAvatar'
    ]);*/

    // Route to show user avatar
    Route::get('yourlp', [
        'uses'      => 'LandingPageController@index'
    ]);

    Route::get('edit/landingPage/1', [
        'uses'      => 'LandingPageController@editLandingPage1'
    ]);

    Route::get('edit/landingPage/2', [
        'uses'      => 'LandingPageController@editLandingPage2'
    ]);

    Route::get('edit/landingPage/3', [
        'uses'      => 'LandingPageController@editLandingPage3'
    ]);

    //e-commerce count down
    Route::get('edit/landingPage/4', [
        'uses'      => 'LandingPageController@editLandingPage4'
    ]);
    //e-commerce coupon
    Route::get('edit/landingPage/5', [
        'uses'      => 'LandingPageController@editLandingPage5'
    ]);

    Route::get('edit/landingPage/6', [
        'uses'      => 'LandingPageController@editLandingPage6'
    ]);

    Route::get('edit/landingPage/7', [
        'uses'      => 'LandingPageController@editLandingPage7'
    ]);

    Route::get('orders', [
        'uses'      => 'LandingPageController@orders'
    ]);

    Route::get('allLandingPages', [
        'uses'      => 'LandingPageController@allLandingPages'
    ]);

    //landingpage1
    Route::get('landingPageStats', ['uses'      => 'LandingPageController@landingPageStats']);

    // landing page 2
    Route::get('landingPage2Stats', ['uses'      => 'LandingPageController@landingPage2Stats']);
    // 3
    Route::get('landingPage3Stats', ['uses'      => 'LandingPageController@landingPage3Stats']);
    //ecommerce lp stats
    Route::get('landingPage4Stats', ['uses'      => 'LandingPageController@landingPage4Stats']);
    Route::get('landingPage5Stats', ['uses'      => 'LandingPageController@landingPage5Stats']);

    Route::get('landingPage7Stats', ['uses'      => 'LandingPageController@landingPage7Stats']);
    
    Route::get('specificOpenHouesMessages/{propId}', ['uses'      => 'LandingPageController@specificOpenHouesMessages']);

    Route::post('/uploadBackground', ['as' => 'uploadBackground', 'uses' => 'LandingPageController@uploadBackground']);
    Route::post('/uploadBackground2', ['as' => 'uploadBackground2', 'uses' => 'LandingPageController@uploadBackground2']);// lp 2
    Route::post('/uploadBackground3', ['as' => 'uploadBackground3', 'uses' => 'LandingPageController@uploadBackground3']);// lp 2

    Route::post('/propertyImagesUpload', ['as' => 'uploadBackground3', 'uses' => 'LandingPageController@propertyImagesUpload']);// lp 2
    Route::post('/deletePropPhoto', ['as' => 'deletePropPhoto', 'uses' => 'LandingPageController@deletePropPhoto']);// lp 2
    
    //lp4
    Route::post('/uploadBackground4', ['as' => 'uploadBackground4', 'uses' => 'LandingPageController@uploadBackground4']);
    Route::post('/uploadProductImg4', ['as' => 'uploadProductImg4', 'uses' => 'LandingPageController@uploadProductImg4']);

    // lp 5
    Route::post('/uploadBackground5', ['as' => 'uploadBackground5', 'uses' => 'LandingPageController@uploadBackground5']);
    Route::post('/uploadProductImg5', ['as' => 'uploadProductImg5', 'uses' => 'LandingPageController@uploadProductImg5']);

    Route::post('/uploadBackground6', ['as' => 'uploadBackground6', 'uses' => 'LandingPageController@uploadBackground6']);
    Route::post('/uploadProductImg6', ['as' => 'uploadProductImg6', 'uses' => 'LandingPageController@uploadProductImg6']);

    // lp 7
    Route::post('/uploadBackground7', ['as' => 'uploadBackground7', 'uses' => 'LandingPageController@uploadBackground7']);
    Route::post('/uploadProductImg7', ['as' => 'uploadProductImg7', 'uses' => 'LandingPageController@uploadProductImg7']);
    Route::post('/uploadDigitalDownload', ['as' => 'uploadDigitalDownload', 'uses' => 'LandingPageController@uploadDigitalDownload']);

    // Branding
    // profile edit disabled for now. relaced with account settings
    Route::get('profile/{username}/edit', [
        'as'        => '{username}',
        'uses'      => 'ProfilesController@show'
    ]);
    Route::get('/accountSettings', ['as' => 'accountSettings', 'uses' => 'ProfilesController@accountSettings']);
    Route::any('/updateAccountSettings', ['as' => 'updateAccountSettings', 'uses' => 'ProfilesController@updateAccountSettings']);

    // Upload company logo
    Route::post('/uploadCompanyLogo', ['as' => 'uploadCompanyLogo', 'uses' => 'ProfilesController@uploadCompanyLogo']);
    Route::post('/updateCompanyBranding', ['as' => 'updateCompanyBranding', 'uses' => 'ProfilesController@updateCompanyBranding']);
    Route::any('/uuu', ['as' => 'uuu', 'uses' => 'ProfilesController@uuu']);

    Route::post('/uploadUserAvatar', ['as' => 'uploadUserAvatar', 'uses' => 'ProfilesController@uploadUserAvatar']);
    Route::post('/updateUserBranding', ['as' => 'updateUserBranding', 'uses' => 'ProfilesController@updateUserBranding']);
    Route::get('/branding', ['as' => 'branding', 'uses' => 'ProfilesController@branding']);
    
    //edit Openhouse ajax
    Route::post('/getOpenhouse', ['uses' => 'LandingPageController@getOpenhouse']);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);

    //Route for update button on edit page
    Route::post('/saveLandingPage1', ['uses' => 'LandingPageController@saveLandingPage1']);

    Route::post('/saveLandingPage2', ['uses' => 'LandingPageController@saveLandingPage2']);

    Route::post('/saveLandingPage3', ['uses' => 'LandingPageController@saveLandingPage3']);

    Route::post('/saveLandingPage4', ['uses' => 'LandingPageController@saveLandingPage4']);
    
    Route::get('/lp4Output', ['uses' => 'LandingPageController@lp4Output']);
    Route::get('/lp5Output', ['uses' => 'LandingPageController@lp5Output']);
    Route::post('/saveLandingPage5', ['uses' => 'LandingPageController@saveLandingPage5']);
    

    Route::post('/saveLandingPage6', ['uses' => 'LandingPageController@saveLandingPage6']);

    Route::post('/saveShippingPlan', ['uses' => 'LandingPageController@saveShippingPlan']);
    Route::any('/deleteShippingPlan', ['uses' => 'LandingPageController@deleteShippingPlan']);

    Route::post('/saveLandingPage7', ['uses' => 'LandingPageController@saveLandingPage7']);

});

// Registered, activated, and is admin routes.
Route::group(['middleware'=> ['auth', 'activated', 'role:admin']], function () {

    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ]
    ]);

    //give user free year subscription, clicked from view users page, admin users only
    Route::post('/giveFreeYear', ['uses' => 'UsersManagementController@giveFreeYear']);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index' => 'users',
            'destroy' => 'user.destroy'
        ],
        'except' => [
            'deleted'
        ]
    ]);

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index' => 'themes',
            'destroy' => 'themes.destroy'
        ]
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('php', 'AdminDetailsController@listPHPInfo');
    Route::get('routes', 'AdminDetailsController@listRoutes');

    Route::get('/createPrefabLandingPages', 'AdminDetailsController@createPrefabLandingPages');

});