<?php

namespace App\Http\Controllers;

use App\Mail\VerifyUserEmail;
use App\Models\Branch;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;


class FrontController extends Controller
{
    //

    public function index()
    {
        $ip = '27.34.30.148'; //For static IP address get
        //$ip = request()->ip(); //Dynamic IP address get
        $userlocation = Location::get($ip); //Get user coordinates
        $branch = Branch::where('status', 1)->distance($userlocation->latitude, $userlocation->longitude)->orderBy('distance', 'ASC')->first(); //Choose nearest branch
        $setting = Setting::first();
        $sliders = Slider::latest()->get();

        $branches = Branch::where('status', 1)->get();
        return view('frontend.index', compact('branch', 'setting', 'branches', 'sliders'));
    }

    public static function verifyEmail($name, $email, $verification_code)
    {
        $mailData = [
            'name' => $name,
            'verification_code' => $verification_code,
        ];
        Mail::to($email)->send(new VerifyUserEmail($mailData));
    }

    public function aboutus()
    {
        return view('frontend.aboutus');
    }
}
