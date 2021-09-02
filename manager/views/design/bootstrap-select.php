<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>



<body class="subheader--transparent page--loading">
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
                            <h3 class="subheader__title">Bootstrap Select</h3>

                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Forms &amp; Controls </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Form Widgets </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Bootstrap Select </a>
                            </div>

                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn subheader__btn-secondary">
                                    Reports
                                </a>

                                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="top" data-original-title="Quick actions">
                                    <a href="#" class="btn btn-danger subheader__btn-options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="la la-plus"></i> New Product</a>
                                        <a class="dropdown-item" href="#"><i class="la la-user"></i> New Order</a>
                                        <a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
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
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
                                <div class="alert-text">
                                    The jQuery plugin that brings select elements into the 21st century with intuitive multiselection, searching, and much more.
                                    <br>
                                    For more info please visit the plugin's <a class="link font-bold" href="https://developer.snapappointments.com/bootstrap-select/examples/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/snapappointments/bootstrap-select" target="_blank">Github Repo</a>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    Bootstrap Select Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" tabindex="-98">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Options Size</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" data-size="4" tabindex="-98">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                            <option>Tent</option>
                                            <option>Flashlight</option>
                                            <option>Toilet Paper</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Optgroups Example</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" tabindex="-98">
                                            <optgroup label="Picnic" data-max-options="2">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </optgroup>
                                            <optgroup label="Camping" data-max-options="2">
                                                <option>Tent</option>
                                                <option>Flashlight</option>
                                                <option>Toilet Paper</option>
                                            </optgroup>
                                        </select>
                                        <span class="form-text text-muted">Select boxes with optgroups</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Multiple Select</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" multiple="" tabindex="-98">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Live Search</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" data-live-search="true" tabindex="-98">
                                            <option>Hot Dog, Fries and a Soda</option>
                                            <option>Burger, Shake and a Smile</option>
                                            <option>Sugar, Spice and all things nice</option>
                                        </select>
                                        <span class="form-text text-muted">You can add a search input by passing <code>data-live-search="true"</code> attribute</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Key Words</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" data-live-search="true" tabindex="-98">
                                            <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                                            <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                            <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                                        </select>
                                        <span class="form-text text-muted">Add key words to options to improve their searchability using <code>data-tokens</code></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Limited Selection</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control form-control--fixed selectpicker" multiple="" data-max-options="2" data-width="200" tabindex="-98">
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Placeholder</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" title="Choose one of the following..." tabindex="-98">
                                            <option class="bs-title-option" value=""></option>
                                            <option>Mustard</option>
                                            <option>Ketchup</option>
                                            <option>Relish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Selected Text</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select class="form-control selectpicker" title="Choose one of the following..." tabindex="-98">
                                            <option class="bs-title-option" value=""></option>
                                            <option title="Combo 1">Hot Dog, Fries and a Soda</option>
                                            <option title="Combo 2" selected="">Burger, Shake and a Smile</option>
                                            <option title="Combo 3">Sugar, Spice and all things nice</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Selected Text Format</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                   <select class="form-control selectpicker" multiple="" data-selected-text-format="count" tabindex="-98">
                                                <option title="Combo 1">Hot Dog, Fries and a Soda</option>
                                                <option title="Combo 2">Burger, Shake and a Smile</option>
                                                <option title="Combo 3" selected="">Sugar, Spice and all things nice</option>
                                            </select>
                                        <div class="space-10"></div>
                                       <select class="form-control selectpicker" multiple="" data-selected-text-format="count > 3" tabindex="-98">
                                                <option title="Combo 1" selected="">Hot Dog, Fries and a Soda</option>
                                                <option title="Combo 2">Burger, Shake and a Smile</option>
                                                <option title="Combo 3">Sugar, Spice and all things nice</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Style Options</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" title="" tabindex="-98">
                                                <option class="-bg-success font-inverse-success">Mustard</option>
                                                <option class="-bg-warning font-inverse-warning">Ketchup</option>
                                                <option class="-bg-brand font-inverse-brand">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Width Options</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" data-width="" title="Auto" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-light" data-toggle="dropdown" role="button" title="Auto">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Auto</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control " style="width: 200px;"><select class="form-control selectpicker" data-width="200px" title="Fixed: 200px" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-light" data-toggle="dropdown" role="button" title="Fixed: 200px">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Fixed: 200px</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control " style="width: 75%;"><select class="form-control selectpicker" data-width="75%" title="Fixed: 75%" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-light" data-toggle="dropdown" role="button" title="Fixed: 75%">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Fixed: 75%</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Icons</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                <option data-icon="la la-bullhorn">Mustard</option>
                                                <option data-icon="la la-bookmark">Ketchup</option>
                                                <option data-icon="la la-calendar-check-o">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner"><i class=" la la-bullhorn"></i> Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Custom Content</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                <option data-content="<span class='badge badge--success badge--inline badge--rounded'>Relish</span>">Mustard</option>
                                                <option data-content="<span class='badge badge--warning badge--inline badge--rounded'>Ketchup</span>">Ketchup</option>
                                                <option data-content="<span class='badge badge--brand badge--inline badge--rounded'>Relish</span>">Relish</option>
                                                <option data-content="<span class='badge badge--danger badge--inline badge--rounded'>Chili</span>">Chili</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Relish">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner"><span class="badge badge--success badge--inline badge--rounded">Relish</span></div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Subtext</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                <option data-subtext="French's">Mustard</option>
                                                <option data-subtext="Heinz">Ketchup</option>
                                                <option data-subtext="Sweet">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Select/deselect all options</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select show-tick form-control "><select class="form-control selectpicker" multiple="" data-actions-box="true" tabindex="-98">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                                <option>Mayonnaise</option>
                                                <option>Barbecue Sauce</option>
                                                <option>Salad Dressing</option>
                                                <option>Tabasco</option>
                                                <option>Salsa</option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                                <option>Mayonnaise</option>
                                                <option>Barbecue Sauce</option>
                                                <option>Salad Dressing</option>
                                                <option>Tabasco</option>
                                                <option>Salsa</option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                                <option>Mayonnaise</option>
                                                <option>Barbecue Sauce</option>
                                                <option>Salad Dressing</option>
                                                <option>Tabasco</option>
                                                <option>Salsa</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-light" data-toggle="dropdown" role="button" title="Nothing selected">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Nothing selected</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="bs-actionsbox">
                                                    <div class="btn-group btn-group-sm btn-block"><button type="button" class="actions-btn bs-select-all btn btn-light">Select All</button><button type="button" class="actions-btn bs-deselect-all btn btn-light">Deselect All</button></div>
                                                </div>
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Divider</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                <option data-subtext="French's">Mustard</option>
                                                <option data-subtext="Heinz">Ketchup</option>
                                                <option data-divider="true"></option>
                                                <option data-subtext="Sweet">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Menu Header</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" data-header="Select an option" tabindex="-98">
                                                <option data-subtext="French's">Mustard</option>
                                                <option data-subtext="Heinz">Ketchup</option>
                                                <option data-subtext="Sweet">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="popover-header"><button type="button" class="close" aria-hidden="true">×</button>Select an option</div>
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Disabled</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select disabled form-control "><select class="form-control selectpicker" disabled="" tabindex="-98">
                                                <option data-subtext="French's">Mustard</option>
                                                <option data-subtext="Heinz">Ketchup</option>
                                                <option data-subtext="Sweet">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle disabled btn-light" data-toggle="dropdown" role="button" tabindex="-1" aria-disabled="true" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Disabled Options</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                <option data-subtext="French's">Mustard</option>
                                                <option data-subtext="Heinz" disabled="">Ketchup</option>
                                                <option data-subtext="Sweet">Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Button States</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <div class="dropdown bootstrap-select form-control  dropup"><select class="form-control selectpicker" title="Success" data-style="btn-success" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-success" data-toggle="dropdown" role="button" title="Success" aria-expanded="false">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Success</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu" role="combobox" style="max-height: 1883.95px; overflow: hidden; min-height: 0px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -3px, 0px);" x-placement="top-start">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1" style="max-height: 1857.95px; overflow-y: auto; min-height: 0px;">
                                                    <ul class="dropdown-menu inner show">
                                                        <li><a role="option" class="dropdown-item" aria-disabled="false" tabindex="0" aria-selected="false"><span class="text">Mustard</span></a></li>
                                                        <li><a role="option" class="dropdown-item" aria-disabled="false" tabindex="0" aria-selected="false"><span class="text">Ketchup</span></a></li>
                                                        <li><a role="option" class="dropdown-item" aria-disabled="false" tabindex="0" aria-selected="false"><span class="text">Relish</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" title="Warning" data-style="btn-warning" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-warning" data-toggle="dropdown" role="button" title="Warning">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Warning</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" title="Danger" data-style="btn-danger" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-danger" data-toggle="dropdown" role="button" title="Danger">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Danger</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" title="Brand" data-style="btn-brand" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-brand" data-toggle="dropdown" role="button" title="Brand">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Brand</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-10"></div>
                                        <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" title="Primary" data-style="btn-primary" tabindex="-98">
                                                <option class="bs-title-option" value=""></option>
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle bs-placeholder btn-primary" data-toggle="dropdown" role="button" title="Primary">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Primary</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <a href="" class="btn btn-success btn btn--pill" data-toggle="modal" data-target="#select_modal">Launch modal examples</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card__foot">
                                <div class="form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="reset" class="btn btn-brand">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::card-->
                    <!--begin::Modal-->
                    <div class="modal fade" id="select_modal" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Bootstrap Touchspin Examples</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="la la-remove"></span>
                                    </button>
                                </div>
                                <form class="form form--label-right">
                                    <div class="modal-body">
                                        <div class="form-group row margin-t-20">
                                            <label class="col-form-label col-lg-3 col-sm-12">Standard Input</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <input type="text" class="form-control" value="Some value">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Minimum Setup</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                        <option>Mustard</option>
                                                        <option>Ketchup</option>
                                                        <option>Relish</option>
                                                    </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                        <div class="filter-option">
                                                            <div class="filter-option-inner">
                                                                <div class="filter-option-inner-inner">Mustard</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="dropdown-menu " role="combobox">
                                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                            <ul class="dropdown-menu inner show"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Optgroups Example</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" tabindex="-98">
                                                        <optgroup label="Picnic" data-max-options="2">
                                                            <option>Mustard</option>
                                                            <option>Ketchup</option>
                                                            <option>Relish</option>
                                                        </optgroup>
                                                        <optgroup label="Camping" data-max-options="2">
                                                            <option>Tent</option>
                                                            <option>Flashlight</option>
                                                            <option>Toilet Paper</option>
                                                        </optgroup>
                                                    </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                        <div class="filter-option">
                                                            <div class="filter-option-inner">
                                                                <div class="filter-option-inner-inner">Mustard</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="dropdown-menu " role="combobox">
                                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                            <ul class="dropdown-menu inner show"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="form-text text-muted">Select boxes with optgroups</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Multiple Select</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row margin-b-20">
                                            <label class="col-form-label col-lg-3 col-sm-12">Live Search</label>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="dropdown bootstrap-select form-control "><select class="form-control selectpicker" data-live-search="true" tabindex="-98">
                                                        <option>Hot Dog, Fries and a Soda</option>
                                                        <option>Burger, Shake and a Smile</option>
                                                        <option>Sugar, Spice and all things nice</option>
                                                    </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Hot Dog, Fries and a Soda">
                                                        <div class="filter-option">
                                                            <div class="filter-option-inner">
                                                                <div class="filter-option-inner-inner">Hot Dog, Fries and a Soda</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div class="dropdown-menu " role="combobox">
                                                        <div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div>
                                                        <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                            <ul class="dropdown-menu inner show"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="form-text text-muted">You can add a search input by passing <code>data-live-search="true"</code> attribute</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-brand btn" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-secondary btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    <!--begin::card-->
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title">
                                    Validation State Examples
                                </h3>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="form form--label-right">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Success State</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12 validate">
                                        <div class="dropdown bootstrap-select form-control is-valid "><select class="form-control is-valid selectpicker" tabindex="-98">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="valid-feedback">Success! You've done it.</div>
                                        <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Warning State</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12 validate">
                                        <div class="dropdown bootstrap-select form-control is-invalid "><select class="form-control is-invalid selectpicker" tabindex="-98">
                                                <option>Mustard</option>
                                                <option>Ketchup</option>
                                                <option>Relish</option>
                                            </select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="button" title="Mustard">
                                                <div class="filter-option">
                                                    <div class="filter-option-inner">
                                                        <div class="filter-option-inner-inner">Mustard</div>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="dropdown-menu " role="combobox">
                                                <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                                    <ul class="dropdown-menu inner show"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
                                        <span class="form-text text-muted">Example help text that remains unchanged.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card__foot">
                                <div class="form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="reset" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::card-->
                </div>
                <!-- end:: Content -->
            </div>
        </div>


        <?php
  include 'includes/footer.php';
?>
        <script src="js/vendors/bootstrap-select.min.js"></script>
    </div>

</body>


</html>