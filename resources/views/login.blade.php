<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page | Pinjam</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white">
    <div
        class="container w-fit flex justify-between relative my-auto md:top-28 m-auto bg-white rounded-2xl flex-col md:flex-row">
        <div class="font-poppins w-fit text-primary2 m-auto md:m-0 p-5 md:py-10 md:pr-10">
            <div class="w-60 m-auto overflow-hidden">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-full">
            </div>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col md:w-80 gap-3 mt-8 tracking-wide">
                @csrf
                @if ($errors->any())
                    <div>{{ $errors->first() }}</div>
                @endif
                <div class="flex flex-col gap-1">
                    <p class="font-semibold relative">NIP</p>
                    <input type="text" name="nip" placeholder="NIP"
                        class="border-2 shadow-sm px-2 py-1 w-full rounded-md text-sm bg-slate-100" required>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-semibold">Kata Sandi</p>
                    <input type="password" name="password" placeholder="Kata Sandi"
                        class="border-2 border-slate-200 px-2 py-1 w-full rounded-md shadow-sm text-sm bg-slate-100" required>
                </div>
            
                <a href="#" class="text-blue-700 text-sm font-semibold text-right mt-1">Lupa kata sandi?</a>
            
                <button type="submit"
                    class="bg-primary2 mt-4 rounded-md font-bold p-2 text-center text-white hover:opacity-80">
                    Masuk
                </button>
            
                <p class="text-slate-700 text-center text-sm mt-3">
                    Ada kendala dalam proses login? hubungi kami <b>@politekniknegeribatam</b>
                </p>
            </form>
        </div>

    </div>


</body>

</html>