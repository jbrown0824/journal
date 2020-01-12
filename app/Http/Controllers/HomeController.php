<?php

namespace App\Http\Controllers;

use App\Actions\CurrentFeelings;
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

        $feelings = (new CurrentFeelings($user))->execute();

        $groups = $user->groups()->with([ 'users' => function($query) use ($user) {
            $query->where('user_id', '!=', $user->id);
        }])->get();

        return view('home', compact('today', 'yesterday', 'feelings', 'groups'));
    }
}
