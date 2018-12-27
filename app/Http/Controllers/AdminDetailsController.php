<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use File;
use DB;

class AdminDetailsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRoutes()
    {
		$routes = Route::getRoutes();
		$data = [
			'routes' => $routes
		];

       return view('pages.admin.route-details', $data);
    }

    public function listPHPInfo()
    {
        return view('pages.admin.php-details');
    }

    public function createPrefabLandingPages(){
        /*
        $allUsers = DB::table('users')->get();
        
         #we no longer use this, this has been replaced with users creating landing pages on the fly
        foreach ($allUsers as $user ) {
            
            $doWeHaveRealEstate = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->count();

            $doWeHaveEcommerce = DB::table('landingPages')->where(['user_id' => $user->id,'type' => 'New Product Countdown'])->count();

            if( $doWeHaveRealEstate == 0){
                //Realestate
                /* Create  default landing pages in landingPages table. 
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "What's my home worth?", 'secondaryTitle' => 'Fill out the address form to find out.', 'type' => 'Home Valuation']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "The best way to find your home", 'secondaryTitle' => 'With over 700,000 active listings, Realtyspace has the largest inventory of apartments in the United States', 'type' => 'Property Details']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Maximize your time by advertising your open houses", 'secondaryTitle' => 'This is the secondary title of the third landing page, this should probably be changed before going live, check activateController', 'type' => 'Open Houses']);
                
            }else if($doWeHaveEcommerce == 0){
                //Ecommerce
                
                /* Create  default landing pages in landingPages table for ecommerce landing pages. 
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "Product Launch Countdown", 'secondaryTitle' => 'Our new product will launch in', 'type' => 'New Product Countdown']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product Coupon", 'secondaryTitle' => 'Use this coupon to get a deal on our new product', 'type' => 'New Product Coupon']);
                DB::table('landingPages')->insert(['user_id' => $user->id,'title' => "New Product For Sale", 'secondaryTitle' => 'Secondary Title', 'type' => 'Single Item Shopping Cart']);
            }


        }
        */
        return 'done';


    }

}