<?php

namespace App\Actions;

use App\User;
use Carbon\Carbon;

class UpdateCurrentFeelings {

    /**
     * @var User
     */
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function execute(array $existing, array $new) {
        $currentFeelings = (new CurrentFeelings($this->user))->execute(Carbon::today())->keyBy('id');

        foreach ($existing as $id => $feeling) {
            $current = $currentFeelings[$id];
            if (!$current) {
                $new[] = $feeling;
                continue;
            }

            if ($feeling != $current->feeling) {
                // Feeling has been modified or deleted
                if (Carbon::parse($current->start_date)->isToday()) {
                    // They are just updating a feeling they created earlier today
                    $current->feeling = $feeling;
                    $current->save();
                } else {
                    $current->end_date = Carbon::now();

                    if (empty($feeling)) {
                        $this->create($feeling);
                    }
                    $current->save();
                }
            }
        }

        foreach ($new as $feeling) {
            if (!empty($feeling)) {
                $this->create($feeling);
            }
        }
    }

    protected function create($feeling) {
        $this->user->core_feelings()->create([
            'feeling' => $feeling,
            'start_date' => Carbon::now()
        ]);
    }
}
