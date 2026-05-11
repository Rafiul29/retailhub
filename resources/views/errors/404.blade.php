<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | POS</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 antialiased flex items-center justify-center px-4">

    <div class="w-full max-w-2xl">
        <div class="text-center">
            <!-- Error Code Animation -->
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 blur-3xl bg-gradient-to-r from-indigo-400 to-blue-400 opacity-20 rounded-full"></div>
                <div class="relative text-9xl font-black text-transparent bg-clip-text bg-linear-to-r from-indigo-600 to-blue-600">
                    404
                </div>
            </div>

            <!-- Heading -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 mb-4">Page Not Found</h1>
            <p class="text-lg text-slate-600 mb-8 max-w-md mx-auto">The page you're looking for seems to have vanished. It might have been moved or deleted.</p>

            <!-- Icon -->
            <div class="flex justify-center mb-12">
                <div class="relative">
                    <div class="absolute inset-0 blur-2xl bg-gradient-to-br from-indigo-500 to-blue-500 opacity-10 rounded-full w-24 h-24"></div>
                    <div class="relative flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-indigo-100 to-blue-100 border-2 border-indigo-200">
                        <i class="fas fa-search text-indigo-600 text-4xl"></i>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(auth()->check())
                    @if(auth()->user()->role === 'Admin')
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fas fa-home"></i>
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('cashier.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fas fa-home"></i>
                            Go to Dashboard
                        </a>
                    @endif
                    <a href="{{ route('pos.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-cash-register"></i>
                        Go to POS
                    </a>
                @else
                    <a href="{{ route('landing') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-home"></i>
                        Go Home
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-200 py-3 px-8 text-sm font-bold text-slate-700 hover:bg-slate-300 transition focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </a>
                @endif
            </div>

            <!-- Additional Info -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <p class="text-sm text-slate-500 mb-4">Still need help?</p>
                <div class="flex justify-center gap-6">
                    <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition">
                        <i class="fas fa-envelope mr-1"></i>
                        Contact Support
                    </a>
                    <a href="javascript:history.back()" class="text-slate-600 hover:text-slate-700 font-semibold text-sm transition">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Go Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
    </div>

</body>
</html>
