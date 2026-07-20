<!DOCTYPE html><html lang="zxx" class="js">
<!-- Mirrored from dashlite.net/demo2/pages/auths/auth-login-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 14 Dec 2022 09:00:51 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head> <meta charset="utf-8">
    <meta name="author" content="Softnio"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <link rel="shortcut icon" href="{{ asset('template_admin') }}/images/favicon.png">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('template_admin') }}/assets/css/dashliteb12b.css?ver=3.1.1">
    <link id="skin-default" rel="stylesheet" href="{{ asset('template_admin') }}/assets/css/themeb12b.css?ver=3.1.1">
</head>
<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content " style="background-image: url({{ asset('assets/images/login.jpg')  }}); background-size: cover;">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="#" class="logo-link">
                                <h5 style="color: white;">SISTEM INFORMASI LAYANAN PENGADUAN SERVER MENGGUNAKAN ALGORITMA FIRST COME FIRST SERVE </h5>
                            </a>
                            <br>
                            @include('layouts.partials.notification')
                        </div>
                        <div class="card" style="border: 1px solid !important;">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Register</h4>
                                        <div class="nk-block-des">
                                            <p>Masukan Data anda untuk melanjutkan.</p>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ URL::to('do-register') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Nama Lengkap</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" name="nama" id="default-01" placeholder="Input nama lengkap">
                                        </div>
                                    </div><div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg" name="email" id="default-01" placeholder="Input email">
                                        </div>
                                    </div><div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">No Telephone</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control form-control-lg" name="no_telp" id="default-01" placeholder="Input no_telp">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Username</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" name="username" id="default-01" placeholder="Input username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Passcode</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Input passcode">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Register</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4">Do you have account ?
                                    <a href="{{ URL::to('login') }}">Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('template_admin') }}/assets/js/bundleb12b.js?ver=3.1.1"></script>
    <script src="{{ asset('template_admin') }}/assets/js/scriptsb12b.js?ver=3.1.1"></script>
    <script src="{{ asset('template_admin') }}/assets/js/demo-settingsb12b.js?ver=3.1.1"></script>
</body>
<!-- Mirrored from dashlite.net/demo2/pages/auths/auth-login-v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 14 Dec 2022 09:00:51 GMT -->
</html>