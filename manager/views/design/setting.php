<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>
    <body class="fb-body">
        <div class="app">
            <?php include 'includes/sidebar.php';  ?>
            <div class="wrap">
                <header class="main-header header">
                    <div class="container-fluid">
                        <div class="main-header-inner">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="" class="">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">Account</li>
                                    <li class="breadcrumb-item">Settings</li>
                                </ul>
                            </div>
                            <div class="main-header-toolbar">
                                <div class="header-action">
                                    <div class="header-action__item">
                                        <a class="header-action__trigger" href="">
                                            <span class="icon">
                                                <svg width="24" height="24">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-search"></use>
                                                </svg> 
                                            </span>  
                                        </a>
                                        <div class="header-action__target"></div>
                                    </div>
                                    <div class="header-action__item">
                                        <a class="header-action__trigger" href="">
                                            <span class="icon">
                                                <svg width="24" height="24">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-grid"></use>
                                                </svg>                                                 
                                            </span>  
                                        </a>
                                        <div class="header-action__target"></div>
                                    </div>
                                    <div class="header-action__item dropdown header-account">
                                        <a class="header-action__trigger dropdown-toggle no-after" data-toggle="dropdown" href="">
                                            <span class="header-account__img">
                                                 <img aria-expanded="false" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg" alt="">
                                            </span>                                            
                                        </a>
                                        <div class="header-action__target p-0 dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                            <div class="header-account__avtar">
                                                <div class="profile">
                                                    <div class="profile__img">
                                                        <img alt="" src="<?php echo CONF_WEBROOT_URL;?>images/users/100_4.jpg">
                                                    </div>
                                                    <div class="profile__detail">
                                                        <h6>Hi, Michael Williams <h6>
                                                        <a href="#" class="">max@kt.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator m-0"></div>
                                            <nav class="nav nav--header-account">
                                                <a href="#">View Profile</a>
                                                <a href="#">Orders</a>
                                                <a href="#">Change password</a>
                                            </nav>
                                            <div class="separator m-0"></div>
                                            <nav class="nav nav--header-account">
                                                <a href="#" class="language-selector">
                                                    Language
                                                    <span class="selected-language">
                                                         English
                                                         <span><img src="<?php echo CONF_WEBROOT_URL;?>images/flags/009-australia.svg" alt=""></span>
                                                    </span>
                                                    <div class="languages">
                                                         <span onclick="">English</span>
                                                         <span onclick="">Arabic</span>
                                                    </div>
                                                </a>
                                                <a href="#">Account Setting</a>
                                                <a href="#">Sign out</a>
                                            </nav>

                                        </div>                                        
                                    </div>

                                </div>                               

                            </div>
                        </div>
                    </div>
                </header>
                <main class="main">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">  
                                <div class="setting-search">
                                    <form class="form">
                                        <div class="row justify-content-center">
                                            <div class="col-md-12">
                                                 <input type="search" class="form-control" name="search" value="" placeholder="Search">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="settings">
                                    <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                     <a class="setting" href="#">
                                         <div class="setting__icon">
                                             <span class="icon">
                                                <svg class="icon" width="40" height="40">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-setting-1"></use>
                                                </svg>   
                                             </span>
                                         </div>
                                         <div class="setting__detail">
                                             <h6>System</h6>
                                             <span>Display, Sound, notifications, power</span>
                                         </div>
                                     </a><!--setting-->
                                    
                                  
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include 'includes/footer.php';  ?>
            </div>
        </div>
    </body>
</html>