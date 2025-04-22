<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Users</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-200">
    <div class="flex">
        <!-- Sidebar -->
        <div id="sidebar"
            class="flex flex-col absolute md:fixed inset-y-0 left-0 z-50 bg-white w-64 h-full p-5 transition-transform transform -translate-x-full md:translate-x-0 shadow-sm">
            <button id="closeSidebar" class="md:hidden text-2xl mb-4 self-end">✕</button>
            <div class="flex w-36 mb-10">
                <img src="../assets/logo.png" alt="Logo">
            </div>

            <ul class="flex flex-col gap-4 text-primary2 font-semibold text-sm">
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="dashboard"
                        class="flex items-center"><ion-icon name="apps" class="text-2xl pr-2"></ion-icon>Dashboard</a>
                </li>
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="timeline-peminjaman"
                        class="flex items-center"><ion-icon name="calendar" class="text-2xl pr-2"></ion-icon>Timeline
                        Peminjaman</a></li>
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="pinjam-kendaraan"
                        class="flex items-center"><ion-icon name="car" class="text-2xl pr-2"></ion-icon>Pinjam
                        Kendaraan</a></li>
                @if(auth()->user()->role !== 'staff')        
                <li class="hover:bg-slate-200 rounded-l-full p-2">
                    <a href="daftar-permohonan" class="flex items-center"><ion-icon name="megaphone" class="text-2xl pr-2"></ion-icon>Daftar
                        Permohonan
                    </a>
                </li>
                <li class="hover:bg-slate-200 rounded-l-full p-2">
                    <a href="user" class="flex items-center">
                        <ion-icon name="person" class="text-2xl pr-2"></ion-icon>Users
                    </a>
                </li>
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="permohonan-verifikasi"
                        class="flex items-center"><ion-icon name="person-add" class="text-2xl pr-2"></ion-icon>Permohonan Verifikasi</a>
                </li>
                @endif
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="logout"
                        class="flex items-center"><ion-icon name="log-out" class="text-2xl pr-2"></ion-icon>Keluar</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 min-h-screen p-6 w-full md:ml-64">
            <!-- Tombol Sidebar -->
            <button id="openSidebar" class="md:hidden text-2xl mb-4">☰</button>

            <!-- Navbar -->
            <div class="flex justify-between">
                <h1 class="font-poppins font-bold text-xl sm:text-2xl flex items-center">Pinjam Kendaraan
                </h1>

                <button class="flex w-fit gap-3" id="openPopupProfile">
                    <div class="flex flex-col text-sm">
                        <h1>Hey, <b>{{ $user->nama }}</b>.</h1>
                        <p class="text-left">{{ $user->role }}</p>
                    </div>
                    <div class="flex">
                        <div class="w-9 h-9 overflow-hidden rounded-full my-auto bg-center bg-cover shadow-sm"
                            style="background-image: url(../assets/user\ \(2\).jpg);"></div>
                    </div>
                </button>

                <!-- Popup (Modal) -->
                <div id="popupProfile"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[90vh] overflow-y-auto">
                        <h2 class="text-xl font-semibold mb-4">Form: Data Diri</h2>

                        <!-- Modal Form -->
                        <form id="popupFormProfile">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium">Nama</label>
                                <input type="text" id="name" name="nama" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="{{ $user->nama }}">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="{{ $user->email }}">
                            </div>

                            {{-- <div class="mb-4 relative">
                                <label for="pass" class="block text-sm font-medium">Password</label>
                                <input type="password" id="pass" name="password" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="{{ $user->password }}">
                                
                                <!-- Tombol Show/Hide Password -->
                                <button type="button" id="togglePass" class="absolute right-2 top-8 text-xl text-gray-500">
                                    <ion-icon id="eyeIcon" name="eye-off"></ion-icon>
                                </button>
                            </div> --}}

                            <!-- Jika pengguna BUKAN admin, tampilkan field tambahan -->
                            @if ($user->role !== 'admin')
                                <div class="mb-4">
                                    <label for="no-hp" class="block text-sm font-medium">No Whatsapp</label>
                                    <input type="text" id="no-hp" name="no_hp" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        maxlength="18" value="{{ $user->no_hp }}">
                                </div>

                                <div class="flex justify-between gap-2 mb-4">
                                    <div class="flex flex-col w-full">
                                        <label for="depart" class="block text-sm font-medium">Prodi</label>
                                        <select name="departemen" id="depart" class="p-2 border rounded-md w-full focus:ring-2 focus:ring-blue-400">
                                            <option value="informatika" {{ $user->departemen == 'informatika' ? 'selected' : '' }}>Informatika</option>
                                            <option value="mesin" {{ $user->departemen == 'mesin' ? 'selected' : '' }}>Mesin</option>
                                            <option value="bisnis" {{ $user->departemen == 'bisnis' ? 'selected' : '' }}>Manajemen Bisnis</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="ktp" class="block text-sm font-medium">KTP</label>
                                    <input type="file" id="ktp" name="ktp" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>

                            @endif

                            <div class="flex justify-end space-x-2">
                                <button type="button" id="closePopupProfile" class="bg-gray-300 text-black px-4 py-2 rounded-md">Cancel</button>
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="relative overflow-x-auto mt-8">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[90vh] overflow-y-auto m-auto">
                    <h2 class="text-xl font-semibold mb-4">Pinjam Kendaraan</h2>
                    <form id="popupFormPinjam1" class="font-normal" action="{{ route('pinjam-kendaraan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_kendaraan" value="{{ $kendaraan->id }}">
                        <input type="hidden" name="id_user" value="{{ $user->id }}">
                
                        <div class="mb-4">
                            <label for="merk" class="block font-semibold text-sm">Merk</label>
                            <input type="text" id="merk" name="merk" required value="{{ $kendaraan->merk }}" readonly
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="mb-4">
                            <label for="seri" class="block font-semibold text-sm">Seri</label>
                            <input type="text" id="seri" name="seri" required value="{{ $kendaraan->seri }}" readonly
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_awal_peminjaman" class="block font-semibold text-sm">Estimasi Awal</label>
                            <div class="flex flex-col gap-2">
                                <input type="datetime-local" id="tanggal_awal_peminjaman" name="tanggal_awal_peminjaman" required
                                    class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                                
                                <label for="tanggal_akhir_peminjaman" class="block font-semibold text-sm">Estimasi Akhir</label>
                                <input type="datetime-local" id="tanggal_akhir_peminjaman" name="tanggal_akhir_peminjaman" required
                                    class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                            </div>
                        </div>
                        <div class="mb4">
                            <label for="tujuan" class="block text-sm font-medium">Tujuan Peminjaman</label>
                            <textarea name="tujuan_peminjaman" id="tujuan_peminjaman"
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>

                        <input type="text" name="status_peminjaman" value="Pending" hidden>

                        <div class="flex justify-end space-x-2">
                            <a href="/pinjam-kendaraan"
                                class="bg-gray-300 text-black px-4 py-2 rounded-md">Cancel</a>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // popup Profile

        const openPopup = document.getElementById('openPopupProfile');
        const closePopup = document.getElementById('closePopupProfile');
        const popup = document.getElementById('popupProfile');

        // Buka popup
        openPopup.addEventListener('click', () => {
            popup.classList.remove('hidden');
        });

        // Tutup popup
        closePopup.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        // Submit form
        document.getElementById('popupForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Form submitted!');
            popup.classList.add('hidden');
        });

    </script>

    <script>
    $(document).ready(function () {
        $("#popupFormPinjam1").submit(function (e) {
            e.preventDefault(); // Mencegah reload halaman

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: $(this).serialize(),
                dataType: "json", // Pastikan response adalah JSON
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "/timeline-peminjaman"; // Redirect ke halaman lain
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText); // Cek error di console
                    Swal.fire("Error!", "Terjadi kesalahan saat menyimpan data.", "error");
                }
            });
        });
    });
    </script>
    
</body>


</html>