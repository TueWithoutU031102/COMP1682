<!DOCTYPE html>
<html data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tếtnolo-Z</title>

    @stack('header')

    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.2/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false
            },
            theme: {
                extend: {
                    color: {
                        primary: '#006699'
                    }
                }
            }
        }
    </script>

    <script>
        function toggleTheme() {
            const html = document.querySelector('html');
            const currentTheme = html.getAttribute('data-theme');
            const targetTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', targetTheme);
        }
    </script>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <img src="/images/Menubar.png" alt="">
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('customer.index') }}">Trang chủ</a></li>
                    <li><a href="{{ route('customer.menu.index') }}">Menu</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <a class="btn btn-ghost normal-case text-xl"></a>
        </div>
        <div class="navbar-end">
            <button class="btn btn-ghost btn-circle lg:hidden">
                <label for="navbar" class="indicator">
                    <img src="/images/Bag.png" alt=""></a>
                    @if ($bill && count($bill) > 0)
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                    @endif
                </label>
            </button>
        </div>
    </div>

    <div class="drawer drawer-end lg:drawer-open">
        <input id="navbar" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col bg-stone-50">
            <!-- Page content here -->
            @yield('content')
        </div>
        <div class="drawer-side z-20" id='cart-data'>
            <label for="navbar" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="flex flex-col justify-between p-2 w-80 bg-base-200">
                <div class="flex flex-col space-y-2">
                    @if ($bill)
                    @php $total = 0 @endphp
                    @foreach ($bill as $b)
                    <div class="rounded flex space-x-2 bg-white p-2 cart-detail">
                        <div class="cart-detail-img">
                            <img class="aspect-square w-12 h-12 rounded" src="{{ asset($b->menu->image) }}" alt="">
                        </div>
                        <div>
                            <p>
                                {{ $b['quantity'] }} X
                                {{ $b->menu->name }}
                                @if ($b['status'] !== 'Completed')
                                <span class="text-sm opacity-50">({{ $b['status'] }})</span>
                                @endif
                            </p>
                            @php
                            $price = $b->menu->price * $b['quantity'];
                            @endphp
                            <span class="text-red-500 price">{{ number_format($price) }} đ</span>
                            @php $total += $price @endphp
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

                <div>
                    <hr class="border-t h-1 border-black border-dashed w-full my-2">
                    <div class="flex justify-between">
                        <span>Total price:</span>
                        <span> {{ number_format($total) }}đ</span>
                    </div>
                    @php
                    $allCompleted = true;
                    @endphp

                    @if ($bill && count($bill) > 0)
                    @foreach ($bill as $b)
                    @if ($b['status'] !== 'Completed')
                    @php
                    $allCompleted = false;
                    @endphp
                    @endif
                    @endforeach
                    @if ($allCompleted)
                    <a href="{{ route('customer.checkout.show') }}">
                        <button type="submit" class="btn btn-info w-full mt-2 bg-[rgba(202,1,71,1)] text-white">Thanh
                            toán</button>
                    </a>
                    @endif
                    @endif

                    {{-- <div class="lg:mt-5 w-full text-center">
                        <label class="swap swap-flip opacity-40">

                            this hidden checkbox controls the state
                            <input type="checkbox" class="hidden" />
                            <div class="swap-off"><span class="text-4xl">😀</span></div>
                            <div class="swap-on"><span class="text-4xl">🤡</span></div>
                        </label>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        async function updateEvent() {
            let url = "/customers/cart-data";
            let response = await fetch(url);
            let text = await response.text();
            let element = window.document.querySelector('#cart-data');
            element.innerHTML = text;
        }
        setInterval(updateEvent, 1500);
    </script>

    <!-- <div class="bg-white rounded-t-xl">
        <footer class="container p-5 flex justify-between">
            <aside class="">
                <p class="mt-5">Wibu Coffee<br />Product of Vu Nguyen Duc Tue</p>
            </aside>

            <nav class="grid grid-cols-1">
                <strong>Social</strong>

                <div class="grid grid-flow-col gap-4">
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                            </path>
                        </svg></a>
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                            </path>
                        </svg></a>
                    <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            class="fill-current">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                            </path>
                        </svg></a>
                </div>
            </nav>
        </footer>
    </div> -->

    @stack('scripts')
</body>

</html>