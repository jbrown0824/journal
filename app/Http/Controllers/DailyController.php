<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($date, Group $group = null) {
        $date = Carbon::parse($date);
        $group = $this->getGroup($group);

        $answers = auth()->user()->prompt_answers()
            ->whereDate('date', $date->toDateString())->where('group_id', $group->id)
            ->get()->keyBy('prompt_id');

        $lastUpdated = $answers->max('updated_at') ?: false;

        if (!$date->isValid()) {
            return back()->withErrors([ 'Unable to determine journal day' ]);
        }

        if ($date->isBefore(Carbon::today())) {
            return redirect('/day/' . $date->toDateString() . '/review');
        }

//        return [ $group, $date ];

        return view('day', compact('date', 'group', 'answers', 'lastUpdated'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $date) {
        $date = Carbon::parse($date);
        $group = $this->getGroup();

        if (!$date->isToday()) {
            return back()->with('error', 'You tried to update ' . $date->format('F jS, Y') . ' which is not today.');
        }

        $user = auth()->user();
        $dateString = $date->toDateString();
        foreach ($group->prompts as $prompt) {
            $answer = $request['answer'][$prompt->id] ?? null;
            $url = $request['url'][$prompt->id] ?? null;
            if (!$answer && !$url) continue;

            $user->prompt_answers()->updateOrCreate(
                [ 'group_id' => $group->id, 'prompt_id' => $prompt->id, 'date' => $dateString ],
                [ 'prompt' => $prompt->prompt, 'answer' => $answer, 'url' => $url ]
            );
        }

        $this->setJournalStreak($user);

        return redirect()->route('review', [
            'date' => $dateString,
            'group' => $group->id,
            'user' => $user->id
        ])->with('success', true);
    }

    protected function getGroup(Group $group = null) {
        $group = $group ?: auth()->user()->groups()->firstOrFail();
        $group->load('prompts');

        return $group;
    }

    /**
     * @param User $user
     */
    protected function setJournalStreak(User $user): void {
        $days = 1;
        if ($user->last_journaled_at) {
            if ($user->last_journaled_at->isToday()) return; // Already saved today
            if ($user->last_journaled_at->isYesterday()) {
                $days += $user->consecutive_days;
            }
        }

        $user->consecutive_days = $days;
        $user->last_journaled_at = Carbon::now();

        $user->save();
    }
}
