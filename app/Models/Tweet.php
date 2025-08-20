<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
        'content',
        'parent_tweet_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // the tweet i'm replying to 
    public function parentTweet()
    {
        return $this->belongsTo(Tweet::class, 'parent_tweet_id');
    }

    // the tweets that replied to me directly 
    public function childTweets()
    {
        return $this->hasMany(Tweet::class, 'parent_tweet_id');
    }

    // the original tweet that started everything
    public function baseTweet()
    {
        return $this->belongsTo(Tweet::class, 'base_tweet_id');
    }

    // all replies under my tweet, even if not direct replies
    public function descendantTweets()
    {
        return $this->hasMany(Tweet::class, 'base_tweet_id');
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    public function likedByUsers()
    { // the Users directly
        return $this->belongsToMany(\App\Models\User::class, 'likes')->withTimestamps();
    }
}
