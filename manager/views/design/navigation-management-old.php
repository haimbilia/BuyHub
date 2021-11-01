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
                                                    consectetur, adipisci velit...
                                                </h6>
                                                <ul>
                                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                                                    <li>Sed aliquam turpis ac justo accumsan volutpat.</li>
                                                    <li>Donec commodo augue id justo molestie luctus mattis id mi.</li>
                                                    <li>Sed ut tellus rutrum, egestas lectus at, ultrices arcu.</li>
                                                    <li>Phasellus posuere lectus vitae arcu volutpat, et consectetur
                                                        lacus vestibulum.
                                                    </li>
                                                    <li>Sed ullamcorper lectus nec risus tincidunt, eu tempor ipsum
                                                        viverra.
                                                    </li>
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
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">
                                                Navigation Management
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="settings-inner">
                                            <ul>
                                                <li class="settings-inner-item is-active">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Seller Left Navigation</h6>
                                                            <span class="settings-inner-desc">(Seller Left
                                                                Navigation)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item ">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Header </h6>
                                                            <span class="settings-inner-desc">(Header)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item ">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Top Header Navigation</h6>
                                                            <span class="settings-inner-desc">(Top Header
                                                                Navigation)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item ">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Quick Links</h6>
                                                            <span class="settings-inner-desc">(Quick Links)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item ">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Extras</h6>
                                                            <span class="settings-inner-desc">(Extras)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="settings-inner-item ">
                                                    <a class="settings-inner-link" href="">
                                                        <div class="settings-inner-content">
                                                            <h6 class="settings-inner-title">Way to shop</h6>
                                                            <span class="settings-inner-desc">(Way to shop)</span>
                                                        </div>
                                                        <div class="settings-inner-action">
                                                            <span class="switch switch-sm switch-icon">
                                                                <label>
                                                                    <input type="checkbox" checked="checked" name="">
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <span class="card-head-title">Seller Left Navigation</span>

                                        </div>
                                        <div class="card-toolbar">
                                            <ul class="actions">
                                                <li>
                                                    <a class="" href="#" title="">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="/admin/images/retina/sprite-actions.svg#edit">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li> <a href="#" class="btn btn-icon btn-light btn-add">

                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="/admin/images/retina/sprite-actions.svg#add">
                                                            </use>
                                                        </svg>
                                                        <span>New</span>
                                                    </a>
                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-dashed">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="sorting">#</th>
                                                        <th class="sorting">
                                                            <span>Caption
                                                                <i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#arrow-up">
                                                                        </use>
                                                                    </svg>
                                                                </i>
                                                            </span>
                                                        </th>
                                                        <th class="align-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>1</td>
                                                        <td>Baby & Kids</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>2</td>
                                                        <td>Electronics</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>3</td>
                                                        <td>Men</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>4</td>
                                                        <td>Women</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>5</td>
                                                        <td>About Us</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                        <td class="dragHandle">
                                                            <i class="icn">
                                                                <svg class="svg" width="18" height="18">
                                                                    <use
                                                                        xlink:href="/admin/images/retina/sprite-actions.svg#drag">
                                                                    </use>
                                                                </svg>
                                                            </i>
                                                        </td>
                                                        <td>6</td>
                                                        <td>Contact Us</td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>
                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">

                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#edit">
                                                                            </use>
                                                                        </svg>
                                                                    </a>
                                                                </li>
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="modal fixed-right fade " id="edit" tabindex="-1" role="dialog"
                            aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-vertical" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="">Card title goes here</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="modal-body form form-edit">
                                        <div class="form-edit-head">
                                            <nav class="nav nav-tabs">
                                                <a class="nav-link active" href="#">Active</a>
                                                <a class="nav-link" href="#">Longer nav link</a>
                                                <a class="nav-link" href="#">Link</a>
                                                <a class="nav-link disabled" href="#">Disabled</a>
                                            </nav>

                                        </div>
                                        <div class="form-edit-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label required">Language </label>
                                                        <select onchange=""
                                                            data-field-caption="Language"
                                                             name="lang_id">
                                                            <option value="1" selected="selected">English
                                                            </option>
                                                            <option value="2">Arabic</option>
                                                        </select>
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
                                                <div class="col"><button type="reset"
                                                        class="btn btn-outline-brand">Cancel</button>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-brand  ">Update</button>
                                                </div>
                                            </div>
                                        </div>


                                    </form>


                                </div>
                            </div>
                        </div>


                    </div>
                </main>
                <?php
            include 'includes/footer.php';
            ?>
                <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.min.js"></script>
                <script src="https://unpkg.com/@yaireo/tagify@4.8.0/dist/tagify.polyfills.min.js"></script>
                <script>
                var input = document.querySelector('input[name=tags-outside]')
                // init Tagify script on the above inputs
                var tagify = new Tagify(input, {
                    whitelist: ["Thin 100", "Thin 100 italic", "Light 300", "Light 300 italic", "Regular 400",
                        "Regular 400 italic",
                        "Medium 500", "Medium 500 italic", "Bold 700", "Bold 700 italic",
                        "Black 900"
                    ],
                    dropdown: {
                        position: "input",
                        enabled: 0 // always opens dropdown when input gets focus
                    }
                })
                </script>
            </div>
        </div>
    </body>

</html>