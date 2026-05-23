<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run daily: move completed-onboarding employees to probation & flag overdue
Schedule::command('hr:check-probation')->dailyAt('08:00');

// Prune location records older than 7 days
Schedule::command('locations:prune')->dailyAt('02:00');

