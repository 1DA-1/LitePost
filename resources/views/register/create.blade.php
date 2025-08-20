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

    <form method="post" enctype="multipart/form-data" class="space-y-3 theme-green">
        @csrf

        <div class="max-w- input-floating">
            <input type="file" required accept="image/*" class="input" id="avatar" name="avatar" />
            <label class="input-floating-label" for="avatar">Profile picture</label>
            @error('avatar')
                <div class="text-error helper-text ps-3 mb-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <x-input id="name" minLength="3" label="Username" icon="icon-[tabler--user]" />
        <x-input id="email" label="Email" icon="icon-[tabler--mail]" type="email" />

        <x-input id="password" minLength="8" label="Password" icon="icon-[tabler--lock]" type="password" />
        <p class="text-sm text-[#4A5D54] ps-1">Password must be at least 8 characters long.</p>

        <x-input id="password_confirmation" minLength="8" label="Confirm password" icon="icon-[tabler--lock-check]" type="password" />
        <p class="text-sm text-[#4A5D54] ps-1">Must match the password.</p>

        <div class="flex justify-center mt-8">
            <button class="px-16 py-2 rounded-lg font-semibold bg-[#4A5D54] text-[#f7fbf9] hover:bg-[#728e80] transition-colors" type="submit">
                Sign up for LitePost
            </button>
        </div>

        <span class="text-[#4A5D54]">
            Already have an account?
            <a href="/login" class="link link-animated text-[#4A5D54]">Login</a>
        </span>
    </form>
</x-layouts.auth>