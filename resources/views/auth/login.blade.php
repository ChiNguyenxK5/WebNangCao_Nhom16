<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Đăng Nhập</h2>
        <p class="text-gray-600 text-sm">Chào mừng bạn trở lại Pizza House!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                📧 Email Address
            </label>
            <input id="email" 
                   class="input-field block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:outline-none focus:ring-0 bg-gray-50 focus:bg-white transition-all duration-300" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="Nhập email của bạn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                🔒 Mật Khẩu
            </label>
            <input id="password" 
                   class="input-field block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:outline-none focus:ring-0 bg-gray-50 focus:bg-white transition-all duration-300"
                   type="password"
                   name="password"
                   required 
                   autocomplete="current-password"
                   placeholder="Nhập mật khẩu" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-orange-300 text-orange-600 shadow-sm focus:ring-orange-500" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">Ghi nhớ đăng nhập</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-600 hover:text-orange-800 font-medium transition-colors duration-200" 
                   href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="btn-primary w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-orange-300">
            🚀 Đăng Nhập
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-gray-600 text-sm mb-3">Chưa có tài khoản?</p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center justify-center w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-xl transition-all duration-300 border border-gray-300">
                ✨ Đăng Ký Ngay
            </a>
        </div>
    </form>
</x-guest-layout>
