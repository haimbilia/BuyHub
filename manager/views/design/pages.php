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

    <body class="">
        <div class="wrapper">
            <?php
        include 'includes/header.php';
        ?>
            <div class="body" id="body">
                <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

                    <!-- begin:: Subheader -->
                    <div id="subheader" class="subheader">
                        <div class="container ">
                            <div class="subheader__main">
                                <h3 class="subheader__title">All Pages</h3>

                                <div class="subheader__breadcrumbs">
                                    <a href="#" class="subheader__breadcrumbs-home"><i
                                            class="flaticon2-shelter"></i></a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Components </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Base </a>
                                    <span class="subheader__breadcrumbs-separator"></span>
                                    <a href="" class="subheader__breadcrumbs-link">
                                        Alerts </a>
                                </div>

                            </div>
                            <div class="subheader__toolbar">
                                <div class="subheader__wrapper">
                                    <a href="#" class="btn subheader__btn-secondary">
                                        Reports
                                    </a>

                                    <div class="dropdown dropdown-inline" data-toggle="tooltip" title=""
                                        data-placement="top" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Products
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                            <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                            <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New
                                                Download</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end:: Subheader -->
                    <!-- begin:: Content -->
                    <div class="container  grid__item grid__item--fluid">

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title">Yokart Admin</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="pages__list-wrapper">
                                            <li><a href="listing.php">Listing</a></li>
                                            <li><a href="login-1.php">Login</a></li>
                                            <li><a href="password-reset.php">Password Reset</a></li>
                                            <li><a href="profile-management.php">Profile Management</a></li>
                                            <li><a href="get-started.php">Getting Started</a></li>
                                            <li><a href="setting.php">Settings</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <!--begin::card-->
                                <div class="card">
                                    <div class="card-head">
                                        <div class="card-head-label">
                                            <h3 class="card-head-title"> Page list </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin::Section-->
                                        <div class="section">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="pages__list-wrapper">
                                                        <li><a href="">Dashboard</a>
                                                            <ul>
                                                                <li><a href="index.php">Dashboard</a></li>
                                                                <li><a href="index.php">Default Dashboard</a></li>
                                                                <li><a href="fluid.php">Fluid Dashboard </a></li>
                                                                <li><a href="dashboard.php">Yo!kart Dashboard</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><a href="">Projects</a>
                                                            <ul>
                                                                <li><a href="#">List</a>
                                                                    <ul>
                                                                        <li><a href="list-columns-1.php">Columns
                                                                                1</a>
                                                                        </li>
                                                                        <li><a href="list-columns-2.php">Columns
                                                                                2</a>
                                                                        </li>
                                                                        <li><a href="list-datatable.php">Datatable</a>
                                                                        </li>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><a href="view-project.php">View Project </a></li>
                                                        <li><a href="add-project.php">Add Project</a></li>
                                                        <li><a href="edit-project.php">Edit Project</a></li>
                                                    </ul>
                                                    </li>
                                                    <li><a href="">Features</a>
                                                        <ul>
                                                            <li><a href="#">Base</a>
                                                                <ul>
                                                                    <li><a href="colors.php">State Colors</a></li>
                                                                    <li><a href="button-group.php">Button Group</a>
                                                                    </li>
                                                                    <li><a href="dropdown.php">Dropdown</a></li>
                                                                    <li><a href="bootstrap.php">Bootstrap Tabs</a>
                                                                    </li>
                                                                    <li><a href="line.php">Line Tabs</a></li>
                                                                    <li><a href="accordions.php">Accordions</a></li>
                                                                    <li><a href="tables.php">Tables</a></li>
                                                                    <li><a href="progress.php">Progress</a></li>
                                                                    <li><a href="lightbox.php">Featherlight</a></li>
                                                                    <li><a href="lightbox-gallery.php">Featherlight
                                                                            Gallery</a></li>
                                                                    <li><a href="modal.php">Modal</a></li>
                                                                    <li><a href="alerts.php">Alerts</a></li>
                                                                    <li><a href="popover.php">Popover</a></li>
                                                                    <li><a href="tooltip.php">Tooltip</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">General Components</a>
                                                                <ul>
                                                                    <li><a href="buttons.php">Button</a></li>
                                                                    <li><a href="typography.php">Typography</a></li>
                                                                    <li>
                                                                        <a href="#">Icon</a>
                                                                        <ul>
                                                                            <li><a href="flaticon.php">Flaticon</a>
                                                                            </li>
                                                                            <li><a href="fontawesome5.php">Fontawesome
                                                                                    5</a></li>
                                                                            <li><a
                                                                                    href="lineawesome.php">Lineawesome</a>
                                                                            </li>
                                                                            <li><a href="socicon.php">Socicons</a>
                                                                            </li>
                                                                            <li><a href="svg.php">SVG Icons</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Custom </a>
                                                                <ul>
                                                                    <li><a href="badge.php">Badge</a></li>
                                                                    <li><a href="nav.php">Navigations</a></li>
                                                                    <li><a href="lists.php">Lists</a></li>
                                                                    <li><a href="notes.php">Notes</a></li>
                                                                    <li><a href="timeline.php">Timeline</a></li>
                                                                    <li><a href="media.php">Media</a></li>
                                                                    <li><a href="spinners.php">Spinners</a></li>
                                                                    <li><a href="pagination.php">Pagination</a></li>
                                                                    <li><a href="iconbox.php">Iconbox</a></li>
                                                                    <li><a href="infobox.php">Infobox</a></li>
                                                                    <li><a href="callout.php">Callout</a></li>
                                                                    <li><a href="ribbon.php">Ribbon</a></li>
                                                                    <li><a href="miscellaneous.php">Miscellaneous</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Extended</a>
                                                                <ul>
                                                                    <li><a href="blockui.php">Block UI</a></li>
                                                                    <li><a href="perfect-scrollbar.php">Perfect
                                                                            Scrollbar</a></li>
                                                                    <li><a href="treeview.php">Tree View</a></li>
                                                                    <li><a href="bootstrap-notify.php">Bootstrap
                                                                            Notify</a></li>
                                                                    <li><a href="toastr.php">Toastr</a></li>
                                                                    <li><a href="sweetalert2.php">SweetAlert2</a>
                                                                    </li>
                                                                    <li><a href="dual-listbox.php">Dual Listbox</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">cards </a>
                                                                <ul>
                                                                    <li><a href="base.php">Base cards</a></li>
                                                                    <li><a href="advanced.php">Advanced cards</a>
                                                                    </li>
                                                                    <li><a href="tabbed.php">Tabbed cards</a></li>
                                                                    <li><a href="draggable.php">Draggable cards</a>
                                                                    </li>
                                                                    <li><a href="tools.php">card Tools</a></li>
                                                                    <li><a href="sticky-head.php">Sticky Head</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Widgets </a>
                                                                <ul>
                                                                    <li><a href="lists.php">Lists</a></li>
                                                                    <li><a href="charts.php">Charts</a></li>
                                                                    <li><a href="general.php">General</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Calendar</a>
                                                                <ul>
                                                                    <li><a href="base.php">Basic Calendar</a></li>
                                                                    <li><a href="list-view.php">List Views</a></li>
                                                                    <li><a href="google.php">Google Calendar</a>
                                                                    </li>
                                                                    <li><a href="external-events.php">External
                                                                            Events</a></li>
                                                                    <li><a href="background-events.php">Background
                                                                            Events</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Maps </a>
                                                                <ul>
                                                                    <li><a href="google-maps.php">Google Maps</a>
                                                                    </li>
                                                                    <li><a href="jqvmaps.php"> JQVMap</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Charts </a>
                                                                <ul>
                                                                    <li><a href="#">amCharts</a>
                                                                        <ul>
                                                                            <li><a href="charts.php">amCharts
                                                                                    Charts</a>
                                                                            </li>
                                                                            <li><a href="stock-charts.php">amCharts
                                                                                    Stock Charts</a></li>
                                                                            <li><a href="maps.php">amCharts Maps</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="apex-charts.php">Apex Charts</a>
                                                                    </li>
                                                                    <li><a href="flotcharts.php">Flot Charts</a>
                                                                    </li>
                                                                    <li><a href="google-charts.php">Google
                                                                            Charts</a>
                                                                    </li>
                                                                    <li><a href="morris-charts.php">Morris
                                                                            Charts</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Utils</a>
                                                                <ul>
                                                                    <li><a href="session-timeout.php">Session
                                                                            Timeout</a></li>
                                                                    <li><a href="idle-timer.php">Idle Timer</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="">Users</a>
                                                        <ul>
                                                            <li><a href="add-user.php">Add User</a></li>
                                                            <li><a href="edit-user.php">Edit User</a></li>
                                                            <li><a href="#">List</a>
                                                                <ul>
                                                                    <li><a href="list-default.php">Default</a></li>
                                                                    <li><a href="list-datatable.php">Datatable</a>
                                                                    </li>
                                                                    <li><a href="list-colums-1.php">Columns 1 </a>
                                                                    </li>
                                                                    <li><a href="list-colums-2.php">Columns 2</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="">Cruds</a>
                                                        <ul>
                                                            <li><a href="#">Form & Controls</a>
                                                                <ul>
                                                                    <li><a href="#">Form Control</a>
                                                                        <ul>
                                                                            <li><a href="base-input.php">Base
                                                                                    Inputs</a>
                                                                            </li>
                                                                            <li><a href="input-group.php">Input
                                                                                    Groups</a></li>
                                                                            <li><a href="checkbox.php">Checkbox</a>
                                                                            </li>
                                                                            <li><a href="radio.php">Radio</a></li>
                                                                            <li><a href="switch.php">Switch</a></li>
                                                                            <li><a href="option.php">Mega
                                                                                    Options</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Form Widget</a>
                                                                        <ul>
                                                                            <li><a
                                                                                    href="bootstrap-datepicker.php">Datepicker</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-datetimepicker.php">DateTimepicker</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-timepicker.php">Timepicker</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-daterangepicker.php">Daterangepicker</a>
                                                                            </li>
                                                                            <li><a href="tagify.php">Tagify</a></li>
                                                                            <li><a
                                                                                    href="bootstrap-touchspin.php">Touchspin</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-maxlength.php">Maxlength</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-switch.php">Switch</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="bootstrap-multipleselectsplitter.php">Multiple
                                                                                    Select Splitter</a></li>
                                                                            <li><a href="bootstrap-select.php">Bootstrap
                                                                                    Select</a></li>
                                                                            <li><a href="select2.php">Select2</a>
                                                                            </li>
                                                                            <li><a href="typeahead.php">Typeahead</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Form Widget 2</a>
                                                                        <ul>
                                                                            <li><a href="nouislider.php">noUiSlider</a>
                                                                            </li>
                                                                            <li><a href="form-repeater.php">Form
                                                                                    Repeater</a></li>
                                                                            <li><a href="ion-range-slider.php">Ion
                                                                                    Range
                                                                                    Slider</a></li>
                                                                            <li><a href="input-mask.php">Input
                                                                                    Masks</a>
                                                                            </li>
                                                                            <li><a href="quill.php">Quill Text
                                                                                    Editor</a></li>
                                                                            <li><a href="summernote.php">Summernote
                                                                                    WYSIWYG</a></li>
                                                                            <li><a href="bootstrap-markdown.php">Markdown
                                                                                    Editor</a></li>
                                                                            <li><a href="autosize.php">Autosize</a>
                                                                            </li>
                                                                            <li><a href="recaptcha.php">Clipboard</a>
                                                                            </li>
                                                                            <li><a href="recaptcha.php">Google
                                                                                    reCaptcha</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Form Validation</a>
                                                                        <ul>
                                                                            <li><a href="states.php">Validation
                                                                                    States</a></li>
                                                                            <li><a href="form-controls.php">Form
                                                                                    Controls</a></li>
                                                                            <li><a href="form-widgets.php">Form
                                                                                    Widgets</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Form Layout</a>
                                                                        <ul>
                                                                            <li><a href="default-forms.php">Default
                                                                                    Forms</a></li>
                                                                            <li><a href="multi-column-forms.php">Multi
                                                                                    Column Forms</a></li>
                                                                            <li><a href="action-bars.php">Basic
                                                                                    Action
                                                                                    Bars</a></li>
                                                                            <li><a href="sticky-action-bar.php">Sticky
                                                                                    Action Bar</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">YKDatatable</a>
                                                                <ul>
                                                                    <li><a href="#">Base</a>
                                                                        <ul>
                                                                            <li><a href="data-local.php">Local
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="data-json.php">JSON
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="data-ajax.php">Ajax
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="html-table.php">HTML
                                                                                    Table</a>
                                                                            </li>
                                                                            <li><a href="local-sort.php">Local
                                                                                    Sort</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="translation.php">Translation</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">KTDatatable</a>
                                                                <ul>
                                                                    <li><a href="#">Base</a>
                                                                        <ul>
                                                                            <li><a href="data-local.php">Local
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="data-json.php">JSON
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="data-ajax.php">Ajax
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="html-table.php">HTML
                                                                                    Table</a>
                                                                            </li>
                                                                            <li><a href="local-sort.php">Local
                                                                                    Sort</a>
                                                                            </li>
                                                                            <li><a
                                                                                    href="translation.php">Translation</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Advanced</a>
                                                                        <ul>
                                                                            <li><a href="record-selection.php">Record
                                                                                    Selection</a></li>
                                                                            <li><a href="row-details.php">Row
                                                                                    Details</a></li>
                                                                            <li><a href="modal.php">Modal
                                                                                    Examples</a>
                                                                            </li>
                                                                            <li><a href="column-rendering.php">Column
                                                                                    Rendering</a></li>
                                                                            <li><a href="column-width.php">Column
                                                                                    Width</a></li>
                                                                            <li><a href="vertical.php">Vertical
                                                                                    Scrolling</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Child Datatables</a>
                                                                        <ul>
                                                                            <li><a href="data-local.php">Local
                                                                                    Data</a>
                                                                            </li>
                                                                            <li><a href="data-ajax.php">Remote
                                                                                    Data</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">API</a>
                                                                        <ul>
                                                                            <li><a href="methods.php">API
                                                                                    Methods</a>
                                                                            </li>
                                                                            <li><a href="events.php">Events</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li><a href="#">Datatables.net</a>
                                                                <ul>
                                                                    <li><a href="#">Basic</a>
                                                                        <ul>
                                                                            <li><a href="basic.php">Basic Tables</a>
                                                                            </li>
                                                                            <li><a href="scrollable.php">Scrollable
                                                                                    Tables</a></li>
                                                                            <li><a href="headers.php">Complex
                                                                                    Headers</a></li>
                                                                            <li><a href="pagination.php">Pagination
                                                                                    Options</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Advanced</a>
                                                                        <ul>
                                                                            <li><a href="column-rendering.php">Column
                                                                                    Rendering</a></li>
                                                                            <li><a href="multiple-controls.php">Multiple
                                                                                    Controls</a></li>
                                                                            <li><a href="column-visibilty.php">Column
                                                                                    Visibility</a></li>
                                                                            <li><a href="row-callback.php">Row
                                                                                    Callback</a></li>
                                                                            <li><a href="row-grouping.php">Row
                                                                                    Grouping</a></li>
                                                                            <li><a href="footer-callback.php">Footer
                                                                                    Callback</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Data sources</a>
                                                                        <ul>
                                                                            <li><a href="html.php">HTML</a></li>
                                                                            <li><a href="javascript.php">Javascript</a>
                                                                            </li>
                                                                            <li><a href="ajax-client-side.php">Ajax
                                                                                    Client-side</a></li>
                                                                            <li><a href="ajax-server-side.php">Ajax
                                                                                    Server-side</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Search Options</a>
                                                                        <ul>
                                                                            <li><a href="column-search.php">Column
                                                                                    Search</a></li>
                                                                            <li><a href="advanced-search.php">Advanced
                                                                                    Search</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="#">Extensions</a>
                                                                        <ul>
                                                                            <li><a href="buttons.php">Buttons</a>
                                                                            </li>
                                                                            <li><a href="colreorder.php">ColReorder</a>
                                                                            </li>
                                                                            <li><a href="keytable.php">KeyTable</a>
                                                                            </li>
                                                                            <li><a href="responsive.php">Responsive</a>
                                                                            </li>
                                                                            <li><a href="rowgroup.php">RowGroup</a>
                                                                            </li>
                                                                            <li><a href="rowreorder.php">RowReorder</a>
                                                                            </li>
                                                                            <li><a href="scroller.php">Scroller</a>
                                                                            </li>
                                                                            <li><a href="select.php">Select</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">File Upload</a>
                                                                <ul>
                                                                    <li><a href="avatar.php">Avatar</a></li>
                                                                    <li><a href="dropzone.php">DropzoneJS</a></li>
                                                                </ul>
                                                        </ul>
                                                    </li>
                                                    </li>
                                                    <li><a href="">Apps</a>
                                                        <ul>
                                                            <li><a href="#">Profile 1</a>
                                                                <ul>
                                                                    <li><a href="profile-overview.php">Overview</a>
                                                                    </li>
                                                                    <li><a href="profile-personal-information.php">Personal
                                                                            Information</a></li>
                                                                    <li><a href="profile-account-information.php">Account
                                                                            Information</a></li>
                                                                    <li><a href="profile-change-password.php">Change
                                                                            Password</a></li>
                                                                    <li><a href="profile-email-settings.php">Email
                                                                            Settings</a></li>
                                                                    <li><a href="profile-2.php">Profile 2</a></li>
                                                                    <li><a href="profile-3.php">Profile 3</a></li>
                                                                    <li><a href="profile-4.php">Profile 4</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Contacts</a>
                                                                <ul>
                                                                    <li><a href="list-columns.php">List -
                                                                            Columns</a>
                                                                    </li>
                                                                    <li><a href="list-datatable.php">List -
                                                                            Datatable</a></li>
                                                                    <li><a href="view-contact.php">View Contact</a>
                                                                    </li>
                                                                    <li><a href="add-contact.php">Add Contact</a>
                                                                    </li>
                                                                    <li><a href="edit-contact.php">Edit Contact</a>
                                                                    </li>
                                                                </ul>
                                                            <li><a href="#">Chat</a>
                                                                <ul>

                                                                    <li><a href="private.php">Private</a></li>
                                                                    <li><a href="group.php">Group</a></li>
                                                                    <li><a href="popup.php">Popup</a></li>
                                                                </ul>
                                                            </li>
                                                    </li>
                                                    <li><a href="#">Projects</a>
                                                        <ul>
                                                            <li><a href="list-columns-1.php">List - Columns 1</a>
                                                            </li>
                                                            <li><a href="list-columns-2.php">List - Columns 2</a>
                                                            </li>
                                                            <li><a href="list-columns-3.php">List - Columns 3</a>
                                                            </li>
                                                            <li><a href="list-columns-4.php">List - Columns 4</a>
                                                            </li>
                                                            <li><a href="list-datatable.php">List - Datatable</a>
                                                            </li>
                                                            <li><a href="view-project.php">View Project</a></li>
                                                            <li><a href="add-project.php">Add Project</a></li>
                                                            <li><a href="edit-project.php">Edit Project</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Support Center</a>
                                                        <ul>
                                                            <li><a href="home-1.php">Home 1</a></li>
                                                            <li><a href="home-2.php">Home 2</a></li>
                                                            <li><a href="faq-1.php">FAQ 1</a></li>
                                                            <li><a href="faq-2.php">FAQ 2</a></li>
                                                            <li><a href="feedback.php">Feedback</a></li>
                                                            <li><a href="license.php">License</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="inbox.php">Inbox</a></li>
                                                    </ul>
                                                    </li>

                                                    <li class="drop-left has-sub"><a href="">Pages</a>
                                                        <ul>
                                                            <li><a href="#">Pricing Tables</a>
                                                                <ul>
                                                                    <li><a href="pricing-1.php">Pricing Tables 1</a>
                                                                    </li>
                                                                    <li><a href="pricing-2.php">Pricing Tables 2</a>
                                                                    </li>
                                                                    <li><a href="pricing-3.php">Pricing Tables 3</a>
                                                                    </li>
                                                                    <li><a href="pricing-4.php">Pricing Tables 4</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Wizards</a>
                                                                <ul>
                                                                    <li><a href="wizard-1.php">Wizard 1</a></li>
                                                                    <li><a href="wizard-2.php">Wizard 2</a></li>
                                                                    <li><a href="wizard-3.php">Wizard 3</a></li>
                                                                    <li><a href="wizard-4.php">Wizard 4</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Kanban</a>
                                                                <ul>
                                                                    <li><a href="kanban.php">Kanban 1</a></li>
                                                                    <li><a href="kanban-1.php">Kanban 2</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Invoices & FAQ </a>
                                                                <ul>
                                                                    <li><a href="invoice-1.php">Invoice 1</a></li>
                                                                    <li><a href="invoice-2.php">Invoice 2</a></li>
                                                                    <li><a href="faq-1.php">FAQ 1</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">User Pages</a>
                                                                <ul>
                                                                    <li><a href="login-1.php">Login 1</a></li>
                                                                    <li><a href="login-2.php">Login 2</a></li>
                                                                    <li><a href="login-3.php">Login 3</a></li>
                                                                    <li><a href="login-4.php">Login 4</a></li>
                                                                    <li><a href="login-5.php">Login 5</a></li>
                                                                    <li><a href="login-6.php">Login 6</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="#">Error Pages</a>
                                                                <ul>
                                                                    <li><a href="400.php">Bad Request (400)</a></li>
                                                                    <li><a href="401.php">Unauthorised (401)</a>
                                                                    </li>
                                                                    <li><a href="403.php"> Access Denied (403)</a>
                                                                    </li>
                                                                    <li><a href="404.php">Page not found (404)</a>
                                                                        <ul>
                                                                            <li><a href="error-1.php">Error 1</a>
                                                                            </li>
                                                                            <li><a href="error-2.php">Error 2</a>
                                                                            </li>
                                                                            <li><a href="error-3.php">Error 3</a>
                                                                            </li>
                                                                            <li><a href="error-4.php">Error 4</a>
                                                                            </li>
                                                                            <li><a href="error-5.php">Error 5</a>
                                                                            </li>
                                                                            <li><a href="error-6.php">Error 6</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><a href="408.php">Time Out (408)</a></li>
                                                                    <li><a href="500.php">Server error (500)</a>
                                                                    </li>
                                                                    <li><a href="501.php">Not Implemented (501)</a>
                                                                    </li>
                                                                    <li><a href="502.php">Service Temporarily
                                                                            Overloaded
                                                                            (502)</a></li>
                                                                    <li><a href="503.php">Service Unavailable
                                                                            (503)</a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="">Emails</a>
                                                        <ul>
                                                            <li class=""><a href="email/account-verification.html"
                                                                    target="_blank">Account Verification</a></li>
                                                            <li class=""><a href="email/account-verification-admin.html"
                                                                    target="_blank">Account Verification Admin</a>
                                                            </li>
                                                            <li class=""><a href="email/admin-message.html"
                                                                    target="_blank">Admin Message</a></li>
                                                            <li class=""><a
                                                                    href="email/admin-review-recived-approval.html"
                                                                    target="_blank">Admin Review Approval</a></li>
                                                            <li class=""><a
                                                                    href="email/admin-review-recived-without-approval.html"
                                                                    target="_blank">Admin Review Without
                                                                    Approval</a>
                                                            </li>
                                                            <li class=""><a href="email/buyer-give-review.html"
                                                                    target="_blank">Buyer Give Review</a></li>
                                                            <li class=""><a href="email/buyer-message.html"
                                                                    target="_blank">Buyer Message</a></li>
                                                            <li class=""><a
                                                                    href="email/cancellation-requested-admin.html"
                                                                    target="_blank">Cancellation Requested Admin</a>
                                                            </li>
                                                            <li class=""><a
                                                                    href="email/cancellation-requested-buyer.html"
                                                                    target="_blank">Cancellation Requested Buyer</a>
                                                            </li>
                                                            <li class=""><a href="email/COD-payment-link.html"
                                                                    target="_blank">COD Payment Link</a></li>
                                                            <li class=""><a href="email/COD-verification.html"
                                                                    target="_blank">COD Verification</a></li>
                                                            <li class=""><a href="email/contact-us-admin.html"
                                                                    target="_blank">Contact Us Admin</a></li>
                                                            <li class=""><a href="email/contact-us-buyer.html"
                                                                    target="_blank">Contact Us Buyer</a></li>
                                                            <li class=""><a href="email/digital-download.html"
                                                                    target="_blank">Digital Download</a></li>
                                                            <li class=""><a href="email/discount-coupon-buyer.html"
                                                                    target="_blank">Discount Coupon Buyer</a></li>
                                                            <li class=""><a href="email/email-from-admin-buyer.html"
                                                                    target="_blank">Email from Admin To Buyer</a>
                                                            </li>
                                                            <li class=""><a href="email/failed-login-attempt.html"
                                                                    target="_blank">Failed Login Attempt</a></li>
                                                            <li class=""><a href="email/failed-login-attempt-admin.html"
                                                                    target="_blank">Failed Login Attempt Admin</a>
                                                            </li>
                                                            <li class=""><a href="email/favorite-email-buyer.html"
                                                                    target="_blank">Favorite Email Buyer</a></li>
                                                            <li class=""><a href="email/favorite-price-drop-buyer.html"
                                                                    target="_blank">Favorite Price Drop Buyer</a>
                                                            </li>
                                                            <li class=""><a href="email/forgot-password.html"
                                                                    target="_blank">Forgot Password</a></li>
                                                            <li class=""><a href="email/forgot-password-admin.html"
                                                                    target="_blank">Forgot Password Admin</a></li>
                                                            <li class=""><a href="email/GDPR-delete-account.html"
                                                                    target="_blank">GDPR Delete Account</a></li>
                                                            <li class=""><a href="email/GDPR-information-buyer.html"
                                                                    target="_blank">GDPR Information Buyer</a></li>
                                                            <li class=""><a href="email/general-email.html"
                                                                    target="_blank">General Email</a></li>
                                                            <li class=""><a href="email/new-order-admin.html"
                                                                    target="_blank">New Order Admin</a></li>
                                                            <li class=""><a href="email/newsletter-subscribe-admin.html"
                                                                    target="_blank">Newsletter subscribe admin</a>
                                                            </li>
                                                            <li class=""><a href="email/newsletter-subscribe-buyer.html"
                                                                    target="_blank">Newsletter subscribe buyer</a>
                                                            </li>
                                                            <li class=""><a
                                                                    href="email/newsletter-unsubscribe-admin.html"
                                                                    target="_blank">Newsletter unsubscribe admin</a>
                                                            </li>
                                                            <li class=""><a
                                                                    href="email/newsletter-unsubscribe-buyer.html"
                                                                    target="_blank">Newsletter unsubscribe buyer</a>
                                                            </li>
                                                            <li class=""><a href="email/new-user-sign-up.html"
                                                                    target="_blank">New user sign up</a></li>
                                                            <li class=""><a href="email/order-Comment-admin.html"
                                                                    target="_blank">Order Comment Admin</a></li>
                                                            <li class=""><a href="email/order-comment-buyer.html"
                                                                    target="_blank">Order Comment Buyer</a></li>
                                                            <li class=""><a href="email/order-cancelled-admin.html"
                                                                    target="_blank">Order Cancelled Admin</a></li>
                                                            <li class=""><a href="email/order-cancelled-buyer.html"
                                                                    target="_blank">Order cancelled buyer</a></li>
                                                            <li class=""><a href="email/order-confirmation.html"
                                                                    target="_blank">Order confirmation</a></li>
                                                            <li class=""><a href="email/order-confirmation-email-2.html"
                                                                    target="_blank">Order confirmation email-2</a>
                                                            </li>
                                                            <li class=""><a href="email/order-confirmation-email-3.html"
                                                                    target="_blank">Order confirmation email-3</a>
                                                            </li>
                                                            <li class=""><a href="email/order-delivered-digital.html"
                                                                    target="_blank">Order delivered digital</a></li>
                                                            <li class=""><a href="email/order-delivered-physical.html"
                                                                    target="_blank">Order delivered physical</a>
                                                            </li>
                                                            <li class=""><a href="email/order-ready-digital.html"
                                                                    target="_blank">Order ready digital</a></li>
                                                            <li class=""><a href="email/order-ready-physical.html"
                                                                    target="_blank">Order ready physical</a></li>
                                                            <li class=""><a href="email/order-shipped-digital.html"
                                                                    target="_blank">Order shipped digital</a></li>
                                                            <li class=""><a href="email/order-shipped-physical.html"
                                                                    target="_blank">Order shipped physical</a></li>
                                                            <li class=""><a href="email/order-shipping-email.html"
                                                                    target="_blank">Order shipping email</a></li>
                                                            <li class=""><a
                                                                    href="email/payment-failed-payment-link.html"
                                                                    target="_blank">Payment failed payment link</a>
                                                            </li>
                                                            <li class=""><a href="email/pending-cart-buyer.html"
                                                                    target="_blank">Pending cart buyer</a></li>
                                                            <li class=""><a href="email/return-requested-admin.html"
                                                                    target="_blank">Return requested admin</a></li>
                                                            <li class=""><a href="email/return-requested-buyer.html"
                                                                    target="_blank">Return requested buyer</a></li>
                                                            <li class=""><a
                                                                    href="email/return-requested-buyer-approved.html"
                                                                    target="_blank">Return requested buyer
                                                                    approved</a>
                                                            </li>
                                                            <li class=""><a
                                                                    href="email/return-requested-buyer-declined.html"
                                                                    target="_blank">Return requested buyer
                                                                    declined</a>
                                                            </li>
                                                            <li class=""><a
                                                                    href="email/return-requested-buyer-item-recived.html"
                                                                    target="_blank">Return requested buyer item
                                                                    recived</a></li>
                                                            <li class=""><a href="email/rewards-earned-on-birthday.html"
                                                                    target="_blank">Rewards earned on birthday</a>
                                                            </li>
                                                            <li class=""><a href="email/rewards-earned-on-order.html"
                                                                    target="_blank">Rewards earned on order</a></li>
                                                            <li class=""><a
                                                                    href="email/rewards-earned-on-social-sharing.html"
                                                                    target="_blank">Rewards earned on social
                                                                    sharing</a>
                                                            </li>
                                                            <li class=""><a href="email/rewards-share-earn.html"
                                                                    target="_blank">Rewards share & earn</a></li>
                                                            <li class=""><a href="email/rewards-expired.html"
                                                                    target="_blank">Rewards expired</a></li>
                                                            <li class=""><a href="email/rewards-spent-on-order.html"
                                                                    target="_blank">Rewards spent on order</a></li>
                                                            <li class=""><a href="email/sub-admin-welcome.html"
                                                                    target="_blank">Sub admin welcome</a></li>
                                                            <li class=""><a href="email/test-email.html"
                                                                    target="_blank">Test email</a></li>
                                                            <li class=""><a
                                                                    href="email/threshold-notification-admin.html"
                                                                    target="_blank">Threshold notification admin</a>
                                                            </li>
                                                            <li class=""><a href="email/to-do-assigned.html"
                                                                    target="_blank">To do assigned</a></li>
                                                            <li class=""><a href="email/to-do-reminder.html"
                                                                    target="_blank">To do reminder</a></li>
                                                            <li class=""><a href="email/welcome-email.html"
                                                                    target="_blank">Welcome email</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            Other Pages
                                                        </a>
                                                        <ul>

                                                            <li><a href="categories.php" target="_blank">Categories</a>
                                                            </li>
                                                            <li><a href="email-template-settings.php"
                                                                    target="_blank">Email temaplate - Settings</a>
                                                            </li>
                                                            <li><a href="products.php" target="_blank">Products</a>
                                                            </li>
                                                            <li><a href="add-product.php" target="_blank">Add
                                                                    Products</a></li>
                                                            <li><a href="tax-rules-listing.php" target="_blank">Tax
                                                                    Rules Listing</a></li>
                                                            <li><a href="tax-rules-edit.php" target="_blank">Tax
                                                                    Rules
                                                                    Edit</a></li>
                                                            <li><a href="shipping.php" target="_blank">Shipping</a>
                                                            </li>
                                                            <li><a href="general-profile.php"
                                                                    target="_blank">General-Profile</a></li>
                                                            <li><a href="admin-role.php" target="_blank">Admin
                                                                    Role</a>
                                                            </li>
                                                            <li><a href="orders-kanban.php" target="_blank">Orders</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    </ul>

                                                </div>
                                                <!-- <div class="col-md-12">
                                                <h3>Single Vendor Pages</h3>
                                                <ul>

                                                    <li><a href="sample-page.php" target="_blank">Sample Page</a></li>

                                                    <li><a href="categories.php" target="_blank">Categories</a></li>
                                                    <li><a href="email-template-settings.php" target="_blank">Email temaplate - Settings</a></li>
                                                    <li><a href="products.php" target="_blank">Products</a></li>
                                                    <li><a href="add-product.php" target="_blank">Add Products</a></li>
                                                    <li><a href="tax-rules-listing.php" target="_blank">Tax Rules Listing</a></li>
                                                    <li><a href="tax-rules-edit.php" target="_blank">Tax Rules Edit</a></li>
                                                    <li><a href="shipping.php" target="_blank">Shipping</a></li>
                                                    <li><a href="general-profile.php" target="_blank">General-Profile</a></li>
                                                    <li><a href="admin-role.php" target="_blank">Admin Role</a></li>
                                                    <li><a href="orders-kanban.php" target="_blank">Orders</a></li>


                                                </ul>

                                            </div> -->
                                            </div>
                                        </div>
                                        <!--end::Section-->
                                    </div>
                                </div>
                                <!--end::card-->

                            </div>

                        </div>
                    </div>
                    <!-- end:: Content -->
                </div>
            </div>

            <?php
        include 'includes/footer.php';
        ?>
        </div>

    </body>


</html>