<?php

use App\Console\Commands\MakeFilamentAdmin;
use App\Models\Commissions\Commission;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('livewire-tmp:clean', function () {
    Storage::deleteDirectory('livewire-tmp');
    Storage::makeDirectory('livewire-tmp');
})->purpose('cleans livewire-tmp');

Artisan::command('update-commission', function () {
    $commissions = Commission::all();
    foreach ($commissions as $c) {
        if ($c->created_at <= now()->subWeeks(2)) {
            // $c->approved = true;
        }
    }
})->purpose('updates commission value in the user account');

Schedule::command('auth:clear-resets')->everyFifteenMinutes();
Schedule::command('livewire-tmp:clean')->daily();
// Schedule::command('update-commission')->daily();
