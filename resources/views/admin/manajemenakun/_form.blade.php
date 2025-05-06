{{-- resources/views/admin/manajemenakun/_form.blade.php --}}
@csrf

<div class="bg-white p-6 rounded-lg shadow">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                placeholder="Masukkan nama lengkap" required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                placeholder="example@mail.com" required>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role Pengguna --}}
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Role Pengguna</label>
            <select id="role" name="role"
                class="mt-1 block w-full rounded-md border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required>
                @foreach (['admin', 'juri', 'peserta'] as $roleOption)
                    <option value="{{ $roleOption }}"
                        {{ old('role', $user->role ?? '') === $roleOption ? 'selected' : '' }}>
                        {{ ucfirst($roleOption) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password & Konfirmasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                    @if (isset($user))
                        <span class="text-xs text-gray-500">(kosongkan jika tidak diubah)</span>
                    @endif
                </label>
                <input id="password" name="password" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    placeholder="******" {{ isset($user) ? '' : 'required' }}>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                    Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="mt-1 block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    placeholder="******" {{ isset($user) ? '' : 'required' }}>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('admin.manajemen-akun.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow hover:bg-gray-300 transition focus:outline-none focus:ring focus:ring-gray-200 focus:ring-opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <button type="submit"
            class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md shadow hover:bg-blue-700 transition focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            {{ $submitText }}
        </button>
    </div>
</div>
