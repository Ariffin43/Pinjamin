<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PINJAM - Aplikasi peminjaman kendaraan dinas</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script>
        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }
    </script>
</head>

<body class="font-poppins px-5 mb-20">

    <div class="max-w-7xl m-auto">
        <!-- Navbar -->
        <nav class="flex justify-between py-4 items-center">
            <div class="w-32 sm:w-52">
                <img src="assets/logo.png" alt="Logo" class="w-full">
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden" onclick="toggleMenu()">
                <ion-icon name="menu" class="text-3xl"></ion-icon>
            </button>

            <ul class="hidden md:flex items-center gap-5 font-semibold">
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Case Study</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact</a></li>
                <a href="/login"
                    class="px-7 py-2 rounded-xl border-2 border-primary2 hover:bg-primary2 hover:text-white">Sign In</a>
            </ul>
        </nav>

        <!-- Mobile Menu -->
        <ul id="mobile-menu"
            class="hidden flex flex-col gap-3 font-semibold mt-3 bg-white shadow-md p-5 rounded-lg md:hidden">
            <li><a href="#">Home</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Case Study</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Contact</a></li>
            <a href="login/index.html"
                class="px-7 py-2 rounded-xl border-2 border-primary2 text-center hover:bg-primary2 hover:text-white">Sign
                In</a>
        </ul>

        <!-- Hero Section -->
        <div class="flex flex-col-reverse md:flex-row gap-8 md:gap-0 justify-between mt-28">
            <div class="flex flex-col gap-5 md:w-2/5 w-full">
                <h1 class="text-xl font-semibold">Butuh kendaraan dinas? Semua menjadi mudah di Pinjam.</h1>
                <p>Pinjam merupakan aplikasi berbasis web yang memiliki visi memudahkan karyawan Politeknik Negeri
                    Batam.</p>
                <a href="login/registrasi.html"
                    class="px-6 py-2 rounded-x w-fit border-2 border-primary2 font-semibold text-white bg-primary2 hover:bg-white hover:text-primary2">Move
                    with us</a>
            </div>

            <div class="flex w-52 m-auto md:m-0 md:w-max">
                <img src="assets/snap.png" alt="Inpokan Free Vector" class="mx-auto md:w-1/2">
            </div>
        </div>

        <!-- Services Section -->
        <div class="flex flex-col sm:flex-row justify-between w-full md:w-3/5 gap-5 mt-32">
            <h1 class="font-semibold bg-primary1 px-2 py-1 h-fit text-2xl w-fit">Services</h1>
            <p class="text-sm text-slate-500 flex items-center">Website ini mempermudah
                pengelolaan peminjaman, pengembalian, dan pemeliharaan kendaraan. Dengan fitur
                ketersediaan real-time.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 mt-10">
            <div class="flex flex-row justify-between border-4 rounded-xl p-8 gap-4 border-primary2">
                <div class="flex flex-col justify-between gap-5 w-2/3 sm:w-auto">
                    <h1 class="bg-primary1 text-lg font-bold p-1 rounded-sm">Pinjam Cepat: Pinjam kendaraan dengan satu
                        ketikan.</h1>
                    <a href="#" class="py-1 flex gap-2 items-center space-x-1">
                        <ion-icon name="arrow-dropright-circle" class="text-4xl md:text-4xl text-primary2"></ion-icon>
                        <span class="font-semibold text-lg">Learn More</span>
                    </a>
                </div>
                <img src="assets/pinjam-cepat.png" alt="Pinjam Cepat" class="w-16 sm:w-48 h-fit my-auto sm:m-0">
            </div>

            <div
                class="flex sm:flex-row justify-between border-4 rounded-xl p-8 gap-4 border-primary2 bg-primary2 text-white">
                <div class="flex flex-col justify-between gap-5 w-2/3 sm:w-auto">
                    <h1 class="bg-white text-lg text-black font-bold p-1 rounded-sm">Jadwal Pasti: Jadwal Peminjaman
                        terstruktur dan sistematis.</h1>
                    <a href="#" class="py-1 flex gap-2 items-center space-x-1">
                        <ion-icon name="arrow-dropright-circle" class="text-4xl text-white"></ion-icon>
                        <span class="font-semibold text-lg">Learn More</span>
                    </a>
                </div>
                <img src="assets/jadwal-pasti.png" alt="Jadwal Pasti" class="w-16 sm:w-48 h-fit my-auto sm:m-0">
            </div>

            <div
                class="flex sm:flex-row justify-between border-4 rounded-xl p-8 gap-4 border-primary2 bg-primary2 text-white">
                <div class="flex flex-col justify-between gap-5 w-2/3 sm:w-auto">
                    <h1 class="bg-white text-lg text-black font-bold p-1 rounded-sm">Keamanan Terjaga: Keamanan data
                        anda prioritas utama kami.</h1>
                    <a href="#" class="py-1 flex gap-2 items-center space-x-1">
                        <ion-icon name="arrow-dropright-circle" class="text-4xl text-white"></ion-icon>
                        <span class="font-semibold text-lg">Learn More</span>
                    </a>
                </div>
                <img src="assets/secure-data.png" alt="Keamanan Terjaga" class="w-16 sm:w-48 h-fit my-auto sm:m-0">
            </div>

            <div class="flex sm:flex-row justify-between border-4 rounded-xl p-8 gap-4 border-primary2">
                <div class="flex flex-col justify-between gap-5 w-2/3 sm:w-auto">
                    <h1 class="bg-primary1 text-lg font-bold p-1 rounded-sm">Perawatan Kendaraan: Pengecekan Rutin
                        Merupakan SOP kami.</h1>
                    <a href="#" class="py-1 flex gap-2 items-center space-x-1">
                        <ion-icon name="arrow-dropright-circle" class="text-4xl text-primary2"></ion-icon>
                        <span class="font-semibold text-lg">Learn More</span>
                    </a>
                </div>
                <img src="assets/car-services.png" alt="Perawatan Kendaraan"
                    class="w-16 sm:w-48 h-fit flex my-auto sm:m-0">
            </div>
        </div>

        <div class="flex flex-col-reverse gap-2 md:flex-row justify-between items-center mt-20 px-6 md:px-12 py-14 bg-slate-100 rounded-2xl"
            id="about-us">
            <div class="flex flex-col gap-6 text-center md:text-left my-auto w-full md:w-2/3">
                <h1 class="text-3xl font-bold">About us</h1>
                <p> Platform ini dirancang untuk <b>mempermudah pengelolaan peminjaman kendaraan dinas secara
                    efisien dan terstruktur</b>. Dengan sistem yang terintegrasi, kami menyediakan fitur pemantauan
                    real-time, pencatatan riwayat peminjaman, serta pengelolaan jadwal servis dan perawatan kendaraan.</p>
                    <p>
                        <b>Tujuan kami</b> adalah membantu instansi dalam meningkatkan transparansi, efisiensi administrasi, serta
                        memastikan setiap kendaraan selalu dalam kondisi optimal dan siap digunakan. Dengan teknologi yang
                        terus berkembang, <b>kami berkomitmen</b> untuk menghadirkan solusi terbaik dalam pengelolaan aset
                        kendaraan dinas agar lebih mudah, cepat, dan akurat.
                    </p>
            </div>

            <div class="flex w-full md:w-52 justify-center">
                <img src="assets/about.png" alt="" class="w-40 md:w-52 max-w-full">
            </div>
        </div>

        <!-- Services Section -->
        <div class="flex flex-col sm:flex-row justify-between w-full md:w-3/5 gap-5 mt-20">
            <h1 class="font-semibold bg-primary1 px-2 py-1 h-fit text-2xl w-fit whitespace-nowrap">Case Study</h1>
            <p class="text-sm text-slate-500 flex items-center">Lorem ipsum Lorem ipsum dolor sit amet consectetur
                adipisicing elit. Alias, dolores!dolor sit amet consectetur adipisicing elit. Maxime dolore non unde.
            </p>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 bg-primary2 text-white p-8 md:p-16 gap-5 mt-10 rounded-3xl">
            <div
                class="flex flex-col gap-2 px-5 py-5 md:py-0 border-b border-white md:border-b-0 md:border-r md:border-white">
                    <h1 class=" text-lg text-primary1">Bagaimana cara mengajukan peminjaman kendaraan?</h1>

                <p>Pengguna dapat mengajukan peminjaman kendaraan dengan masuk ke aplikasi, mengisi formulir peminjaman, dan mengajukan permohonan. Setelah itu, admin akan memverifikasi dan menyetujui atau menolak permohonan.</p>
            </div>
            <div
                class="flex flex-col gap-2 px-5 py-5 md:py-0 border-b border-white md:border-b-0 md:border-r md:border-white">
                    <h1 class=" text-lg text-primary1">Bagaimana cara mengecek ketersediaan kendaraan?</h1>

                <p>Pengguna dapat melihat daftar kendaraan yang tersedia langsung di dashboard aplikasi. Pada tabel Timeline, kendaraan yang .</p>
            </div>
            <div
                class="flex flex-col gap-2 px-5 py-5 md:py-0 border-white md:border-b-0">
                    <h1 class=" text-lg text-primary1">Bagaimana jika ada keterlambatan dalam pengembalian kendaraan?</h1>

                <p>Jika terjadi keterlambatan, sistem akan secara otomatis menghubungi nomor Whatsapp peminjam. Keterlambatan tanpa konfirmasi bisa dikenakan sanksi sesuai kebijakan instansi.</p>
            </div>
        </div>

    </div>

</body>

</html>