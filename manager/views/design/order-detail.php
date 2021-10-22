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
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-head">
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

                                        <div class="card-toolbar">
                                            <select class="form-select" name="" id="">
                                                <option value="All">All</option>
                                                <option value="Seller1">Seller1</option>
                                                <option value="Seller1">Seller1</option>
                                                <option value="Seller1">Seller1</option>
                                                <option value="Seller1">Seller1</option>
                                                <option value="Seller1">Seller1</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-wrap">
                                            <table class="table table-orders">
                                                <thead>
                                                    <tr>
                                                        <th width="50%">Items Summary</th>
                                                        <th>Qty</th>
                                                        <th>Store</th>
                                                        <th>Status</th>
                                                        <th class="align-right">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail"
                                                                    data-ratio="1:1">
                                                                    <img data-aspect-ratio="1:1"
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


                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>02</td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> Akshay's E-Store
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <span class="badge badge-info">Processing</span>
                                                        </td>
                                                        <td class="align-right"><span class="currency-value"
                                                                dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail"
                                                                    data-ratio="1:1">
                                                                    <img data-aspect-ratio="1:1"
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


                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>01</td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> Kanwar's Shop
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-warning">Shipped</span>

                                                        </td>
                                                        <td class="align-right"><span class="currency-value"
                                                                dir="ltr"><span
                                                                    class="currency-symbol">$</span>20.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="product-profile">
                                                                <div class="product-profile__thumbnail"
                                                                    data-ratio="1:1">
                                                                    <img data-aspect-ratio="1:1"
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


                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>03</td>
                                                        <td>
                                                            <div class="sold_by">
                                                                <svg class="svg" width="20" height="20">
                                                                    <use
                                                                        xlink:href="<?php echo CONF_WEBROOT_URL;?>images/retina/sprite.yokart.svg#icon-store">
                                                                    </use>
                                                                </svg> James Garments Store
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Delivered</span>

                                                        </td>
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
                                            <h3 class="card-head-title">Order Payment History </h3>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <form class="form" action="">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Comments</label>
                                                        <textarea> </textarea>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="label">Payment
                                                            Method</label>
                                                        <input class="form-control" type="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="label">Transaction id</label>
                                                        <input class="form-control" type="text" value="">
                                                    </div>



                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="label">Amount</label>
                                                        <input class="form-control" type="text" value="">
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <button type="reset" class="btn btn-outline-brand">Cancel</button>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-brand">Save Changes</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="separator separator-dashed my-5"></div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Added On </th>
                                                    <th width="10%">Transaction id </th>
                                                    <th width="15%">Payment Method </th>
                                                    <th width="10%">Amount </th>
                                                    <th width="15%">Comments </th>
                                                    <th width="25%">Gateway Response </th>
                                                    <th width="15%">Status </th>
                                                    <th width="15%">Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>21/10/2021 </td>
                                                    <td>1245787/87/ </td>
                                                    <td>Kotak </td>
                                                    <td>$150.00 </td>
                                                    <td>
                                                        <div class="break-me">Order Payments<br>
                                                            entry </div>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>

                                                        <span class="badge badge-success">Approved</span>

                                                    </td>
                                                    <td>
                                                        n/a </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <!-- <div class="card">
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

                                </div> -->

                            </div>
                            <div class="col-md-3">

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
                                        <ul class="list-text">
                                            <li class="">
                                                <span class="lable">Email:</span>
                                                <span class="value">tribe@dummyid.com</span>
                                            </li>
                                            <li><span class="lable">Phone:</span>
                                                <span class="value"> +1 4804568915</span>
                                            </li>
                                        </ul>
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
                                        <ul class="list-text">
                                            <li>
                                                <span class="lable">Name:</span>
                                                <span class="value"> John Doe</span>
                                            </li>
                                            <li><span class="lable">Apartment / House:</span>
                                                <span class="value"> University Drive</span>
                                            </li>

                                            <li><span class="lable">City &amp; State:</span>
                                                <span class="value"> Mumbai, Maharashtra</span>
                                            </li>
                                            <li><span class="lable">Postal Code:</span>
                                                <span class="value"> 45684 </span>
                                            </li>
                                            <li><span class="lable">Select Country:</span>
                                                <span class="value"> India</span>
                                            </li>
                                            <li><span class="lable">Phone:</span>
                                                <span class="value"> +91 7895456525 </span>
                                            </li>
                                        </ul>

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
                                        <ul class="list-text">
                                            <li><span class="lable">Name:</span>
                                                <span class="value"> John Doe </span>
                                            </li>
                                            <li><span class="lable">Apartment / House:</span>
                                                <span class="value"> University Drive </span>
                                            </li>

                                            <li><span class="lable">City &amp; State:</span>
                                                <span class="value"> Mumbai, Maharashtra </span>
                                            </li>
                                            <li><span class="lable">Postal Code:</span>
                                                <span class="value"> 45684 </span>
                                            </li>
                                            <li><span class="lable">Select Country:</span>
                                                <span class="value"> India </span>
                                            </li>
                                            <li><span class="lable">Phone:</span>
                                                <span class="value"> +91 7895456525 </span>
                                            </li>
                                        </ul>

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
                                        <h6 class="payment-cc mb-4">
                                            <i class="fas fa-credit-card"></i>
                                            <span class="payment-cc-num">**** **** **** 0005</span>
                                        </h6>



                                        <ul class="list-text">
                                            <li>
                                                <span class="lable">Transaction number </span>
                                                <span class="value">ch_1Ib3rfL1bMNoOfFv4tf7HZkN</span>
                                            </li>
                                        </ul>
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