<?php

namespace App\Http\Controllers;

use App\Actions\CurrentFeelings;
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
        $previous = $date->clone()->subDay();
        $next = $date->clone()->addDay();
        $user = $user ?: auth()->user();
        $group = $group ?: $user->groups()->first();

        $feelings = (new CurrentFeelings($user))->execute($date);

        $answers = $user->prompt_answers()
            ->whereDate('date', $date->toDateString())->where('group_id', $group->id)
            ->get()->keyBy('prompt_id');

        $lastUpdated = $answers->max('updated_at') ?: false;

        return view('day_review', compact('date', 'previous', 'next', 'feelings', 'group', 'answers', 'user', 'lastUpdated'));
    }
}
