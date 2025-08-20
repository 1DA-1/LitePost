<?php

use App\Models\Tweet;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fix-tweets', function () {
     //foreach (Tweet::all() as $tweet) {
     //   $tweet->baseTweeet()->associate($tweet)->save();
    // }
Tweet::find(26)->delete();

}); 