@if (session('success'))
    <div id="alert-success"
        class="fixed top-5 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-md bg-green-50 border-t-2 border-green-500 rounded-lg p-4 shadow-lg dark:bg-green-800/40 transition-all duration-500 ease-in-out transform"
        role="alert" aria-live="assertive">
        <div class="flex items-start">
            <!-- Icon -->
            <div class="shrink-0">
                <span
                    class="inline-flex justify-center items-center size-8 rounded-full border-4 border-green-100 bg-green-200 text-green-800 dark:border-green-900 dark:bg-green-700 dark:text-green-300">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                </span>
            </div>

            <!-- Message -->
            <div class="ms-3 flex-1">
                <h3 class="text-gray-800 font-semibold dark:text-white">
                    {{ session('success') }}
                </h3>
            </div>

            <!-- Close Button -->
            <button id="close-alert-success"
                class="ms-3 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none">
                &times;
            </button>
        </div>
    </div>

    <script>
        const alertSuccess = document.getElementById('alert-success');
        const closeBtn = document.getElementById('close-alert-success');

        setTimeout(() => {
            if (alertSuccess) {
                alertSuccess.classList.add('opacity-0', '-translate-y-5');
                setTimeout(() => alertSuccess.remove(), 500);
            }
        }, 3000);

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alertSuccess.classList.add('opacity-0', '-translate-y-5');
                setTimeout(() => alertSuccess.remove(), 500);
            });
        }
    </script>
@endif
