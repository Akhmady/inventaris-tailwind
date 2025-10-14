<x-guest-layout>
    {{-- Alert Error --}}
    @if ($errors->any())
        <div id="alert-error"
            class="fixed top-5 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-md bg-red-50 border-s-4 border-red-500 p-4 rounded-lg shadow-lg dark:bg-red-800/30
               transition duration-700 ease-in-out"
            role="alert">
            <div class="flex">
                <div class="ms-3">
                    <h3 class="text-gray-800 font-semibold dark:text-white">Error!</h3>
                    <ul class="text-sm text-gray-700 dark:text-neutral-400 list-disc ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Login --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-10">
        @csrf

        {{-- Email --}}
        <div class="relative">
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="peer py-3 px-4 ps-11 block w-full rounded-xl border border-gray-300 shadow-sm
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900
                       dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                placeholder="Email" required autofocus>

            <!-- Icon Email/User -->
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
        </div>

        {{-- Password --}}
        <div class="relative">
            <input type="password" name="password" id="password"
                class="peer py-3 px-4 ps-11 block w-full rounded-xl border border-gray-300 shadow-sm
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900
                       dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700"
                placeholder="Password" required>

            <!-- Icon Password/Lock -->
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <svg class="shrink-0 size-5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
                    <circle cx="16.5" cy="7.5" r=".5" />
                </svg>
            </div>
        </div>


        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>

        </div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                class="w-full py-3 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-md hover:scale-105 transition">
                Log in
            </button>
        </div>
    </form>

    {{-- Auto-hide error --}}
    <script>
        setTimeout(() => {
            const alertError = document.getElementById('alert-error');
            if (alertError) {
                alertError.classList.add('opacity-0', '-translate-y-5');
                setTimeout(() => {
                    alertError.style.display = 'none';
                }, 700);
            }
        }, 5000);
    </script>
</x-guest-layout>
