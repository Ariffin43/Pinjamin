<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
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
                        Kendaraan</a>
                </li>
                <li class="hover:bg-slate-200 rounded-l-full p-2"><a href="/peminjaman-saya"
                    class="flex items-center"><ion-icon name="car" class="text-2xl pr-2"></ion-icon>Peminjaman
                    Saya</a>
                </li>
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
                <h1 class="font-poppins font-bold text-xl sm:text-2xl flex items-center">Analiytics</h1>

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
            <div class="relative overflow-x-auto shadow-md rounded-lg mt-8">


                <div class="flex mb-2 items-center ml-auto w-fit">
                    <!-- Input Pencarian -->
                    <input type="text" id="search" placeholder="Cari..." class="p-2 border rounded-md mr-2"
                        onkeyup="searchTable()">

                    <label for="sort" class="mr-2 font-semibold">Sort by</label>
                    <select name="sort" id="sort" class="p-2 border rounded-md cursor-pointer">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                </div>

                <script>
                    // Fungsi Pencarian di Tabel
                    function searchTable() {
                        const input = document.getElementById('search').value.toLowerCase();
                        const rows = document.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(input) ? '' : 'none';
                        });
                    }
                </script>

                <table class="min-w-[700px] w-full text-sm text-left rtl:text-right text-primary2">
                    <thead class="text-xs text-gray-700 uppercase bg-white">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-base">Users</th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b border-gray-200">
                            <th scope="row" class="px-4 py-4 font-medium text-primary2"><img
                                    src="../assets/user (1).jpg" alt="" class="rounded-full w-12 h-12"></th>
                            <th scope="row" class="px-4 py-4 font-semibold text-primary2 whitespace-nowrap">Farrel
                                Adelio
                                Asman</th>
                            <td class="px-4 py-4">farreladelioasman@gmail.com</td>
                            <td class="px-4 py-4">12345xxxxxxxx</td>
                            <td class="px-4 py-4">Informatika</td>
                            <td class="px-4 py-4">Admin</td>
                            <td class="px-4 py-4 space-x-2">
                                <button class="font-medium bg-yellow-400 px-3 py-1 rounded-lg hover:opacity-60"
                                    id="Edit">Edit</button>
                                <button class="font-medium bg-red-500 px-3 py-1 rounded-lg hover:opacity-60"
                                    id="">Hapus</button>
                            </td>
                        </tr>
                        <tr class="bg-white border-b border-gray-200">
                            <th scope="row" class="px-4 py-4 font-medium text-primary2"><img
                                    src="../assets/user (2).jpg" alt="" class="rounded-full w-12 h-12"></th>
                            <th scope="row" class="px-4 py-4 font-semibold text-primary2 whitespace-nowrap">Zoro</th>
                            <td class="px-4 py-4">bangzoro@gmail.com</td>
                            <td class="px-4 py-4">12345xxxxxxxx</td>
                            <td class="px-4 py-4">Mesin</td>
                            <td class="px-4 py-4">Staff</td>
                            <td class="px-4 py-4 space-x-2">
                                <button class="font-medium bg-yellow-400 px-3 py-1 rounded-lg hover:opacity-60"
                                    id="openPopupUser">Edit</button>
                                <button class="font-medium bg-red-500 px-3 py-1 rounded-lg hover:opacity-60"
                                    id="">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Popup (Modal) -->
                <div id="popupUser"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[90vh] overflow-y-auto">
                        <h2 class="text-xl font-semibold mb-4">Form: Data Diri</h2>

                        <form id="popupFormUser">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium">Nama</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="Farrel Adelio Asman">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="farreladelioasman@gmail.com">
                            </div>

                            <div class="mb-4">
                                <label for="nip" class="block text-sm font-medium">NIP</label>
                                <input type="nip" id="nip" name="nip" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    maxlength="18" value="11111111111111111">
                            </div>

                            <div class="mb-4">
                                <label for="no-hp" class="block text-sm font-medium">No Whatsapp</label>
                                <input type="text" id="no-hp" name="no-hp" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    maxlength="18" value="089686968886">
                            </div>

                            <div class="mb-4 relative">
                                <label for="pass" class="block text-sm font-medium">Password</label>
                                <input type="password" id="pass" name="pass" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    value="farrel@2025">

                                <!-- Tombol Show/Hide dengan Ionicons -->
                                <button type="button" id="togglePass"
                                    class="absolute right-2 top-8 text-xl text-gray-500">
                                    <ion-icon id="eyeIcon" name="eye-off"></ion-icon>
                                </button>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium">KTP</label>
                                <input type="file" id="email" name="email" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </div>

                            <div class="flex flex-col w-full">
                                <label for="depart"
                                    class="block text-sm font-medium  focus:ring-2 focus:ring-blue-400">Departemen</label>

                                <select name="depart" id="sort"
                                    class="p-2 border rounded-md w-full  focus:ring-2 focus:ring-blue-400">
                                    <option value="poltek">Informatika</option>
                                    <option value="saab">Mesin</option>
                                    <option value="mercedes">Manajemen Bisnis</option>
                                </select>
                            </div>


                            <div class="flex justify-end space-x-2 mt-2">
                                <button type="button" id="closePopupUser"
                                    class="bg-gray-300 text-black px-4 py-2 rounded-md">Cancel</button>
                                <button type="submit"
                                    class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        // popup UsersTable

        const openPopupUser = document.getElementById('openPopupUser');
        const closePopupUser = document.getElementById('closePopupUser');
        const popupUser = document.getElementById('popupUser');

        // Buka popup
        openPopupUser.addEventListener('click', () => {
            popupUser.classList.remove('hidden');
        });

        // Tutup popup
        closePopupUser.addEventListener('click', () => {
            popup.classList.add('hidden');
        });

        // Submit form
        document.getElementById('popupFormUser').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Form submitted!');
            popup.classList.add('hidden');
        });
    </script>
</body>


</html>