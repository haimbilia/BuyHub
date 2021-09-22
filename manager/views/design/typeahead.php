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



<body class="subheader--transparent page--loading">
	<div class="wrapper">

		<?php
  include 'includes/header.php';
?>
<div class="body" id="body">
											<div class="content " id="content">
								
<!-- begin:: Subheader -->
<div id="subheader" class="subheader" >
	<div class="container ">
	    <div class="subheader__main">
	        <h3 class="subheader__title">Typeahead</h3>

	        	            <div class="subheader__breadcrumbs">
	                <a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Crud	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Forms &amp; Controls	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Form Widgets	                    </a>
	                	                    <span class="subheader__breadcrumbs-separator"></span>
	                    <a href="" class="subheader__breadcrumbs-link">
	                        Typeahead	                    </a>
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
                typeahead.js a flexible JavaScript library that provides a strong foundation for building robust typeaheads. typeahead.js is a fast and fully-featured autocomplete library.
                <br>
                For more info please visit the plugin's <a class="link font-bold" href="http://twitter.github.io/typeahead.js/" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/twitter/typeahead.js" target="_blank">Github Repo</a>.
            </div>
        </div>
    </div>
</div>

<!--begin::card-->
<div class="card">
	<div class="card-head">
		<div class="card-head-label">
			<h3 class="card-head-title">
				Typeahead Examples
			</h3>
		</div>
	</div>
	<!--begin::Form-->
	<form class="form form--label-right">
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Basic Demo</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" type="text" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_1" type="text" dir="ltr" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Bloodhound (Suggestion Engine)</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" type="text" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_2" type="text" dir="ltr" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
					</div>
					<div class="form-text text-muted">
						Bloodhound offers advanced functionalities such as prefetching and backfilling with remote data.
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Prefetch</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" type="text" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_3" type="text" dir="ltr" placeholder="Countries" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-countries"></div></div></span>
					</div>
					<div class="form-text text-muted">Prefetched data is fetched and processed on initialization</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Custom Templates</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" type="text" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_4" type="text" dir="ltr" placeholder="Oscar winners" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-best-pictures"></div></div></span>
					</div>
					<div class="form-text text-muted">Custom templates give you full control over how suggestions get rendered</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Multiple Datasets</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" type="text" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_5" type="text" dir="ltr" placeholder="Select an option" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-nba-teams"></div><div class="tt-dataset tt-dataset-nhl-teams"></div></div></span>
					</div>
					<div class="form-text text-muted">Remote data is only used when the data provided by local and prefetch is insufficient</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<a href="" class="btn btn-label-brand btn-bold btn-sm" data-toggle="modal" data-target="#typeahead_modal">Launch modal typeaheads</a>
				</div>
			</div>
		</div>
		<div class="card-foot">
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
<div class="modal fade" id="typeahead_modal" tabindex="-1" role="dialog" aria-labelledby="" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Typeahead Examples</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="la la-remove"></span>
				</button>
			</div>
			<form class="form form--fit form--label-right">
				<div class="modal-body">
					<div class="form-group row margin-t-20">
						<label class="col-form-label col-lg-3 col-sm-12">Basic Demo</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="typeahead">
								<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" dir="ltr" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_1_modal" dir="ltr" type="text" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-lg-3 col-sm-12">Bloodhound</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="typeahead">
								<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" dir="ltr" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_2_modal" dir="ltr" type="text" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
							</div>
							<div class="form-text text-muted">
								Bloodhound offers advanced functionalities such as prefetching and backfilling with remote data.
							</div>
						</div>
					</div>
					<div class="form-group row margin-b-20">
						<label class="col-form-label col-lg-3 col-sm-12">Prefetch</label>
						<div class="col-lg-9 col-md-9 col-sm-12">
							<div class="typeahead">
								<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control tt-hint" dir="ltr" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0% padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control tt-input" id="typeahead_3_modal" dir="ltr" type="text" placeholder="Countries" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-countries"></div></div></span>
							</div>
							<div class="form-text text-muted">Prefetched data is fetched and processed on initialization</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-secondary">Submit</button>
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
				<div class="col-lg-4 col-md-9 col-sm-12 is-valid">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control is-valid tt-hint" dir="ltr" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%231dc9b7' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e&quot;) no-repeat scroll calc(100% - 9.1px) 50% / 18.2px 18.2px padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control is-valid tt-input" id="typeahead_1_validate" dir="ltr" type="text" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
					</div>
					<div class="valid-feedback">Success! You've done it.</div>
					<span class="form-text text-muted">Example help text that remains unchanged.</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12">Error State</label>
				<div class="col-lg-4 col-md-9 col-sm-12 is-invalid">
					<div class="typeahead">
						<span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="form-control is-invalid tt-hint" dir="ltr" type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fd397a' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23fd397a' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E&quot;) no-repeat scroll calc(100% - 9.1px) 50% / 18.2px 18.2px padding-box;" readonly="" autocomplete="off" spellcheck="false" tabindex="-1"><input class="form-control is-invalid tt-input" id="typeahead_2_validate" dir="ltr" type="text" placeholder="States of USA" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
					</div>
					<div class="invalid-feedback">Shucks, check the formatting of that and try again.</div>
					<span class="form-text text-muted">Example help text that remains unchanged.</span>
				</div>
			</div>
		</div>
		<div class="card-foot">
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
<!--end::card-->	</div>
<!-- end:: Content -->						</div>
									</div>


		<?php
  include 'includes/footer.php';
?>
	</div>

</body>


</html>