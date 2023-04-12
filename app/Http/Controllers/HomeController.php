<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\ItemReview;


use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

/**************************************
*タイムライン画面の表示
*****************************************/
    public function timeline(){

        $reviews = ItemReview::with(['item','user'])->orderBy('updated_at', 'desc')->get();
        // dd($reviews);


        return view('home',compact("reviews"));
    }
}

