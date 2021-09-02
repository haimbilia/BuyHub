<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">

 
<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />
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
                            <h3 class="subheader__title">General profile</h3>
                            <div class="subheader__breadcrumbs">
                                <a javascript:void(0) class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Tax Rules </a>
                            </div>

                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="container grid__item grid__item--fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Name</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <div class="card-head-actions">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">

                                                <input type="" class="form-control" placeholder="Fragile products">
                                                <span class="form-text text-muted">Customers won’t see this.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::card-->

                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Products</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <div class="card-head-actions">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                               
                                               <div class="input-icon input-icon--left">
												<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
												 
												<span class="input-icon__icon input-icon__icon--left">
													<span><i class="la la-search"></i></span>
												</span>
											</div>
                                                
                                             
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="shape-bg-color-1 p-4 mt-4 rounded text-center">
                                    <div class="h4">No products</div>
                                    <span class="">Move products here from another profile to set up separate rates.</span></div>
                                    
                                    
                                    
                                </div>
                            </div>
                            <!--end::card-->






                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Shipping from</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <div class="card-head-actions">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto mr-3">
                                                    <i class="icon-svg btn btn-secondary btn-elevate btn-icon p-2">
                                                        <svg class="svg">
                                                            <use xlink:href="media/retina/sprite.svg#location" href="media/retina/sprite.svg#location"></use>
                                                        </svg>
                                                    </i>

                                                </div>
                                                <div class="col-auto">
                                                    <h6 class="font-bold">New delhi</h6>
                                                    <p class="mb-0">New delhi, 110056 new delhi, India</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto"><a href="#" title="" class="link font-bolder">Manage</a></div>
                                    </div>
                                </div>



                                <div class="separator  separator--border-solid separator--sm"></div>
                                <div class="card-body">
                                    <div class="row justify-content-between mb-4">
                                        <div class="col">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <h6 class="font-bold">Shipping to</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><a href="#" data-toggle="modal" data-target="#modal_create_zone" title="" class="link font-bolder">Create shipping zone</a></div>
                                    </div>
                                    <div class="row justify-content-between mb-4">
                                        <div class="col">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto mr-3">
                                                    <i class="btn btn-secondary btn-elevate btn-icon p-2"><img src="../media/flags/4x3/in.svg" alt=""></i>
                                                </div>
                                                <div class="col-auto">
                                                    <h6 class="font-bold">Domestic</h6>
                                                    <p class="mb-0">India</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                    <i class="la la-ellipsis-h"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                    <a href="#" class="dropdown-item">Edit zone</a>
                                                    <a href="#" class="dropdown-item">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Rate name</th>
                                                <th>Conditions</th>
                                                <th>Cost</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>priority</td>
                                                <td>—</td>
                                                <td>Free</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                            <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Edit rate</a>
                                                            <a href="#" class="dropdown-item">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Standard</td>
                                                <td>—</td>
                                                <td>$100</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                            <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Edit rate</a>
                                                            <a href="#" class="dropdown-item">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-bold btn-label-brand" data-toggle="modal" data-target="#modal_add_rate"><i class="la la-plus"></i> Add rate</button></div>
                                    </div>


                                </div>
                                <div class="separator  separator--border-solid separator--sm"></div>
                                <div class="card-body">
                                    <div class="row justify-content-between  mb-4">
                                        <div class="col">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto mr-3">
                                                    <i class="btn btn-secondary btn-elevate btn-icon p-2"><img src="../media/retina/world.svg" alt=""></i>
                                                </div>
                                                <div class="col-auto">
                                                    <h6 class="font-bold">Rest of World</h6>
                                                    <p class="mb-0">Rest of World</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                    <i class="la la-ellipsis-h"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                    <a href="#" class="dropdown-item">Edit zone</a>
                                                    <a href="#" class="dropdown-item">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Rate name</th>
                                                <th>Conditions</th>
                                                <th>Cost</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>priority</td>
                                                <td>—</td>
                                                <td>Free</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                            <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Edit rate</a>
                                                            <a href="#" class="dropdown-item">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Standard</td>
                                                <td>—</td>
                                                <td>$100</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="">
                                                            <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Edit rate</a>
                                                            <a href="#" class="dropdown-item">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-bold btn-label-brand"><i class="la la-plus"></i> Add rate</button></div>
                                    </div>
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
        <!--begin: Modal -->
        <div class="modal fade" id="modal_create_zone" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create zone</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body ">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Zone name</label>
                                        <input type="text" class="form-control" placeholder="" value="">
                                        <span class="form-text text-muted">Customers won’t see this.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-icon input-icon--left">
                                            <input type="text" class="form-control" placeholder="Search countries and regions" id="">
                                            <span class="input-icon__icon input-icon__icon--left">
                                                <span><i class="la la-search"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator  separator--border-solid separator--sm"></div>
                            <div class="accordion-country">
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col"><label class="checkbox checkbox--bold checkbox--brand">
                                                    <input type="checkbox">Rest of world<span></span>
                                                </label></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col"><label class="checkbox checkbox--bold checkbox--brand">
                                                    <input type="checkbox">Asia<span></span>
                                                </label></div>
                                        </div>

                                        <ul>
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/af.svg" alt="">
                                                            </i>Afghanistan<span></span>
                                                        </label></div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Bangladesh<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Bhutan<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row justify-content-between align-items-center">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>China<span></span>
                                                        </label></div>

                                                    <div class="col-auto">
                                                        <a href="#">0 of 31 provinces <i class="flaticon2-down-arrow"></i></a>
                                                    </div>
                                                </div>

                                                <ul>
                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Anhui<span></span>
                                                        </label>
                                                    </li>

                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Beijing<span></span>
                                                        </label>
                                                    </li>
                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Chongqing<span></span>
                                                        </label>
                                                    </li>
                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Fujian<span></span>
                                                        </label>
                                                    </li>
                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Gansu<span></span>
                                                        </label>
                                                    </li>
                                                    <li> <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox">Guangdong<span></span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Cocos (Keeling) Islands<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Cocos (Keeling) Islands<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Cocos (Keeling) Islands<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col">
                                                        <label class="checkbox checkbox--bold checkbox--brand">
                                                            <input type="checkbox"><i class="icn-flag">
                                                                <img src="../media/flags/4x3/ci.svg" alt="">
                                                            </i>Cocos (Keeling) Islands<span></span>
                                                        </label></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    <li>
                                        <div class="row">
                                            <div class="col"><label class="checkbox checkbox--bold checkbox--brand">
                                                    <input type="checkbox">Europe<span></span>
                                                </label></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Done</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end: Modal -->

        <!--begin: Modal -->
        <div class="modal fade" id="modal_add_rate" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add rate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="radio-list">
                                    <label class="radio">
                                        <input type="radio" name="radio1">Set up your own rates <span></span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="radio1">Use carrier or app to calculate rates <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="separator  separator--border-solid separator--md"></div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Rate name</label>
                                    <select class="form-control">
                                        <option>Standard</option>
                                        <option>Priority</option>
                                    </select>
                                    <span class="form-text text-muted">Customers will see this at checkout.</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="text" class="form-control" name="fname" placeholder="" value="">
                                </div>

                            </div>
                        </div>

                        <div class="mt-3"><a href="" class="link font-bolder">Add conditions</a></div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Done</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end: Modal -->

    </div>

</body>


</html>