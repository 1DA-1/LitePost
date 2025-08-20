<x-layouts.default>
  <div class="flex items-center justify-center min-h-screen">
    <div class="my-auto card p-6 py-7 max-w-md w-full border border-[#4A5D54] shadow-[0_0_30px_2px_rgba(74,93,84,0.5)] ">
      
      <!-- Logo -->
      <div class="mb-10 text-center">
        <h1 class="font-bold text-4xl litepost-logo">LitePostᯓ★</h1>
      </div>

      <!-- Slot for forms -->
      <div>
        {{ $slot }}
      </div>
    </div>
  </div>
</x-layouts.default>