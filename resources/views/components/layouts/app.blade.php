<x-layouts.default>
    <nav class="navbar bg-base-100 rounded-box shadow-green-300/20 shadow-sm sticky top-4 z-50 border border-b-4">
        <div class="flex flex-1 items-center">
            <a class="link text-base-content link-neutral text-xl font-bold no-underline litepost-logo" href="/">
                LitePostᯓ★
            </a>
        </div>

        <div class="navbar-end flex items-center gap-4">
            @if(Auth::check())

                {{-- Notifications dropdown --}}
                <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:12] [--placement:bottom-end]">
                    <button type="button" class="dropdown-toggle btn btn-text btn-square relative" aria-haspopup="menu"
                        aria-expanded="false" aria-label="Notifications">
                        <span class="icon-[tabler--bell] text-3xl"></span>
                        @if(isset($notifications) && $notifications->where('read', false)->count() > 0)
                            <span class="badge badge-error badge-sm absolute -top-1 -right-1"></span>
                        @endif
                    </button>

                    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-80 max-h-[28rem] overflow-y-auto p-4 rounded-xl shadow-lg"
                        role="menu">
                        @forelse($notifications ?? collect() as $note)
                            @php
                                $actor = \App\Models\User::find($note->data['actor_id'] ?? null);
                                $tweetId = $note->data['tweet_id'] ?? null;
                            @endphp
                            <li class="p-3 border-b last:border-0 hover:bg-base-200 rounded-lg transition">
                                <div class="flex items-start gap-3 text-sm">
                                    <div class="avatar">
                                        <div class="size-8 rounded-box overflow-hidden ring ring-[#92CAA9] ring-offset-2">
                                            <img src="/storage/{{ $actor?->avatar }}" alt="avatar">
                                        </div>
                                    </div>
                                    <div>
                                        @if($note->type === 'like')
                                            <b>{{ $actor?->name ?? 'Someone' }}</b> liked your
                                            <a href="{{ $tweetId ? route('tweet.view', $tweetId) : '#' }}"
                                                class="text-[#4A5D54] underline">tweet</a>.
                                        @elseif($note->type === 'comment')
                                            <b>{{ $actor?->name ?? 'Someone' }}</b> commented on your
                                            <a href="{{ $tweetId ? route('tweet.view', $tweetId) : '#' }}"
                                                class="text-[#4A5D54] underline">tweet</a>.
                                        @else
                                            New notification.
                                        @endif
                                        <div class="text-xs text-gray-500 mt-1">{{ $note->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="p-4 text-gray-500 text-center">No notifications yet.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Avatar dropdown (profile + logout) --}}
                <div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
                    <button id="dropdown-scrollable" type="button" class="dropdown-toggle flex items-center"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                        <div class="avatar">
                            <div class="size-9.5 rounded-box">
                                <img src="/storage/{{ Auth::user()->avatar }}" alt="avatar 1" />
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu"
                        aria-orientation="vertical" aria-labelledby="dropdown-avatar">

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show', Auth::user()) }}">
                                <span class="icon-[tabler--user]"></span>
                                My Profile
                            </a>
                        </li>

                        <li class="dropdown-footer gap-2">
                            <form method="post" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="btn btn-error btn-soft btn-block">
                                    <span class="icon-[tabler--logout]"></span>
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            @else
                <a href="{{ route('login') }}">
                    <button class="btn btn-text btn-square">
                        <span class="icon-[tabler--login] size-7"></span>
                    </button>
                </a>
            @endif
        </div>
    </nav>

    <div class="my-8 flex-1">
        {{ $slot }}
    </div>
   <form method="post" action="{{ route('tweet.create') }}"
      class="border-2 border-gray-300 rounded-field sticky bottom-4 drop-shadow-2xl bg-base-100
             focus-within:border-[#4A5D54] focus-within:border-2 transition-colors">
    @csrf
    <input type="hidden" name="parent_tweet_id" value="{{ request()->tweet?->id }}" />

    <div class="textarea-floating group relative">
        <textarea
            required
            id="content"
            name="content"
            placeholder="What's on your mind?"
            class="textarea w-full border-0 resize-none
                   focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none
                   placeholder:text-transparent
                   focus:placeholder:text-[#4A5D54]/70
            "
        ></textarea>

        <label for="content"
               class="textarea-floating-label text-gray-400 pointer-events-none
                      transition-opacity duration-0
                      group-focus-within:opacity-0">
            Write a Tweet
        </label>
    </div>

    <div class="p-2 pt-0">
        @error('content')
            <div>{{ $message }}</div>
        @enderror

        <button
            type="submit"
            class="px-6 py-2 rounded-lg bg-[#4A5D54] text-[#daf1e6]
                   hover:bg-[#728e80] transition-colors"
        >
            Post
        </button>
    </div>
</form>
</x-layouts.default>