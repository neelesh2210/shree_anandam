<!DOCTYPE html>
<html>

<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{config('app.name')}} @isset($page_title) | {{$page_title}} @endisset</title>
        <link rel="icon" type="image/png" href="{{asset('backend/assets/image/favicon.png')}}" sizes="16x16">

        @include('admin.layouts.css')

    </head>

    <body @guest('admin') class="gray-bg" @endguest>
        @auth('admin')
            <div id="wrapper">

                @include('admin.layouts.sidebar')

                <div id="page-wrapper" class="gray-bg">

                    @include('admin.layouts.nav')

                        @yield('content')

                    @include('admin.layouts.footer')

                </div>
            </div>
        @endauth
        @guest('admin')
            @yield('content')
        @endguest

        @include('admin.layouts.js')
    </body>

</html>
