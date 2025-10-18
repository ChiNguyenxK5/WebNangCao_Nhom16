<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileUserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.updateprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Cập nhật thông tin cơ bản
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
        ]);

        // Cập nhật mật khẩu nếu có
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
            }

            if ($request->filled('new_password')) { // Thêm kiểm tra này
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
            }
        }

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
