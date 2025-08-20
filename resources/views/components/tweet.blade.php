@props([
    'tweet',
])

{{-- my note: this is the tweet card. --}}
<div 
    class="card border border-green-300 rounded-xl shadow-sm font-poppins"
   
>
    {{-- content --}}
    <div class="card-body py-4 px-7">
        <p>{{ $tweet->content }}</p>
    </div>

    {{-- actions bar: left = reply + like, right = user --}}
    <div class="card-actions p-4 pt-0 flex justify-between items-center">
        {{-- LEFT SIDE: reply + like --}}
        <div class="flex items-center gap-3">
            {{-- reply button + comment count --}}
            @if (request()->routeIs('home'))
                @auth
                    <a 
                        href="{{ route('tweet.view', $tweet->baseTweet->id) }}" 
                        class="btn btn-text btn-square flex items-center gap-1"
                        title="View comments"
                    >
                        <span class="icon-[tabler--message] text-[#92CAA9] text-xl"></span>
                        <span class="text-sm text-gray-500">
                            {{ $tweet->comments_count ?? $tweet->childTweets()->count() }}
                        </span>
                    </a>
                @else
                    <a 
                        href="{{ route('login') }}" 
                        class="btn btn-text btn-square flex items-center gap-1"
                        title="Log in to view comments"
                    >
                        <span class="icon-[tabler--message] text-gray-300 text-xl"></span>
                        <span class="text-sm text-gray-400">
                            {{ $tweet->comments_count ?? $tweet->childTweets()->count() }}
                        </span>
                    </a>
                @endauth
            @else
                @auth
                    <button
                        onclick="document.querySelector(`input[name='parent_tweet_id']`).value={{ $tweet->id }}"         
                        class="btn btn-text btn-square flex items-center gap-1"
                        title="Reply"
                    >
                        <span class="icon-[tabler--message] text-[#92CAA9] text-xl"></span>
                        <span class="text-sm text-gray-500">
                            {{ $tweet->comments_count ?? $tweet->childTweets()->count() }}
                        </span>
                    </button>
                @else
                    <a 
                        href="{{ route('login') }}" 
                        class="btn btn-text btn-square flex items-center gap-1"
                        title="Log in to reply"
                    >
                        <span class="icon-[tabler--message] text-gray-300 text-xl"></span>
                        <span class="text-sm text-gray-400">
                            {{ $tweet->comments_count ?? $tweet->childTweets()->count() }}
                        </span>
                    </a>
                @endauth
            @endif

            {{-- LIKE: toggles based on state + shows count --}}
            <div>
                @auth
                    @php
                        // note: using cached counts if present, otherwise querying
                        $count = $tweet->likes_count ?? $tweet->likes()->count();
                        $likedByMe = property_exists($tweet, 'liked_by_auth')
                            ? (bool) $tweet->liked_by_auth
                            : $tweet->likes()->where('user_id', auth()->id())->exists();
                    @endphp

                    @if ($likedByMe)
                        <form action="{{ route('tweets.unlike', $tweet) }}" method="POST" class="like-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-text btn-square flex items-center gap-1" title="Unlike" aria-pressed="true">
                                <span class="icon-[tabler--heart-filled] text-[#92CAA9] text-xl"></span>
                                <span class="text-sm text-gray-500">{{ $count }}</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('tweets.like', $tweet) }}" method="POST" class="like-form">
                            @csrf
                            <button class="btn btn-text btn-square flex items-center gap-1" title="Like" aria-pressed="false">
                                <span class="icon-[tabler--heart] text-[#92CAA9] text-xl"></span>
                                <span class="text-sm text-gray-500">{{ $count }}</span>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-text btn-square flex items-center gap-1" title="Log in to like">
                        <span class="icon-[tabler--heart] text-gray-300 text-xl"></span>
                        <span class="text-sm text-gray-400">{{ $tweet->likes()->count() }}</span>
                    </a>
                @endauth
            </div>
        </div>

        {{-- RIGHT SIDE: user info (name + tiny avatar) --}}
        <a class="flex btn btn-text items-center gap-2" title="View profile">
            <div class="text-sm text-[#4A5D54]">{{ $tweet->user->name }}</div>
            <div class="avatar">
                <div class="size-6 rounded-box overflow-hidden">
                    <img src="/storage/{{ $tweet->user->avatar }}" alt="avatar" class="object-cover w-full h-full" />
                </div>
            </div>
        </a>
    </div>
</div>

{{-- thread replies (only on the tweet view page) --}}
@if (request()->routeIs('tweet.view'))
    <div class="ms-6 ps-2 space-y-2 border-s-2">
        @foreach ($tweet->childTweets as $childTweet)
            {{-- note: render each child using the same component to keep styling consistent --}}
            <x-tweet :tweet="$childTweet" /> 
        @endforeach
    </div> 
@endif