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
                                    <div
                                        class="card-head ribbon ribbon--brand ribbon--shadow ribbon--left ribbon--round">
                                        <div class="ribbon__target" style="top: 15px; right: -2px;"><span><i
                                                    class="far fa-credit-card"></i> Paid Via Stripe </span></div>
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                <a class="back" href="">
                                                    <svg class="svg" width="24" height="24">
                                                        <use
                                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                                        </use>
                                                    </svg>
                                                </a>
                                                Order no. #10039

                                            </h3>

                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-wrap">
                                            <table class="table table-orders">
                                                <thead>
                                                    <tr>
                                                        <th>Items Summary</th>
                                                        <th>Store</th>
                                                        <th>Selling Price</th>
                                                        <th class="align-right">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail">
                                                                    <img
                                                                        src="<?php echo CONF_WEBROOT_URL;?>images/products/product1.jpg" />


                                                                </div>
                                                                <div class="product-profile__data">
                                                                    <div class="title">Gabby Smocked Floral-Print Mini
                                                                        Dress
                                                                    </div>
                                                                    <div class="sub_title">
                                                                        Printed Men Round or Crew Blue T-Shirt </div>
                                                                    <div class="brand">
                                                                        Brand:
                                                                        Pepe Jeans </div>

                                                                    <div class="options"> Qty: 1 </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> Akshay's E-Store
                                                            </div>
                                                        </td>
                                                        <td><span class="currency-value" dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                        <td class="align-right"><span class="currency-value"
                                                                dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail">
                                                                    <img
                                                                        src="<?php echo CONF_WEBROOT_URL;?>images/products/product2.jpg" />


                                                                </div>
                                                                <div class="product-profile__data">
                                                                    <div class="title">
                                                                        Printed Men Round or Crew Blue T-Shirt
                                                                    </div>
                                                                    <div class="sub_title">
                                                                        Printed Men Round or Crew Blue T-Shirt </div>
                                                                    <div class="brand">
                                                                        Brand:
                                                                        Pepe Jeans </div>

                                                                    <div class="options"> Qty: 1 </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> Kanwar's Shop
                                                            </div>
                                                        </td>
                                                        <td><span class="currency-value" dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                        <td class="align-right"><span class="currency-value"
                                                                dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail">
                                                                    <img
                                                                        src="<?php echo CONF_WEBROOT_URL;?>images/products/product3.jpg" />


                                                                </div>
                                                                <div class="product-profile__data">
                                                                    <div class="title">

                                                                        Candle Ankle Formal Shoes (Size 10)
                                                                    </div>
                                                                    <div class="sub_title">
                                                                        Printed Men Round or Crew Blue T-Shirt </div>
                                                                    <div class="brand">
                                                                        Brand:
                                                                        Pepe Jeans </div>

                                                                    <div class="options"> Qty: 1 </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> James Garments Store
                                                            </div>
                                                        </td>
                                                        <td><span class="currency-value" dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                        <td class="align-right"><span class="currency-value"
                                                                dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>




                                    </div>

                                </div>

                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Timeline</h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <form class="form form-fly">

                                            <input type="text" placeholder="Email addresses" class="fly-field">
                                            <button type="button" class="fly-btn"><svg class="svg">
                                                    <use
                                                        xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fly-btn">
                                                    </use>
                                                </svg></button>
                                        </form>

                                        <div class="timelines-wrap">
                                            <ul class="timeline">
                                                <li class="enable currently in-process">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <time class="timeline_date">29/12/2020</time>
                                                            <span class="order-status"> <em class="dot"></em>
                                                                Payment Pending </span>
                                                        </div>

                                                        <div class="timeline_data_body">
                                                            <p> Order Payment Has Not Been Confirmed Yet.</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="disabled  in-process">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <span class="order-status"> <em class="dot"></em>
                                                                Payment Confirmed </span>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="disabled  ready-for-shipping">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <span class="order-status"> <em class="dot"></em>
                                                                In Process </span>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="disabled  shipped">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <span class="order-status"> <em class="dot"></em>
                                                                Shipped </span>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="disabled  delivered">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <span class="order-status"> <em class="dot"></em>
                                                                Delivered </span>
                                                        </div>

                                                    </div>
                                                </li>
                                                <li class="disabled  delivered">
                                                    <div class="timeline_data">
                                                        <div class="timeline_data_head">
                                                            <span class="order-status"> <em class="dot"></em>
                                                                Completed </span>
                                                        </div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"><i class="fas fa-file"></i> Order Summary
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="cart-summary">
                                            <ul>
                                                <li>
                                                    <span class="label">Order Created </span>
                                                    <span class="value">29/12/2020</span>
                                                </li>
                                                <li>
                                                    <span class="label">
                                                        Shipping Charges </span>
                                                    <span class="value">
                                                        <span class="currency-value" dir="ltr"><span
                                                                class="currency-symbol">$</span>50.00</span> </span>
                                                </li>

                                                <li>
                                                    <span class="label">
                                                        Tax Charges </span>
                                                    <span class="value"><span class="currency-value" dir="ltr"><span
                                                                class="currency-symbol">$</span>0.00</span></span>
                                                </li>
                                                <li>
                                                    <span class="label">Cart Total</span>
                                                    <span class="value"><span class="currency-value" dir="ltr"><span
                                                                class="currency-symbol">$</span>87.00</span></span>
                                                </li>
                                                <li class="text-success">
                                                    <span class="label">Volume/loyalty Discount</span>
                                                    <span class="value"><span class="currency-value" dir="ltr"><span
                                                                class="currency-symbol">$</span>50.00</span></span>
                                                </li>

                                                <li class="highlighted">
                                                    <span class="label">Net Amount</span>
                                                    <span class="value">
                                                        <span class="currency-value" dir="ltr"><span
                                                                class="currency-symbol">$</span>137.00</span> </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
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

                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom collapsed" data-toggle="collapse"
                                        data-target="#order-block2" aria-expanded="false" aria-controls="order-block2">

                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Payment Details
                                            </h3>
                                        </div>
                                        <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body collapse" id="order-block2">
                                        <div class="payment-mode">
                                            <div class="payment-cc">
                                                <i class="fas fa-credit-card"></i>
                                                <span class="payment-cc-num">**** **** **** 0005</span>
                                            </div>
                                            <div class="payment-id">
                                                <h6>Transaction number </h6>
                                                <span>ch_1Ib3rfL1bMNoOfFv4tf7HZkN</span>
                                            </div>
                                        </div>
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