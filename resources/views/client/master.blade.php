<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    @include('client.layouts.css')

    <title>@yield('title')</title>
</head>

<body>
    <header id="header" class="header style-04 header-dark">
        <div class="header-top">
            <div class="container">

                <!-- top -->
                @include('client.layouts.top')

            </div>
        </div>
        <div class="header-middle">
            <div class="container">

                <!-- menu1 -->
                @include('client.layouts.menu1')

            </div>
        </div>
        <div class="header-wrap-stick">

            <!-- menu main -->
           @include('client.layouts.menumain')

        </div>

        <div class="header-mobile">
            @include('client.layouts.mobile')
        </div>
    </header>

    @yield('content')

    <footer id="footer" class="footer style-01">

        <!-- footer -->
        @include('client.layouts.footer')

    </footer>
    <div class="footer-device-mobile">

        <!-- footer mobile -->
        @include('client.layouts.footermobile')

    </div>

    <!-- Quay Lại Trang Đầu  -->
    @include('client.layouts.plass')

    <!-- Js -->
    @include('client.layouts.js')

</body>

</html>