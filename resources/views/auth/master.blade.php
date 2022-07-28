<!DOCTYPE html>
<html lang="en">

<head>
    @include('auth.blocks.head')
</head>

<body>
    <div id="auth">   
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                @yield('content')
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>

    @yield('foot')
    
</body>

</html>
