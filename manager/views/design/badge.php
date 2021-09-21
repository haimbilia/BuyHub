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
				
				Badge			</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Components	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Custom	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Badge	                    </a>
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
                Metronic extends <code>Bootstrap Badge</code> component with a variety of options to provide uniquely looking Badge component that matches the Metronic's design standards.
                <br>
                For more info please visit the plugin's <a class="link font-bold" href="https://getbootstrap.com/docs/4.3/components/badge/" target="_blank">Documentation</a>.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
						<i class="la la-gear"></i>
					</span>
                    <h3 class="card-head-title">
					Basic Examples
					</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Basic state color badges 
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand">3</span>
                        <span class="badge badge--dark">4</span>
                        <span class="badge badge--primary">7</span>
                        <span class="badge badge--success">8</span>
                        <span class="badge badge--info">11</span>
                        <span class="badge badge--warning">2</span>
                        <span class="badge badge--danger">5</span>

                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Basic style examples 
                    </span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand">3</span>
                        <span class="badge badge--dark">4</span>
                        <span class="badge badge--primary  badge--inline badge--pill">new</span>
                        <span class="badge badge--success  badge--inline badge--pill">hot</span>
                        <span class="badge badge--info  badge--rounded">11</span>
                        <span class="badge badge--warning  badge--rounded">2</span>
                        <span class="badge badge--danger  badge--rounded">5</span>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->

        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
						<i class="la la-gear"></i>
					</span>
                    <h3 class="card-head-title">
					  Sizing &amp; Styles
					</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Medium size:
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--md">A</span>
                        <span class="badge badge--dark badge--md">B</span>
                        <span class="badge badge--primary badge--md">S</span>
                        <span class="badge badge--success badge--md">D</span>
                        <span class="badge badge--info badge--md">F</span>
                        <span class="badge badge--warning badge--md">R</span>
                        <span class="badge badge--danger badge--md">L</span>
                    </div>

                    <div class="separator separator--border-dashed"></div>

                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--md badge--rounded">A</span>
                        <span class="badge badge--dark badge--md badge--rounded">B</span>
                        <span class="badge badge--primary badge--md badge--rounded">S</span>
                        <span class="badge badge--success badge--md badge--rounded">D</span>
                        <span class="badge badge--info badge--md badge--rounded">F</span>
                        <span class="badge badge--warning badge--md badge--rounded">R</span>
                        <span class="badge badge--danger badge--md badge--rounded">L</span>
                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Large size
                    </span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--lg">A</span>
                        <span class="badge badge--dark badge--lg">B</span>
                        <span class="badge badge--primary badge--lg">S</span>
                        <span class="badge badge--success badge--lg">D</span>
                        <span class="badge badge--info badge--lg">F</span>
                        <span class="badge badge--warning badge--lg">R</span>
                        <span class="badge badge--danger badge--lg">L</span>
                    </div>

                    <div class="separator separator--border-dashed"></div>

                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--lg badge--rounded">A</span>
                        <span class="badge badge--dark badge--lg badge--rounded">B</span>
                        <span class="badge badge--primary badge--lg badge--rounded">S</span>
                        <span class="badge badge--success badge--lg badge--rounded">D</span>
                        <span class="badge badge--info badge--lg badge--rounded">F</span>
                        <span class="badge badge--warning badge--lg badge--rounded">R</span>
                        <span class="badge badge--danger badge--lg badge--rounded">L</span>
                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Extra large size
                    </span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--xl">A</span>
                        <span class="badge badge--dark badge--xl">B</span>
                        <span class="badge badge--primary badge--xl">S</span>
                        <span class="badge badge--success badge--xl">D</span>
                        <span class="badge badge--info badge--xl">F</span>
                        <span class="badge badge--warning badge--xl">R</span>
                        <span class="badge badge--danger badge--xl">L</span>
                    </div>

                    <div class="separator separator--border-dashed"></div>

                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--xl badge--rounded">A</span>
                        <span class="badge badge--dark badge--xl badge--rounded">B</span>
                        <span class="badge badge--primary badge--xl badge--rounded">S</span>
                        <span class="badge badge--success badge--xl badge--rounded">D</span>
                        <span class="badge badge--info badge--xl badge--rounded">F</span>
                        <span class="badge badge--warning badge--xl badge--rounded">R</span>
                        <span class="badge badge--danger badge--xl badge--rounded">L</span>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->

        
        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="card-head-title">
                      Unified Styles
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
                        Circle and rounded unified styles:
                    </span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--unified-brand badge--lg badge--bold">A</span>
                        <span class="badge badge--unified-primary badge--lg badge--bold">S</span>
                        <span class="badge badge--unified-success badge--lg badge--bold">D</span>
                        <span class="badge badge--unified-info badge--lg badge--bold">F</span>
                        <span class="badge badge--unified-warning badge--lg badge--bold">R</span>
                        <span class="badge badge--unified-danger badge--lg badge--bold">L</span>
                    </div>

                    <div class="separator separator--border-dashed"></div>

                    <div class="section__content section__content--solid">
                        <span class="badge badge--unified-brand badge--lg badge--rounded badge--bold">A</span>
                        <span class="badge badge--unified-primary badge--lg badge--rounded badge--bold">S</span>
                        <span class="badge badge--unified-success badge--lg badge--rounded badge--bold">D</span>
                        <span class="badge badge--unified-info badge--lg badge--rounded badge--bold">F</span>
                        <span class="badge badge--unified-warning badge--lg badge--rounded badge--bold">R</span>
                        <span class="badge badge--unified-danger badge--lg badge--rounded badge--bold">L</span>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->
    </div>

    <div class="col-md-6">

        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
						<i class="la la-gear"></i>
					</span>
                    <h3 class="card-head-title">
					More Styles &amp; Options
					</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Square style badges:
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--square">3</span>
                        <span class="badge badge--dark badge--square">4</span>
                        <span class="badge badge--primary badge--square">7</span>
                        <span class="badge badge--success badge--square">8</span>
                        <span class="badge badge--info badge--square">11</span>
                        <span class="badge badge--warning badge--square">2</span>
                        <span class="badge badge--danger badge--square">5</span>

                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Dot style examples: 
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--dot badge--sm"></span>
                        <span class="badge badge--dark badge--dot badge--sm"></span>
                        <span class="badge badge--primary badge--dot badge--sm"></span>
                        <span class="badge badge--success badge--dot badge--sm"></span>
                        <span class="badge badge--info badge--dot badge--sm"></span>
                        <span class="badge badge--warning badge--dot badge--sm"></span>
                        <span class="badge badge--danger badge--dot badge--sm"></span>
                        <div class="space-20"></div>
                        
                        <span class="badge badge--brand badge--dot"></span>
                        <span class="badge badge--dark badge--dot"></span>
                        <span class="badge badge--primary badge--dot"></span>
                        <span class="badge badge--success badge--dot"></span>
                        <span class="badge badge--info badge--dot"></span>
                        <span class="badge badge--warning badge--dot"></span>
                        <span class="badge badge--danger badge--dot"></span>
                        <div class="space-20"></div>

                        
                        <span class="badge badge--brand badge--dot badge--lg"></span>
                        <span class="badge badge--dark badge--dot badge--lg"></span>
                        <span class="badge badge--primary badge--dot badge--lg"></span>
                        <span class="badge badge--success badge--dot badge--lg"></span>
                        <span class="badge badge--info badge--dot badge--lg"></span>
                        <span class="badge badge--warning badge--dot badge--lg"></span>
                        <span class="badge badge--danger badge--dot badge--lg"></span>
                        <div class="space-20"></div>

                        <span class="badge badge--brand badge--dot badge--xl"></span>
                        <span class="badge badge--dark badge--dot badge--xl"></span>
                        <span class="badge badge--primary badge--dot badge--xl"></span>
                        <span class="badge badge--success badge--dot badge--xl"></span>
                        <span class="badge badge--info badge--dot badge--xl"></span>
                        <span class="badge badge--warning badge--dot badge--xl"></span>
                        <span class="badge badge--danger badge--dot badge--xl"></span>
                        <div class="space-20"></div>


                        Pending <span class="badge badge--brand badge--dot"></span> Caption <span class="badge badge--primary badge--dot"></span> Heading <span class="badge badge--info badge--dot"></span> Status <span class="badge badge--danger badge--dot"></span>
                        <div class="space-20"></div>
                        Pending <span class="badge badge--brand badge--dot badge--sm"></span> Caption <span class="badge badge--primary badge--dot badge--sm"></span> Heading <span class="badge badge--info badge--dot badge--sm"></span> Status <span class="badge badge--danger badge--dot badge--sm"></span>

                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Wide badges for longer text:
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--inline">new</span>
                        <span class="badge badge--dark badge--inline">pending</span>
                        <span class="badge badge--primary badge--inline">203</span>
                        <span class="badge badge--success badge--inline">hot</span>
                        <span class="badge badge--info badge--inline">fixed</span>
                        <span class="badge badge--warning badge--inline">in process</span>
                        <span class="badge badge--danger badge--inline">completed</span>

                    </div>
                </div>
                <!--end::Section-->

                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Rounded badges examples:
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--brand badge--inline badge--pill badge--rounded">new</span>
                        <span class="badge badge--dark badge--inline badge--pill badge--rounded">pending</span>
                        <span class="badge badge--primary badge--inline badge--pill badge--rounded">203</span>
                        <span class="badge badge--success badge--inline badge--pill badge--rounded">hot</span>
                        <span class="badge badge--info badge--inline badge--pill badge--rounded">fixed</span>
                        <span class="badge badge--warning badge--inline badge--pill badge--rounded">in process</span>
                        <span class="badge badge--danger badge--inline badge--pill badge--rounded">completed</span>

                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->

        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
						<i class="la la-gear"></i>
					</span>
                    <h3 class="card-head-title">
						Outline Badges
					</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Basic state color badges:
					</span>
                    <div class="section__content section__content--solid">
                        <span class="badge badge--outline badge--dark">3</span>
                        <span class="badge badge--outline badge--info">4</span>
                        <span class="badge badge--outline badge--danger">7</span>
                        <span class="badge badge--outline badge--primary">8</span>
                        <span class="badge badge--outline badge--warning">1</span>
                        <span class="badge badge--outline badge--success">2</span>
                        <span class="badge badge--outline badge--brand">5</span>

                        <div class="separator separator--border-dashed"></div>

                        <span class="badge badge--outline badge--outline-2x badge--dark">3</span>
                        <span class="badge badge--outline badge--outline-2x badge--info">4</span>
                        <span class="badge badge--outline badge--outline-2x badge--danger">7</span>
                        <span class="badge badge--outline badge--outline-2x badge--primary">8</span>
                        <span class="badge badge--outline badge--outline-2x badge--warning">1</span>
                        <span class="badge badge--outline badge--outline-2x badge--success">2</span>
                        <span class="badge badge--outline badge--outline-2x badge--brand">5</span>

                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->
 
        <!--begin::card-->
        <div class="card card--tab">
            <div class="card-head">
                <div class="card-head-label">
                    <span class="card-head-icon hide">
						<i class="la la-gear"></i>
					</span>
                    <h3 class="card-head-title">
						Outline Badges
					</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Section-->
                <div class="section">
                    <span class="section__info">
						Basic state color badges:
					</span>
                    <div class="section__content section__content--solid">
                        <div class="badge badge__pics">
                            <a href="#" class="badge__pic" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="John Myer">
                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_1.jpg" alt="image">
                            </a>
                            <a href="#" class="badge__pic" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Alison Brandy">
                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_10.jpg" alt="image">
                            </a>
                            <a href="#" class="badge__pic" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Selina Cranson">
                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_11.jpg" alt="image">
                            </a>
                            <a href="#" class="badge__pic" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Luke Walls">
                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_2.jpg" alt="image">
                            </a>
                            <a href="#" class="badge__pic" data-toggle="tooltip" data-skin="brand" data-placement="top" title="" data-original-title="Micheal York">
                                <img src="<?php echo CONF_WEBROOT_URL;?>images/users/100_3.jpg" alt="image">
                            </a>
                            <a href="#" class="badge__pic  badge__pic--last">
                                +3
                            </a>
                        </div>	
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::card-->
    </div>
</div> 	</div>
<!-- end:: Content -->						</div>
									</div>

		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>