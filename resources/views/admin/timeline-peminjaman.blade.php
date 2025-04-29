<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <!-- TIMELINE -->
            <div class="relative overflow-x-auto shadow-md rounded-lg mt-8">

                <div class="flex justify-between whitespace-nowrap gap-2">
                    <a href="pinjam-kendaraan"
                        class="bg-blue-500 text-white w-fit h-fit px-2 py-2 rounded-md">Pinjam
                        Sekarang
                    </a>

                    <div class="flex mb-2 items-center ml-auto w-fit">
                        <input type="text" id="search" placeholder="Cari..." class="p-2 border rounded-md mr-2"
                            onkeyup="searchTable()">

                        <label for="sort" class="mr-2 font-semibold">Sort by</label>
                        <select name="sort" id="sort" class="p-2 border rounded-md cursor-pointer">
                            <option value="terbaru">Terbaru</option>
                            <option value="terlama">Terlama</option>
                        </select>
                    </div>

                    <script>
                        function searchTable() {
                            const input = document.getElementById('search').value.toLowerCase();
                            const rows = document.querySelectorAll('tbody tr');

                            rows.forEach(row => {
                                const text = row.textContent.toLowerCase();
                                row.style.display = text.includes(input) ? '' : 'none';
                            });
                        }
                    </script>
                </div>

                <table class="min-w-[700px] w-full text-sm text-left rtl:text-right text-primary2">
                    <thead class="text-xs text-gray-700 uppercase bg-white">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama Peminjam</th>
                            <th scope="col" class="px-4 py-3">Plat Nomor</th>
                            <th scope="col" class="px-4 py-3">Merk</th>
                            <th scope="col" class="px-4 py-3">Seri</th>
                            <th scope="col" class="px-4 py-3">Tujuan Peminjaman</th>
                            <th scope="col" class="px-4 py-3">Tanggal Awal</th>
                            <th scope="col" class="px-4 py-3">Tanggal Akhir</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($peminjaman->isEmpty())
                            <tr>
                                <td colspan="9" class="px-4 py-4 text-center text-gray-500">Data peminjaman tidak ada</td>
                            </tr>
                        @else
                            @foreach($peminjaman as $item)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-4 py-4">{{ $item->user->nama }}</td>
                                    <td class="px-4 py-4">{{ $item->kendaraan->no_plat }}</td>
                                    <td class="px-4 py-4">{{ $item->kendaraan->merek->nama }}</td>
                                    <td class="px-4 py-4">{{ $item->kendaraan->seri }}</td>
                                    <td class="px-4 py-4">{{ $item->tujuan_peminjaman }}</td>
                                    <td class="px-4 py-4">{{ $item->tanggal_awal_peminjaman }}</td>
                                    <td class="px-4 py-4">{{ $item->tanggal_akhir_peminjaman }}</td>
                                    <td class="px-4 py-4">
                                        @switch($item->status_peminjaman)
                                            @case('Pending')
                                                <p class="bg-yellow-300 text-black rounded-full w-fit px-2 py-1 font-semibold">
                                                    {{ $item->status_peminjaman }}
                                                </p>
                                                @break
                                    
                                            @case('Di Terima')
                                                <p class="bg-green-300 text-black rounded-full w-fit px-2 py-1 font-semibold">
                                                    {{ $item->status_peminjaman }}
                                                </p>
                                                @break
                                    
                                            @case('Di Tolak')
                                                <p class="bg-red-400 text-black rounded-full w-fit px-2 py-1 font-semibold">
                                                    {{ $item->status_peminjaman }}
                                                </p>
                                                @break
                                    
                                            @default
                                                <p class="bg-gray-300 text-black rounded-full w-fit px-2 font-semibold">
                                                    Tidak Diketahui
                                                </p>
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="javascript:void(0)"
                                                 onclick="openEditModal({{ $item }})"
                                                class="font-medium bg-yellow-300 px-3 py-1 rounded-lg hover:opacity-60">
                                                Edit
                                            </a>
                                    
                                            <form action="{{ route('timeline-peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="font-medium bg-red-500 px-3 py-1 rounded-lg hover:opacity-60">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                    
                                    <!-- Modal Edit Peminjaman -->
                                    <div id="editModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[90vh] overflow-y-auto m-auto">
                                            <h2 class="text-xl font-semibold mb-4">Edit Peminjaman</h2>
                                    
                                            <form id="editForm" method="POST" action="">
                                                @csrf
                                                @method('PUT')
                                    
                                                <input type="hidden" id="edit_id" name="id">
                                    
                                                <div class="mb-4" hidden>
                                                    <label for="edit_merek" class="block font-semibold text-sm">Merk</label>
                                                    <input type="text" id="edit_merek" name="merek" value=""
                                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>
                                                
                                                <div class="mb-4" hidden>
                                                    <label for="edit_seri" class="block font-semibold text-sm">Seri</label>
                                                    <input type="text" id="edit_seri" name="seri" value=""
                                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>                                                
                                    
                                                <div class="mb-4">
                                                    <label for="edit_tanggal_awal_peminjaman" class="block font-semibold text-sm">Estimasi Awal</label>
                                                    <input type="datetime-local" id="edit_tanggal_awal_peminjaman" name="tanggal_awal_peminjaman" required
                                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>
                                    
                                                <div class="mb-4">
                                                    <label for="edit_tanggal_akhir_peminjaman" class="block font-semibold text-sm">Estimasi Akhir</label>
                                                    <input type="datetime-local" id="edit_tanggal_akhir_peminjaman" name="tanggal_akhir_peminjaman" required
                                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                </div>
                                    
                                                <div class="mb-4">
                                                    <label for="edit_tujuan_peminjaman" class="block font-semibold text-sm">Tujuan Peminjaman</label>
                                                    <textarea id="edit_tujuan_peminjaman" name="tujuan_peminjaman" required
                                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                                                </div>
                                    
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" onclick="closeEditModal()" 
                                                        class="bg-gray-300 text-black px-4 py-2 rounded-md">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                                        Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <script>
                                        // Fungsi untuk membuka modal dan mengisi data
                                        function openEditModal(peminjaman) {
                                            console.log(peminjaman);  // Cek apakah data peminjaman sudah benar
                                            document.getElementById('edit_id').value = peminjaman.id;
                                            document.getElementById('edit_merek').value = peminjaman.kendaraan.merek.nama;
                                            document.getElementById('edit_seri').value = peminjaman.kendaraan.seri;
                                            document.getElementById('edit_tanggal_awal_peminjaman').value = peminjaman.tanggal_awal_peminjaman;
                                            document.getElementById('edit_tanggal_akhir_peminjaman').value = peminjaman.tanggal_akhir_peminjaman;
                                            document.getElementById('edit_tujuan_peminjaman').value = peminjaman.tujuan_peminjaman;

                                            // Tampilkan modal
                                            document.getElementById('editModal').classList.remove('hidden');

                                            // Set action form untuk submit ke URL yang benar
                                            document.getElementById('editForm').action = `/timeline-peminjaman/${peminjaman.id}`;
                                        }


                                        // Fungsi untuk menutup modal
                                        function closeEditModal() {
                                            document.getElementById('editModal').classList.add('hidden');
                                        }

                                        // Fungsi untuk mengirim data menggunakan fetch
                                        document.getElementById('editForm').addEventListener('submit', function (e) {
                                            e.preventDefault(); // Mencegah form dari submit tradisional

                                            const formData = new FormData(this); // Ambil data form

                                            // Cek data yang dikirim
                                            for (let [key, value] of formData.entries()) {
                                                console.log(key, value); // Cek setiap field
                                            }

                                            const formAction = this.action; // Ambil URL action (URL yang sesuai dengan route)

                                            // Kirim data menggunakan fetch
                                            fetch(formAction, {
                                                method: 'PUT',
                                                body: formData,
                                                headers: {
                                                    'Accept': 'application/json',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'X-CSRF-TOKEN': formData.get('_token'),
                                                },
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    // Success logic here
                                                } else {
                                                    console.log(data); // Cek data yang diterima untuk informasi error
                                                    Swal.fire({
                                                        title: 'Error!',
                                                        text: data.message || 'Terjadi kesalahan, silakan coba lagi.',
                                                        icon: 'error',
                                                        confirmButtonText: 'OK',
                                                    });
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error); // Cek error lebih lanjut
                                            });
                                        });



                                    </script>
                                    
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                
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

        // Ambil elemen yang dibutuhkan
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
    </script>
</body>


</html>