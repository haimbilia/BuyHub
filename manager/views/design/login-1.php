<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body>
    <div id="particles-js"></div>
    <div class="login-page login-1">
        <div class="container">
            <div class="login-block">
                <div class="logo">
                    <a href="index.php">
                        <img title="Yo!Kart" src="<?php echo CONF_WEBROOT_URL; ?>images/logos/logo-coloured.png" alt="Yo!Kart">
                    </a>
                </div>
                <div class="card">
                    <div class="card-head">
                        <div class="title">
                            <h2>Sign in to your account</h2>
                            <p class="text-muted">Lorem, ipsum dolor sit amet consectetur adipisicing elit. </p>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="form form-login">
                            <div class="form-group">
                                <label class="label">Username</label>
                                <input class="form-control" title="Username" placeholder="" type="text" value="">

                            </div>
                            <div class="form-group">
                                <label class="label">Password</label>
                                <input class="form-control" title="Password" placeholder="" type="password" value="">
                            </div>
                            <div class="form-group">
                                <label class="switch switch-sm remember-me">
                                    <input type="checkbox" name="">
                                    <span class="input-helper"></span>Stay signed in for a week</label>
                            </div>

                            <div class="form-group">
                                <button disabled class="btn btn-brand btn-lg btn-block not-allowed" type="submit">Login</button>
                            </div>

                        </form>
                    </div>
                    <div class="card-foot">
                        <ul class="other-links">
                            <li><a href="#" class="">Forgot Password?</a></li>

                        </ul>
                    </div>
                </div>
                <p class="version">Admin version 2021</p>
            </div>

        </div>
        <script src="js/vendors/particles.min.js"></script>
        <script src="js/vendors/script.js"></script>
</body>

</html>