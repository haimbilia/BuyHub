<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
	<meta charset="utf-8" />
	<title>FATbit | Dashboard</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	
	
	<link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
	
	<link rel="shortcut icon" href="images/favicon.ico" />
	 
</head>



<body class="">
	<div class="wrapper">
		<?php
  include 'includes/header.php';
?>
		<div class="body " id="body">
											<div class="content " id="content">
							
<!-- begin:: Subheader -->
<div class="subheader   grid__item" id="subheader">
	<div class="container ">
	    <div class="subheader__main">
		    <h3 class="subheader__title">
				
				BlockUI			</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Components	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Extended	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Block UI	                    </a>
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
	<div class="container">
		<div class="row">
    <div class="col">
        <div class="alert alert-light alert-elevate fade show" role="alert">
            <div class="alert-icon"><i class="flaticon-warning font-brand"></i></div>
            <div class="alert-text">
                The jQuery BlockUI Plugin lets you simulate synchronous behavior when using AJAX, without locking the browser.
                <br>
                For more info please visit the plugin's <a class="link font-bold" href="http://jquery.malsup.com/block/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/malsup/blockui/" target="_blank">Github Repo</a>.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <!--begin::card-->
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Basic Examples
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Click below buttons to block below content area:
                    </span>
                    <div class="section__content">
                        <p style="padding: 20px; margin: 10px 0 30px 0; border: 4px solid #efefef" id="blockui_1_content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Inceptos imperdiet magna! Sed fusce fames tempus litora venenatis ad: Ac aliquet leo hendrerit taciti viverra? Nisl suscipit potenti accumsan quis ipsum purus cursus. Suspendisse ultrices morbi in purus lectus dictum porta; Commodo penatibus nec.
                        </p>
                        <button type="button" class="btn btn-success" id="blockui_1_1">Default</button>
                        <button type="button" class="btn btn-brand" id="blockui_1_2">Overlay color</button>
                        <button type="button" class="btn btn-primary" id="blockui_1_3">Custom spinner</button>
                        <button type="button" class="btn btn-info" id="blockui_1_4">Custom text 1</button>
                        <button type="button" class="btn btn-danger" id="blockui_1_5">Custom text 2</button>
                    </div>
                </div>
                <!--end::Section-->

                <div class="separator separator--dashed"></div>
            </div>
        </div>
        <!--end::card-->

        <!--begin::card-->
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Modal Blocking
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Click below buttons to block modal content:
                    </span>
                    <div class="section__content">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#blockui_4_1_modal">Default</button>
                        <button type="button" class="btn btn-brand" data-toggle="modal" data-target="#blockui_4_2_modal">Overlay color</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#blockui_4_3_modal">Custom spinner</button>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#blockui_4_4_modal">Custom text 1</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#blockui_4_5_modal">Custom text 2</button>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->
    </div>
    <div class="col-xl-6">
        <!--begin::card-->
        <div class="card" id="blockui_2_card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        card Blocking
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Click below buttons to block this card:
                    </span>
                    <div class="section__content">
                        <button type="button" class="btn btn-success" id="blockui_2_1">Default</button>
                        <button type="button" class="btn btn-brand" id="blockui_2_2">Overlay color</button>
                        <button type="button" class="btn btn-primary" id="blockui_2_3">Custom spinner</button>
                        <button type="button" class="btn btn-info" id="blockui_2_4">Custom text 1</button>
                        <button type="button" class="btn btn-danger" id="blockui_2_5">Custom text 2</button>
                    </div>
                </div>
                <!--end::Section-->

                <div class="separator separator--dashed"></div>
            </div>
        </div>
        <!--end::card-->

        <!--begin::card-->
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Page Blocking
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Click below buttons to block current page:
                    </span>
                    <div class="section__content">
                        <button type="button" class="btn btn-success" id="blockui_3_1">Default</button>
                        <button type="button" class="btn btn-brand" id="blockui_3_2">Overlay color</button>
                        <button type="button" class="btn btn-primary" id="blockui_3_3">Custom spinner</button>
                        <button type="button" class="btn btn-info" id="blockui_3_4">Custom text 1</button>
                        <button type="button" class="btn btn-danger" id="blockui_3_5">Custom text 2</button>
                    </div>
                </div>
                <!--end::Section-->

                <div class="separator separator--dashed"></div>
            </div>
        </div>
        <!--end::card-->
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="blockui_4_1_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="blockui_4_1">Block modal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="blockui_4_2_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="blockui_4_2">Block modal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="blockui_4_3_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="blockui_4_3">Block modal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="blockui_4_4_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="blockui_4_4">Block modal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="blockui_4_5_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="blockui_4_5">Block modal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->	</div>
<!-- end:: Content -->						</div>
									</div>

		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>