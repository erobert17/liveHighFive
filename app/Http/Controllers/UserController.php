<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Billable;
use DB;

class UserController extends Controller
{

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    use Billable;

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
    public function index()
    {

        $user = Auth::user();

        if ($user->isAdmin()) {

            return view('pages.admin.home', compact('user'));

        }

        return view('pages.user.home', compact('user'));

    }


}