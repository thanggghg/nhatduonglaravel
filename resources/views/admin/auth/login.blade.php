<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ghost-fog min-h-screen flex items-center justify-center p-16">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-32">
            <h1 class="text-display font-bold text-brand-green mb-8">Nhật Dương</h1>
            <p class="text-body text-muted-gray">Quản trị hệ thống</p>
        </div>

        <!-- Login Card -->
        <div class="bg-canvas-white rounded-lg shadow-lg p-32">
            <h2 class="text-heading font-semibold text-forest-deep mb-24">Đăng nhập</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-16 py-12 rounded-md mb-24">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-body-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <!-- Email -->
                <div class="mb-24">
                    <label for="email" class="block text-body-sm font-medium text-slate-text mb-8">
                        Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent"
                        placeholder="admin@nhatduong.com"
                    >
                </div>

                <!-- Password -->
                <div class="mb-24">
                    <label for="password" class="block text-body-sm font-medium text-slate-text mb-8">
                        Mật khẩu
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-16 py-12 border border-input-border rounded-md text-body text-slate-text placeholder-hint-gray focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Remember Me -->
                <div class="mb-24">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-16 h-16 text-brand-green border-input-border rounded focus:ring-2 focus:ring-brand-green"
                        >
                        <span class="ml-8 text-body-sm text-muted-gray">Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-brand-green text-canvas-white font-semibold py-14 px-28 rounded-md hover:bg-green-hover transition-colors duration-200"
                >
                    Đăng nhập
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-24">
            <p class="text-body-sm text-muted-gray">
                © {{ date('Y') }} Nhà Xe Nhật Dương. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
