<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CollabQuest - Manajemen Tugas Terpadu')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F5F8F5] text-[#223326] min-h-screen flex flex-col font-sans antialiased selection:bg-[#2E5E3A] selection:text-white">
    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 max-w-md w-full pointer-events-none px-4 sm:px-0"></div>

    <div class="flex-1 flex flex-col">
        @yield('content')
    </div>

    <!-- Global Toast Script Helper -->
    <script>
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-start gap-3 p-4 rounded-xl shadow-lg border transition-all duration-300 transform translate-y-2 opacity-0 text-sm font-medium';

            let iconSvg = '';
            if (type === 'success') {
                toast.classList.add('bg-white', 'border-[#CCE0CF]', 'text-[#244B2E]');
                iconSvg = `<svg class="w-5 h-5 text-[#2E5E3A] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
            } else if (type === 'error') {
                toast.classList.add('bg-white', 'border-[#F7CDCD]', 'text-[#8A2424]');
                iconSvg = `<svg class="w-5 h-5 text-[#C53030] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
            } else {
                toast.classList.add('bg-white', 'border-[#CFDFD2]', 'text-[#2B362C]');
                iconSvg = `<svg class="w-5 h-5 text-[#4A5E4D] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
            }

            toast.innerHTML = `
                ${iconSvg}
                <div class="flex-1">${message}</div>
                <button type="button" class="text-stone-400 hover:text-stone-600 transition" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

            container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            });

            // Auto dismiss after 3.5 seconds
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        };
    </script>

    @stack('scripts')
</body>
</html>
