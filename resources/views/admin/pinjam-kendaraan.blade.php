<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Tambah Kendaraan</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <label for="foto-profile" class="block text-sm font-medium">Foto Profile</label>
                                <input type="file" id="foto-profile" name="foto" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </div>

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

                            <div class="mb-4">
                                <label for="nip" class="block text-sm font-medium">NIP</label>
                                <input type="nip" id="nip" name="nip" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    maxlength="18" value="{{ $user->nip }}">
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
            <div class="flex flex-col gap-1">
                <p class="mt-3 text-red-500 font-bold text-center">Semua Kendaraan</p>
                <h1 class="font-semibold mt-2 text-xl text-center">Seluruh tipe kendaraan dan spesifikasi yang tersedia
                </h1>
                <p class="text-slate-500 text-sm text-center">Semua kendaraan tersedia merupakan hak milik Politeknik
                    Negeri Batam.
                </p>

                <div class="flex flex-wrap gap-2 mt-10 items-center justify-between">
                        <!-- Tombol Buka Modal -->
                        <div class="flex gap-2">
                            @if(auth()->user()->role !== 'staff')
                                <button id="tambahKendaraanButton" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tambah Kendaraan</button>
                            @endif
                        
                            <!-- Popup (Modal) -->
                            <div id="popupTambahKendaraan"
                                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
                                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg max-w-[95%] sm:max-w-lg w-full max-h-[90vh] overflow-y-auto relative">
                                    <h2 class="text-xl font-semibold mb-4">Form: Tambah Kendaraan</h2>
                        
                                    <form id="popupFormTambahKendaraan" method="POST" action="tambahkendaraan" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="seri" class="block text-sm font-medium">Atas Nama</label>
                                            <input type="text" id="seri" name="atas_nama" required value=""
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        </div>
                        
                                        <label class="block mb-2 font-medium">Jenis Kendaraan</label>
                                        <select name="jenis_kendaraan" required class="w-full p-2 border rounded-md">
                                            <option value="">Pilih Salah Satu</option>
                                            <option value="Mobil">Mobil</option>
                                            <option value="Motor">Motor</option>
                                            <option value="Bus">Bus</option>
                                        </select>
                        
                                        <label class="block mb-2 font-medium">Merk Kendaraan</label>
                                        <select name="id_merek"
                                            class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">
                                            <option value="">Pilih Merk Kendaraan</option>
                                            @foreach($merek as $merk)
                                                <option value="{{ $merk->id }}">{{ $merk->nama }}</option>
                                            @endforeach
                                        </select>
                        
                                        <div class="mb-4">
                                            <label for="seri" class="block text-sm font-medium">Seri Kendaraan</label>
                                            <input type="text" id="seri" name="seri" required value=""
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        </div>
                        
                                        <div class="mb-4">
                                            <label for="no_plat" class="block text-sm font-medium">Nomor Plat</label>
                                            <input type="text" id="no_plat" name="no_plat" required value="" placeholder="Contoh: BP 1234 ABC"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        </div>

                                        <!-- Form tambah Lokasi -->
                                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
                                        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

                                        <div class="mt-6 mb-4">
                                            <h2 class="block text-sm font-medium">Lokasi Kendaraan</h2>
                                            <div id="map" name="lokasi_awal" class="rounded-xl shadow-md" style="height: 300px;"></div>

                                            <input type="hidden" name="lokasi_awal" id="lokasi_awal">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">

                                            <p class="text-xs mt-2 text-slate-500">Pastikan lokasi sudah sesuai.</p>
                                        </div>
                                        <script>
                                            const map = L.map('map').setView([1.1517, 104.0223], 13);
                                            const marker = L.marker([1.1517, 104.0223]).addTo(map);
        
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '&copy; OpenStreetMap'
                                            }).addTo(map);
                                            map.on('click', function(e) {
                                            marker.setLatLng(e.latlng);
                                            document.getElementById('latitude').value = e.latlng.lat;
                                            document.getElementById('longitude').value = e.latlng.lng;
                                            document.getElementById('lokasi_awal').value = `${e.latlng.lat},${e.latlng.lng}`;
                                            });
                                    
                                            // Cari lokasi user
                                            navigator.geolocation.getCurrentPosition(function (position) {
                                                const lat = position.coords.latitude;
                                                const lng = position.coords.longitude;
                                    
                                                map.setView([lat, lng], 15);
                                                marker.setLatLng([lat, lng]);
                                    
                                                // Set latitude dan longitude
                                                document.getElementById('latitude').value = lat;
                                                document.getElementById('longitude').value = lng;
                                    
                                                // Set lokasi_awal sebagai "lat,lng"
                                                document.getElementById('lokasi_awal').value = `${lat},${lng}`;
                                            }, function () {
                                                alert('Gagal mengambil lokasi. Pastikan GPS aktif.');
                                            });
                                        </script>


                                        <div class="mb-4">
                                            <label for="status" class="block text-sm font-medium">Status Kendaraan</label>
                                            <select id="status" name="status_kendaraan" required
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                <option value="">Pilih Status Kendaraan</option>
                                                <option value="Available">Available</option>
                                                <option value="Perbaikan">Perbaikan</option>
                                                <option value="Digunakan">Digunakan</option>
                                            </select>
                                        </div>
                        
                                        <div class="mb-4">
                                            <label for="spesifikasi" class="block text-sm font-medium">Spesifikasi
                                                Kendaraan</label>
                                            <textarea id="spesifikasi" name="detail_kendaraan" required rows="4"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
