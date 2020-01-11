<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyReviewController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $date
     * @param Group|null $group
     * @param User|null $user
     * @return \Illuminate\Http\Response
     */
    public function index($date, Group $group = null, User $user = null) {
        $date = Carbon::parse($date);
        $user = $user ?: auth()->user();
        $group = $group ?: $user->groups()->first();

        $answers = $user->prompt_answers()
            ->whereDate('date', $date->toDateString())->where('group_id', $group->id)
            ->get()->keyBy('prompt_id');

        $lastUpdated = $answers->max('updated_at') ?: false;

        return view('day_review', compact('date', 'group', 'answers', 'user', 'lastUpdated'));
    }
}
