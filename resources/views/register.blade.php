<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan akunmu | Pinjam</title>
    @vite('resources/css/app.css')
    <style>
    </style>
</head>

<body class="bg-white">
    <div class="container w-fit flex justify-between relative top-10 m-auto bg-white rounded-2xl flex-col md:flex-row">
        <div class="font-poppins w-fit text-primary2 m-auto md:m-0 p-5 md:py-10 md:pr-10">
            <div class="w-60 m-auto overflow-hidden">
                <img src="../assets/logo.png" alt="" class="w-full">
            </div>

            <!-- Form Register -->
            <form action="{{ url('/register') }}" method="POST" class="flex flex-col md:w-80 gap-3 mt-8 tracking-wide" enctype="multipart/form-data">
                @csrf  <!-- CSRF Token -->
                
                <!-- Role -->
                <div class="flex flex-col w-full mb-4">
                    <label for="role" class="block text-sm font-medium focus:ring-2 focus:ring-blue-400">Role</label>
                    <select name="role" id="role" class="p-2 border rounded-md w-full focus:ring-2 focus:ring-blue-400">
                        <option value="Staff">Staff</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <!-- NIP -->
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required maxlength="8"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('nip')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required maxlength="255"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('nama')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- No HP -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-sm font-medium">No Whatsapp</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required maxlength="13"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('no_hp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto KTP -->
                <div class="mb-4">
                    <label for="foto_ktp" class="block text-sm font-medium">KTP</label>
                    <input type="file" id="foto_ktp" name="foto_ktp" required
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('foto_ktp')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Prodi -->
                <div class="flex flex-col w-full mb-4">
                    <label for="prodi" class="block text-sm font-medium focus:ring-2 focus:ring-blue-400">Prodi</label>
                    <select name="prodi" id="prodi" class="p-2 border rounded-md w-full focus:ring-2 focus:ring-blue-400">
                        <option value="TRPL">Teknik Rekayasa Perangkat Lunak</option>
                        <option value="MB">Manajemen Bisnis</option>
                        <option value="TI">Teknik Informatika</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Submit Button -->
                <button type="submit" class="bg-primary2 mt-2 rounded-md font-bold p-2 text-center text-white hover:opacity-80">
                    Daftar
                </button>

                <!-- Link to Login -->
                <p class="text-slate-700 text-center text-sm mt-3">Sudah memiliki akun? silahkan login <a href="/login" class="text-blue-500 font-semibold">disini</a></p>
            </form>
        </div>
    </div>
</body>

</html>
