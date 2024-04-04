<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItineraryController;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Product;
use App\Models\ItineraryHead;
use App\Models\AccomplishmentHead;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function agentHome()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        $itinerary = ItineraryHead::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $accomplishment = AccomplishmentHead::where('user_id',$user->id)->where('status', 'Approved')->orderBy('created_at','desc')->get();

        return view('agent.home', compact('itinerary', 'accomplishment'));
    }

    public function rsmHome()
    {
        return view('home',["msg" => "I am Regional Sales Manager"]);
    }

    public function asmHome()
    {
        return view('home',["msg" => "I am Area Sales Manager"]);
    }

    public function nsmnlHome()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        $itinerary = ItineraryHead::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $accomplishment = AccomplishmentHead::where('user_id',$user->id)->where('status', 'Approved')->orderBy('created_at','desc')->get();

        return view('home', compact('itinerary', 'accomplishment'));
    }

    public function nsmflHome()
    {
        return view('home',["msg" => "I am National Sales Manager for life"]);
    }

    public function executive_assistantHome()
    {
        return view('home',["msg" => "I am the Executive Assistant"]);
    }

    public function general_adminHome()
    {
        $user = Auth::user();
        $products = Product::all();
        $accounts = Account::all();
        $itinerary = ItineraryHead::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $accomplishment = AccomplishmentHead::where('user_id',$user->id)->where('status', 'Approved')->orderBy('created_at','desc')->get();

        return view('admin.home', compact('itinerary', 'accomplishment'));
    }
}
