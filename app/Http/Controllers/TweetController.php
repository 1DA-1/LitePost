<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Models\Tweet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    // NOTE: now accepts Request so it can eager-load "liked_by_auth"
    public function index(Request $request)
    {
        $query = Tweet::query()
            ->whereNull('parent_tweet_id')
            ->latest()               // same as orderByDesc('created_at')
            ->withCount([
                'likes',
                'childTweets as comments_count',
            ]);  

        // If logged in, add a lightweight flag for "did the auth user like this?"
        if ($request->user()) {
            $userId = $request->user()->id;

            // Laravel 10+: withExists – creates $tweet->liked_by_auth 
            $query->withExists([
                'likes as liked_by_auth' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ]);
        }

        $tweets = $query
            ->limit(20)
            ->get();

        return view('index', compact('tweets'));
    }

    public function view(Tweet $tweet)
    {
        $tweet->loadCount(['likes', 'childTweets as comments_count']);
        return view('tweet.view', compact('tweet'));
    }

    public function store(StoreTweetRequest $request)
    {
        $tweet = Auth::user()->tweets()->create($request->validated());

        if ($tweet->parentTweet()->exists()) {
            $tweet->baseTweet()->associate($tweet->parentTweet->baseTweet->id)->save();
        } else {
            $tweet->baseTweet()->associate($tweet)->save();
        }

        return redirect()->back();
    }

    // ===== Likes API (routes: POST /tweets/{tweet}/like, DELETE /tweets/{tweet}/like) =====

    public function like(Request $request, Tweet $tweet)
    {
        $userId = $request->user()->id;

        // if already liked, this won't duplicate due to unique index (user_id, tweet_id)
        $tweet->likes()->firstOrCreate([
            'user_id' => $userId,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'liked' => true,
                'count' => $tweet->likes()->count(),
            ]);
        }

        return back();
    }

    public function unlike(Request $request, Tweet $tweet)
    {
        $userId = $request->user()->id;

        $tweet->likes()
            ->where('user_id', $userId)
            ->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'liked' => false,
                'count' => $tweet->likes()->count(),
            ]);
        }

        return back();
    }
}