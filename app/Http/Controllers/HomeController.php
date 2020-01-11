<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $user = auth()->user();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $feelings = $user->core_feelings;

        $groups = $user->groups()->with([ 'users' => function($query) use ($user) {
            $query->where('user_id', '!=', $user->id);
        }])->get();

        return view('home', compact('today', 'yesterday', 'feelings', 'groups'));
    }
}
