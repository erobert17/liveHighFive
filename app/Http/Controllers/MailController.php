<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function send(Request $request)
    {

        // need to overload message prop
        // https://laravel.com/docs/5.0/mail#basic-usage
        $props = $request->all();
        $props['body'] = $props['message'];


        Mail::send('email', $props, function ($m) use ($request) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to(config('mail.admins'))->subject($request->get('subject'));
        });

        //success
        return redirect('/');
    }
}
