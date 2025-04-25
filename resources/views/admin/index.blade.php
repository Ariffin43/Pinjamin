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
                <h1 class="font-poppins font-bold text-xl sm:text-2xl flex items-center">Dashboard</h1>

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
                        <form id="popupFormProfile" method="POST">

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
                                        <label for="prodi" class="block text-sm font-medium">Prodi</label>
                                        <select name="prodi" id="prodi" class="p-2 border rounded-md w-full focus:ring-2 focus:ring-blue-400">
                                            <option value="informatika" {{ $user->prodi == 'informatika' ? 'selected' : '' }}>Informatika</option>
                                            <option value="mesin" {{ $user->prodi == 'mesin' ? 'selected' : '' }}>Mesin</option>
                                            <option value="bisnis" {{ $user->prodi == 'bisnis' ? 'selected' : '' }}>Manajemen Bisnis</option>
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
            <div class="flex flex-col lg:flex-row gap-5 mt-5">
                <!-- Left / Main content -->
                <div class="w-full {{ auth()->user()->role !== 'staff' ? 'lg:w-2/3' : '' }}">
                    {{-- Info Kendaraan --}}
                    <div class="flex flex-col sm:flex-row justify-between gap-5">
                        <div class="flex justify-between text-primary2 h-fit w-full sm:w-1/2 xl:w-80 p-5 xl:p-10 rounded-md bg-white shadow-md hover:bg-primary2 hover:text-white">
                            <div class="flex flex-col gap-1 md:gap-2">
                                <h1 class="font-bold text-xl xl:text-3xl">{{ $available }}</h1>
                                <p class="text-lg xl:text-lg">Available</p>
                            </div>
                    
                            <p class="text-center flex items-center w-fit"><ion-icon name="podium" class="text-3xl xl:text-6xl"></ion-icon></p>
                        </div>
                    
                        <div class="flex text-primary2 justify-between h-fit w-full sm:w-1/2 xl:w-80 p-5 xl:p-10 rounded-md bg-white shadow-md hover:bg-primary2 hover:text-white">
                            <div class="flex flex-col gap-1 md:gap-2">
                                <h1 class="font-bold text-xl xl:text-3xl">{{ $used }}</h1>
                                <p class="text-lg xl:text-lg">Digunakan</p>
                            </div>
                    
                            <p class="text-center flex items-center w-fit"><ion-icon name="map" class="text-3xl xl:text-6xl"></ion-icon></p>
                        </div>
                    
                        <div class="flex justify-between text-primary2 h-fit w-full sm:w-1/2 xl:w-80 p-5 xl:p-10 rounded-md bg-white shadow-md hover:bg-primary2 hover:text-white">
                            <div class="flex flex-col gap-1 md:gap-2">
                                <h1 class="font-bold text-xl xl:text-3xl">{{ $repair }}</h1>
                                <p class="text-lg xl:text-lg">Perbaikan</p>
                            </div>
                    
                            <p class="text-center flex items-center w-fit"><ion-icon name="cog" class="text-3xl xl:text-6xl"></ion-icon></p>
                        </div>
                    </div>
                    
                    <!-- USER -->
                    <div class="flex mt-8 flex-col">
                        <h1 class="font-semibold font-poppins text-xl">Users</h1>
                        <div class="flex flex-wrap justify-start mt-2 gap-12 bg-white shadow-md px-6 md:px-8 xl:px-12 py-5 rounded-xl">
                            @if($users->isEmpty())
                                <div class="w-full text-center py-10">
                                    <p class="text-gray-400 font-poppins text-base">Belum ada user terdaftar!</p>
                                </div>
                            @else
                                @foreach ($users as $user)
                                    <div class="flex flex-col gap-3 w-fit text-center hover:bottom-2 transition-all">
                                        <div class="background w-12 h-12 xl:w-20 xl:h-20 bg-center bg-cover rounded-full m-auto shadow-sm"
                                            style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&color=fff');">
                                        </div>
                                        <div class="flex flex-col">
                                            <h1 class="font-bold tracking-wide text-center text-base sm:text-lg xl:text-xl font-poppins">
                                                {{ $user->nama }}
                                            </h1>
                                            <p class="text-center text-slate-400 font-poppins text-xs md:text-sm">
                                                {{ $user->departemen }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Button Tambah User -->
                                @can('admin')
                                    <a href="/tambah-users"
                                        class="flex flex-col gap-3 w-fit text-center my-auto relative hover:bottom-2 md:hover:bottom-0 transition-all">
                                        <ion-icon name="add"
                                            class="md:text-3xl xl:text-7xl font-bold rounded-full p-2 hover:bg-slate-100"></ion-icon>
                                        <p class="font-bold font-poppins tracking-wide text-center text-xs text-slate-400 hover:text-primary2">
                                            Selengkapnya..
                                        </p>
                                    </a>
                                @endcan
                            @endif
                        </div>                           
                    </div>

                    {{-- Time Line Kendaraan --}}
                    <div class="relative overflow-x-auto rounded-lg mt-8">
                        <h1 class="text-xl font-semibold font-poppins mb-2">Timeline</h1>
                        <table class="min-w-[700px] w-full text-sm  shadow-sm text-left rtl:text-right text-primary2">
                            <thead class="text-xs text-gray-700 uppercase bg-white">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Plat Nomor</th>
                                    <th scope="col" class="px-4 py-3">Merk</th>
                                    <th scope="col" class="px-4 py-3">Seri</th>
                                    <th scope="col" class="px-4 py-3">Kategori</th>
                                    <th scope="col" class="px-4 py-3">Peminjam</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b border-gray-200">
                                    <th scope="row" class="px-4 py-4 font-medium text-primary2">BP1234</th>
                                    <td class="px-4 py-4">Avanza</td>
                                    <td class="px-4 py-4">Avanza 1</td>
                                    <td class="px-4 py-4">Mobil</td>
                                    <td class="px-4 py-4">Abdul</td>
                                    <td class="px-4 py-4">
                                        <p class="bg-yellow-100 rounded-full w-fit px-2 font-semibold">Digunakan</p>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-gray-200">
                                    <th scope="row" class="px-4 py-4 font-medium text-primary2">BP1234</th>
                                    <td class="px-4 py-4">Avanza</td>
                                    <td class="px-4 py-4">Avanza 2</td>
                                    <td class="px-4 py-4">Mobil</td>
                                    <td class="px-4 py-4">Abdul</td>
                                    <td class="px-4 py-4">
                                        <p class="bg-red-400 rounded-full w-fit px-2 font-semibold">Perbaikan</p>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-gray-200">
                                    <th scope="row" class="px-4 py-4 font-medium text-primary2">BP1234</th>
                                    <td class="px-4 py-4">Avanza</td>
                                    <td class="px-4 py-4">Avanza 3</td>
                                    <td class="px-4 py-4">Mobil</td>
                                    <td class="px-4 py-4">Abdul</td>
                                    <td class="px-4 py-4">
                                        <p class="bg-green-300 rounded-full w-fit px-2 font-semibold">Available</p>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b border-gray-200">
                                    <th scope="row" class="px-4 py-4 font-medium text-primary2">BP1234</th>
                                    <td class="px-4 py-4">Avanza</td>
                                    <td class="px-4 py-4">Avanza 3</td>
                                    <td class="px-4 py-4">Mobil</td>
                                    <td class="px-4 py-4">Abdul</td>
                                    <td class="px-4 py-4">
                                        <p class="bg-green-300 rounded-full w-fit px-2 font-semibold">Available</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- right -->
                @if(auth()->user()->role !== 'staff')
                    <h1 class="font-bold font-poppins text-xl mt-6 hidden sm:flex md:hidden">Notifikasi</h1>
                    <div class="w-full lg:w-1/3 flex-col sm:flex md:flex-col gap-3">
                        <h1 class="font-bold font-poppins text-xl flex sm:hidden md:flex">Permohonan Terbaru</h1>
                        <div class="flex flex-col bg-white py-5 rounded-xl shadow-sm">
                            @if($permohonanPending->isEmpty())
                                <p class="text-center text-sm text-gray-500">Tidak ada permohonan terbaru yang menunggu verifikasi.</p>
                            @else
                                <ul class="flex flex-col gap-5 max-h-56 px-5 overflow-y-auto">
                                    @foreach($permohonanPending as $p)
                                    <li class="flex gap-3 items-start">
                                        <div class="background w-10 h-10 bg-center bg-cover rounded-full shadow-sm"
                                            style="background-image: url({{ asset('assets/user.jpg') }});"></div> <!-- Ganti dengan path yang sesuai -->
                                        <p class="text-sm"><b>{{ $p->nama }}</b>, menunggu untuk verifikasi akun.</p> <!-- Sesuaikan dengan field di database -->
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="{{ route('daftar-permohonan') }}" class="flex mt-2 mx-5 items-start border-2 border-dotted border-slate-300 rounded-xl p-2">
                                <h1 class="font-semibold mx-auto">Setujui Peminjaman</h1>
                            </a>
                        </div>
                        
                        <h1 class="font-bold font-poppins text-xl mt-7 flex sm:hidden md:flex">Verifikasi Akun Terbaru</h1>
                        <div class="flex flex-col bg-white py-5 rounded-xl shadow-sm">
                            @if($akunPending->isEmpty())
                                <p class="text-center text-sm text-gray-500">Tidak ada akun yang menunggu verifikasi.</p>
                            @else
                                <ul class="flex flex-col gap-5 max-h-56 px-5 overflow-y-auto">
                                    @foreach($akunPending as $va)
                                    <li class="flex gap-3 items-center">
                                        <div class="background w-10 h-10 bg-center bg-cover rounded-full shadow-sm"
                                            style="background-image: url({{ $va->image ? asset('storage/'.$va->image) : 'https://ui-avatars.com/api/?name='.urlencode($va->nama).'&background=random&color=fff' }});">
                                        </div>
                                        <p class="text-sm text-center"><b>{{ $va->nama }}</b>, menunggu untuk verifikasi akun.</p>
                                    </li>                                    
                                    @endforeach
                                </ul>
                            @endif
                            <a href="{{ route('permohonan-verifikasi') }}" class="flex mt-2 mx-5 items-start border-2 border-dotted border-slate-300 rounded-xl p-2">
                                <h1 class="font-semibold mx-auto">Verifikasi Akun</h1>
                            </a>
                        </div>
                    </div>
                @endif
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
    </script>

    <script>
        const togglePass = document.getElementById('togglePass');
        const passInput = document.getElementById('pass');
        const eyeIcon = document.getElementById('eyeIcon');
    
        togglePass.addEventListener('click', function () {
            // Jika password sedang disembunyikan
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.setAttribute('name', 'eye'); // Ganti ikon
            } else {
                // Jika password sedang ditampilkan
                passInput.type = 'password';
                eyeIcon.setAttribute('name', 'eye-off'); // Ganti ikon
            }
        });
    </script>
</body>


</html>