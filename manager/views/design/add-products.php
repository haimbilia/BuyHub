<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">

    <head>
        <meta charset="utf-8" />
        <title>FATbit | Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
        <link href="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.css" rel="stylesheet" type="text/css" />
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
                <main class="main">
                    <div class="container">
                        <div class="add-stock">
                            <div class="add-stock-column column-nav">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="stock-nav">
                                            <ul>
                                                <li class="stock-nav-item is-active">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                Basic details</h6>
                                                            <span class="stock-nav-desc"> Add general details about the
                                                                product
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="stock-nav-item">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                Variants and options</h6>
                                                            <span class="stock-nav-desc"> Add options like Color, size
                                                                etc for your product</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="stock-nav-item">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                Media</h6>
                                                            <span class="stock-nav-desc"> Attach media files for the
                                                                product </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="stock-nav-item">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                Specifications</h6>
                                                            <span class="stock-nav-desc"> Product Specifications are
                                                                added in this section </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="stock-nav-item">
                                                    <a class="stock-nav-link" href="">
                                                        <i class="stock-nav-icn">
                                                            <svg class="svg" width="20" height="20">
                                                                <use
                                                                    xlink:href="/yokart/manager/images/retina/sprite.yokart.svg#icon-system-setting">
                                                                </use>
                                                            </svg>
                                                        </i>
                                                        <div class="">
                                                            <h6 class="stock-nav-title">
                                                                Tax and Shipping</h6>
                                                            <span class="stock-nav-desc"> Add Tax and Shipping details
                                                                from this section </span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="add-stock-column column-main">
                                <div class="add-stock-column-head">
                                    <h2>Add Product</h2>
                                    <span class="text-muted"> When adding products here, do not forget to fll the
                                        required felds marked with
                                        asterisk (*).</span>
                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Basic Details </h3>
                                            <span class="text-muted">Add basic details about your product</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form class="form" action="">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required"> Product type </label>
                                                        <div class="">
                                                            <ul class="list-radio">
                                                                <li>
                                                                    <label class="radio">
                                                                        <input type="radio" value="0" checked="checked">
                                                                        Physical</label>
                                                                </li>
                                                                <li><label class="radio">
                                                                        <input type="radio" value="0">
                                                                        Digital</label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required">
                                                            Product name
                                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="Lorem ipsum dolor sit amet consectetur adipisicing elit"
                                                                aria-label="Lorem ipsum dolor sit amet consectetur adipisicing elit"></i>
                                                        </label>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required "> Brand </label> <a
                                                                class="link" href="">Add brand</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="label required ">Category </label> <a
                                                                class="link" href="">Add category</a>
                                                        </div>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label"> Model Number </label>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label">Minimum Selling Price</label>
                                                        <input type="text" placeholder="">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Warranty </label>
                                                        <div class="input-group">
                                                            <input type="text" placeholder="">
                                                            <div class="input-group-append ">
                                                                <button type="button"
                                                                    class="btn btn-outline-gray dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="true">
                                                                    Days
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="#">Days</a>
                                                                    <a class="dropdown-item" href="#">Month</a>
                                                                    <a class="dropdown-item" href="#">Years</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Description</label>
                                                        <textarea></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse"
                                        data-target="#stock-block1" aria-expanded="false" aria-controls="stock-block1">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Variants and options
                                            </h3>
                                            <span class="text-muted">Add options like Color, size
                                                etc for your product</span>
                                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body show" id="stock-block1">
                                        <form class="form" action="">

                                            <div class="form-group row justify-content-between">
                                                <div class="col">
                                                    <label class="label">This product has multiple options,
                                                        like different sizes or colors</label>
                                                </div>
                                                <div class="col-auto">
                                                    <ul class="list-radio">
                                                        <li>
                                                            <label class="radio"><input type="radio" checked="checked"
                                                                    name="radio7" value="1">
                                                                Yes
                                                            </label>
                                                        </li>
                                                        <li>

                                                            <label class="radio"><input type="radio" name="radio7"
                                                                    value="0">
                                                                No
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <table class="table table-variants">
                                                <tbody>
                                                    <tr>

                                                        <td><select name="optionsSelect" class="form-control">
                                                                <option disabled="disabled" value="">
                                                                    Select Option</option>
                                                                <option value="1">Color</option>
                                                                <option value="2">Size</option>
                                                                <option value="3">Carat</option>
                                                                <option value="4">Clarity</option>
                                                                <option value="5">Strap</option>
                                                            </select></td>
                                                        <td> <input name='tags' value='Red, Green, Blue' autofocus>
                                                        </td>
                                                        <td>
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td><select name="optionsSelect" class="form-control">
                                                                <option value="">
                                                                    Size</option>
                                                                <option value="1">Color</option>
                                                                <option value="2">Size</option>
                                                                <option value="3">Carat</option>
                                                                <option value="4">Clarity</option>
                                                                <option value="5">Strap</option>
                                                            </select></td>
                                                        <td> <input name='tags' value='Small, , Medium, Large, XL, XXL'
                                                                autofocus>
                                                        </td>
                                                        <td>
                                                            <ul class="actions">



                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td><select name="optionsSelect" class="form-control">
                                                                <option value="">
                                                                    Select Option</option>
                                                                <option value="1">Color</option>
                                                                <option value="2">Size</option>
                                                                <option value="3">Carat</option>
                                                                <option value="4">Clarity</option>
                                                                <option value="5">Strap</option>
                                                            </select></td>
                                                        <td> <input name='tags' value='Lorem, Lorem2, Lorem5' autofocus>
                                                        </td>
                                                        <td>
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0)" class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#add">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>



                                            <div class="separator separator-dashed my-4"></div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Variant</th>
                                                        <th>EAN/UPC code</th>
                                                        <th class="align-right">
                                                            <a class="link disabled" disabled="disabled">Undo</a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Red / Small </td>
                                                        <td><input class="form-control" type="text" placeholder=""></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a title="Copy to all" href="javascript:void(0)"
                                                                        class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Red / Small </td>
                                                        <td><input class="form-control" type="text" placeholder=""></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a title="Copy to all" href="javascript:void(0)"
                                                                        class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Red / Small </td>
                                                        <td><input class="form-control" type="text" placeholder=""></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a title="Copy to all" href="javascript:void(0)"
                                                                        class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Red / Small </td>
                                                        <td><input class="form-control" type="text" placeholder=""></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a title="Copy to all" href="javascript:void(0)"
                                                                        class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Red / Small </td>
                                                        <td><input class="form-control" type="text" placeholder=""></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a title="Copy to all" href="javascript:void(0)"
                                                                        class="">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="/yokart/manager/images/retina/sprite-actions.svg#copy-to-all">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="separator separator-dashed my-4"></div>

                                            <div class="form-group">
                                                <label class="label">Select Default Product Variant</label>
                                                <select name="default" data-vv-as="Default" data-vv-validate-on="none"
                                                    class="form-control" aria-required="true" aria-invalid="false">
                                                    <option disabled="disabled" value="">Select
                                                    </option>
                                                    <option value="0"><span>red / small</span></option>
                                                    <option value="1"><span>red / medium</span></option>
                                                    <option value="2"><span>red / large</span></option>
                                                    <option value="3"><span>green / small</span></option>
                                                    <option value="4"><span>green / medium</span></option>
                                                    <option value="5"><span>green / large</span></option>
                                                    <option value="6"><span>blue / small</span></option>
                                                    <option value="7"><span>blue / medium</span></option>
                                                    <option value="8"><span>blue / large</span></option>
                                                </select>


                                            </div>

                                        </form>
                                    </div>



                                    </form>

                                </div>


                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse"
                                        data-target="#stock-block2" aria-expanded="false" aria-controls="stock-block2">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Media
                                            </h3>
                                            <span class="text-muted">Attach media files for the product </span>
                                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body show" id="stock-block2">Media</div>
                                </div>

                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse"
                                        data-target="#stock-block3" aria-expanded="false" aria-controls="stock-block3">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Specifications
                                            </h3>
                                            <span class="text-muted">Product Specifications are added in this
                                                section</span>
                                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body show" id="stock-block3">Specifications</div>
                                </div>

                                <div class="card">
                                    <div class="card-head dropdown-toggle-custom show" data-toggle="collapse"
                                        data-target="#stock-block4" aria-expanded="false" aria-controls="stock-block4">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Tax and Shipping
                                            </h3>
                                            <span class="text-muted">Add Tax and Shipping details from
                                                thissection</span>
                                        </div> <i class="dropdown-toggle-custom-arrow"></i>
                                    </div>
                                    <div class="card-body show" id="stock-block4">Tax and Shipping</div>
                                </div>




                            </div>

                            <div class="add-stock-column column-actions">
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
                        </div>
                    </div>
                </main>

                <?php
        include 'includes/footer.php';
        ?> <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
                <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>

                <script>
                // The DOM element you wish to replace with Tagify
                var input = document.querySelector('input[name=tags]');

                // initialize Tagify on the above input node reference
                new Tagify(input);
                </script>


            </div>

        </div>

    </body>

</html>