Kapasitas Penumpang: -
Muatan Maksimal: -
Kapasitas Mesin: -
Bahan Bakar: -
Kapasitas Tangki: -
Transmisi: Manual / Otomatis (CVT)
Sistem Penggerak: -
Dimensi (PxLxT): -
                                            </textarea>
                                        </div>
                        
                                        <div class="mb-4">
                                            <label for="foto" class="block text-sm font-medium">Upload Foto Kendaraan</label>
                                            <input type="file" id="foto" name="image" accept="image/*"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        </div>
                        
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" id="closePopupTambahKendaraan"
                                                class="bg-gray-300 text-black px-4 py-2 rounded-md">Cancel</button>
                                            <button type="submit"
                                                class="bg-green-500 text-white px-4 py-2 rounded-md">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
                            {{-- // Script untuk Modal --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                // Fungsi untuk membuka popup form tambah kendaraan
                                function openPopupTambahKendaraan() {
                                    const popup = document.getElementById('popupTambahKendaraan');
                                    popup.classList.remove('hidden'); // Menampilkan modal
                                    setTimeout(() => {
                                        map.invalidateSize();
                                    }, 300);
                                }

                                // Fungsi untuk menutup popup form tambah kendaraan
                                const closePopupButton = document.getElementById('closePopupTambahKendaraan');
                                closePopupButton.addEventListener('click', function () {
                                    const popup = document.getElementById('popupTambahKendaraan');
                                    popup.classList.add('hidden'); // Menyembunyikan modal
                                });

                                // Event listener untuk tombol tambah kendaraan
                                const tambahKendaraanButton = document.getElementById('tambahKendaraanButton');
                                tambahKendaraanButton.addEventListener('click', openPopupTambahKendaraan);

                                // Form submit untuk menambah kendaraan
                                document.getElementById('popupFormTambahKendaraan').addEventListener('submit', function (e) {
                                    e.preventDefault(); // Mencegah form submit biasa

                                    // Ambil data form
                                    let formData = new FormData(this);

                                    // Kirim data form dengan AJAX ke route tambahkendaraan
                                    fetch("{{ route('tambahkendaraan') }}", {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(async (response) => {
                                        if (!response.ok) {
                                            const errorData = await response.json();
                                            throw { status: response.status, data: errorData };
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        // Notifikasi sukses
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: data.message,
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            document.getElementById('popupFormTambahKendaraan').reset();
                                            document.getElementById('popupTambahKendaraan').classList.add('hidden');
                                            location.reload();
                                        });
                                    })
                                    .catch((error) => {
                                        if (error.status === 422 && error.data.errors) {
                                            const errorMessages = Object.values(error.data.errors).flat().join('\n');
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Validasi Gagal!',
                                                text: errorMessages
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal!',
                                                text: 'Terjadi kesalahan saat menambahkan kendaraan.'
                                            });
                                        }
                                    });

                                });
                            });

                            </script>
                    
                            @if(auth()->user()->role !== 'staff')
                            <!-- Button to trigger the popup -->
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md" onclick="showPopup()">Tambah Merk</button>
                            @endif

                            <!-- Popup content (hidden by default) -->
                            <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50" id="popup">
                                <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
                                    <div class="text-lg font-bold mb-4">Merk Kendaraan</div>

                                    <!-- To-Do List Items -->
                                    <ul class="list-disc pl-5 space-y-2">
                                        @foreach ($merek as $item)
                                            <li class="flex justify-between items-center">
                                                <span>{{ $item->nama }}</span>
                                                <form action="{{ route('hapus.merek', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus merek ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 ml-2 rounded-md hover:bg-red-600">Delete</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    
                                    <!-- Input and Add Button -->
                                    <form action="{{ route('tambah.merek') }}" method="POST" class="flex space-x-2 mt-4">
                                        @csrf
                                        <input type="text" name="nama" class="border border-gray-300 px-4 py-2 rounded-md w-full" placeholder="Tambah merek baru">
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add</button>
                                    </form>

                                    <!-- Close Button -->
                                    <div class="mt-4 text-right">
                                        <button class="bg-gray-300 px-4 py-2 rounded-md" onclick="closePopup()">Close</button>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                                // Show the popup
                                function showPopup() {
                                    document.getElementById('popup').classList.remove('hidden');
                                }

                                // Close the popup
                                function closePopup() {
                                    document.getElementById('popup').classList.add('hidden');
                                }
                            </script>
                        </div>

                        {{-- Filter --}}
                        <div class="flex flex-wrap gap-2 items-center w-full sm:w-auto">
                            <input type="text" id="searchInput" placeholder="Cari nama kendaraan..."
                                class="p-2 border rounded-md w-full sm:w-auto" onkeyup="searchByCarName()">

                            <label for="sort" class="font-semibold">Sort by</label>
                            <select name="sort" id="sort" class="p-2 border rounded-md cursor-pointer w-full sm:w-auto">
                                <option value="terbaru">Terbaru</option>
                                <option value="terlama">Terlama</option>
                            </select>
                        </div>
                </div>

                {{-- List Kendaraan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-5 font-semibold" id="cardContainer">
                    @foreach($kendaraan as $item)

                        <div class="card h-64 rounded-xl flex flex-col shadow-sm justify-between relative group overflow-hidden cursor-pointer"
                            style="background-image: url('{{ asset('storage/' . $item->image) }}'); background-size: cover; background-position: center;"
                            onclick="openModal('modal{{ $item->id }}')">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300">
                            </div>
                        </div>

                        <div id="modal{{ $item->id }}"
                            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                @if(auth()->user()->role !== 'staff')
                                    <div class="flex gap-2 mb-5">
                                        <button class="mt-4 bg-yellow-300 text-white p-2 rounded w-fit editKendaraanButton" data-kendaraan="{{ json_encode($item) }}">
                                            <ion-icon name="brush" class="text-lg flex items-center self-center"></ion-icon>
                                        </button>                                        
                                        <button class="mt-4 bg-red-500 text-white p-2 rounded w-fit"><ion-icon name="trash"
                                                class="text-lg flex items-center self-center" onclick="hapusKendaraan({{ $item->id }})"></ion-icon>
                                        </button>

                                        <script>
                                            function hapusKendaraan(id) {
                                                Swal.fire({
                                                    title: 'Yakin ingin menghapus kendaraan?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Ya, hapus!',
                                                    cancelButtonText: 'Batal'
                                                }).then(result => {
                                                    if (result.isConfirmed) {
                                                    fetch(`/hapus-kendaraan/${id}`, {
                                                        method: 'DELETE',
                                                        headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        }
                                                    })
                                                    .then(res => {
                                                        if (res.ok) return res.json();
                                                        throw new Error('Gagal menghapus kendaraan');
                                                    })
                                                    .then(data => {
                                                        Swal.fire('Terhapus!', data.message, 'success').then(() => location.reload());
                                                    })
                                                    .catch(err => {
                                                        Swal.fire('Error', err.message, 'error');
                                                    });
                                                    }
                                                });
                                                }

                                        </script>
                                    </div>
                                @endif

                                <h1 class="text-xl font-semibold mb-1">{{ $item->merek->nama }}</h1>
                                <h2 class="text-base font-normal text-slate-500">{{ $item->seri }}</h2>
                                <p class="text-base font-normal text-slate-500 mb-2">{{ $item->atas_nama }}</p>

                                <ul class="font-normal">
                                    @foreach(explode("\n", $item->detail_kendaraan) as $detail)
                                        @if(trim($detail) !== '')
                                            @php
                                                $parts = explode(':', $detail, 2); // Pisah berdasarkan ":", maksimal 2 bagian
                                            @endphp
                                            <li>
                                                <b>{{ trim($parts[0]) }}</b>:
                                                {{ isset($parts[1]) ? trim($parts[1]) : '' }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                
                                
                                <div class="flex justify-between">
                                    @if($item->status_kendaraan === 'Available')
                                        <a href="{{ route('peminjaman.create', ['id' => $item->id]) }}" class="mt-4 bg-green-500 text-white px-4 py-2 rounded w-fit hover:bg-green-600 transition">Pinjam</a>
                                    @elseif($item->status_kendaraan === 'Perbaikan')
                                        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded w-fit cursor-not-allowed opacity-70" disabled>Dalam Perbaikan</button>
                                    @else
                                        <button class="mt-4 bg-yellow-400 text-white px-4 py-2 rounded w-fit cursor-not-allowed opacity-70" disabled>Sedang Digunakan</button>
                                    @endif
                                    <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded w-fit"
                                        onclick="closeModal('modal{{ $item->id }}')">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Modal Edit Kendaraan -->
                    <div id="popupEditKendaraan" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
                        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg max-w-[95%] sm:max-w-lg w-full max-h-[90vh] overflow-y-auto relative">
                            <h2 class="text-xl font-semibold mb-4">Form: Edit Kendaraan</h2>
                            <form id="popupFormEditKendaraan" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <input type="hidden" id="editKendaraanId" name="id" value="">
                    
                                <div class="mb-4">
                                    <label for="atas_nama" class="block text-sm font-medium">Atas Nama</label>
                                    <input type="text" id="editAtasNama" name="atas_nama" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                    
                                <label class="block mb-2 font-medium">Jenis Kendaraan</label>
                                <select name="jenis_kendaraan" id="editJenisKendaraan" required class="w-full p-2 border rounded-md">
                                    <option value="">Pilih Salah Satu</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Bus">Bus</option>
                                </select>
                    
                                <label class="block mb-2 font-medium">Merk Kendaraan</label>
                                <select name="id_merek" id="editMerekKendaraan" class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">
                                    <option value="">Pilih Merk Kendaraan</option>
                                    @foreach($merek as $merk)
                                        <option value="{{ $merk->id }}">{{ $merk->nama }}</option>
                                    @endforeach
                                </select>
                    
                                <div class="mb-4">
                                    <label for="seri" class="block text-sm font-medium">Seri Kendaraan</label>
                                    <input type="text" id="editSeri" name="seri" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                    
                                <div class="mb-4">
                                    <label for="no_plat" class="block text-sm font-medium">Nomor Plat</label>
                                    <input type="text" id="editNoPlat" name="no_plat" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                        
                                <!-- Form Edit Lokasi -->
                                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
                                <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

                                <div class="mt-6 mb-4">
                                    <h2 class="block text-sm font-medium">Lokasi Kendaraan</h2>
                                    <div id="mapEdit" name="lokasi_awal" class="rounded-xl shadow-md" style="height: 300px;"></div>
                
                                    <input type="hidden" name="lokasi_awal" id="lokasi_awal_edit">
                                    <input type="hidden" name="latitude" id="latitude_edit">
                                    <input type="hidden" name="longitude" id="longitude_edit">
                
                                    <p class="text-xs mt-2 text-slate-500">Pastikan lokasi sudah sesuai.</p>
                                </div>

                                <script>
                                    const mapEdit = L.map('mapEdit').setView([1.1517, 104.0223], 13);
                                    const markerEdit = L.marker([1.1517, 104.0223]).addTo(mapEdit);

                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap'
                                    }).addTo(mapEdit);
                                    mapEdit.on('click', function(e) {
                                    markerEdit.setLatLng(e.latlng);
                                    document.getElementById('latitude_edit').value = e.latlng.lat;
                                    document.getElementById('longitude_edit').value = e.latlng.lng;
                                    document.getElementById('lokasi_awal_edit').value = `${e.latlng.lat},${e.latlng.lng}`;
                                    });
                            
                                    // Cari lokasi user
                                    navigator.geolocation.getCurrentPosition(function (position) {
                                        const lat = position.coords.latitude;
                                        const lng = position.coords.longitude;
                            
                                        map.setView([lat, lng], 15);
                                        marker.setLatLng([lat, lng]);
                            
                                        // Set latitude dan longitude
                                        document.getElementById('latitude_edit').value = lat;
                                        document.getElementById('longitude_edit').value = lng;
                            
                                        // Set lokasi_awal sebagai "lat,lng"
                                        document.getElementById('lokasi_awal_edit').value = `${lat},${lng}`;
                                    }, function () {
                                        alert('Gagal mengambil lokasi. Pastikan GPS aktif.');
                                    });
                                </script>
                    
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium">Status Kendaraan</label>
                                    <select id="editStatus" name="status_kendaraan" required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">Pilih Status Kendaraan</option>
                                        <option value="Available">Available</option>
                                        <option value="Perbaikan">Perbaikan</option>
                                        <option value="Digunakan">Digunakan</option>
                                    </select>
                                </div>
                    
                                <div class="mb-4">
                                    <label for="spesifikasi" class="block text-sm font-medium">Spesifikasi Kendaraan</label>
                                    <textarea id="editSpesifikasi" name="detail_kendaraan" required rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                                </div>
                    
                                <div class="mb-4">
                                    <label for="foto" class="block text-sm font-medium">Upload Foto Kendaraan</label>
                                    <input type="file" id="editFoto" name="image" accept="image/*"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                    
                                <div class="flex justify-end space-x-2">
                                    <button type="button" id="closePopupEditKendaraan" class="bg-gray-300 text-black px-4 py-2 rounded-md">Cancel</button>
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const editButtons = document.querySelectorAll('.editKendaraanButton');
                            const popupEditKendaraan = document.getElementById('popupEditKendaraan');
                            const closePopupEditKendaraan = document.getElementById('closePopupEditKendaraan');
                            const formEditKendaraan = document.getElementById('popupFormEditKendaraan');

                            editButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const kendaraan = JSON.parse(this.getAttribute('data-kendaraan'));
                        
                                    // Isi data ke form
                                    document.getElementById('editKendaraanId').value = kendaraan.id || '';
                                    document.getElementById('editAtasNama').value = kendaraan.atas_nama || '';
                                    document.getElementById('editJenisKendaraan').value = kendaraan.jenis_kendaraan || '';
                                    document.getElementById('editMerekKendaraan').value = kendaraan.id_merek || '';
                                    document.getElementById('editSeri').value = kendaraan.seri || '';
                                    document.getElementById('editNoPlat').value = kendaraan.no_plat || '';
                                    document.getElementById('latitude').value = kendaraan.latitude || '';
                                    document.getElementById('longitude').value = kendaraan.longitude || '';
                                    // Jangan set langsung lokasi_awal di sini,
                                    // karena nanti akan kita set gabungan lat,long saat submit
                                    document.getElementById('lokasi_awal').value = kendaraan.lokasi_awal || '';
                                    document.getElementById('editStatus').value = kendaraan.status_kendaraan || '';
                                    document.getElementById('editSpesifikasi').value = kendaraan.detail_kendaraan || '';
                        
                                    // Set action form ke route update kendaraan
                                    formEditKendaraan.action = `/edit-kendaraan/${kendaraan.id}`;
                        
                                    // Tampilkan popup
                                    popupEditKendaraan.classList.remove('hidden');
                                        setTimeout(() => {
                                        mapEdit.invalidateSize();
                                    }, 200);
                                });
                            });
                        
                            // Tombol close popup
                            closePopupEditKendaraan.addEventListener('click', function () {
                                popupEditKendaraan.classList.add('hidden');
                            });
                        
                            // Sebelum submit, gabungkan latitude dan longitude ke lokasi_awal
                            formEditKendaraan.addEventListener('submit', function (e) {
                                e.preventDefault();
                        
                                const lat = document.getElementById('latitude_edit').value.trim();
                                const lon = document.getElementById('longitude_edit').value.trim();
                        
                                if (!lat || !lon) {
                                    alert('Latitude dan Longitude harus diisi!');
                                    return false;
                                }
                        
                                // Gabungkan lat,long ke lokasi_awal
                                document.getElementById('lokasi_awal').value = lat + ',' + lon;
                        
                                // Konfirmasi dengan SweetAlert
                                Swal.fire({
                                    title: 'Apakah anda yakin?',
                                    text: "Data kendaraan akan diperbarui!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#22c55e',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, simpan!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        this.submit(); // Submit form jika yakin
                                    }
                                });
                            });
                        });
                    </script>
                        
                </div>

                <script>
                    function openModal(modalId) {
                        document.getElementById(modalId).classList.remove('hidden');
                    }

                    function closeModal(modalId) {
                        document.getElementById(modalId).classList.add('hidden');
                    }
                </script>
            </div>
        </div>
    </div>

    <script>
        // Sidebar
        const sidebar = document.getElementById('sidebar');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // Popup Timeline Peminjaman Detail
        const openDetail1 = document.getElementById('openPopupDetail1');
        const closeDetail1 = document.getElementById('closePopupDetail1');
        const popupDetail1 = document.getElementById('popupDetail1');

        if (openDetail1 && closeDetail1 && popupDetail1) {
            openDetail1.addEventListener('click', () => {
                popupDetail1.classList.remove('hidden'); // ✅ Perbaikan di sini
            });

            closeDetail1.addEventListener('click', () => {
                popupDetail1.classList.add('hidden'); // ✅ Perbaikan di sini
            });

            document.getElementById('popupFormDetail1').addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Form submitted!');
                popupDetail1.classList.add('hidden'); // ✅ Perbaikan di sini
            });
        }

        // Popup Profile
        const openPopupProfile = document.getElementById('openPopupProfile');
        const closePopupProfile = document.getElementById('closePopupProfile');
        const popupProfile = document.getElementById('popupProfile');

        if (openPopupProfile && closePopupProfile && popupProfile) {
            openPopupProfile.addEventListener('click', () => {
                popupProfile.classList.remove('hidden');
            });

            closePopupProfile.addEventListener('click', () => {
                popupProfile.classList.add('hidden');
            });
        }
    </script>
</body>
</html>