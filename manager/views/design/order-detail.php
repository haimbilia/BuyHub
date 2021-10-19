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
                                            <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/no-data-cuate.svg"
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
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Head</h3>
                                        </div>

                                    </div>
                                    <div class="card-body">Body</div>
                                    <div class="card-foot">Foot</div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"><i class="fas fa-envelope"></i>
                                                Contact Information
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="list-text"><span class="lable">Email:</span>
                                            tribe@dummyid.com
                                        </p>
                                        <p class="list-text"><span class="lable">Phone:</span>
                                            +1 4804568915
                                        </p>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"><i class="fas fa-envelope"></i>
                                                Payment Details
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="payment-mode">
                                            <div class="cc-payment"><i class="icn"><strong>unionpay</strong></i> <span
                                                    class="cc-num">**** **** **** 0005</span></div>
                                            <div class="txt-id">
                                                <h6><strong>Transaction number</strong></h6>
                                                <span>ch_1Ib3rfL1bMNoOfFv4tf7HZkN</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"><i class="fas fa-shipping-fast"></i>
                                                Shipping Address
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="list-text"><span class="lable">Name:</span>
                                            John Doe
                                        </p>
                                        <p class="list-text"><span class="lable">Apartment / House:</span>
                                            University Drive
                                        </p>
                                        <!---->
                                        <p class="list-text"><span class="lable">City &amp; State:</span>
                                            Mumbai, Maharashtra
                                        </p>
                                        <p class="list-text"><span class="lable">Postal Code:</span>
                                            45684
                                        </p>
                                        <p class="list-text"><span class="lable">Select Country:</span>
                                            India
                                        </p>
                                        <p class="list-text"><span class="lable">Phone:</span>
                                            +91
                                            7895456525
                                        </p>
                                        <!---->
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"><i class="fas fa-file-invoice"></i>
                                                Billing Address
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <p class="list-text"><span class="lable">Name:</span>
                                            John Doe
                                        </p>
                                        <p class="list-text"><span class="lable">Apartment / House:</span>
                                            University Drive
                                        </p>
                                        <!---->
                                        <p class="list-text"><span class="lable">City &amp; State:</span>
                                            Mumbai, Maharashtra
                                        </p>
                                        <p class="list-text"><span class="lable">Postal Code:</span>
                                            45684
                                        </p>
                                        <p class="list-text"><span class="lable">Select Country:</span>
                                            India
                                        </p>
                                        <p class="list-text"><span class="lable">Phone:</span>
                                            +91
                                            7895456525
                                        </p>
                                        <!---->
                                    </div>

                                </div>

                            </div>






                        </div>

                    </div>
                </main>

                <?php
        include 'includes/footer.php';
        ?>


            </div>

        </div>

    </body>

</html>