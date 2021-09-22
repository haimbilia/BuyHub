<!DOCTYPE html>
<html lang="en" data-theme="dark" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />
</head>



<body class="subheader--transparent page--loading">
    <div class="wrapper">

        <?php
  include 'includes/header.php';
?>
        <div class="body" id="body">
            <div class="content " id="content">
                <!-- begin:: Subheader -->
                <div id="subheader" class="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Tax Rules</h3>
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
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-light alert-elevate fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning font-info"></i></div>
                                <div class="alert-text">Use this section to manage categories within the system. Click on the category item to edit. Categories can be dragged to re-order.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::card-->
                            <div class="card">
                                <div class="card-head">
                                    <div class="card-head-label">
                                        <h3 class="card-head-title">Tax Rules</h3>
                                    </div>
                                    <div class="card-head-toolbar">
                                        <div class="card-head-actions">
                                            <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-brand">
                                                <i class="la la-plus"></i> Add</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body card__body--fit">
                                    <!--begin: Datatable -->
                                    <div class="datatable datatable--default datatable--brand datatable--loaded" id="local_data">
                                        <table class="datatable__table" width="100%">
                                            <thead class="datatable__head">
                                                <tr class="datatable__row">
                                                    <th width="20" class="datatable__cell--center datatable__cell datatable__cell--check">
                                                        <span style="width:20px;"><label class="checkbox checkbox--single checkbox--all checkbox--solid"><input type="checkbox">&nbsp;<span></span></label></span>
                                                    </th>
                                                    <th class="datatable__cell datatable__cell--sort"><span>Summary</span></th>
                                                    <th class="datatable__cell"><span>Actions</span></th>
                                                </tr>
                                            </thead>
                                            <tbody class="datatable__body">

                                                <tr class="datatable__row datatable__row--even">
                                                    <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width:20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>


                                                    <td class="datatable__cell">
                                                        
                                                        <div class="row">
                                                        <div class="col-lg-6"><span>GST- Himachal <br> Country</span></div>
                                                        <div class="col-lg-6"><ol>
                                                            <li><strong>CGST(9%)</strong> - <em>All States</em></li></ol></div>
                                                        </div>
                                                        
                                                        
                                                        
                                                    
                                                    
                                                    </td>
                                                    <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                            <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false"> <i class="la la-ellipsis-h"></i> </a>
                                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                                    <a href="#" class="dropdown-item">Duplicate</a>
                                                                    <a href="#" class="dropdown-item">Make Default</a>
                                                                    <a href="#" class="dropdown-item">View Logs</a>
                                                                </div>
                                                            </div>
                                                            <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a>

                                                            <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                        </span></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                        <div class="pagination  pagination--brand">
                                            <ul class="pagination__links">
                                                <li class="pagination__link--first">
                                                    <a href="#"><i class="fa fa-angle-double-left font-brand"></i></a>
                                                </li>
                                                <li class="pagination__link--next">
                                                    <a href="#"><i class="fa fa-angle-left font-brand"></i></a>
                                                </li>


                                                <li>
                                                    <a href="#">29</a>
                                                </li>
                                                <li>
                                                    <a href="#">30</a>
                                                </li>

                                                <li class="pagination__link--active">
                                                    <a href="#">31</a>
                                                </li>
                                                <li>
                                                    <a href="#">32</a>
                                                </li>


                                                <li class="pagination__link--prev">
                                                    <a href="#"><i class="fa fa-angle-right font-brand"></i></a>
                                                </li>
                                                <li class="pagination__link--last">
                                                    <a href="#"><i class="fa fa-angle-double-right font-brand"></i></a>
                                                </li>
                                            </ul>
                                            <div class="pagination__toolbar mt-4 mt-md-0">
                                                <select class="form-control font-brand" style="width: 60px;">
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <span class="pagination__desc">
                                                    Displaying 10 of 230 records
                                                </span>
                                            </div>
                                        </div>



                                    </div>
                                    <!--end: Datatable -->
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