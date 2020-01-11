<?php

namespace App\Http\Controllers;

use App\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date)
    {
        $date = Carbon::parse($date);
        $group = $this->getGroup();

        $answers = auth()->user()->prompt_answers()
            ->whereDate('date', $date->toDateString())->where('group_id', $group->id)
            ->get()->keyBy('prompt_id');

        return view('day_review', compact('date', 'group', 'answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($date, Group $group = null)
    {
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
            return redirect('/day/' . $date->format('Y-m-d') . '/review');
        }

//        return [ $group, $date ];

        return view('day', compact('date', 'group', 'answers', 'lastUpdated'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $date)
    {
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

        return back()->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getGroup(Group $group = null) {
        $group = $group ?: auth()->user()->groups()->firstOrFail();
        $group->load('prompts');

        return $group;
    }
}
