<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
    <meta charset="utf-8" />
    <title>FATbit | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
    
    <link rel="shortcut icon" href="../images/favicon.ico" />
</head>



<body class="">
    <div class="wrapper">

        <?php
  include 'includes/header.php';
?>
        <div class="body grid__item grid__item--fluid grid grid--hor grid--stretch" id="body">
            <div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">
                <!-- begin:: Subheader -->
                <div class="subheader   grid__item" id="subheader">
                    <div class="container ">
                        <div class="subheader__main">
                            <h3 class="subheader__title">Products</h3>
                            <div class="subheader__breadcrumbs">
                                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Crud </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    YKDatatable </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Base </a>
                                <span class="subheader__breadcrumbs-separator"></span>
                                <a href="" class="subheader__breadcrumbs-link">
                                    Local Data </a>
                            </div>
                        </div>
                        <div class="subheader__toolbar">
                            <div class="subheader__wrapper">
                                <a href="#" class="btn btn-clean btn-icon-sm"><i class="la la-long-arrow-left"></i>Back</a>
                                <a href="#" class="btn btn-danger subheader__btn-options">Add Products</a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="container  grid__item grid__item--fluid">

                    <div class="card card--tabs">
                        <div class="card-head">
                            <div class="card-head-toolbar">
                                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#card_base_demo_1_1_tab_content" role="tab" aria-selected="false">
                                            All
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#card_base_demo_1_2_tab_content" role="tab" aria-selected="true">Custom Search
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Search Form -->
                            <div class="form form--label-right margin-t-20 margin-b-10">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Filters
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                    <div role="separator" class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="" placeholder="Search by Name, Brand, Categories, Collections and Description">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <tags class="tagify" aria-haspopup="true" aria-expanded="false" role="tagslist">
                                        <tag title="css" contenteditable="false" spellcheck="false" class="tagify__tag tagify--noAnim" role="tag" value="css">
                                            <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
                                            <div><span class="tagify__tag-text">css</span></div>
                                        </tag>
                                        <tag title="html" contenteditable="false" spellcheck="false" class="tagify__tag tagify--noAnim" role="tag" value="html">
                                            <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
                                            <div><span class="tagify__tag-text">html</span></div>
                                        </tag>
                                        <tag title="javascript" contenteditable="false" spellcheck="false" class="tagify__tag tagify--noAnim" role="tag" value="javascript">
                                            <x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
                                            <div><span class="tagify__tag-text">javascript</span></div>
                                        </tag><span contenteditable="" data-placeholder="type..." aria-placeholder="type..." class="tagify__input" role="textbox" aria-multiline="false"></span>
                                    </tags>
                                </div>




                            </div>
                            <!--end: Search Form -->
                        </div>

                        <div class="separator separator--border-dashed separator--space-sm"></div>
                        <div class="card-body card__body--fit">
                            <!--begin: Datatable -->
                            <div class="datatable datatable--default datatable--brand datatable--loaded" id="local_data">
                                <table class="datatable__table" width="100%">
                                    <thead class="datatable__head">
                                        <tr class="datatable__row">
                                            <th width="20" class="datatable__cell--center datatable__cell datatable__cell--check">
                                                <span style="width:20px;"><label class="checkbox checkbox--single checkbox--all checkbox--solid"><input type="checkbox">&nbsp;<span></span></label></span>
                                            </th>
                                            <th class="datatable__cell datatable__cell--sort"><span>Name</span></th>
                                            <th class="datatable__cell datatable__cell--sort datatable__cell--sorted"><span>Inventory <i class="flaticon2-arrow-up"></i> </span></th>

                                            <th class="datatable__cell datatable__cell--sort"><span>Price</span></th>
                                            <th class="datatable__cell datatable__cell--sort"><span>Publish</span></th>
                                            <th class="datatable__cell"><span>Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="datatable__body">
                                        <tr class="datatable__row">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width:20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>
                                            <td class="datatable__cell">
                                                <div class="d-flex">
                                                    <span>Apple phone</span>
                                                    <div class="dropdown dropdown-inline ml-2">
                                                        <a href="#" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-angle-down"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="#" class="dropdown-item d-flex justify-content-between">Product Yellow <span class="badge badge--unified-brand badge--inline badge--pill">10</span> </a>

                                                            <a href="#" class="dropdown-item d-flex justify-content-between">Product Black <span class="badge badge--unified-brand  badge--inline badge--pill">548</span> </a> <a href="#" class="dropdown-item d-flex justify-content-between">Product Black <span class="badge badge--unified-brand  badge--inline badge--pill">55</span> </a> <a href="#" class="dropdown-item d-flex justify-content-between">Product Black <span class="badge badge--unified-brand  badge--inline badge--pill">9336</span> </a>




                                                        </div>
                                                    </div>
                                                </div>







                                            </td>
                                            <td class="datatable__cell"><span>706</span></td>
                                            <td class="datatable__cell"><span>$10000</span></td>
                                            <td class="datatable__cell"><span class="switch switch--sm">
                                                    <label>
                                                        <input type="checkbox" checked="checked" name="">
                                                        <span></span>
                                                    </label>
                                                </span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Duplicate</a>
                                                            <a href="#" class="dropdown-item">View</a>
                                                            <a href="#" class="dropdown-item">View Review</a>
                                                        </div>
                                                    </div>
                                                    <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a>

                                                    <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr class="datatable__row datatable__row--even">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width:20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>


                                            <td class="datatable__cell"><span>Apple phone</span></td>
                                            <td class="datatable__cell"><span>706</span></td>
                                            <td class="datatable__cell"><span>$10000</span></td>
                                            <td class="datatable__cell"><span class="switch switch--sm">
                                                    <label>
                                                        <input type="checkbox" checked="checked" name="">
                                                        <span></span>
                                                    </label>
                                                </span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Duplicate</a>
                                                            <a href="#" class="dropdown-item">View</a>
                                                            <a href="#" class="dropdown-item">View Review</a>
                                                        </div>
                                                    </div>
                                                    <a title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-edit"></i> </a>

                                                    <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"> <i class="la la-trash"></i> </a>
                                                </span></td>
                                        </tr>
                                        <tr class="datatable__row">
                                            <td class="datatable__cell--center datatable__cell datatable__cell--check" data-field="RecordID"><span style="width:20px;"><label class="checkbox checkbox--single checkbox--solid"><input type="checkbox" value="1">&nbsp;<span></span></label></span></td>
                                            <td class="datatable__cell"><span>Apple phone</span></td>
                                            <td class="datatable__cell"><span>706</span></td>
                                            <td class="datatable__cell"><span>$10000</span></td>
                                            <td class="datatable__cell"><span class="switch switch--sm">
                                                    <label>
                                                        <input type="checkbox" checked="checked" name="">
                                                        <span></span>
                                                    </label>
                                                </span></td>
                                            <td data-field="Actions" data-autohide-disabled="false" class="datatable__cell"><span style="overflow: visible; position: relative; width: 110px;">
                                                    <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md" aria-expanded="false"> <i class="la la-ellipsis-h"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                                            <a href="#" class="dropdown-item">Duplicate</a>
                                                            <a href="#" class="dropdown-item">View</a>
                                                            <a href="#" class="dropdown-item">View Review</a>
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