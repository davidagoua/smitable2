
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SMIT | Hospital Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="assets/js/head.js"></script>

</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card bg-pattern">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <h3>SMIT</h3>
                                <h3>&nbsp;</h3>
                                <h3>&nbsp;</h3>
                            </div>
                        </div>
                        @if(session()->get('error'))

                        <div class=" rounded bg-danger mb-3 text-white p-2 text-center">
                            {{ session()->get('error')  }}
                        </div>
                        @endif
                        <form action="{{ route('login') }}" method="post">
                            @csrf()
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Adresse Email</label>
                                <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Enter your email">
                                @error('email')<small class="text-red">{{ $message }}</small>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group input-group-merge">
                                    <input name="password" type="password" id="password" class="form-control" placeholder="Enter your password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                @error('password')<small class="text-red">{{ $message }}</small>@enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Se souvenir de moi</label>
                                </div>
                            </div>

                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit">Se connecter</button>
                            </div>

                        </form>



                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="auth-recoverpw.html" class="text-white-50 ms-1">Mot de passe oublié ?</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<!-- Vendor js -->
<script src="/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="/assets/js/app.min.js"></script>

</body>
</html>
