<x-layouts.auth>
    <style>
        .theme-green :is(input, .input, textarea, select) {
            border-color: #D1D5DB;
            color: #4A5D54;
        }

        .theme-green :is(input, .input, textarea, select):focus {
            outline: none !important;
            border-color: #4A5D54 !important;
            --tw-ring-offset-shadow: 0 0 #0000 !important;
            --tw-ring-shadow: 0 0 #0000 !important;
            --tw-ring-color: transparent !important;
            box-shadow: none !important;
        }

        .theme-green .input-floating:focus-within .input-floating-label,
        .theme-green :is(input, .input, textarea, select):focus + .input-floating-label {
            color: #4A5D54 !important;
        }

        .theme-green :is(input, .input, textarea, select)::placeholder {
            color: rgba(74,93,84,0.65);
        }
    </style>

    <form method="post" class="space-y-3 theme-green">
        @csrf

        <x-input id="email" label="Email" icon="icon-[tabler--mail]" type="email" />
        <x-input id="password" label="Password" icon="icon-[tabler--lock]" type="password" />

        <div class="flex justify-center mt-8">
            <button class="px-18 py-2 rounded-lg font-semibold bg-[#4A5D54] text-[#f7fbf9] hover:bg-[#728e80] transition-colors" type="submit">
                Log in to LitePost
            </button>
        </div>

        <span class="text-[#4A5D54]">
            Don’t have an account?
            <a href="/register" class="link link-animated text-[#4A5D54]">Create account</a>
        </span>
    </form>
</x-layouts.auth>