<!DOCTYPE html>
<html lang="en">
@include('main.layouts.head')

<body>
    <div class="main-wrapper">
        @include('main.layouts.header')
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    @include('main.layouts.js')
</body>

</html>