<!DOCTYPE html>
<html lang="en" data-theme="light" dir="ltr">


<head>
	<meta charset="utf-8" />
	<title>FATbit | Dashboard</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<script>
		WebFont.load({
			google: {
				"families": ["Poppins:300,400,500,600,700"]
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<link href="<?php echo CSS_PATH;?>main-ltr.css" rel="stylesheet" type="text/css" />
	
	<link rel="shortcut icon" href="images/favicon.ico" />
	 
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
		    <h3 class="subheader__title">
				
				Notes			</h3>

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
	                        Notes	                    </a>
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
    <div class="col-lg-6">
        <!--Begin::card-->
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Basic Notes
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="notes">
                    <div class="notes__items">
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <span class="notes__icon">
                                    <i class="flaticon2-shield font-brand"></i>                                    
                                </span>                               
                            </div>         
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            New order                                                    
                                        </a>
                                        <span class="notes__desc">
                                            9:30AM 16 June, 2015
                                        </span>
                                        <span class="badge badge--brand badge--inline">important</span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>                                             
                        </div> 
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <span class="notes__icon">
                                    <i class="flaticon2-line-chart font-success"></i>                                    
                                </span>                                  
                            </div>   
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            System notification                                                    
                                        </a>
                                        <span class="notes__desc">
                                            10:30AM 23 May, 2013
                                        </span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Make Metronic Development. Lorem Ipsum. Make Widgets Development. Estudiat Communy Elit
                                </span>  
                            </div>                     
                        </div> 
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <span class="notes__icon">
                                    <i class="flaticon2-layers font-danger"></i>                                    
                                </span>                               
                            </div>                             
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            New member                                                          
                                        </a>
                                        <span class="notes__desc">
                                            7:10AM 21 February, 2016
                                        </span>
                                        <span class="badge badge--success badge--inline">pending</span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium aque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>  
                        </div> 
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <span class="notes__icon">
                                    <i class="flaticon2-pie-chart-1 font-warning"></i>                                    
                                </span>                               
                            </div>                              
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            New mail                                                          
                                        </a>
                                        <span class="notes__desc">
                                            11:40AM 14 March, 2012
                                        </span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>                          
                        </div> 
                        <div class="notes__item notes__item--clean"> 
                            <div class="notes__media">
                                <span class="notes__circle"></span>                                
                            </div>                              
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            Nick Bold                                                           
                                        </a>
                                        <span class="notes__desc">
                                            10:30AM 23 April, 2013
                                        </span>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                </span>  
                            </div>                           
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!--End::card-->
    </div>
    <div class="col-lg-6">
        <!--Begin::card-->
        <div class="card">
            <div class="card-head">
                <div class="card-head-label">
                    <h3 class="card-head-title">
                        Extended Notes
                    </h3>
                </div>
            </div>
            <div class="card-body">                   
                <div class="notes">
                    <div class="notes__items">
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <img class="hidden-" src="media/users/100_3.jpg" alt="image">
                                <span class="notes__icon font-boldest hidden">
                                    <i class="flaticon2-cup"></i>                                    
                                </span> 
                                <h3 class="notes__user font-boldest hidden">
                                    N S                                                       
                                </h3>                                 
                            </div>    
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            New order                                                        
                                        </a>
                                        <span class="notes__desc">
                                            9:30AM 16 June, 2015
                                        </span>
                                        <span class="badge badge--success badge--inline">new</span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon-more-1 font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>                                             
                        </div> 
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <span class="notes__icon notes__icon--danger font-boldest">
                                    <i class="flaticon2-rocket font-danger"></i>                                    
                                </span>                               
                            </div>   
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            Notification                                                        
                                        </a>
                                        <span class="notes__desc">
                                            10:30AM 23 May, 2013
                                        </span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon2-rectangular font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>                     
                        </div> 
                        <div class="notes__item"> 
                            <div class="notes__media">
                                <h3 class="notes__user font-brand font-boldest">
                                    DS                                                        
                                </h3>                                 
                            </div>                             
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            System alert                                                        
                                        </a>
                                        <span class="notes__desc">
                                            7:10AM 21 February, 2016
                                        </span>
                                    </div>
                                    <div class="notes__dropdown"> 
                                        <a href="#" class="btn btn-sm btn-icon-md btn-icon" data-toggle="dropdown">
                                            <i class="flaticon2-note font-brand"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav">
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-line-chart"></i>
            <span class="nav__link-text">Reports</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-send"></i>
            <span class="nav__link-text">Messages</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-pie-chart-1"></i>
            <span class="nav__link-text">Charts</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-avatar"></i>
            <span class="nav__link-text">Members</span>
        </a>
    </li>
    <li class="nav__item">
        <a href="#" class="nav__link">
            <i class="nav__link-icon flaticon2-settings"></i>
            <span class="nav__link-text">Settings</span>
        </a>
    </li>
</ul>                                        </div>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>  
                        </div> 
                        <div class="notes__item notes__item--clean"> 
                            <div class="notes__media">
                                <img class="hidden" src="media/users/100_1.jpg" alt="image">
                                <span class="notes__icon font-boldest hidden">
                                    <i class="flaticon2-cup"></i>                                    
                                </span> 
                                <h3 class="notes__user font-boldest hidden">
                                    M E                                                     
                                </h3> 
                                <span class="notes__circle hidden-"></span>                                
                            </div>  
                            
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            Order                                                          
                                        </a>
                                        <span class="notes__desc">
                                            11:40AM 14 March, 2012
                                        </span>
                                        <span class="badge badge--danger badge--inline">important</span>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.
                                </span>  
                            </div>                          
                        </div> 
                        <div class="notes__item notes__item--clean"> 
                            <div class="notes__media">
                                <img class="hidden" src="media/users/100_1.jpg" alt="image">
                                <span class="notes__icon font-boldest hidden">
                                    <i class="flaticon2-cup"></i>                                    
                                </span> 
                                <h3 class="notes__user font-boldest hidden">
                                    N B                                                        
                                </h3> 
                                <span class="notes__circle hidden-"></span>                                
                            </div>  
                            
                            <div class="notes__content"> 
                                <div class="notes__section">     
                                    <div class="notes__info">
                                        <a href="#" class="notes__title">
                                            Remarks                                                           
                                        </a>
                                        <span class="notes__desc">
                                            10:30AM 23 April, 2013
                                        </span>
                                    </div>
                                </div>
                                <span class="notes__body">                                        
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.
                                </span>  
                            </div>                           
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!--End::card-->
    </div>
</div>	</div>
<!-- end:: Content -->						</div>
									</div>

		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>