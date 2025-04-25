<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Tambah Kendaraan</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <div class="flex flex-col gap-1">
                <p class="mt-3 text-red-500 font-bold text-center">Semua Kendaraan</p>
                <h1 class="font-semibold mt-2 text-xl text-center">Seluruh tipe kendaraan dan spesifikasi yang tersedia
                </h1>
                <p class="text-slate-500 text-sm text-center">Semua kendaraan tersedia merupakan hak milik Politeknik
                    Negeri Batam.
                </p>

                <div class="flex flex-wrap gap-2 mt-10 items-center justify-between">
                    <!-- Tombol Buka Modal -->
                    @if(auth()->user()->role !== 'staff')
                        <button id="openTambahKendaraan"
                            class="bg-blue-500 text-white w-fit px-3 py-2 rounded-md">Tambah Kendaraan
                        </button>
                    @endif


                    <!-- Popup (Modal) -->
                    <div id="popupTambahKendaraan"
                        class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
                        <div
                            class="bg-white p-4 sm:p-6 rounded-lg shadow-lg max-w-[95%] sm:max-w-lg w-full max-h-[90vh] overflow-y-auto relative">
                            <h2 class="text-xl font-semibold mb-4">Form: Tambah Kendaraan</h2>

                            <form id="popupFormPinjam" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="id_merek">Jenis Kendaraan</label>
                                        <select name="jenis_kendaraan" required class="w-full p-2 border rounded-md">
                                            <option value="">Pilih Salah Satu</option>
                                            <option value="Mobil">Mobil</option>
                                            <option value="Motor">Motor</option>
                                            <option value="Bus">Bus</option>
                                        </select>
                                </div>
                                <div class="mb-4">
                                    <label for="id_merek">Merek</label>
                                    <select name="id_merek" required class="w-full p-2 border rounded-md">
                                        <option value="">Pilih Salah Satu</option>
                                        @foreach($merek as $merk)
                                            <option value="{{ $merk->id }}">{{ $merk->nama }}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                <div class="mb-4">
                                    <label for="seri">Seri</label>
                                    <input type="text" id="seri" name="seri" required class="w-full p-2 border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="no_plat">No Plat</label>
                                    <input type="text" id="no_plat" name="no_plat" required class="w-full p-2 border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="detail_kendaraan">Detail Kendaraan</label>
                                    <textarea id="detail_kendaraan" name="detail_kendaraan" rows="4" required class="w-full p-2 border rounded-md"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="status_kendaraan">Status Kendaraan</label>
                                    <select id="status_kendaraan" name="status_kendaraan" required class="w-full p-2 border rounded-md">
                                        <option value="Available">Available</option>
                                        <option value="Perbaikan">Perbaikan</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi_awal" required class="w-full p-2 border rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="image">Gambar Kendaraan</label>
                                    <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded-md">
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" class="closeModal bg-gray-300 px-4 py-2 rounded-md">Batal</button>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

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

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-5 font-semibold" id="cardContainer">
                    @foreach($kendaraan as $item)
                        <!-- Card -->
                        <div class="card h-64 rounded-xl flex flex-col shadow-sm justify-between relative group overflow-hidden cursor-pointer"
                            style="background-image: url('{{ asset('storage/' . $item->image) }}'); background-size: cover; background-position: center;"
                            onclick="openModal('modal{{ $item->id }}')">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition duration-300">
                            </div>
                        </div>
                    
                        <!-- Modal -->
                        <div id="modal{{ $item->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                <div class="flex gap-2 mb-5">
                                    @if(auth()->user()->role !== 'staff')
                                        <!-- Tombol Edit -->
                                        <button class="mt-4 bg-yellow-300 text-white p-2 rounded w-fit editKendaraan" data-kendaraan="{{ json_encode($item) }}">
                                            <ion-icon name="brush" class="text-lg flex items-center self-center"></ion-icon>
                                        </button>
                                    
                                        <!-- Tombol Hapus -->
                                        <button class="mt-4 bg-red-500 text-white p-2 rounded w-fit" onclick="hapusKendaraan({{ $item->id }})">
                                            <ion-icon name="trash" class="text-lg flex items-center self-center"></ion-icon>
                                        </button>
                                    @endif                        
                                </div>
                                
                                <h1 class="text-xl font-semibold mb-2">{{ $item->merk }}</h1>
                                <h2 class="text-base font-normal text-slate-500 mb-4">{{ $item->seri }}</h2>
                    
                                <ul class="font-normal">
                                    <li><b>No. Plat</b>: {{ $item->no_plat }}</li>
                                    <li><b>Jenis Kendaraan</b>: {{ $item->jenis_kendaraan }}</li>
                                    <li><b>Detail</b>: {{ $item->detail_kendaraan }}</li>
                                    <li><b>Status</b>: {{ $item->status_kendaraan }}</li>
                                </ul>
                                <div class="flex justify-between">
                                    @if($item->status_kendaraan === 'Available')
                                        <a href="{{ route('peminjaman.create', ['id' => $item->id]) }}" class="mt-4 bg-green-500 text-white px-4 py-2 rounded w-fit hover:bg-green-600 transition">Pinjam</a>
                                    @else
                                        <button class="mt-4 bg-yellow-400 text-white px-4 py-2 rounded w-fit cursor-not-allowed opacity-70" disabled>Sedang Digunakan</button>
                                    @endif
                                    <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded w-fit" onclick="closeModal('modal{{ $item->id }}')">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Popup Edit Kendaraan -->
                    <div id="popupEditKendaraan" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                            <h2 class="text-xl font-semibold mb-4">Edit Kendaraan</h2>
                            <form id="popupFormEdit">
                                <input type="hidden" name="id" id="editId">
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Merk:</label>
                                    <input type="text" name="merk" id="editMerk" class="w-full border rounded p-2">
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Seri:</label>
                                    <input type="text" name="seri" id="editSeri" class="w-full border rounded p-2">
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">No. Plat:</label>
                                    <input type="text" name="no_plat" id="editNoPlat" class="w-full border rounded p-2">
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Jenis Kendaraan:</label>
                                    <input type="text" name="jenis_kendaraan" id="editJenis" class="w-full border rounded p-2">
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Detail Kendaraan:</label>
                                    <textarea name="detail_kendaraan" id="editDetail" class="w-full border rounded p-2"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Status Kendaraan:</label>
                                    <select name="status_kendaraan" id="editStatus" class="w-full border rounded p-2">
                                        <option value="Available">Tersedia</option>
                                        <option value="Digunakan">Digunakan</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium">Gambar (opsional):</label>
                                    <input type="file" name="image" id="editImage" class="w-full border rounded p-2">
                                </div>
                                <div class="flex justify-between">
                                    <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded w-fit">Simpan Perubahan</button>
                                    <button type="button" class="mt-4 bg-red-500 text-white px-4 py-2 rounded w-fit closeModal">Tutup</button>
                                </div>
                            </form>
                        </div>
                    </div>
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

        // Popup Tambah Kendaraan
        const openTambahKendaraan = document.getElementById('openTambahKendaraan');
        const closeTambahKendaraan = document.querySelectorAll('.closeModal');
        const popupTambahKendaraan = document.getElementById('popupTambahKendaraan');

        if (openTambahKendaraan && popupTambahKendaraan) {
            openTambahKendaraan.addEventListener('click', () => {
                popupTambahKendaraan.classList.remove('hidden');
            });

            closeTambahKendaraan.forEach(button => {
                button.addEventListener('click', () => {
                    popupTambahKendaraan.classList.add('hidden');
                });
            });

            document.getElementById('popupFormPinjam').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch("{{ route('tambahkendaraan') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambahkan kendaraan.'
                    });
                });
            });
        }

        // Popup Edit Kendaraan
        const popupEditKendaraan = document.getElementById('popupEditKendaraan');
        const closeModals = document.querySelectorAll('.closeModal');

        // Event tombol edit
        document.querySelectorAll('.editKendaraan').forEach(button => {
            button.addEventListener('click', function () {
                const kendaraan = JSON.parse(this.getAttribute('data-kendaraan'));
                
                // Isi form dengan data kendaraan yang dipilih
                document.getElementById('editId').value = kendaraan.id;
                document.getElementById('editMerk').value = kendaraan.merk;
                document.getElementById('editSeri').value = kendaraan.seri;
                document.getElementById('editNoPlat').value = kendaraan.no_plat;
                document.getElementById('editJenis').value = kendaraan.jenis_kendaraan;
                document.getElementById('editDetail').value = kendaraan.detail_kendaraan;
                document.getElementById('editStatus').value = kendaraan.status_kendaraan;

                popupEditKendaraan.classList.remove('hidden');
            });
        });

        // Event tombol tutup modal
        closeModals.forEach(button => {
            button.addEventListener('click', () => {
                popupEditKendaraan.classList.add('hidden');
            });
        });

        // Form submit untuk edit kendaraan
        document.getElementById('popupFormEdit').addEventListener('submit', function (e) {
            e.preventDefault();

            const kendaraanId = document.getElementById('editId').value;
            const formData = new FormData(this);

            fetch(`/edit-kendaraan/${kendaraanId}`, {
                method: 'POST', // Ganti 'PUT' jika di Laravel pakai PUT
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengedit kendaraan.'
                    });
            });
        });

        function hapusKendaraan(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data kendaraan dan peminjaman terkait akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/hapus-kendaraan/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus kendaraan.'
                        });
                    });
                }
            });
        }

    </script>
    </body>


</html>