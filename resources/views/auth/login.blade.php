
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | GeoLog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <main class="w-full max-w-md">

        <div class="p-8 w-full flex flex-col justify-center items-center">
            <span
                aria-hidden="true"
                class="h-20 w-60 bg-main"
                style="mask: url('{{ asset('images/logo.png') }}') left center / contain no-repeat;"
            ></span>
        </div>

        <div class="bg-white rounded-xl border border-gray-300 p-8">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex flex-col gap-4">
                    <x-form.input
                        name="email"
                        label="メールアドレス"
                        type="email"
                    />
                    <x-form.input
                        name="password"
                        label="パスワード"
                        type="password"
                    />
                    <x-form.button>
                        ログイン
                    </x-form.button>
                </div>
            </form>
        </div>

        <p class="p-8 text-center text-xs text-gray-600">
            © 2026 GeoLog ver1.0
        </p>
        
    </main>

</body>
</html>