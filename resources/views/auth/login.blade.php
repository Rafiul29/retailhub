<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | POS</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 antialiased">

    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="relative w-full max-w-6xl rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Left: Form Card -->
                <div class="flex items-center justify-center bg-white p-8 sm:p-12 lg:p-16">
                    <div class="w-full max-w-sm">
                        <!-- Header -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-2">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-linear-to-br from-indigo-600 to-indigo-700 shadow-lg shadow-indigo-600/30">
                                    <i class="fas fa-bolt text-white text-xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-extrabold text-slate-900">RetailHub</h1>
                                    <p class="text-xs text-slate-500 font-medium">Point of Sale System</p>
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 mt-4">Welcome Back</h2>
                            <p class="text-sm text-slate-500 mt-1">Sign in to your account to continue.</p>
                        </div>

                        @if (session('status'))
                            <div
                                class="mb-6 rounded-lg bg-emerald-50 p-4 text-emerald-700 text-sm border border-emerald-200">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                            @csrf

                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-700 mb-2">Email
                                    Address</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    autofocus placeholder="name@company.com"
                                    class="w-full rounded-lg bg-slate-50 border border-slate-200 py-3 px-4 text-sm text-slate-700 placeholder:text-slate-400 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-rose-500 bg-rose-50 @enderror">
                                @error('email') <p class="mt-2 text-xs text-rose-600 font-medium"><i
                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-xs font-semibold text-slate-700 mb-2">Password</label>
                                <input id="password" name="password" type="password" required placeholder="••••••••"
                                    class="w-full rounded-lg bg-slate-50 border border-slate-200 py-3 px-4 text-sm text-slate-700 placeholder:text-slate-400 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-rose-500 bg-rose-50 @enderror">
                                @error('password') <p class="mt-2 text-xs text-rose-600 font-medium"><i
                                class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center justify-between pt-2 space-x-1">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox"
                                        class="h-4 w-4 shrink-0 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer transition duration-150 ease-in-out">
                                    <label for="remember"
                                        class="ml-2.5 block text-sm font-medium text-slate-700 cursor-pointer select-none">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">Forgot
                                        password?</a>
                                @endif
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 rounded-lg bg-indigo-600 py-3 px-4 text-sm font-bold text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <i class="fas fa-sign-in-alt"></i>
                                Sign in
                            </button>
                        </form>

                        <div
                            class="mt-8 rounded-lg bg-linear-to-br from-indigo-50 to-blue-50 p-5 border border-indigo-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600">
                                    <i class="fas fa-star-half text-white text-sm"></i>
                                </div>
                                <p class="text-xs font-bold uppercase tracking-wider text-indigo-900">Quick Demo Login
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" onclick="loginAsAdmin()"
                                    class="flex flex-col items-center justify-center gap-1.5 rounded-lg bg-white py-3 px-3 text-xs font-semibold text-slate-700 border border-indigo-200 hover:border-indigo-400 hover:bg-indigo-50 transition shadow-sm">
                                    <i class="fas fa-user-shield text-indigo-600 text-base"></i>
                                    <span>Admin</span>
                                    <span class="text-xs font-normal text-slate-500">admin@example.com</span>
                                </button>
                                <button type="button" onclick="loginAsCashier()"
                                    class="flex flex-col items-center justify-center gap-1.5 rounded-lg bg-white py-3 px-3 text-xs font-semibold text-slate-700 border border-emerald-200 hover:border-emerald-400 hover:bg-emerald-50 transition shadow-sm">
                                    <i class="fas fa-cash-register text-emerald-600 text-base"></i>
                                    <span>Cashier</span>
                                    <span class="text-xs font-normal text-slate-500">cashier@example.com</span>
                                </button>
                            </div>
                        </div>

                        <script>
                            function loginAsAdmin() {
                                document.getElementById('email').value = 'admin@example.com';
                                document.getElementById('password').value = 'password';
                                document.querySelector('form').submit();
                            }

                            function loginAsCashier() {
                                document.getElementById('email').value = 'cashier@example.com';
                                document.getElementById('password').value = 'password';
                                document.querySelector('form').submit();
                            }
                        </script>
                    </div>
                </div>

                <!-- Right: Visual / Marketing -->
                <div class="hidden lg:flex items-center justify-center relative bg-slate-900 overflow-hidden">
                    <img class="absolute inset-0 h-full w-full object-cover opacity-40"
                        src="https://images.unsplash.com/photo-1556742049-2996d9333989?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                        alt="POS System">
                    <div class="absolute inset-0 bg-linear-to-tr from-indigo-900/90 to-black/60"></div>

                    <div class="relative z-10 px-12 text-white text-center">
                        <div class="mb-8 flex justify-center">
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur border border-white/20">
                                <i class="fas fa-shopping-cart text-indigo-300 text-2xl"></i>
                            </div>
                        </div>
                        <h3 class="text-4xl sm:text-5xl font-extrabold leading-tight">
                            Lightning fast <span
                                class="text-transparent bg-clip-text bg-linear-to-r from-indigo-400 to-blue-400">Digital
                                Retail</span>
                        </h3>
                        <p class="mt-6 text-lg text-slate-200 max-w-md mx-auto leading-relaxed">
                            Real-time inventory tracking, seamless checkout experience, and powerful analytics for
                            modern retail stores.
                        </p>

                        <div class="mt-12 grid grid-cols-3 gap-6 text-center">
                            <div>
                                <i class="fas fa-tachometer-alt text-indigo-300 text-2xl mb-2 block"></i>
                                <p class="text-xs font-semibold text-slate-300 uppercase tracking-wide">Lightning Fast
                                </p>
                            </div>
                            <div>
                                <i class="fas fa-chart-line text-emerald-300 text-2xl mb-2 block"></i>
                                <p class="text-xs font-semibold text-slate-300 uppercase tracking-wide">Smart Analytics
                                </p>
                            </div>
                            <div>
                                <i class="fas fa-lock text-amber-300 text-2xl mb-2 block"></i>
                                <p class="text-xs font-semibold text-slate-300 uppercase tracking-wide">Secure</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>