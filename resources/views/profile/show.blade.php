<x-layouts.default>
    {{-- === HEADER  === --}}
    <div
        class="relative h-64 sm:h-72 w-screen left-1/2 right-1/2 -mx-[50vw] overflow-hidden"
        style="background: linear-gradient(135deg, #92CAA9 0%, #4A5D54 100%);">
        {{--  overlay --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/white-diamond.png')] opacity-20"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 -mt-28 relative z-10">
        {{-- === PROFILE CARD === --}}
        <div class="rounded-3xl shadow-2xl bg-white/95 backdrop-blur border border-green-300 overflow-hidden">
            <div class="flex flex-col items-center p-6 space-y-4">

                {{-- avatar --}}
                <div class="relative">
                    <div
                        class="w-40 h-40 rounded-full overflow-hidden ring-4 ring-[#92CAA9] shadow-lg shadow-green-200/50">
                        <img src="/storage/{{ $user->avatar }}" alt="avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 rounded-full animate-pulse ring ring-green-400/40"></div>
                </div>

                {{-- name + username --}}
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
                    @if ($user->username)
                        <p class="text-[#4A5D54] font-medium">@{{ $user->username }}</p>
                    @endif
                </div>

                {{-- bio card --}}
                <div class="bg-gradient-to-r from-[#daf1e6] to-[#92CAA9]/20 rounded-xl p-4 w-full text-center shadow-sm">
                    <p class="text-gray-700 italic">
                        {!! $user->bio ? nl2br(e($user->bio)) : 'No bio yet 🌿' !!}
                    </p>
                </div>

                {{-- stats row --}}
                <div class="flex gap-4">
                    <div class="px-4 py-2 rounded-full bg-[#92CAA9]/20 text-[#4A5D54] font-semibold shadow">
                        📝 {{ $tweetsCount }} Posts
                    </div>
                    <div class="px-4 py-2 rounded-full bg-[#4A5D54]/20 text-[#4A5D54] font-semibold shadow">
                        📅 Joined {{ $user->created_at->format('M Y') }}
                    </div>
                </div>

                {{-- edit bio (only owner) --}}
                @auth
                    @if (auth()->id() === $user->id)
                        <details class="w-full mt-2">
                            <summary class="cursor-pointer text-sm text-[#4A5D54]">✏️ Edit bio</summary>
                            <form method="POST" action="{{ route('profile.update', $user) }}" class="mt-2 space-y-2">
                                @csrf
                                @method('PATCH')
                                <textarea name="bio" rows="3" maxlength="500"
                                    class="textarea w-full border-green-300 focus:border-green-500">{{ old('bio', $user->bio) }}</textarea>
                                <button
                                    class="px-4 py-2 rounded-lg bg-[#4A5D54] text-white hover:bg-[#92CAA9] transition">
                                    Save bio
                                </button>
                            </form>
                        </details>
                    @endif
                @endauth
            </div>
        </div>

        {{-- divider --}}
        <div class="flex justify-center my-6 text-[#92CAA9] text-lg">✦ ✦ ✦</div>

        {{-- tweets --}}
        <div class="space-y-4">
            @forelse ($tweets as $tweet)
                <x-tweet :tweet="$tweet" />
            @empty
                <div class="text-center text-gray-400">No posts yet 🌱</div>
            @endforelse
        </div>

        {{-- pagination --}}
        <div class="mt-6">
            {{ $tweets->links() }}
        </div>
    </div>
</x-layouts.default>