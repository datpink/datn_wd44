<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('admin.layouts.css')
    <style>
        html,
        body {
            overflow-x: hidden;
            overflow-y: hidden;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="page-wrapper">
        <div class="main-container">
            @include('admin.layouts.load')

            @include('admin.layouts.header')

            @include('admin.layouts.menu')

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="alert">
                        <h4>@yield('title-page')</h4>
                    </div>
                </section>

                <div class="container">
                    @yield('content')
                </div>
            </div>

            @include('admin.layouts.footer')

        </div>

        @include('admin.layouts.js')

        @yield('custom-js')
        @yield('scripts')
    </div>
</body>

</html>
