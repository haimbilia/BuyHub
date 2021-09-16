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

                <div class="modal fixed-right fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
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
                                        <div class="empty-stats">
                                            <img src="<?php echo CONF_WEBROOT_URL;?>images/retina/no-data-cuate.svg"
                                                alt="">

                                            <div class="data">
                                                <h6>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                                    consectetur, adipisci velit...</h6>

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
                            <div class="col-md-12">
                                <form class="form" action="#">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="search" class="form-control" name="search" value=""
                                                        placeholder="Search">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-brand btn-block">Search</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn btn-link" data-toggle="collapse"
                                                        href="#collapseExample" aria-expanded="false"
                                                        aria-controls="collapseExample">Advanced
                                                        Search</a>
                                                </div>
                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <div class="separator separator-dashed my-4"></div>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">From
                                                                [USD]</label>
                                                            <input data-field-caption="From [USD]"
                                                                data-fatreq="{&quot;required&quot;:false,&quot;floating&quot;:true,&quot;range&quot;:{&quot;minval&quot;:0,&quot;maxval&quot;:9999999999,&quot;numeric&quot;:true}}"
                                                                type="text" name="minprice" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">To
                                                                [USD]</label>
                                                            <input data-field-caption="To [USD]"
                                                                data-fatreq="{&quot;required&quot;:false,&quot;floating&quot;:true,&quot;range&quot;:{&quot;minval&quot;:0,&quot;maxval&quot;:9999999999,&quot;numeric&quot;:true}}"
                                                                type="text" name="maxprice" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">Status</label>
                                                            <select data-field-caption="Status"
                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                name="status">
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">Date
                                                                From</label>
                                                            <input readonly="readonly"
                                                                class="field--calender fld-date hasDatepicker"
                                                                data-field-caption="Date From"
                                                                id="date_from_1630320541_71"
                                                                data-fatdateformat="yy-mm-dd"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="date_from" value="">


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">Date To</label>
                                                            <input readonly="readonly"
                                                                class="field--calender fld-date hasDatepicker"
                                                                data-field-caption="Date To" id="date_to_1630320541_93"
                                                                data-fatdateformat="yy-mm-dd"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="date_to" value="">


                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="label">User
                                                                Type</label>
                                                            <select data-field-caption="User Type"
                                                                data-fatreq="{&quot;required&quot;:false}" name="type">
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
                                            <a href="#" class="btn btn-sm btn-light btn-light">

                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                            rx="1" transform="rotate(-90 11.364 20.364)" fill="black">
                                                        </rect>
                                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                            fill="black"></rect>
                                                    </svg>
                                                </span>
                                                New
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-dashed">
                                                <thead>
                                                    <tr>
                                                        <th class="">
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </th>
                                                        <th class="sorting">#</th>
                                                        <th class="sorting">Order Id</th>
                                                        <th class="sorting">Full Name</th>
                                                        <th class="sorting">Order Date</th>
                                                        <th class="sorting">Amount</th>
                                                        <th class="sorting">Payment Status</th>
                                                        <th class="align-right">ACtion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>

                                                        </td>
                                                        <td>110</td>
                                                        <td>
                                                            <div class="order-num">
                                                                <a target="_blank"
                                                                    href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_7.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <p class="date"> 17/08/2021
                                                                <time>15:45</time>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <span class="amount">$4,000.00</span>
                                                        </td>
                                                        <td><span class="badge badge-success">Approved</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>
                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_1.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">
                                                                        Jessie Clarcson</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-warning">In Progress</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>

                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_2.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-danger">Success</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>
                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_3.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-info">Rejected</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>
                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_4.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-primary">Approved</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>
                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_5.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-info">Pending</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label class="checkbox">
                                                                <input type="checkbox" value="1">
                                                            </label>
                                                        </td>
                                                        <td>110</td>
                                                        <td><a target="_blank"
                                                                href="/yokart/admin/orders/view/O5932791969">O5932791969</a>
                                                        </td>
                                                        <td>
                                                            <div class="user-profile">
                                                                <figure class="user-profile_photo">
                                                                    <img src="/yokart/manager/images/users/100_6.jpg"
                                                                        alt="image">
                                                                </figure>
                                                                <div class="user-profile_data">
                                                                    <a class="user-profile_title"
                                                                        href="javascript:void(0)">Michael Williams</a>
                                                                    <span
                                                                        class="text-muted fw-bold">login@dummyid.com</span>

                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>17/08/2021 15:45</td>
                                                        <td>$4,000.00</td>
                                                        <td><span class="badge badge-info">Pending</span></td>
                                                        <td class="align-right">
                                                            <ul class="actions">
                                                                <li>

                                                                    <a href="#" data-toggle="modal" data-target="#edit"
                                                                        title="Edit">


                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                fill="black"></path>
                                                                            <path
                                                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                fill="black"></path>
                                                                        </svg>

                                                                    </a>
                                                                </li>
                                                                <li><a href="javascript:void(0)" class=""
                                                                        title="Product Info" 0="1">
                                                                        <svg class="svg"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black"></path>
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black"></path>
                                                                        </svg>
                                                                    </a></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="card-foot">
                                        <div class="row justify-content-between">
                                            <div class="col">
                                                <div class="data-length">
                                                    <select name="" class="form-select data-length-select">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    <div class="data-length-info"></div> Showing 1 to 10 of 29 records
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <ul class="pagination">
                                                    <li class="prev">
                                                        <a href="javascript:void(0);"> </a>
                                                    </li>
                                                    <li><a href="javascript:void(0);">1</a></li>
                                                    <li class="selected"><a href="javascript:void(0);">2</a></li>
                                                    <li><a href="javascript:void(0);">...</a></li>
                                                    <li class="next"><a href="javascript:void(0);"> </a>
                                                    </li>

                                                </ul>
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
                                                            <select onchange="addShopLangForm(5, this.value);"
                                                                data-field-caption="Language"
                                                                data-fatreq="{&quot;required&quot;:false}"
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
                                                                data-fatreq="{&quot;required&quot;:true}" type="text"
                                                                name="shop_name" value="Jason's Store">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Shop City</label>

                                                            <input data-field-caption="Shop City"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_city" value="phoenix">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Contact Person</label>
                                                            <input data-field-caption="Contact Person"
                                                                data-fatreq="{&quot;required&quot;:false}" type="text"
                                                                name="shop_contact_person" value="Jason">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="label">Description</label>

                                                            <textarea data-field-caption="Description"
                                                                data-fatreq="{&quot;required&quot;:false}"
                                                                name="shop_description">Best range of products in the United States</textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-edit-foot">
                                                <div class="row">
                                                    <div class="col"><button type="reset"
                                                            class="btn btn-outline-brand">Discard</button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit"
                                                            class="btn btn-brand gb-btn gb-btn-primary ">Update</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </form>


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