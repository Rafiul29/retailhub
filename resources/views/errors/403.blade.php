<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | POS</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-yellow-50 antialiased flex items-center justify-center px-4">

    <div class="w-full max-w-2xl">
        <div class="text-center">
            <!-- Error Code Animation -->
            <div class="mb-8 relative inline-block">
                <div class="absolute inset-0 blur-3xl bg-gradient-to-r from-amber-400 to-yellow-400 opacity-20 rounded-full"></div>
                <div class="relative text-9xl font-black text-transparent bg-clip-text bg-linear-to-r from-amber-600 to-yellow-600">
                    403
                </div>
            </div>

            <!-- Heading -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 mb-4">Access Denied</h1>
            <p class="text-lg text-slate-600 mb-8 max-w-md mx-auto">You don't have permission to access this resource. Only authorized users can view this page.</p>

            <!-- Icon -->
            <div class="flex justify-center mb-12">
                <div class="relative">
                    <div class="absolute inset-0 blur-2xl bg-gradient-to-br from-amber-500 to-yellow-500 opacity-10 rounded-full w-24 h-24"></div>
                    <div class="relative flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-amber-100 to-yellow-100 border-2 border-amber-200">
                        <i class="fas fa-lock text-amber-600 text-4xl"></i>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(auth()->check())
                    @if(auth()->user()->role === 'Admin')
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                            <i class="fas fa-home"></i>
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('cashier.dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                            <i class="fas fa-home"></i>
                            Go to Dashboard
                        </a>
                    @endif
                    <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-200 py-3 px-8 text-sm font-bold text-slate-700 hover:bg-slate-300 transition focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        <i class="fas fa-arrow-left"></i>
                        Go Back
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 py-3 px-8 text-sm font-bold text-white shadow-lg shadow-amber-600/30 hover:bg-amber-700 transition focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </a>
                    <a href="{{ route('landing') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-200 py-3 px-8 text-sm font-bold text-slate-700 hover:bg-slate-300 transition focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        <i class="fas fa-home"></i>
                        Go Home
                    </a>
                @endif
            </div>

            <!-- Additional Info -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <p class="text-sm text-slate-500 mb-4">Error Code: 403 | Forbidden</p>
                <p class="text-xs text-slate-400">If you believe this is a mistake, please contact the administrator.</p>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
    </div>

</body>
</html>
