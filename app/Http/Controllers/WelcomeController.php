<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WelcomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {	
    	//Redirect::to('http://cnn.com');
    	#return redirect('http://growyourleads.com/front/');
        return view('welcome');
    }

}
