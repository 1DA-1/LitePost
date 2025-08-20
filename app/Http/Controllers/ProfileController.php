<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $user)
    {
        // Count just the "root" tweets (not replies)
        $tweetsCount = $user->tweets()
            ->whereNull('parent_tweet_id')
            ->count();

        // Load this user's tweets with counts (likes + comments)
        $tweets = $user->tweets()
            ->whereNull('parent_tweet_id')
            ->latest()
            ->withCount([
                'likes',
                'childTweets as comments_count',
            ]);

        // Add "did I like it?" for the viewer (if logged in)
        if ($request->user()) {
            $viewerId = $request->user()->id;
            $tweets->withExists([
                'likes as liked_by_auth' => function ($q) use ($viewerId) {
                    $q->where('user_id', $viewerId);
                }
            ]);
        }

        $tweets = $tweets->paginate(20);

        return view('profile.show', [
            'user' => $user,
            'tweets' => $tweets,
            'tweetsCount' => $tweetsCount,
        ]);
    }
    public function update(Request $request, \App\Models\User $user)
    {
        // Only allow the owner to edit
        abort_if($request->user()->id !== $user->id, 403);

        $data = $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($data);

        return back()->with('status', 'Bio updated!');
    }
}
