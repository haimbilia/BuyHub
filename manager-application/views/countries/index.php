<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onsubmit', 'frmSrchCountry(this); return(false);');
$frmSrch->setFormTagAttribute('id', 'frmSearch');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 6;

$keyword  = $frmSrch->getField('keyword');
$keyword->addFieldtagAttribute('class', 'form-control');
$keyword->setFieldtagAttribute('type', 'search');
$keyword->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_Search', $adminLangId));
$frmSrch->getField('btn_clear')->addFieldtagAttribute('onclick', 'clearSearch();');
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form class="form" action="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <?php echo $frmSrch->getFieldHTML('keyword'); ?>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-brand btn-wide">Search</button>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-link" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Advanced
                                        Search</a>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="separator separator-dashed my-4"></div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Keyword</label>
                                            <input data-field-caption="Keyword" data-fatreq="{&quot;required&quot;:false}" type="text" name="keyword" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">From
                                                [USD]</label>
                                            <input data-field-caption="From [USD]" data-fatreq="{&quot;required&quot;:false,&quot;floating&quot;:true,&quot;range&quot;:{&quot;minval&quot;:0,&quot;maxval&quot;:9999999999,&quot;numeric&quot;:true}}" type="text" name="minprice" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">To
                                                [USD]</label>
                                            <input data-field-caption="To [USD]" data-fatreq="{&quot;required&quot;:false,&quot;floating&quot;:true,&quot;range&quot;:{&quot;minval&quot;:0,&quot;maxval&quot;:9999999999,&quot;numeric&quot;:true}}" type="text" name="maxprice" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Status</label>
                                            <select data-field-caption="Status" data-fatreq="{&quot;required&quot;:false}" name="status">
                                                <option value="-1">Does not matter</option>
                                                <option value="0">Withdrawal Request Pending
                                                </option>
                                                <option value="1">Withdrawal Request Completed
                                                </option>
                                                <option value="2">Withdrawal Request Approved
                                                </option>
                                                <option value="3">Withdrawal Request Declined
                                                </option>
                                                <option value="4">Withdrawal Request Processed
                                                </option>
                                                <option value="5">Withdrawal Request Payout
                                                    Failed
                                                </option>
                                                <option value="6">Withdrawal Request Payout
                                                    Unclamed
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Date
                                                From</label>
                                            <input readonly="readonly" class="field--calender fld-date hasDatepicker" data-field-caption="Date From" id="date_from_1630320541_71" data-fatdateformat="yy-mm-dd" data-fatreq="{&quot;required&quot;:false}" type="text" name="date_from" value="">


                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">Date To</label>
                                            <input readonly="readonly" class="field--calender fld-date hasDatepicker" data-field-caption="Date To" id="date_to_1630320541_93" data-fatdateformat="yy-mm-dd" data-fatreq="{&quot;required&quot;:false}" type="text" name="date_to" value="">


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="label">User
                                                Type</label>
                                            <select data-field-caption="User Type" data-fatreq="{&quot;required&quot;:false}" name="type">
                                                <option value="-1" selected="selected">Does Not
                                                    Matter</option>
                                                <option value="1">Buyer</option>
                                                <option value="2">Seller</option>
                                                <option value="4">Advertiser</option>
                                                <option value="3">Affiliate</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-head">
                        <h3 class="card-head-label">
                            <span class="card-head-title">New Products</span>
                            <span class="text-muted">Over 500 new products</span>
                        </h3>
                        <div class="card-toolbar">

                            <button type="button" class="btn btn-sm btn-icon btn-color-brand btn-active-light-brand" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000">
                                            </rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>

                            </button>
                            <!--begin::Menu 1-->
                            <div class="dropdown-menu dropdown-menu-anim form" data-kt-menu="true" id="kt_menu_6124ed05a962e" style="">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->
                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">Status:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid select2-hidden-accessible" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_6124ed05a962e" data-allow-clear="true" data-select2-id="select2-data-10-uonl" tabindex="-1" aria-hidden="true">
                                                <option data-select2-id="select2-data-12-jhnm"></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr" data-select2-id="select2-data-11-ybvm" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single form-select form-select-solid" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-2txw-container" aria-controls="select2-2txw-container"><span class="select2-selection__rendered" id="select2-2txw-container" role="textbox" aria-readonly="true" title="Select option"><span class="select2-selection__placeholder">Select
                                                                option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">Member Type:</label>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1">
                                                <span class="form-check-label">Author</span>
                                            </label>
                                            <!--end::Options-->
                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                                <span class="form-check-label">Customer</span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">Notifications:</label>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked">
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                        <!--end::Switch-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Menu-->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-dashed">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Full Name</th>
                                        <th>Order Date</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-success">Approved</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-warning">In Progress</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-danger">Success</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-info">Rejected</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-primary">Approved</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-info">Pending</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">


                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>

                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                                        </svg>
                                                    </a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>110</td>
                                        <td><a target="_blank" href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                        </td>
                                        <td><a href="javascript:void(0)" onclick="redirectfunc(&quot;/yokart/admin/users&quot;, 4)">Michael
                                                Williams</a><br>login@dummyid.com</td>
                                        <td>17/08/2021 15:45</td>
                                        <td>$4,000.00</td>
                                        <td><span class="badge badge-info">Pending</span></td>
                                        <td>
                                            <ul class="actions">
                                                <li><a href="#" class="" title="Edit">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="" title="Product Info" 0="1">
                                                        <svg class="svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
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
                    <div class="card-foot">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="select-length">
                                    <select name="" class="custom-select form-select">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <ul class="pagination">
                                    <li class="prev">
                                        <a href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                                    </li>
                                    <li><a href="javascript:void(0);">1</a></li>
                                    <li class="selected"><a href="javascript:void(0);">2</a></li>
                                    <li><a href="javascript:void(0);">...</a></li>
                                    <li class="next"><a href="javascript:void(0);">
                                            <i class="fa fa-angle-right"></i>
                                        </a></li>
                                    <li class="forward"><a href="javascript:void(0);">
                                            <i class="fa fa-angle-right"></i>
                                            <i class="fa fa-angle-right"></i>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="empty-stats">
                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-data-cuate.svg" alt="">

                            <div class="data">
                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                    consectetur, adipisci velit...</h6>

                            </div>
                        </div>


                    </div>


                </div>
                <form class="form">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-title">
                                <h3 class="card-head-label"> <span class="card-head-title">Card title
                                        goes here</span></h3>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Language</label>
                                        <select onchange="addShopLangForm(5, this.value);" data-field-caption="Language" data-fatreq="{&quot;required&quot;:false}" name="lang_id">
                                            <option value="1" selected="selected">English</option>
                                            <option value="2">Arabic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Shop
                                            Name<span class="required">*</span>
                                        </label>
                                        <input data-field-caption="Shop Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="shop_name" value="Jason's Store">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Shop City</label>

                                        <input data-field-caption="Shop City" data-fatreq="{&quot;required&quot;:false}" type="text" name="shop_city" value="phoenix">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Contact Person</label>
                                        <input data-field-caption="Contact Person" data-fatreq="{&quot;required&quot;:false}" type="text" name="shop_contact_person" value="Jason">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="label">Description</label>

                                        <textarea data-field-caption="Description" data-fatreq="{&quot;required&quot;:false}" name="shop_description">Best range of products in the United States</textarea>

                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="card-foot">
                            <div class="row">
                                <div class="col"><button type="reset" class="btn btn-outline-brand">Discard</button>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

    </div>
</main>