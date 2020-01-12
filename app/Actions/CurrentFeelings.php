<?php

namespace App\Actions;

use App\User;
use Carbon\Carbon;

class CurrentFeelings {

    /**
     * @var User
     */
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function execute(Carbon $date = null, $excludeEnded = false) {
        $date = $date ?: Carbon::now();
        return $this->user->core_feelings()
            ->whereDate('start_date', '<=', $date)
            ->where(function ($query) use ($date, $excludeEnded) {
                $query->whereDate('end_date', '>=', $date);
                if (!$excludeEnded) {
                    $query->orWhereNull('end_date');
                }
            })
            ->get();
    }
}
