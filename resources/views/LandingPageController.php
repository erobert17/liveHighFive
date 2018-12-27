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
use DateTime;

class LandingPageController extends Controller
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
    public function link1($code){

        $thisUser = DB::table('users')->where('randomUserLink', $code)->first();
        $landingPageNumber = '1';
        $lp = DB::table("landingPages")->where('user_id', $thisUser->id)->where('type', 'Home Valuation')->take(1)->get();
        $lp = $lp[0];

        $userId = $thisUser->id;

        $authorUser = User::find($thisUser->id);
        
        //var_dump($authorUser->onPlan('monthlyPremium'));

        //check if owner is subscribed    
        if($authorUser->onPlan('monthlyPremium') == true){// author is subscribed, and current
          DB::table('views')->insert(['userId' => $thisUser->id, 'type' => 'Home Valuation']);
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

    public function link2($code){

        $thisUser = DB::table('users')->where('randomUserLink', $code)->first();
        $landingPageNumber = '2';
        $lp = DB::table("landingPages")->where('user_id', $thisUser->id)->where('type', 'Property Details')->take(1)->get();
        $lp = $lp[0];

        $userId = $thisUser->id;

        $authorUser = User::find($thisUser->id);
        
        //var_dump($authorUser->onPlan('monthlyPremium'));
        //var_dump($authorUser->onPlan('monthlyPremium'));

        //check if owner is subscribed    
        if($authorUser->onPlan('monthlyPremium') == true){// author is subscribed, and current
          DB::table('views')->insert(['userId' => $thisUser->id, 'type' => 'Property Details']);
          return view('landingPagePropertyDetails', compact('lp', 'userId', 'code', 'landingPageNumber'));
        }

        //If unsubscribed, only allow access if logged in.
        if(Auth::user()){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";          
          
          return view('landingPagePropertyDetails', compact('lp', 'userId', 'code', 'warningTitle'));
        }
        return "These aren't the droids you're looking for.";// stop non-logged user.
    }

    /* Landing Page 3, openhouse showings */
    public function openHouseLink($userId, $propertyId){

        // record page visit in 
        $propertyUserId = DB::table('properties')->where(['id' => $propertyId])->pluck('userId');
        DB::table("openHouseLeads")->insert(['propertyId' => $propertyId, 'userId' => $userId, 'hitType' => 'visit']);

        $authorUser = User::find($userId);
        $author = DB::table('users')->where('id','=',$userId)->get();
        $authorAvatar = DB::table('profiles')->where('user_id','=',$userId)->get();

        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        $userProfile = $userProfile[0];

        //var_dump($authorUser->onPlan('monthlyPremium'));
        //var_dump($authorUser->onPlan('monthlyPremium'));

        //Recent properties
        $recentImages = [];
        $properties = DB::table('properties')->where('userId', '=', $userId)->take(3)->get();
        foreach ($properties as $prop) {

          $thisImage = DB::table('propertyImages')
          ->where('userId', '=', $userId)
          ->where('propertyId', '=', $prop->id)->take(1)->get();

          if(isset($thisImage[0]->imageName)){
           array_push($recentImages, $thisImage[0]->imageName);
          } 
        }

        DB::table('views')->insert(['userId' => $userId, 'type' => 'Open House']);

        //check if owner is subscribed
        if($authorUser->onPlan('monthlyPremium') == true){// author is subscribed, and current
          $thisProperty = DB::table('properties')->where('properties.id', '=', $propertyId)
          ->leftJoin('propertyImages', 'properties.id', '=', 'propertyImages.propertyId')
          ->leftJoin('openHouseBackgrounds', 'properties.id', '=', 'openHouseBackgrounds.propertyId')->get();

          return view('landingPageOpenHouse', compact('userId', 'thisProperty', 'author', 'authorAvatar', 'properties', 'recentImages', 'propertyId', 'userProfile'));
        }

        //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";          
          $thisProperty = DB::table('properties')->where('properties.id', '=', $propertyId)
          ->leftJoin('propertyImages', 'properties.id', '=', 'propertyImages.propertyId')
          ->leftJoin('openHouseBackgrounds', 'properties.id', '=', 'openHouseBackgrounds.propertyId')->get();

          return view('landingPageOpenHouse', compact('userId', 'thisProperty', 'warningTitle', 'author', 'authorAvatar', 'properties', 'recentImages', 'propertyId', 'userProfile'));
    }

    /* Landing Page 4, countdown */
    public function link4($code){
        $user = DB::table('users')->where('randomUserLink', '=', $code)->take(1)->get();
        $user = $user[0];

        $userId = $user->id;
        // 1 = admin, 2 = user
        $userRole = DB::table("role_user")->where("user_id", '=', $userId)->pluck("role_id");
        $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','New Product Countdown')->get();

        // record page visit !!!!!!
        DB::table('views')->insert(['userId' => $userId, 'type' => 'New Product Countdown']);

        $authorUser = User::find($userId);
        $author = DB::table('users')->where('id','=',$userId)->get();
        
        $productImg = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('productImg');
        $productImg = (string)$productImg;
        $background = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('background');
        
        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        $userProfile = $userProfile[0];

        //check if owner is subscribed, or is admin
        /* if($authorUser->onPlan('monthlyPremium') == true ||  $userRole === 1 || Auth::user() ){// author is subscribed, and current

          return view('landingPageCountdown', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow'));
        }*/

        return view('landingPageCountdown', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow', 'user'));

        return "These aren't the droids you're looking for.";//top non-logged user.
    }

    /* Landing Page 5, coupon */
    public function link5($code){
        $user = DB::table('users')->where('randomUserLink', '=', $code)->take(1)->get();
        $user = $user[0];

        $userId = $user->id;
        // 1 = admin, 2 = user
        $userRole = DB::table("role_user")->where("user_id", '=', $userId)->pluck("role_id");

        $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','New Product Coupon')->get();
        
        // record page visit !!!!!!
        DB::table('views')->insert(['userId' => $userId, 'type' => 'New Product Coupon']);

        $authorUser = User::find($userId);
        $author = DB::table('users')->where('id','=',$userId)->get();
        
        $productImg = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('productImg');
        $productImg = (string)$productImg;
        $background = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('background');
        
        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        $userProfile = $userProfile[0];


        //check if owner is subscribed, or is admin
        // Disabled this to allow non-premium members who have their lps viewed no matter what
        /*if($authorUser->onPlan('monthlyPremium') == true || $userRole === 1 || Auth::user() ){// author is subscribed, and current

          return view('landingPageCoupon', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow'));
        }*/

        return view('landingPageCoupon', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow', 'user'));

        return "These aren't the droids you're looking for.";//top non-logged user.
    }

    /* Landing Page 6, shopping cart */
    public function link6($code){
        $user = DB::table('users')->where('randomUserLink', '=', $code)->take(1)->get();

        $userId = $user[0]->id;
        // 1 = admin, 2 = user
        $userRole = DB::table("role_user")->where("user_id", '=', $userId)->pluck("role_id");

        $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','Single Item Shopping Cart')->get();

        $product = DB::table('products')->where('userId', '=', $userId)->take(1)->get();
        //$product = $product[0];

        $productImages = DB::table("productImages")->where('userId', '=', $userId)->get();
        
        $featuredProductImage = DB::table("productImages")->where(['userId' => $userId, 'featured' => 1])->take(1)->get();
        //$featuredProductImage = $featuredProductImage[0];
        
        // record page visit !!!!!!
        DB::table('views')->insert(['userId' => $userId, 'type' => 'Single Item Shopping Cart']);

        $authorUser = User::find($userId);
        $author = DB::table('users')->where('id','=',$userId)->get();
        
        $productImg = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('productImg');
        $productImg = (string)$productImg;
        //$background = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('background');
        
        $background = DB::table('backgroundImages')->where(['userId' => $userId, 'active' => 1])->pluck('name');
        
        if($background != Null && isset($background[0]) ){

          $background = $background[0];
        }else{
          $backgroundAll = DB::table('backgroundImages')->where(['userId' => $userId, 'landingPage' => 'Single Item Shopping Cart'])->get();

          if( count($backgroundAll) > 0 ){
            $background = $backgroundAll[0]->name;
            //If we don't have an active background but we still have backgrounds, then set the first bg to active
            DB::table('backgroundImages')->where(['userId' => $userId, 'id' => $background->id, 'landingPage' => 'Single Item Shopping Cart'])->update(['active' => 1]);
          }
        
        }

        //$backgrounds = DB::table('backgroundImages')->where(['user_id' => $userId, 'landingPage' => 'Single Item Shopping Cart'])->get();
        
        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        //$userProfile = $userProfile[0];

        $shippingPlans = DB::table('shippingPlans')->where('userId', $userId)->take(1)->get();
        
        if($userProfile[0]->avatar_status != 1 && Auth::user()->id == $userId){
          return 'Your Company Logo is needed for this shopping cart to work. <a href="http://growyourleads.com/branding">Click here</a> to set it up.';
        }

        if( isset($productImages)
          && isset($product) 
          && isset($product[0]->name) 
          && isset($shippingPlans)
          && count($shippingPlans) > 0
          && isset($thisLandingPageRow[0]->titleColor)
          && isset($product[0]->price)
          && isset($thisLandingPageRow[0]->title)
          && isset($thisLandingPageRow[0]->disclaimerColor)
          && isset($thisLandingPageRow[0]->disclaimer)
          && isset($product[0])
          && isset($thisLandingPageRow[0]->secondaryTitle) ){

          //check if owner is subscribed, or is admin
          // Disabled this to allow non-premium members who have their lps viewed no matter what
          /*
          if($authorUser->onPlan('monthlyPremium') == true || $userRole === 1 || Auth::user() ){// author is subscribed, and current

            return view('singleItemShoppingCart', compact('user', 'userId', 'author', 'background','productImg','userProfile', 'featuredProductImage', 'thisLandingPageRow', 'product', 'productImages'));
          }*/

          return view('singleItemShoppingCart', compact('user', 'userId', 'author', 'background','productImg','userProfile', 'featuredProductImage', 'thisLandingPageRow', 'user', 'shippingPlans', 'product', 'productImages'));
        }else{
          if(Auth::user()->id == $userId){
            return "This shopping cart hasn't been fully setup yet.<a href='http://growyourleads.com/edit/landingPage/6'>Go Back </a>and finish all the nessecary fields. ";
          } else{
            return "This shopping cart hasn't been fully setup yet.";
          }
          
        }

        return "These aren't the droids you're looking for. ";//top non-logged user.

    }

        /* Landing Page 5, coupon */
    public function link7($code){
        $user = DB::table('users')->where('randomUserLink', '=', $code)->take(1)->get();
        $user = $user[0];

        $userId = $user->id;
        // 1 = admin, 2 = user
        $userRole = DB::table("role_user")->where("user_id", '=', $userId)->pluck("role_id");

        $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','Digital Download')->get();
        
        // record page visit !!!!!!
        DB::table('views')->insert(['userId' => $userId, 'type' => 'Digital Download']);

        $authorUser = User::find($userId);
        $author = DB::table('users')->where('id','=',$userId)->get();
        
        $productImg = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('productImg');
        $productImg = (string)$productImg;
        $background = DB::table('landingPages')->where('user_id', '=', $userId)->pluck('background');
        
        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        $userProfile = $userProfile[0];


        //check if owner is subscribed, or is admin
        // Disabled this to allow non-premium members who have their lps viewed no matter what
        /*if($authorUser->onPlan('monthlyPremium') == true || $userRole === 1 || Auth::user() ){// author is subscribed, and current

          return view('landingPageCoupon', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow'));
        }*/

        return view('landingpageDigitalDownload', compact('userId', 'author', 'background','productImg','userProfile', 'thisLandingPageRow', 'user'));

        return "These aren't the droids you're looking for.";//top non-logged user.
    }


    public function singleItemCheckoutStepTwo(Request $request){
      $userId = $request->userId;

      $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','Single Item Shopping Cart')->get();
      $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
      //$userProfile = $userProfile[0];

      //shipping plan inputs are dynamic, so go through and see if we have found the last one,
      // should really just be using angular for this.


      $shippingPlans = DB::table('shippingPlans')->where(['userId' => $userId])->get();

      $background = DB::table('backgroundImages')->where(['userId' => $userId, 'active' => 1])->pluck('name');
      if(strlen($background) > 5){
        $background = $background[0];
      }else{
        $background = 'backgroundLP6.png';
      }

      $user = DB::table('users')->where('id', '=', $request->userId)->get();
      $product = DB::table('products')->where('userId', '=', $request->userId)->take(1)->get();
      //$product = $product[0];
      $qty = $request->qty;

      return view('singleItemShoppingCartStepTwo', compact('product', 'qty', 'user', 'userId', 'background','userProfile', 'thisLandingPageRow', 'shippingPlans'));
    }

      public function singleItemCheckoutStepThree(Request $request){
        $userId = $request->userId;
        $user = DB::table('users')->where('id', '=', $userId)->get();

        $user = $user[0];
        $userEmail = $user->email;
        $stripeKey = $user->stripeKey;
        
        $thisLandingPageRow = DB::table('landingPages')->where('user_id', '=', $userId)->where('type', '=','Single Item Shopping Cart')->get();
        $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
        $userProfile = $userProfile[0];

        $background = DB::table('backgroundImages')->where(['userId' => $userId, 'active' => 1])->pluck('name');
        if(strlen($background) > 5){
          $background = $background[0];
        }else{
          $background = 'backgroundLP6.png';
        }
        
        $user = DB::table('users')->where('id', '=', $request->userId)->get();
        $product = DB::table('products')->where('id', '=', $request->productId)->take(1)->get();
        $product = $product[0];
        
        $phone1 = $request->phone1;
        $phone2 = $request->phone2;
        $email = $request->email1;

        $state = $request->state;
        $zip = $request->zip;

        $qty = $request->qty;
        $shippingPlanPrice = $request->shippingPlan;
        
        $date = new DateTime;
        $date->modify('-1 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $orderAlreadyCreated = DB::table('orders')->where('created','>=',$formatted_date)->count();

        if($orderAlreadyCreated == 0){

          $orderId = DB::table('orders')->insertGetId([
        'productId' => $product->id,
        'productName' => $product->name,
        'price' => $product->price,
        'qty' => $qty,
        'userId' => $userId,
        'enabled' => 0,
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'phone1' => $request->phone1,
        'phone2' => $request->phone2,
        'email' => $request->email1,
        'streetAddress' => $request->street,
        'city' => $request->city,
        'state' => $request->state,
        'customState' => $request->state2,
        'country' => $request->country,
        'zip' => $request->zip,
        'shippingPlan' => $request->shippingPlan]);

          $thisOrder = DB::table('orders')->where(['id' => $orderId])->take(1)->get();
          $thisOrder = $thisOrder[0];
        }else{
          $orderId = DB::table('orders')->where('created','>=',$formatted_date)->take(1)->get();
          $orderId = $orderId[0]->id;
          $thisOrder = DB::table('orders')->where('created','>=',$formatted_date)->take(1)->get();  
          $thisOrder = $thisOrder[0];
          return 'error will robinson';
        }

        $shippingPlans = DB::table('shippingPlans')->where(['userId' => $userId, 'id' => $request->shippingPlan])->take(1)->get();
        $shippingPlans = $shippingPlans[0];

        $qtyInt = (int)($qty);
        $priceInt = (float)($product->price);
        $totalPrice = $qtyInt * $priceInt;
        $totalPrice = (string)$totalPrice;
        $totalPriceHuman = $totalPrice;
        $totalPrice = str_replace('.', '', $totalPrice);

      return view('singleItemShoppingCartStepThree', compact('stripeKey', 'user','product', 'qty', 'user', 'userId', 'background','userProfile', 'thisLandingPageRow', 'shippingPlans', 'orderId', 'thisOrder', 'userEmail', 'totalPrice', 'totalPriceHuman'));
    }

    public function checkoutFinal(Request $request){
  
      DB::table('orders')->where('id', '=', $request->orderId)->update(['enabled' => 1]);

      return view('singleItemShoppingCartStepFinished', compact('userId', 'user'));
      
    }


    public function saveShowingInquiry(Request $request){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $message = $request->message;
        $datepicker1 = $request->datepicker1;
        $datepicker2 = $request->datepicker2;
        $propertyId = $request->propertyId;

        $userIdOfProp = DB::table('properties')->where(['id' => $propertyId])->pluck('userId');
        $userIdOfProp = $userIdOfProp[0];
        DB::table('openHouseLeads')->insert([
          'name' => $name,
          'userId' => $userIdOfProp, 
          'email' => $email, 
          'phone' => $phone, 
          'message' => $message, 
          'firstDate' => $datepicker1, 
          'secondDate' => $datepicker2,
          'propertyId' => $propertyId,
          'hitType' => 'message']);

        return 'Success';

    }

    public function submittedContactLP2(Request $request){
        $code = $request->code;

        $thisUser = DB::table('users')->where('randomUserLink', $code)->get();
        $userId = $thisUser[0]->id;

        $name = $request->name;
        $email = $request->email;
        $cell = $request->phone;

        //Save results
        DB::table('leads')->insert(['name' => $name, 'email' => $email, 'cell' => $cell, 'linkCode' => $code, 'user_id' => $userId, 'type' => 'Property Details']);

        return 'THANKS ITS WORKING, now we need a api connection.';
    }

    /* landing page 1*/
    public function searchAddress(Request $request){//Step1

      //$address = $request->address;
      $code = $request->code;
      $userId = $request->userId;
      $address = $request->address;

      $thisUser = DB::table('users')->where('randomUserLink', $request->code)->get();
      
      $userId = $thisUser[0]->id;
      
      /* zillow api */
      function getStringBetween($str,$from,$to)
      {
          $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
          return substr($sub,0,strpos($sub,$to));
      }

      $addressf = (string)$request->address;
      $addressf = '**'.$addressf;
      $street = getStringBetween($addressf,'**',',');
      $street = urlencode($street);
      $pos = strpos($addressf, ',');$addressf = substr($addressf, $pos + 1); // remove everything before ,
      
      $addressf = '**'.$addressf;
      $city = getStringBetween($addressf,'**',',');
      //$city = urlencode($city);
      $city = ltrim($city);
      $city = str_replace(' ', '%2C', $city);
      $pos = strpos($addressf, ',');$addressf = substr($addressf, $pos + 1); // remove everything before ,

      //$addressf = '**'.$addressf;
      //echo '$addressf '.$addressf.'<br>';
      //$state = getStringBetween($addressf,'**',',');
      $state = substr($addressf, 0, 3);
      //echo 'state-start:'.$state.'<br>';
      $state = urlencode($state);
      //echo 'state-end:'.$state.'<br>';

      $addressf = $street.'&citystatezip='.$city.'%2C'.$state;
      
      //'1610 Westminster Place, Ann Arbor, MI, United States'
      //2114+Bigelow+Ave&citystatezip=Seattle%2C+WA
      //$addressf = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=".$addressf;

      //$addressf = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1funoky0t1n_a80zd&address=".$addressf;
      
      //$addressf = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1funoky0t1n_a80zd&address=2114+Bigelow+Ave&citystatezip=Seattle%2C+WA";
      //echo '$addressf: '.$addressf. ' :$addressf ';
      $addressf = 'http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1funoky0t1n_a80zd&address='.$addressf;
      
      //print $addressf . ' :end of address';
      //echo '$addressf:    '.$addressf.' done ';
      //$addressf = "http://www.google.com";
      $userId = $request->userId;
      $address = $request->address;
      $client = new \GuzzleHttp\Client();

      //$response = $client->get($addressf);
      //$response = $client->get($addressf);
      try {
        $response = $client->get($addressf);
          //$response = $client->post($this->url, $params);
      } catch (\GuzzleHttp\Exception\ClientException $e) {

        //var_dump($e->getResponse()->getBody()->getContents());

      }
      $xml = $response->getBody()->getContents();
      $xml=new \SimpleXMLElement($xml);
      $x = $xml->asXML();
      $Json = json_encode(simplexml_load_string($x));
      $results = json_decode($Json);
      
      //echo $results->response->results->result->lastSoldDate;
      
      /*
      echo '<pre>';
      var_dump($results->response->results->result);
      echo '<pre>';*/

      if($results->message->code != '0'){
        
        $thisUser = DB::table('users')->where('randomUserLink', $code)->get();
        $lp = DB::table("landingPages")->where('user_id', $thisUser[0]->id)->take(1)->get();
        $lp = $lp[0];
        $userId = $thisUser[0]->id;
        $returnError = 'We were unable to validate the address you entered.';
        
        return view('landingPage', compact('lp', 'userId', 'code', 'returnError'));
      
      }elseif( isset($results->response->results->result->lastSoldDate) ){
        $lastSoldDate = $results->response->results->result->lastSoldDate;
        $lastSoldPrice = $results->response->results->result->lastSoldPrice;
      }

      /*
      echo '<pre>';
      var_dump($results);
      echo '</pre>';
      */
      /* end api */

      return view('landingPageStep2', compact('address', 'userId', 'code', 'lastSoldDate', 'lastSoldPrice'));
    }

    public function saveContactInfo(Request $request){//Step 2

        $code = $request->code;
        
        $address = $request->address;
        $thisUser = DB::table('users')->where('randomUserLink', $code)->get();
        $userId = $thisUser[0]->id;

        $userName = $request->userName;
        $email = $request->email;
        $cell = $request->cell;


        //Save results
        DB::table('leads')->insert(['name' => $userName, 'email' => $email, 'cell' => $cell, 'linkCode' => $code, 'user_id' => $userId, 'type' => 'Home Valuation']);

        #DB::table('leads')->insert(['user_id' => $userId, 'linkCode' => $code, 'name' => $userName, 'email' => $email, 'cell' => $cell, 'type' => 'Home Valuation']);
        
        
        return redirect()->route('viewHomeValue', compact('address', 'userId'));

    }

    public function viewHomeValue(Request $request){
      function getStringBetween($str,$from,$to)
      {
          $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
          return substr($sub,0,strpos($sub,$to));
      }

      $addressf = (string)$request->address;
      $addressf = '**'.$addressf;
      $street = getStringBetween($addressf,'**',',');
      $street = urlencode($street);
      $pos = strpos($addressf, ',');$addressf = substr($addressf, $pos + 1); // remove everything before ,
      
      $addressf = '**'.$addressf;
      $city = getStringBetween($addressf,'**',',');
      //$city = urlencode($city);
      $city = ltrim($city);
      $city = str_replace(' ', '%2C', $city);
      $pos = strpos($addressf, ',');$addressf = substr($addressf, $pos + 1); // remove everything before ,

      $addressf = '**'.$addressf;
      $state = getStringBetween($addressf,'**',',');
      $state = urlencode($state);

      $addressf = $street.'&citystatezip='.$city.'%2C'.$state;

      //'1610 Westminster Place, Ann Arbor, MI, United States'
      //2114+Bigelow+Ave&citystatezip=Seattle%2C+WA
      //$addressf = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=".$addressf;
      $addressf = 'http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1funoky0t1n_a80zd&address='.$addressf;

      $userId = $request->userId;
      $userProfile = DB::table('profiles')->where('user_id', $userId)->get();
      $userProfile = $userProfile[0];
      $user = DB::table('users')->where('id', $userId)->take(1)->get();
      $user = $user[0];
      //http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=2114+Bigelow+Ave&citystatezip=Seattle%2C+WA";
      //http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=1610+Westminster+Place&citystatezip=Ann%2Arbor%2C+MI
        
      //$url = 'http://www.zillow.com/webservice/GetZestimate.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&zpid=48749425';
      //$url = 'http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=816+South+State+Street&citystatezip=Ann%2CArbor%2C+MI
      //$url = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1fsozb2q0wb_9tzan&address=2114+Bigelow+Ave&citystatezip=Seattle%2C+WA";

      $address = $request->address;

      $client = new \GuzzleHttp\Client();
      $response = $client->get($addressf);
      $xml = $response->getBody()->getContents();
      $xml=new \SimpleXMLElement($xml);
      $x = $xml->asXML();
      $Json = json_encode(simplexml_load_string($x));
      $results = json_decode($Json);
    
      //echo '<pre>';
      //var_dump($results->response->results->result->zestimate->valuationRange);
      //echo '<pre>';
      //echo $results; // { "type": "User", ....

      if(isset($results->response->results->result->zestimate) ){
        $low = $results->response->results->result->zestimate->valuationRange->low;
        $middle = $results->response->results->result->zestimate->amount;
        $high = $results->response->results->result->zestimate->valuationRange->high;
      }else{
        $low = $results->response->results->result[0]->zestimate->valuationRange->low;
        $middle = $results->response->results->result[0]->zestimate->amount;
        $high = $results->response->results->result[0]->zestimate->valuationRange->high;
      }
      
      return view('landingPageStep3', compact('low','middle','high', 'userId', 'address', 'userProfile', 'user'));
      
    }

    /* landing page 2*/
    public function saveUserInfo(Request $request){//Step 2

        $code = $request->code;

        $address = $request->address;
        $thisUser = DB::table('users')->where('randomUserLink', $code)->get();
        $userId = $thisUser[0]->id;

        $userName = $request->userName;
        $email = $request->email;
        $cell = $request->cell;

        //Save results
        DB::table('leads')->insert(['name' => $userName, 'email' => $email, 'cell' => $cell, 'linkCode' => $code, 'user_id' => $userId, 'type' => 'Property Details']);

        return 'Thank YOU!!!';
    }

    public function index()
    {

        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }

        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.yourLP', compact('landingPage', 'userLink', 'user', 'warningTitle'));
        }
        return view('pages.yourLP', compact('landingPage', 'userLink', 'user'));

    }

    public function editLandingPage1(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->where('type', 'Home Valuation')->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        $landingPageNumber = '1';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.yourLP', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber'));
        }
        return view('pages.yourLP', compact('landingPage', 'userLink', 'user', 'landingPageNumber'));
    }

    public function editLandingPage2(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Property Details'])->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        
        $landingPageNumber = '2';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.yourLP', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber'));
        }
        return view('pages.yourLP', compact('landingPage', 'userLink', 'user', 'landingPageNumber'));
    }

    public function editLandingPage3(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Open Houses'])->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        
        //Check that user's person info, company, phone, name are all set so that a business card can be generated.
        $businessCardCorrect = true;$businesscardWarning = '';
        if( strlen($user->first_name) > 1 && strlen($user->last_name) > 1
        && strlen($user->company) > 3 && strlen($user->phone) > 6 ){
          $businessCardCorrect = false;
        }else{
          $businesscardWarning = "Not all of your contact information appears to be correct. This info is important because it's
          displayed on every Open House Landing Page. <a href='/profile/".$user->name."' >Click Here</a> to update your First, Last names, Phone, Company.";
        }
        $tempRandomString = md5(uniqid(rand(), true));// for linking prop photos to newly created property images
        //$propertyPhotos = DB::table('propertyImages')->where('usersId' => $user->id)
        $properties = DB::table('properties')->where('userId', '=', $user->id)->get();
        $landingPageNumber = '3';
        //If this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. You are limited to only three active properties.";
          //var_dump($warningTitle);
          return view('pages.editLP3', compact('landingPage', 'userLink', 'user', 'landingPageNumber', 'warningTitle', 'properties', 'tempRandomString', 'businessCardCorrect', 'businesscardWarning'));
        }
        return view('pages.editLP3', compact('landingPage', 'userLink', 'user', 'landingPageNumber', 'properties', 'tempRandomString', 'businessCardCorrect', 'businesscardWarning'));
    }

    //ecommerce edit lp
    public function editLandingPage4(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        
        $landingPageNumber = '4';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.landingPageCountdownEdit', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber'));
        }
        return view('pages.landingPageCountdownEdit', compact('landingPage', 'userLink', 'user', 'landingPageNumber'));
    }

    public function editLandingPage5(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        
        $landingPageNumber = '5';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.landingPageCouponEdit', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber'));
        }
        return view('pages.landingPageCouponEdit', compact('landingPage', 'userLink', 'user', 'landingPageNumber'));
    }

    /* single item cart */
    public function editLandingPage6(){
      
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Single Item Shopping Cart'])->get();

        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }

        $product = DB::table('products')->where('userId', '=', $userId)->get();
        //$product = $product[0];
        
        $productImages = DB::table("productImages")->where('userId', '=', $userId)->get();
        $shippingPlans = DB::table('shippingPlans')->where(['userId' => $user->id])->get();

        //Make sure we have a active background
        $backgroundActive = DB::table('backgroundImages')->where(['userId' => $userId, 'landingPage' => 'Single Item Shopping Cart', 'active' => 1])->get();

        $backgrounds = DB::table('backgroundImages')->where(['userId' => $userId, 'landingPage' => 'Single Item Shopping Cart'])->get();

        if(count($backgroundActive) == 0 || $backgroundActive == Null){
          if(count($backgrounds) > 0){// if not active
            DB::table('backgroundImages')->where(['userId' => $userId, 'id' => $backgrounds[0]->id])->update(['active' => 1]);
          }
          
        }

        $backgrounds = DB::table('backgroundImages')->where(['userId' => $userId, 'landingPage' => 'Single Item Shopping Cart'])->get();


        $landingPageNumber = '6';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.landingSingleItemCartEdit', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber', 'shippingPlans', 'product', 'shippingPlans', 'productImages', 'backgrounds'));
        }
        return view('pages.landingSingleItemCartEdit', compact('landingPage', 'userLink', 'user', 'landingPageNumber', 'shippingPlans', 'product', 'shippingPlans', 'productImages', 'backgrounds'));
    }

    // 7 digital Download
    public function editLandingPage7(){
        $user = Auth::user();
        $userId = $user->id;
        $landingPage = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Digital Download'])->get();
        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }
        
        $landingPageNumber = '7';
        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.landingPageDigitalDownload', compact('landingPage', 'userLink', 'user', 'warningTitle', 'landingPageNumber'));
        }
        return view('pages.landingPageDigitalDownload', compact('landingPage', 'userLink', 'user', 'landingPageNumber'));
    }

    /* Landing page 3 */
    public function createProperty(Request $request){
      function getStringBetween($str,$from,$to)
      {
          $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
          return substr($sub,0,strpos($sub,$to));
      }

      $user = Auth::user();
      $newPropId = DB::table('properties')->insertGetId(['userId' => $user->id ,
                'address' => $request->address,
                'price' => $request->price,
                'topBullets' => $request->jsonBullets,
                'bulletsInterior' => $request->jsonInteriorBulletsCreate,
                'bulletsExterior' => $request->jsonExteriorBulletsCreate,
                'bulletsDimentions' => $request->jsonDimentionsBulletsCreate,
                'propertyDescription' => $request->propertyDescription]);
      //geolocate
      $cityclean = str_replace (" ", "+", $request->address);
       $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $cityclean . "&sensor=false";

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $details_url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $geoloc = json_decode(curl_exec($ch), true);
            //return $results->response->results->result->address->latitude;

      if( isset($geoloc["results"][0]["geometry"]["location"]["lat"]) &&
      strlen($geoloc["results"][0]["geometry"]["location"]["lat"]) > 5 ){
        $geolocation = [$geoloc["results"][0]["geometry"]["location"]["lat"], $geoloc["results"][0]["geometry"]["location"]["lng"] ];
        DB::table('properties')->where('id' , '=', $newPropId)->update(['geolocation' => json_encode($geolocation)]);
            
      }
      //Assign property photos to property
      //tempRandomString
      DB::table('propertyImages')->where('tempRandomString' , '=', $request->tempRandomString)->update(['propertyId' => $newPropId]);

      //If user uploaded more than one background before hitting create button
      //Get most recent background id
      $mostRecentBackgroundId = DB::table('openHouseBackgrounds')->where('tempRandomString' , '=', $request->tempRandomString)->orderBy('upload_time', 'desc')->pluck('id')->first();
      // Delete backgrounds with same tempRandomString and not the same Id as most recent
      DB::table('openHouseBackgrounds')->where('tempRandomString' , '=', $request->tempRandomString)->where('id', '<>', $mostRecentBackgroundId)->delete();
      //Update correct background with correct propertyId
      DB::table('openHouseBackgrounds')->where('tempRandomString' , '=', $request->tempRandomString)->update(['propertyId' => $newPropId]);

      return redirect()->action('LandingPageController@editLandingPage3');

    }

    public function editProperty(Request $request)
    {

      DB::table('properties')->where('id', '=', $request->propertyId)->update(['address' => $request->address,
        'price' => $request->price, 
        'topBullets' => $request->jsonBullets, 
        'bulletsInterior' => $request->jsonInteriorBulletsUpdate,
        'bulletsExterior' => $request->jsonExteriorBulletsUpdate,
        'bulletsDimentions' => $request->jsonDimentionsBulletsUpdate,
        'propertyDescription' => $request->propertyDescription]);

      return redirect()->action('LandingPageController@editLandingPage3');
    }

    public function getOpenhouse(Request $request)
    {
      $thisProperty = DB::table('properties')->where('properties.id', '=', $request->propertyId)
      ->leftJoin('propertyImages', 'properties.id', '=', 'propertyImages.propertyId')
      ->leftJoin('openHouseBackgrounds', 'properties.id', '=', 'openHouseBackgrounds.propertyId')->get();
      
      $thisProperty[0]->id = $request->propertyId;
      return json_encode($thisProperty);
    }

    public function deleteOpenhouse(Request $request)
    {
      DB::table('properties')->where('id', '=', $request->propertyId)->delete();
      DB::table('propertyImages')->where('propertyId', '=', $request->propertyId)->delete();

      return 'successfully deleted';
    }

    public function deletePropPhoto(Request $request)
    {
      $thisProperty = DB::table('propertyImages')->where('imageName', '=', $request->photoId)->delete();

      return 'success';
    }

    public function allLandingPages()
    {
        $user = Auth::user();
        $userId = $user->id;

        $hintText = DB::table('hintText')->get();
        // noob hint bubble, turn state to 1 if not already
        $userHintState = DB::table('users')->where('id', $user->id)->pluck('helpBubbleState');
        $userHintState = $userHintState[0];
        if($userHintState == 0){
          DB::table('users')->where(['id' => $user->id])->update(['helpBubbleState' => 1]);
          $userHintState = 1;
        }
        
        $landingPages = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        $landingPagesArray = DB::table('landingPages')->where('user_id', $user->id)->get()->toArray();
        
        $userIndos = DB::table('userAssignedIndustries')->where(['userId' => $user->id, ])->pluck('industryNumber')->toArray();

        //unset($landingPages->{$key})
        //Remove landing pages from array if user isn't signed up for that specific industry,
        //Must be updated if we add more industry types or landing pages to existing industries

        for ($i=0; $i <= count($landingPages); $i++) {

          if( in_array(1, $userIndos) == false ){
            //
            if(isset($landingPages[$i])){

              if($landingPages[$i]->type == 'Home Valuation' || $landingPages[$i]->type == 'Property Details' || $landingPages[$i]->type == 'Open Houses'){
                unset($landingPagesArray[$i]);
                //unset($landingPages->{$key})
              }
            
            }  

          }else if( in_array(2, $userIndos) == false ){
            //

            if(isset($landingPages[$i])){

              if($landingPages[$i]->type == 'New Product Countdown' || $landingPages[$i]->type == 'New Product Coupon' || $landingPages[$i]->type == 'Single Item Shopping Cart'){
                unset($landingPagesArray[$i]);
              }

            }
            
          }

        }


        $landingPagesArray = array_chunk($landingPagesArray, 2);
        $landingPages = (object) $landingPagesArray;

        $userLink = DB::table('users')->where('id', $user->id)->take(1)->get();
        if(isset($userLink[0])){
          $userLink = $userLink[0]->randomUserLink;
        }else{
          $userLink = '';
        }

        //if this user isn't subscribed, return the warning with the page.
        if(Auth::user()->subscribed('main') == false){
          //Must be the author, send a vaiable to be used as a warrning title.
          $warningTitle = "You haven't <a href='/subscribe'>subscribed</a> yet. This landing page's link will only work for others once you subscribe.";
          //var_dump($warningTitle);
          return view('pages.allLandingPages', compact('hintText', 'userHintState','landingPages', 'userLink', 'user', 'warningTitle'));
        }
        return view('pages.allLandingPages', compact('hintText', 'userHintState', 'landingPages', 'userLink', 'user'));

    }

    public function saveLandingPage1(Request $request){

        $user = Auth::user();
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
        if( count($landingPage) == 0){
            DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
            DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->update(['title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }
        return redirect()->action('LandingPageController@editLandingPage1');

    }

    public function saveLandingPage2(Request $request){
        $user = Auth::user();
        $newTitle = $request->title;
        $newSTitle = $request->secondaryTitle;
        DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Property Details'])->update(['title' => $newTitle,
                'secondaryTitle' => $newSTitle]);

        $user = Auth::user();
        $userID = $request->userID;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
        
        if( count($landingPage) == 0){
          
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Property Details'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
          
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Property Details'])->update(['title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }
        return redirect()->action('LandingPageController@editLandingPage2');
    }

    public function saveLandingPage3(Request $request){
        $user = Auth::user();
        $newTitle = $request->title;
        $newSTitle = $request->secondaryTitle;
        DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Open Houses'])->update(['title' => $newTitle,
                'secondaryTitle' => $newSTitle]);

        $user = Auth::user();
        $userID = $request->userID;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
        
        if( count($landingPage) == 0){
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Open Houses'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Open Houses'])->update(['title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }
        return redirect()->action('LandingPageController@editLandingPage3');
    }

    public function saveLandingPage4(Request $request){// countdown
      $user = Auth::user();
        $newTitle = $request->title;
        $newSTitle = $request->secondaryTitle;
        $dateTimestamp = $request->countDownDateTimestamp;
        $disclaimer = $request->disclaimer;
        $titleShadow = $request->titleTextShadow;
        if($request->titleTextShadow == null){
          $titleShadow = 0;
        }else if($request->titleTextShadow == 'on'){
          $titleShadow = 1;
        }else{
          $titleShadow = 0;
        }

        DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->update(
          ['preCountdownText' => $request->preCountdownText,
          'title' => $newTitle,
          'secondaryTitle' => $newSTitle,
          'countdown' => $dateTimestamp,
          'disclaimer' => $disclaimer,
          'titleShadow' => $titleShadow]);

        $user = Auth::user();
        $userID = $request->userID;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
        
        if( strlen($request->titleColor) > 2 || strlen($request->disclaimerColor) > 2 || strlen($request->backgroundColor) > 2 || strlen($request->buttonColor) > 2 ){
           DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->update([
           'titleColor' => $request->titleColor,
           'disclaimerColor' => $request->disclaimerColor,
           'backgroundColor' => $request->backgroundColor,
           'buttonColor' => $request->buttonColor]);     
        }
        
        if( count($landingPage) == 0){
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'New Product Countdown'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
            DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->update(['title' => $newTitle,
                'secondaryTitle' => $newSTitle,
                'countdown' => $dateTimestamp]);
        }
        return redirect()->action('LandingPageController@editLandingPage4');
    }

    public function saveLandingPage5(Request $request){// coupon
      $user = Auth::user();
        $newTitle = $request->title;
        $newSTitle = $request->secondaryTitle;
        $disclaimer = $request->disclaimer;
        $coupon = $request->coupon;
        $titleShadow = $request->titleTextShadow;
        if($request->titleTextShadow == null){
          $titleShadow = 0;
        }else if($request->titleTextShadow == 'on'){
          $titleShadow = 1;
        }else{
          $titleShadow = 0;
        }

        DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->update(['title' => $newTitle,
          'secondaryTitle' => $newSTitle,
          'disclaimer' => $disclaimer,
          'coupon' => $coupon,
          'storeUrl' => $request->storeUrl,
          'titleShadow' => $titleShadow]);

        if( strlen($request->titleColor) > 2 || strlen($request->disclaimerColor) > 2 || strlen($request->backgroundColor) > 2 || strlen($request->buttonColor) > 2 ){
           DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->update([
           'titleColor' => $request->titleColor,
           'disclaimerColor' => $request->disclaimerColor,
           'backgroundColor' => $request->backgroundColor,
           'buttonColor' => $request->buttonColor]);     
        }

        $user = Auth::user();
        $userID = $request->userID;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
       
        if( count($landingPage) == 0){
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'New Product Coupon'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'New Product Coupon'])->update(['title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }
        return redirect()->action('LandingPageController@editLandingPage5');
    }

    public function saveLandingPage6(Request $request){// Single item shopping cart
          $user = Auth::user();
          
          $newTitle = $request->title;
          $newSTitle = $request->secondaryTitle;
          $disclaimer = $request->disclaimer;
          $coupon = $request->coupon;
          $titleShadow = $request->titleTextShadow;
          if($request->titleTextShadow == null){
            $titleShadow = 0;
          }else if($request->titleTextShadow == 'on'){
            $titleShadow = 1;
          }else{
            $titleShadow = 0;
          }

          DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Single Item Shopping Cart'])->update(['title' => $newTitle,
            'secondaryTitle' => $newSTitle,
            'disclaimer' => $disclaimer,
            'titleShadow' => $titleShadow]);

          $productExists = DB::table('products')->where(['userId' => $user->id])->count();

          if($productExists > 0){
             DB::table('products')->where(['userId' => $user->id])->update(['userId' => $user->id,'name' => $request->productName,
            'price' => $request->productPrice]);
          }else{
             DB::table('products')->where(['userId' => $user->id])->insert(['userId' => $user->id,'name' => $request->productName,
            'price' => $request->productPrice]);
          }

          $shippingPlansCount = DB::table('shippingPlans')->where(['userId' => $user->id])->count();
          
          //UPDATEINSERT SHIPPING PLANS
          DB::table('users')->where(['id' => $user->id])->update(['stripeKey' => $request->stripeKey]);

          if( strlen($request->titleColor) > 2 || strlen($request->disclaimerColor) > 2 || strlen($request->backgroundColor) > 2 || strlen($request->buttonColor) > 2 ){
             DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Single Item Shopping Cart'])->update([
             'titleColor' => $request->titleColor,
             'disclaimerColor' => $request->disclaimerColor,
             'backgroundColor' => $request->backgroundColor,
             'buttonColor' => $request->buttonColor]);     
          }

          $userID = $request->userID;
          $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
          
          //Set featured image
          if( $request->featured != Null){
            DB::table('productImages')->update(['featured' => 0]);
            DB::table('productImages')->where(['userId' => $user->id, 'id' => $request->featured])->update(['featured' => 1]);
          }else{// if no featured image, possible because user deleted it wihtout selecting a new one, set first to featured.
            DB::table('productImages')->where(['userId' => $user->id])->limit(1)->update(['featured' => 1]);
          }

          //Set featured backgroundImage
          if($request->activeBackground != Null){
            DB::table('backgroundImages')->update(['active' => 0]);
            DB::table('backgroundImages')->where(['userId' => $user->id, 'id' => $request->activeBackground])->update(['active' => 1]);
          }

          //Delete Product Images
          if( $request->imagesToDelete != Null){
            $imagesToDelete = json_decode($request->imagesToDelete);
            foreach ($imagesToDelete as $imageId) {
              $id = intval($imageId);
              DB::table('productImages')->where(['userId' => $user->id, 'id' => $imageId])->delete();
            }

          }

          //Delete Background
          if( $request->backgroundImagesToDelete != Null){
            $backgroundImagesToDelete = json_decode($request->backgroundImagesToDelete);
            foreach ($backgroundImagesToDelete as $imageId) {
              $id = intval($imageId);
              DB::table('backgroundImages')->where(['userId' => $user->id, 'id' => $imageId])->delete();
            }

          }
          
          if( count($landingPage) == 0){
              DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'New Product Coupon'])->insert(['user_id' => $user->id ,
                  'title' => $request->title,
                  'secondaryTitle' => $request->secondaryTitle]);
          }else{
              DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'New Product Coupon'])->update(['title' => $request->title,
                  'secondaryTitle' => $request->secondaryTitle]);
          }

        return redirect()->action('LandingPageController@editLandingPage6');
    
    }

    public function saveShippingPlan(Request $request){//Ajax Call
      $user = Auth::user();
      $newName=$request->newName;
      $newPrice=$request->newPrice;
      $rowId=$request->rowId;

      //DB::table('leads')->insert(['user_id' => $userId, 'type' => 'New Product Coupon', 'email' => $email]);
      if($rowId == null){
        $newId = DB::table('shippingPlans')->insertGetId(['userid' => $user->id, 'name' => $newName, 'price' => $newPrice]);
        return $newId;
      }else{
        DB::table('shippingPlans')->where(['id' => $rowId])->update(['userid' => $user->id, 'name' => $newName, 'price' => $newPrice]); 
      }

      return 'Success';
    }

    public function deleteShippingPlan(Request $request){//Ajax Call
      $user = Auth::user();
      $rowId = $request->rowId;

      DB::table('shippingPlans')->where('id', '=', $rowId)->delete(); 
      return $rowId;
      return 'Success';
    }

    public function saveLandingPage7(Request $request){// coupon
      $user = Auth::user();
        $newTitle = $request->title;
        $newSTitle = $request->secondaryTitle;
        $disclaimer = $request->disclaimer;
        $titleShadow = $request->titleTextShadow;
        if($request->titleTextShadow == null){
          $titleShadow = 0;
        }else if($request->titleTextShadow == 'on'){
          $titleShadow = 1;
        }else{
          $titleShadow = 0;
        }

        DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Digital Download'])->update(['title' => $newTitle,
          'secondaryTitle' => $newSTitle,
          'disclaimer' => $disclaimer,
          'titleShadow' => $titleShadow]);

        if( strlen($request->titleColor) > 2 || strlen($request->disclaimerColor) > 2 || strlen($request->backgroundColor) > 2 || strlen($request->buttonColor) > 2 ){
           DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Digital Download'])->update([
           'titleColor' => $request->titleColor,
           'disclaimerColor' => $request->disclaimerColor,
           'backgroundColor' => $request->backgroundColor,
           'buttonColor' => $request->buttonColor]);     
        }

        $user = Auth::user();
        $userID = $request->userID;
        $landingPage = DB::table('landingPages')->where('user_id', $user->id)->get();
       
        if( count($landingPage) == 0){
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Digital Download'])->insert(['user_id' => $user->id ,
                'title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }else{
            DB::table('landingPages')->where(['user_id' => $userID, 'type' => 'Digital Download'])->update(['title' => $request->title,
                'secondaryTitle' => $request->secondaryTitle]);
        }
        return redirect()->action('LandingPageController@editLandingPage7');
    }

    public function submitEmailLp4(Request $request){
      $userId=$request->userId;
      $email=$request->email;
      DB::table('leads')->insert(['user_id' => $userId, 'type' => 'New Product Countdown', 'email' => $email]);

      return 'Success';
    }

    public function lp4Output(Request $request){
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->get();
      //$storagePath = storage_path('uploads/users/id/' . $user->id . '/svLP4Output.csv');
      $publicPath = public_path('/uploads/users/id/'.$user->id.'/svLP4Output.csv');

      return view('lp4StatsOutput', compact('leads','user', 'storagePath', 'publicPath'));
    }

    public function lp5Output(Request $request){
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->get();
      //$storagePath = storage_path('uploads/users/id/' . $user->id . '/svLP4Output.csv');
      $publicPath = public_path('/uploads/users/id/'.$user->id.'/svLP5Output.csv');

      return view('lp5StatsOutput', compact('leads','user', 'storagePath', 'publicPath'));
    
    }

    public function submitEmailLp5(Request $request){
      $userId=$request->userId;
      $email=$request->email;
      DB::table('leads')->insert(['user_id' => $userId, 'type' => 'New Product Coupon', 'email' => $email]);
      
      return 'Success';
    }

    public function orders(Request $request){

      $user = Auth::user();
      
      $landingPageNumber = '6';
      
      $ordersActive = DB::table('orders')->where(['userId' => $user->id, 'enabled' => 1, 'archived' => 0])->orderBy('created', 'ASC')->get();

      $ordersArchived = DB::table('orders')->where(['userId' => $user->id, 'enabled' => 1, 'archived' => 1])->get();

      $shippingPlans = DB::table('shippingPlans')->where(['userId' => $user->id])->get();

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
      
      return view('pages.orders', compact('userId', 'user', 'ordersActive', 'ordersArchived', 'landingPageNumber', 'shippingPlans'));
    }

    public function landingPageStats(){// landing page 1
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->orderBy('date', 'desc')->get();
      $views = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Home Valuation'])->select('views')->get();
      $views = $views[0]->views;
      
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
      
      return view('pages.landingPageStats', compact('user', 'leads', 'views'));
    }

    public function landingPage2Stats(){// landing page 2
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'Property Details'])->orderBy('date', 'desc')->get();
      $views = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'Property Details'])->select('views')->get();
      $views = $views[0]->views;

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

      return view('pages.landingPageStats', compact('user', 'leads', 'views'));
      
    }

    public function landingPage3Stats(){// landing page 3
      $user = Auth::user();
      $visits = DB::table('properties')->where('properties.userId', '=', $user->id)
      ->leftJoin('openHouseLeads', 'properties.id', '=', 'openHouseLeads.propertyId')
      ->where('hitType', '=', 'visit')->get();

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

      $properties = DB::table('properties')->where('properties.userId', '=', $user->id)->get();

      $messages = DB::table('properties')->where('properties.userId', '=', $user->id)
      ->leftJoin('openHouseLeads', 'properties.id', '=', 'openHouseLeads.propertyId')
      ->where('hitType', '=', 'message')->get();
      return view('openHouseLeads', compact('properties', 'user', 'visits', 'messages'));
    }

    /* Ecommerce LP stats */
    public function landingPage4Stats(){// countdown
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->get();
      $views = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->select('views')->get();
      $views = $views[0]->views;

      #update table to turn off lead number in left menu(blue circle buble)
      $difference4 = 0;
      $storedLeads = DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->pluck('leads')->toArray();
      $storedLastLeads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Countdown'])->orderBy('date', 'desc')->count();
      if( count($storedLeads) > 0){
        $storedLeads = $storedLeads[0];
      }
      if($storedLeads < $storedLastLeads){//Leads have changed
        $difference4 = ($storedLeads - $storedLastLeads) * -1;
        DB::table('leadsLastLogin')->where(['userId' => $user->id, 'type' => 'New Product Countdown'])->update(['leads' => $storedLastLeads, 'difference' => $difference4]);
      }
      
      return view('landingPageStats4Countdown', compact('user', 'leads', 'views'));
    }

    public function landingPage5Stats(){//coupon
      $user = Auth::user();
      $leads = DB::table('leads')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->orderBy('date', 'desc')->get();
      $views = DB::table('landingPages')->where(['user_id' => $user->id, 'type' => 'New Product Coupon'])->select('views')->get();
      $views = $views[0]->views;
      
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
      
      return view('landingPageStats5Coupon', compact('user', 'leads', 'views'));
    }

    public function specificOpenHouesMessages($propId){// landing page 3
      $user = Auth::user();
      
      $messages = DB::table('properties')->where('properties.id', '=', $propId)
      ->leftJoin('openHouseLeads', 'properties.id', '=', 'openHouseLeads.propertyId')
      ->where('hitType', '=', 'message')->get();

      $smallMesssageArray = DB::table('openHouseLeads')->where('propertyId', '=', $propId)->where('hitType', '=', 'message')->get();
      
      $smallMesssageArray = json_encode($smallMesssageArray);
    
      return view('landingPageStats3', compact('user', 'messages', 'smallMesssageArray'));
    }

    public function ohMessages($propId){
      return 'test '.$propId;
    }

    public function uploadBackground() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP1.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP1.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
            // ...
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type'  => 'Home Valuation'])->update(['background' => $save_path.$filename]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

      public function uploadBackground2() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP2.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
            // ...
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Property Details'])->update(['background' => $save_path.$filename]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }
    
    public function uploadBackground3(Request $request) {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP3'.md5(uniqid(rand(), true)).'.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;
          $saveDBPath = '/uploads/users/id/'.$currentUser->id.'/'.$filename;
          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            //DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Open Houses'])->update(['background' => $save_path.$filename]);
            
            $bgAlreadyInDB = DB::table('openHouseBackgrounds')->where('propertyId', '=', $request->propertyId)->get();
            if( count($bgAlreadyInDB) == 0 ){
              if($request->propertyId == null){// save button not pressed yet
                DB::table('openHouseBackgrounds')->insert(['path' => $saveDBPath, 'tempRandomString' => $request->tempRandomString]);
              }else{
                DB::table('openHouseBackgrounds')->insert(['path' => $saveDBPath, 'propertyId' => $request->propertyId]);
              }
              
            }else{
              DB::table('openHouseBackgrounds')->where('propertyId', '=', $request->propertyId)->update(['path' => $saveDBPath]);
            }
            
            
            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    /**
     * Show user avatar
     *
     * @param $id
     * @param $image
     * @return string
     */
    public function userProfileAvatar($id, $image)
    {
        return Image::make('/uploads/users/id/' . $id . '/avatar/' . $image)->response();
    }

    // landing page 3
    public function propertyImagesUpload(Request $request) {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          $tempRandomString = $request->tempRandomString;
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'propertyImage'.md5(uniqid(rand(), true)).'.jpg';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/propertyImages/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $saveDBPath = '/uploads/users/id/'.$currentUser->id.'/propertyImages/'.$filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          Image::make($background->getRealPath())->save($save_path . $filename);

          if(!isset($request->propertyId)){//property was just created
            $imgId = DB::table('propertyImages')->insertGetId(
                ['userId' =>  $currentUser->id, 'imageName' => $saveDBPath, 'tempRandomString' => $tempRandomString]
            );
          }else{// property already created, Update
            DB::table('propertyImages')->insert(
                ['userId' =>  $currentUser->id, 'imageName' => $saveDBPath, 'propertyId' => $request->propertyId]
            );
          }

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    //LP4
    public function uploadBackground4() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP4.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          //$save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          Image::make($background->getRealPath())->save($path);
            

            //Image::make($background->getRealPath())->save($save_path . $filename);
            
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'New Product Countdown'])->update(['background' => $save_path.$filename]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    //LP4 product img upload
    
    public function uploadProductImg4() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'uploadProductCountdownImg.png';
          
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          $localSavePath = '/uploads/users/id/'.$currentUser->id.'/'.$filename;
          $localSavePath = (string)$localSavePath;
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          
          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          Image::make($background->getRealPath())->save($path);
            

            //Image::make($background->getRealPath())->save($save_path . $filename);
            
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'New Product Countdown'])->update(['productImg' => $localSavePath]);

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }
    
    //LP5
    public function uploadBackground5() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP5.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
            // ...
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'New Product Coupon'])->update(['background' => $save_path.$filename]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }
    
    /* lp5 product img upload*/
    public function uploadProductImg5() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'uploadProductCouponImg.png';
          
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          $localSavePath = '/uploads/users/id/'.$currentUser->id.'/'.$filename;
          $localSavePath = (string)$localSavePath;
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          
          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          Image::make($background->getRealPath())->save($path);
            

            //Image::make($background->getRealPath())->save($save_path . $filename);
            
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'New Product Coupon'])->update(['productImg' => $localSavePath]);

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    //LP6
    public function uploadBackground6() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP6.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;

          /* Random String */
          $key = '';
          $keys = array_merge(range(0, 9), range('a', 'z'));

          for ($i = 0; $i < 50; $i++) {
              $key .= $keys[array_rand($keys)];
          }
          $randomString = $key;
          
          $filename = 'backgroundLP6'.$randomString.$randomString.'.png';
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            //DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Single Item Shopping Cart'])->update(['background' => $save_path.$filename]);

            DB::table('backgroundImages')->where(['userId' => $currentUser->id,'landingPage' => 'Single Item Shopping Cart'])->update(['active' => 0]);

            DB::table('backgroundImages')->insert(['userId' => $currentUser->id, 'name'=>$filename, 'landingPage' => 'Single Item Shopping Cart', 'active' => 1]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }
    
    /* lp6 product img upload*/
    public function uploadProductImg6() {

        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();

          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < 40; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }

          $filename = 'productImage'.$randomString.'.png';
          
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/productImages/');
          $localSavePath = '/uploads/users/id/'.$currentUser->id.'/'.$filename;
          $localSavePath = (string)$localSavePath;
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          
          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          Image::make($background->getRealPath())->save($path);
            
            //Image::make($background->getRealPath())->save($save_path . $filename);
            $featuredCount = DB::table("productImages")->where(['userId' => $currentUser->id, 'featured' => 1])->count();
            if($featuredCount > 0){
              DB::table("productImages")->insert(['userId' => $currentUser->id, 'imageName' => $filename]);
            }else{
              DB::table("productImages")->insert(['userId' => $currentUser->id, 'imageName' => $filename, 'featured' => 1]);
            }
            
            //$existingImages = DB::table('productImages')->where(['user_id' => $currentUser->id)->count();

            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Single Item Shopping Cart'])->update(['productImg' => $localSavePath]);

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }


    //LP5
    public function uploadBackground7() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'backgroundLP7.jpg';
          $save_path    = storage_path() . '/users/id/' . $currentUser->id . '/uploads/images/currentUser/';
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          $public_path  = '/images/profile/' . $currentUser->id . '/currentUser/' . $filename;

          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
            // ...
        
          //Image::make($background->getRealPath())->resize('200','200')->save($filename);
          // Save the file to the server
          //Image::make($background->getRealPath())->save($save_path . 'background.jpg');
            Image::make($background->getRealPath())->save($save_path . $filename);
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Digital Download'])->update(['background' => $save_path.$filename]);

            // Save the public image path
            //$currentUser->profile->avatar = $public_path;
            //$currentUser->profile->save();

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }
    
    /* lp7 product img upload*/
    public function uploadProductImg7() {
        if(Input::hasFile('file')) {

          $currentUser  = \Auth::user();
          $background       = Input::file('file');
          //$filename     = 'backgroundLP2.' . $background->getClientOriginalExtension();
          $filename     = 'uploadDigitalDownloadImg.png';
          
          $save_path = public_path('/uploads/users/id/'.$currentUser->id.'/');
          $localSavePath = '/uploads/users/id/'.$currentUser->id.'/'.$filename;
          $localSavePath = (string)$localSavePath;
          //$save_path = '../uploads/users/id/'.$currentUser->id.'/';
          $path         = $save_path . $filename;
          
          // Make the user a folder and set permissions
          File::makeDirectory($save_path, $mode = 0755, true, true);
          
          Image::make($background->getRealPath())->save($path);
            

            //Image::make($background->getRealPath())->save($save_path . $filename);
            
            DB::table('landingPages')->where(['user_id' => $currentUser->id, 'type' => 'Digital Download'])->update(['productImg' => $localSavePath]);

          return response()->json(array('path'=> $path), 200);

        } else {

          return response()->json(false, 200);

        }
    }

    function arrayToObject($d) {
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return (object) array_map(__FUNCTION__, $d);
        }
        else {
            // Return object
            return $d;
        }
    }


    

}