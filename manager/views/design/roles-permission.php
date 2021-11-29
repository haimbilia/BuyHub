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

<body class="fb-body">
    <div class="app">
        <?php
        include 'includes/sidebar.php';
        ?>

        <div class="wrap">
            <?php
            include 'includes/new-header.php';
            ?>
            <main class="main">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">Products</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Brands</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Categories</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Option Groups
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Write
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Product Reviews
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Add Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">Promotions</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Special Prices</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Discount Coupons</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reward Points

                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Buy Together Products
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Write
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Related Products

                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Add Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">Orders</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Orders
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Add Order
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">CMS</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Pages</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Blogs</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>FAQS
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Testimonials</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Write
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Email Templates </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sms Templates</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">Products</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Brands</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Categories</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Option Groups
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Write
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Product Reviews
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Add Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="45%">Promotions</th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </th>
                                                <th>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </th>
                                                <th class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Special Prices</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Discount Coupons</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reward Points

                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Buy Together Products
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox" checked> Write
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Related Products

                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td> 
                                            </tr>
                                            <tr>
                                                <td>Add Products</td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> None
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Read

                                                    </label>
                                                </td>
                                                <td class="align-right">
                                                    <label class="checkbox">
                                                        <input type="checkbox"> Write
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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