<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Đăng Ký</h2>
        <p class="text-gray-600 text-sm">Tạo tài khoản để thưởng thức pizza ngon!</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                👤 Họ và Tên
            </label>
            <input id="name" 
                   class="input-field block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:outline-none focus:ring-0 bg-gray-50 focus:bg-white transition-all duration-300" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   placeholder="Nhập họ và tên của bạn" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                   autocomplete="new-password"
                   placeholder="Tạo mật khẩu mạnh" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                🔐 Xác Nhận Mật Khẩu
            </label>
            <input id="password_confirmation" 
                   class="input-field block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:outline-none focus:ring-0 bg-gray-50 focus:bg-white transition-all duration-300"
                   type="password"
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   placeholder="Nhập lại mật khẩu" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms Agreement -->
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
            <p class="text-sm text-gray-700 text-center">
                Bằng việc đăng ký, bạn đồng ý với 
                <a href="#" class="text-orange-600 font-semibold hover:text-orange-800">Điều khoản sử dụng</a> 
                và 
                <a href="#" class="text-orange-600 font-semibold hover:text-orange-800">Chính sách bảo mật</a> 
                của chúng tôi.
            </p>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="btn-primary w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-orange-300">
            🎉 Tạo Tài Khoản
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-gray-600 text-sm mb-3">Đã có tài khoản?</p>
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-xl transition-all duration-300 border border-gray-300">
                🔑 Đăng Nhập Ngay
            </a>
        </div>
    </form>
</x-guest-layout>
