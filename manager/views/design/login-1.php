<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body>
        <div id="particles-js"></div>
        <div class="login-page login-1">
            <div class="container">
                <div class="row align-item-center justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-head">
                                <div class="logo text-center p-4 mx-auto">
                                    <a href="index.php">
                                        <img title="Yo!Kart"
                                            src="<?php echo CONF_WEBROOT_URL;?>images/logos/logo-coloured.png"
                                            alt="Yo!Kart">
                                    </a>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="title">
                                    <h2>Sign In to Yokart</h2>
                                </div>
                                <form class="form">
                                    <div class="form-group"><input class="form-control" title="Username"
                                            placeholder="Username" type="text" value="">
                                        <input class="form-control" title="Password" placeholder="Password"
                                            type="password" value="">
                                    </div>
                                    <div class="row py-3">
                                        <div class="col-12">
                                            <label class="switch switch--sm remember-me">
                                                <input type="checkbox" name="">
                                                <span></span>Remember Me </label>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button disabled class="btn btn-brand btn-lg btn-block not-allowed"
                                                type="button">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-foot">
                                <ul class="other-links">
                                    <li><a href="#" class="">Forgot Password?</a></li>

                                </ul>
                            </div>
                        </div>
                        <p class="version">Admin version 2019</p>
                    </div>
                </div>
            </div>
            <script src="js/vendors/particles.min.js"></script>
            <script src="js/vendors/script.js"></script>
    </body>

</html>