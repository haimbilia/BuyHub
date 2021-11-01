<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="<?php echo CSS_PATH; ?>main-ltr.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head>

    <body class="fb-body">
        <div class="app">
            <?php
        include 'includes/sidebar.php';
        ?>

            <div class="wrap">
                <?php
            include 'includes/new-header.php';
            ?>

                <button class="help-btn btn btn-light" data-toggle="modal" data-target="#help">
                    <span class="help_label">Help</span>
                </button>

                <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-vertical" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="help-window">
                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg"
                                                alt="">
                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...</h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.</li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.</li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <main class="main">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mb-0 h-100">
                                    <div class="card-head flex-column">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Messages</h3>
                                        </div>
                                        <div class="message__search">
                                            <form action="" class="form">
                                                <div class="d-flex align-items-center">
                                                    <input type="search" placeholder="keyword">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle no-after p-2" data-toggle="dropdown"
                                                            href="">
                                                            <span class="icon">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-filters">
                                                                    </use>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <div
                                                            class="header-action__target p-3 dropdown-menu dropdown-menu-right dropdown-menu-anim">
                                                            <div class="form-group">
                                                                <label class="label">From</label>
                                                                <input type="text" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="label">Date From</label>
                                                                <input class="field--calender fld-date hasDatepicker"
                                                                    type="text" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="label">Date To</label>
                                                                <input class="field--calender fld-date hasDatepicker"
                                                                    type="text" value="">
                                                            </div>
                                                            <input class="btn btn-brand btn-block" type="submit"
                                                                value="Search">
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="message__list">
                                            <li class="message__list-item is-active">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="message__list-item">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="message__list-item">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="message__list-item">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="message__list-item">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="message__list-item">
                                                <div class="message-from">
                                                    <div class="message-media">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="">
                                                    </div>
                                                    <div class="message-data">
                                                        <h4 class="title">Michael Williams</h4>
                                                        <p>Thank you for the information 😊</p>
                                                    </div>
                                                </div>
                                                <div class="message-to">
                                                    <div class="message-media">
                                                        <div class="user user-sm user-circle">
                                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                                alt="image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-0 h-100">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <div class="card-head-title d-flex align-items-center">
                                                <div class="user user-md user-circle">
                                                    <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                        alt="image">
                                                </div>
                                                <div class="message-user__detail">
                                                    <h3>Michael Williams</h3>
                                                    <p><b>Subject</b>: Return Policy</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="messages">
                                            <div class="date">
                                                Today
                                            </div>
                                            <div class="message-wrap message-wrap--from">
                                                <div class="message-avtar">
                                                    <div class="user user-circle">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="image">
                                                    </div>
                                                </div>
                                                <div class="message-detail">
                                                    <div class="message">
                                                        I am looking to buy this product as a gift and I want to
                                                        understand what is the return policy?
                                                    </div>
                                                    <span class="time">11:41</span>
                                                </div>
                                            </div>
                                            <div class="message-wrap message-wrap--to">
                                                <div class="message-avtar">
                                                    <div class="user user-circle">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                            alt="image">
                                                    </div>
                                                </div>
                                                <div class="message-detail">
                                                    <div class="message">
                                                        Hey, Michael Williams!&nbsp;👋
                                                    </div>
                                                    <span class="time">11:41</span>
                                                </div>
                                            </div>
                                            <div class="message-wrap message-wrap--to">
                                                <div class="message-avtar">
                                                    <div class="user user-circle">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/100_1.jpg"
                                                            alt="image">
                                                    </div>
                                                </div>
                                                <div class="message-detail">
                                                    <div class="message">
                                                        We offer a 30 day no questions asked return policy. I hope this
                                                        helps
                                                    </div>
                                                    <span class="time">11:41</span>
                                                </div>
                                            </div>
                                            <div class="message-wrap message-wrap--from">
                                                <div class="message-avtar">
                                                    <div class="user user-circle">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="image">
                                                    </div>
                                                </div>
                                                <div class="message-detail">
                                                    <div class="message ">
                                                        Yes this surely does!
                                                    </div>
                                                    <span class="time">11:41</span>
                                                </div>
                                            </div>
                                            <div class="message-wrap message-wrap--from">
                                                <div class="message-avtar">
                                                    <div class="user user-circle">
                                                        <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                            alt="image">
                                                    </div>
                                                </div>
                                                <div class="message-detail">
                                                    <div class="message">
                                                        Thank you for the information 😊
                                                    </div>
                                                    <span class="time">11:41</span>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-0 h-100">
                                    <div class="card-body">
                                        <div class="message__user">
                                            <div class="user user-circle">
                                                <img src="<?php echo CONF_WEBROOT_URL; ?>images/users/300_21.jpg"
                                                    alt="image">
                                            </div>
                                            <h3 class="message__user-name">Michael Williams</h3>
                                            <ul class="list__group">
                                                <li class="list__group-item">
                                                    <div class="list__group-icon">
                                                        <svg class="svg">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-mail">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="list__group-title">
                                                        <h4>Michael@gmail.com</h4>
                                                    </div>
                                                </li>
                                                <li class="list__group-item">
                                                    <div class="list__group-icon">
                                                        <svg class="svg">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-phone">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="list__group-title">
                                                        <h4>+1 854-5454-865</h4>
                                                    </div>
                                                </li>
                                                <li class="list__group-item">
                                                    <div class="list__group-icon">
                                                        <svg class="svg">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-map">
                                                            </use>
                                                        </svg>
                                                    </div>
                                                    <div class="list__group-title">
                                                        <h4>Smith Apartment 1c 213 Street Boston, MS 142 USA</h4>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="card-foot">
                                        <a href="javascript:0" class="btn btn-block btn-danger btn-danger-light">
                                            Block User
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog"
                                aria-labelledby="edit" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-vertical" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Edit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="modal-body form form-edit">

                                            <div class="form-edit-body">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label required">Layout </label>
                                                            <div>
                                                                <select class="selectpicker">
                                                                    <option>
                                                                        PL 1</option>
                                                                    <option>CL2</option>
                                                                    <option>PL2</option>
                                                                </select>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">
                                                                <span class="required">Shop Name</span>
                                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-toggle="tooltip" title=""
                                                                    data-original-title="Specify a target priorty"
                                                                    aria-label="Specify a target priorty"
                                                                    aria-describedby="tooltip849482"></i>
                                                            </label>
                                                            <input data-field-caption="Shop Name"
                                                                 type="text"
                                                                name="shop_name" value="Jason's Store">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Shop City</label>

                                                            <input data-field-caption="Shop City"
                                                                 type="text"
                                                                name="shop_city" value="phoenix">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Contact Person</label>
                                                            <input data-field-caption="Contact Person"
                                                                 type="text"
                                                                name="shop_contact_person" value="Jason">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Description</label>

                                                            <textarea data-field-caption="Description"
                                                                
                                                                name="shop_description">Best range of products in the United States</textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-edit-foot">
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="reset"
                                                            class="btn btn-outline-brand">Cancel</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit"
                                                            class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </form>


                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                </main>

                <?php
            include 'includes/footer.php';
            ?>

                <link rel="stylesheet"
                    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


                <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js">
                </script>
                <script>
                $(document).ready(function() {
                    $('.selectpicker').selectpicker();
                });
                </script>


            </div>

        </div>

    </body>

</html>