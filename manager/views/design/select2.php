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

								Select2 </h3>

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
									Select2 </a>
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
									Select2 is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results. Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://select2.org/getting-started/basic-usage" target="_blank">Demo Page</a> or <a class="link font-bold" href="https://github.com/select2/select2" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<!--begin::card-->
					<div class="card">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Select2 Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--fit form--label-right">
							<div class="card-body" data-select2-id="46">
								<div class="form-group row" data-select2-id="45">
									<label class="col-form-label col-lg-3 col-sm-12">Basic Example</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="44">
										<select class="form-control select2 select2-hidden-accessible" id="select2_1" name="param" data-select2-id="select2_1" tabindex="-1" aria-hidden="true">
											<option value="AK" data-select2-id="2">Alaska</option>
											<option value="HI" data-select2-id="51">Hawaii</option>
											<option value="CA" data-select2-id="52">California</option>
											<option value="NV" data-select2-id="53">Nevada</option>
											<option value="OR" data-select2-id="54">Oregon</option>
											<option value="WA" data-select2-id="55">Washington</option>
											<option value="AZ" data-select2-id="56">Arizona</option>
											<option value="CO" data-select2-id="57">Colorado</option>
											<option value="ID" data-select2-id="58">Idaho</option>
											<option value="MT" data-select2-id="59">Montana</option>
											<option value="NE" data-select2-id="60">Nebraska</option>
											<option value="NM" data-select2-id="61">New Mexico</option>
											<option value="ND" data-select2-id="62">North Dakota</option>
											<option value="UT" data-select2-id="63">Utah</option>
											<option value="WY" data-select2-id="64">Wyoming</option>
											<option value="AL" data-select2-id="65">Alabama</option>
											<option value="AR" data-select2-id="66">Arkansas</option>
											<option value="IL" data-select2-id="67">Illinois</option>
											<option value="IA" data-select2-id="68">Iowa</option>
											<option value="KS" data-select2-id="69">Kansas</option>
											<option value="KY" data-select2-id="70">Kentucky</option>
											<option value="LA" data-select2-id="71">Louisiana</option>
											<option value="MN" data-select2-id="72">Minnesota</option>
											<option value="MS" data-select2-id="73">Mississippi</option>
											<option value="MO" data-select2-id="74">Missouri</option>
											<option value="OK" data-select2-id="75">Oklahoma</option>
											<option value="SD" data-select2-id="76">South Dakota</option>
											<option value="TX" data-select2-id="77">Texas</option>
											<option value="TN" data-select2-id="78">Tennessee</option>
											<option value="WI" data-select2-id="79">Wisconsin</option>
											<option value="CT" data-select2-id="80">Connecticut</option>
											<option value="DE" data-select2-id="81">Delaware</option>
											<option value="FL" data-select2-id="82">Florida</option>
											<option value="GA" data-select2-id="83">Georgia</option>
											<option value="IN" data-select2-id="84">Indiana</option>
											<option value="ME" data-select2-id="85">Maine</option>
											<option value="MD" data-select2-id="86">Maryland</option>
											<option value="MA" data-select2-id="87">Massachusetts</option>
											<option value="MI" data-select2-id="88">Michigan</option>
											<option value="NH" data-select2-id="89">New Hampshire</option>
											<option value="NJ" data-select2-id="90">New Jersey</option>
											<option value="NY" data-select2-id="91">New York</option>
											<option value="NC" data-select2-id="92">North Carolina</option>
											<option value="OH" data-select2-id="93">Ohio</option>
											<option value="PA" data-select2-id="94">Pennsylvania</option>
											<option value="RI" data-select2-id="95">Rhode Island</option>
											<option value="SC" data-select2-id="96">South Carolina</option>
											<option value="VT" data-select2-id="97">Vermont</option>
											<option value="VA" data-select2-id="98">Virginia</option>
											<option value="WV" data-select2-id="99">West Virginia</option>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="1" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_1-container"><span class="select2-selection__rendered" id="select2-select2_1-container" role="textbox" aria-readonly="true" title="Alaska">Alaska</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row" data-select2-id="102">
									<label class="col-form-label col-lg-3 col-sm-12">Nested Example</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="101">
										<select class="form-control select2 select2-hidden-accessible" id="select2_2" name="param" data-select2-id="select2_2" tabindex="-1" aria-hidden="true">
											<optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="103">
												<option value="AK" data-select2-id="104">Alaska</option>
												<option value="HI" data-select2-id="105">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone" data-select2-id="106">
												<option value="CA" data-select2-id="107">California</option>
												<option value="NV" selected="" data-select2-id="6">Nevada</option>
												<option value="OR" data-select2-id="108">Oregon</option>
												<option value="WA" data-select2-id="109">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone" data-select2-id="110">
												<option value="AZ" data-select2-id="111">Arizona</option>
												<option value="CO" data-select2-id="112">Colorado</option>
												<option value="ID" data-select2-id="113">Idaho</option>
												<option value="MT" data-select2-id="114">Montana</option>
												<option value="NE" data-select2-id="115">Nebraska</option>
												<option value="NM" data-select2-id="116">New Mexico</option>
												<option value="ND" data-select2-id="117">North Dakota</option>
												<option value="UT" data-select2-id="118">Utah</option>
												<option value="WY" data-select2-id="119">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone" data-select2-id="120">
												<option value="AL" data-select2-id="121">Alabama</option>
												<option value="AR" data-select2-id="122">Arkansas</option>
												<option value="IL" data-select2-id="123">Illinois</option>
												<option value="IA" data-select2-id="124">Iowa</option>
												<option value="KS" data-select2-id="125">Kansas</option>
												<option value="KY" data-select2-id="126">Kentucky</option>
												<option value="LA" data-select2-id="127">Louisiana</option>
												<option value="MN" data-select2-id="128">Minnesota</option>
												<option value="MS" data-select2-id="129">Mississippi</option>
												<option value="MO" data-select2-id="130">Missouri</option>
												<option value="OK" data-select2-id="131">Oklahoma</option>
												<option value="SD" data-select2-id="132">South Dakota</option>
												<option value="TX" data-select2-id="133">Texas</option>
												<option value="TN" data-select2-id="134">Tennessee</option>
												<option value="WI" data-select2-id="135">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone" data-select2-id="136">
												<option value="CT" data-select2-id="137">Connecticut</option>
												<option value="DE" data-select2-id="138">Delaware</option>
												<option value="FL" data-select2-id="139">Florida</option>
												<option value="GA" data-select2-id="140">Georgia</option>
												<option value="IN" data-select2-id="141">Indiana</option>
												<option value="ME" data-select2-id="142">Maine</option>
												<option value="MD" data-select2-id="143">Maryland</option>
												<option value="MA" data-select2-id="144">Massachusetts</option>
												<option value="MI" data-select2-id="145">Michigan</option>
												<option value="NH" data-select2-id="146">New Hampshire</option>
												<option value="NJ" data-select2-id="147">New Jersey</option>
												<option value="NY" data-select2-id="148">New York</option>
												<option value="NC" data-select2-id="149">North Carolina</option>
												<option value="OH" data-select2-id="150">Ohio</option>
												<option value="PA" data-select2-id="151">Pennsylvania</option>
												<option value="RI" data-select2-id="152">Rhode Island</option>
												<option value="SC" data-select2-id="153">South Carolina</option>
												<option value="VT" data-select2-id="154">Vermont</option>
												<option value="VA" data-select2-id="155">Virginia</option>
												<option value="WV" data-select2-id="156">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="5" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_2-container"><span class="select2-selection__rendered" id="select2-select2_2-container" role="textbox" aria-readonly="true" title="Hawaii">Hawaii</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Multi Select</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="163">
										<select class="form-control select2 select2-hidden-accessible" id="select2_3" name="param" multiple="" data-select2-id="select2_3" tabindex="-1" aria-hidden="true">
											<optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="164">
												<option value="AK" selected="" data-select2-id="10">Alaska</option>
												<option value="HI" data-select2-id="165">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone" data-select2-id="166">
												<option value="CA" data-select2-id="167">California</option>
												<option value="NV" selected="" data-select2-id="11">Nevada</option>
												<option value="OR" data-select2-id="168">Oregon</option>
												<option value="WA" data-select2-id="169">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone" data-select2-id="170">
												<option value="AZ" data-select2-id="171">Arizona</option>
												<option value="CO" data-select2-id="172">Colorado</option>
												<option value="ID" data-select2-id="173">Idaho</option>
												<option value="MT" selected="" data-select2-id="12">Montana</option>
												<option value="NE" data-select2-id="174">Nebraska</option>
												<option value="NM" data-select2-id="175">New Mexico</option>
												<option value="ND" data-select2-id="176">North Dakota</option>
												<option value="UT" data-select2-id="177">Utah</option>
												<option value="WY" data-select2-id="178">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone" data-select2-id="179">
												<option value="AL" data-select2-id="180">Alabama</option>
												<option value="AR" data-select2-id="181">Arkansas</option>
												<option value="IL" data-select2-id="182">Illinois</option>
												<option value="IA" data-select2-id="183">Iowa</option>
												<option value="KS" data-select2-id="184">Kansas</option>
												<option value="KY" data-select2-id="185">Kentucky</option>
												<option value="LA" data-select2-id="186">Louisiana</option>
												<option value="MN" data-select2-id="187">Minnesota</option>
												<option value="MS" data-select2-id="188">Mississippi</option>
												<option value="MO" data-select2-id="189">Missouri</option>
												<option value="OK" data-select2-id="190">Oklahoma</option>
												<option value="SD" data-select2-id="191">South Dakota</option>
												<option value="TX" data-select2-id="192">Texas</option>
												<option value="TN" data-select2-id="193">Tennessee</option>
												<option value="WI" data-select2-id="194">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone" data-select2-id="195">
												<option value="CT" data-select2-id="196">Connecticut</option>
												<option value="DE" data-select2-id="197">Delaware</option>
												<option value="FL" data-select2-id="198">Florida</option>
												<option value="GA" data-select2-id="199">Georgia</option>
												<option value="IN" data-select2-id="200">Indiana</option>
												<option value="ME" data-select2-id="201">Maine</option>
												<option value="MD" data-select2-id="202">Maryland</option>
												<option value="MA" data-select2-id="203">Massachusetts</option>
												<option value="MI" data-select2-id="204">Michigan</option>
												<option value="NH" data-select2-id="205">New Hampshire</option>
												<option value="NJ" data-select2-id="206">New Jersey</option>
												<option value="NY" data-select2-id="207">New York</option>
												<option value="NC" data-select2-id="208">North Carolina</option>
												<option value="OH" data-select2-id="209">Ohio</option>
												<option value="PA" data-select2-id="210">Pennsylvania</option>
												<option value="RI" data-select2-id="211">Rhode Island</option>
												<option value="SC" data-select2-id="212">South Carolina</option>
												<option value="VT" data-select2-id="213">Vermont</option>
												<option value="VA" data-select2-id="214">Virginia</option>
												<option value="WV" data-select2-id="215">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="9" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
													<ul class="select2-selection__rendered">
														<li class="select2-selection__choice" title="Alaska" data-select2-id="13"><span class="select2-selection__choice__remove" role="presentation">×</span>Alaska</li>
														<li class="select2-selection__choice" title="Nevada" data-select2-id="14"><span class="select2-selection__choice__remove" role="presentation">×</span>Nevada</li>
														<li class="select2-selection__choice" title="Montana" data-select2-id="15"><span class="select2-selection__choice__remove" role="presentation">×</span>Montana</li>
														<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
													</ul>
												</span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Placeholder</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_4" name="param" data-select2-id="select2_4" tabindex="-1" aria-hidden="true">
											<option data-select2-id="17"></option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="16" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_4-container"><span class="select2-selection__rendered" id="select2-select2_4-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select a state</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row" data-select2-id="223">
									<label class="col-form-label col-lg-3 col-sm-12">Array Data</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="222">
										<select class="form-control select2 select2-hidden-accessible" id="select2_5" name="param" data-select2-id="select2_5" tabindex="-1" aria-hidden="true">
											<option value="2" data-select2-id="22">Duplicate</option>
											<option value="0" data-select2-id="20">Enhancement</option>
											<option value="1" data-select2-id="21">Bug</option>
											<option value="3" data-select2-id="23">Invalid</option>
											<option value="4" data-select2-id="24">Wontfix</option>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="18" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_5-container"><span class="select2-selection__rendered" id="select2-select2_5-container" role="textbox" aria-readonly="true" title="Bug">Bug</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row" data-select2-id="226">
									<label class="col-form-label col-lg-3 col-sm-12">Remote Data</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="225">
										<select class="form-control select2 select2-hidden-accessible" id="select2_6" name="param" data-select2-id="select2_6" tabindex="-1" aria-hidden="true">
											<option data-select2-id="26"></option>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="25" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_6-container"><span class="select2-selection__rendered" id="select2-select2_6-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Search for git repositories</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Disabled Mode</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_7" disabled="" name="param" data-select2-id="select2_7" tabindex="-1" aria-hidden="true">
											<option></option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV" selected="" data-select2-id="28">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="27" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true" aria-labelledby="select2-select2_7-container"><span class="select2-selection__rendered" id="select2-select2_7-container" role="textbox" aria-readonly="true" title="Nevada">Nevada</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Disabled Results</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_8" name="param" data-select2-id="select2_8" tabindex="-1" aria-hidden="true">
											<option data-select2-id="30"></option>
											<option value="one">First</option>
											<option value="two" disabled="disabled">Second (disabled)</option>
											<option value="three">Third</option>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="29" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_8-container"><span class="select2-selection__rendered" id="select2-select2_8-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Limiting Selections</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_9" name="param" multiple="" data-select2-id="select2_9" tabindex="-1" aria-hidden="true">
											<option></option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV" selected="" data-select2-id="32">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="31" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
													<ul class="select2-selection__rendered">
														<li class="select2-selection__choice" title="Nevada" data-select2-id="33"><span class="select2-selection__choice__remove" role="presentation">×</span>Nevada</li>
														<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
													</ul>
												</span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Hiding Search box</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_10" name="param" data-select2-id="select2_10" tabindex="-1" aria-hidden="true">
											<option data-select2-id="35"></option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="34" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_10-container"><span class="select2-selection__rendered" id="select2-select2_10-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Tagging Support</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 select2-hidden-accessible" id="select2_11" multiple="" name="param" data-select2-id="select2_11" tabindex="-1" aria-hidden="true">
											<option></option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="36" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
													<ul class="select2-selection__rendered">
														<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="Add a tag" style="width: 381.983px;"></li>
													</ul>
												</span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Group Inputs</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="la la-exclamation-triangle"></i></span></div>
											<select class="form-control select2 select2-general select2-hidden-accessible" name="param" data-select2-id="37" tabindex="-1" aria-hidden="true">
												<option data-select2-id="39"></option>
												<option value="AK">Option 1</option>
												<option value="AK">Option 2</option>
												<option value="AK">Option 3</option>
												<option value="AK">Option 4</option>
												<option value="AK">Option 5</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="38" style="width: 364.783px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-param-27-container"><span class="select2-selection__rendered" id="select2-param-27-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										</div>
										<div class="space-10"></div>

										<div class="input-group">
											<select class="form-control select2 select2-general select2-hidden-accessible" name="param" data-select2-id="40" tabindex="-1" aria-hidden="true">
												<option data-select2-id="42"></option>
												<option value="AK">Option 1</option>
												<option value="AK">Option 2</option>
												<option value="AK">Option 3</option>
												<option value="AK">Option 4</option>
												<option value="AK">Option 5</option>
											</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="41" style="width: 364.783px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-param-os-container"><span class="select2-selection__rendered" id="select2-param-os-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select an option</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
											<div class="input-group-append"><span class="input-group-text"><i class="la la-exclamation-triangle"></i></span></div>
										</div>
									</div>
								</div>

								<div class="seperator m-seperator--border-dashed m-seperator--space-xl"></div>

								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Modal Demos</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<a href="" class="btn btn-success btn-pill" data-toggle="modal" data-target="#select2_modal">Launch modal select2s</a>
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
					<div class="modal fade" id="select2_modal" role="dialog" aria-labelledby="" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="">Select2 Examples</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" class="la la-remove"></span>
									</button>
								</div>
								<form class="form form--fit form--label-right">
									<div class="modal-body">
										<div class="form-group row margin-t-20">
											<label class="col-form-label col-lg-3 col-sm-12">Basic Example</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<select class="form-control select2" id="select2_1_modal" name="param">
													<option value="AK">Alaska</option>
													<option value="HI">Hawaii</option>
													<option value="CA">California</option>
													<option value="NV">Nevada</option>
													<option value="OR">Oregon</option>
													<option value="WA">Washington</option>
													<option value="AZ">Arizona</option>
													<option value="CO">Colorado</option>
													<option value="ID">Idaho</option>
													<option value="MT">Montana</option>
													<option value="NE">Nebraska</option>
													<option value="NM">New Mexico</option>
													<option value="ND">North Dakota</option>
													<option value="UT">Utah</option>
													<option value="WY">Wyoming</option>
													<option value="AL">Alabama</option>
													<option value="AR">Arkansas</option>
													<option value="IL">Illinois</option>
													<option value="IA">Iowa</option>
													<option value="KS">Kansas</option>
													<option value="KY">Kentucky</option>
													<option value="LA">Louisiana</option>
													<option value="MN">Minnesota</option>
													<option value="MS">Mississippi</option>
													<option value="MO">Missouri</option>
													<option value="OK">Oklahoma</option>
													<option value="SD">South Dakota</option>
													<option value="TX">Texas</option>
													<option value="TN">Tennessee</option>
													<option value="WI">Wisconsin</option>
													<option value="CT">Connecticut</option>
													<option value="DE">Delaware</option>
													<option value="FL">Florida</option>
													<option value="GA">Georgia</option>
													<option value="IN">Indiana</option>
													<option value="ME">Maine</option>
													<option value="MD">Maryland</option>
													<option value="MA">Massachusetts</option>
													<option value="MI">Michigan</option>
													<option value="NH">New Hampshire</option>
													<option value="NJ">New Jersey</option>
													<option value="NY">New York</option>
													<option value="NC">North Carolina</option>
													<option value="OH">Ohio</option>
													<option value="PA">Pennsylvania</option>
													<option value="RI">Rhode Island</option>
													<option value="SC">South Carolina</option>
													<option value="VT">Vermont</option>
													<option value="VA">Virginia</option>
													<option value="WV">West Virginia</option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-sm-12">Nested Example</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<select class="form-control select2" id="select2_2_modal" name="param">
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV" selected="">Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label col-lg-3 col-sm-12">Multi Select</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<select class="form-control select2" id="select2_3_modal" name="param" multiple="multiple">
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK" selected="">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV" selected="">Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT" selected="">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
											</div>
										</div>
										<div class="form-group row margin-b-20">
											<label class="col-form-label col-lg-3 col-sm-12">Placeholder</label>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<select class="form-control select2" id="select2_4_modal" name="param">
													<option></option>
													<optgroup label="Alaskan/Hawaiian Time Zone">
														<option value="AK">Alaska</option>
														<option value="HI">Hawaii</option>
													</optgroup>
													<optgroup label="Pacific Time Zone">
														<option value="CA">California</option>
														<option value="NV">Nevada</option>
														<option value="OR">Oregon</option>
														<option value="WA">Washington</option>
													</optgroup>
													<optgroup label="Mountain Time Zone">
														<option value="AZ">Arizona</option>
														<option value="CO">Colorado</option>
														<option value="ID">Idaho</option>
														<option value="MT">Montana</option>
														<option value="NE">Nebraska</option>
														<option value="NM">New Mexico</option>
														<option value="ND">North Dakota</option>
														<option value="UT">Utah</option>
														<option value="WY">Wyoming</option>
													</optgroup>
													<optgroup label="Central Time Zone">
														<option value="AL">Alabama</option>
														<option value="AR">Arkansas</option>
														<option value="IL">Illinois</option>
														<option value="IA">Iowa</option>
														<option value="KS">Kansas</option>
														<option value="KY">Kentucky</option>
														<option value="LA">Louisiana</option>
														<option value="MN">Minnesota</option>
														<option value="MS">Mississippi</option>
														<option value="MO">Missouri</option>
														<option value="OK">Oklahoma</option>
														<option value="SD">South Dakota</option>
														<option value="TX">Texas</option>
														<option value="TN">Tennessee</option>
														<option value="WI">Wisconsin</option>
													</optgroup>
													<optgroup label="Eastern Time Zone">
														<option value="CT">Connecticut</option>
														<option value="DE">Delaware</option>
														<option value="FL">Florida</option>
														<option value="GA">Georgia</option>
														<option value="IN">Indiana</option>
														<option value="ME">Maine</option>
														<option value="MD">Maryland</option>
														<option value="MA">Massachusetts</option>
														<option value="MI">Michigan</option>
														<option value="NH">New Hampshire</option>
														<option value="NJ">New Jersey</option>
														<option value="NY">New York</option>
														<option value="NC">North Carolina</option>
														<option value="OH">Ohio</option>
														<option value="PA">Pennsylvania</option>
														<option value="RI">Rhode Island</option>
														<option value="SC">South Carolina</option>
														<option value="VT">Vermont</option>
														<option value="VA">Virginia</option>
														<option value="WV">West Virginia</option>
													</optgroup>
												</select>
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
					<div class="card" data-select2-id="231">
						<div class="card-head">
							<div class="card-head-label">
								<h3 class="card-head-title">
									Validation State Examples
								</h3>
							</div>
						</div>
						<!--begin::Form-->
						<form class="form form--label-right" data-select2-id="230">
							<div class="card-body">
								<div class="form-group row" data-select2-id="229">
									<label class="col-form-label col-lg-3 col-sm-12">Valid State</label>
									<div class=" col-lg-4 col-md-9 col-sm-12" data-select2-id="228">
										<select class="form-control select2 is-valid select2-hidden-accessible" id="select2_1_validate" name="param" data-select2-id="select2_1_validate" tabindex="-1" aria-hidden="true">
											<option value="AK" data-select2-id="4">Alaska</option>
											<option value="HI" data-select2-id="232">Hawaii</option>
											<option value="CA" data-select2-id="233">California</option>
											<option value="NV" data-select2-id="234">Nevada</option>
											<option value="OR" data-select2-id="235">Oregon</option>
											<option value="WA" data-select2-id="236">Washington</option>
											<option value="AZ" data-select2-id="237">Arizona</option>
											<option value="CO" data-select2-id="238">Colorado</option>
											<option value="ID" data-select2-id="239">Idaho</option>
											<option value="MT" data-select2-id="240">Montana</option>
											<option value="NE" data-select2-id="241">Nebraska</option>
											<option value="NM" data-select2-id="242">New Mexico</option>
											<option value="ND" data-select2-id="243">North Dakota</option>
											<option value="UT" data-select2-id="244">Utah</option>
											<option value="WY" data-select2-id="245">Wyoming</option>
											<option value="AL" data-select2-id="246">Alabama</option>
											<option value="AR" data-select2-id="247">Arkansas</option>
											<option value="IL" data-select2-id="248">Illinois</option>
											<option value="IA" data-select2-id="249">Iowa</option>
											<option value="KS" data-select2-id="250">Kansas</option>
											<option value="KY" data-select2-id="251">Kentucky</option>
											<option value="LA" data-select2-id="252">Louisiana</option>
											<option value="MN" data-select2-id="253">Minnesota</option>
											<option value="MS" data-select2-id="254">Mississippi</option>
											<option value="MO" data-select2-id="255">Missouri</option>
											<option value="OK" data-select2-id="256">Oklahoma</option>
											<option value="SD" data-select2-id="257">South Dakota</option>
											<option value="TX" data-select2-id="258">Texas</option>
											<option value="TN" data-select2-id="259">Tennessee</option>
											<option value="WI" data-select2-id="260">Wisconsin</option>
											<option value="CT" data-select2-id="261">Connecticut</option>
											<option value="DE" data-select2-id="262">Delaware</option>
											<option value="FL" data-select2-id="263">Florida</option>
											<option value="GA" data-select2-id="264">Georgia</option>
											<option value="IN" data-select2-id="265">Indiana</option>
											<option value="ME" data-select2-id="266">Maine</option>
											<option value="MD" data-select2-id="267">Maryland</option>
											<option value="MA" data-select2-id="268">Massachusetts</option>
											<option value="MI" data-select2-id="269">Michigan</option>
											<option value="NH" data-select2-id="270">New Hampshire</option>
											<option value="NJ" data-select2-id="271">New Jersey</option>
											<option value="NY" data-select2-id="272">New York</option>
											<option value="NC" data-select2-id="273">North Carolina</option>
											<option value="OH" data-select2-id="274">Ohio</option>
											<option value="PA" data-select2-id="275">Pennsylvania</option>
											<option value="RI" data-select2-id="276">Rhode Island</option>
											<option value="SC" data-select2-id="277">South Carolina</option>
											<option value="VT" data-select2-id="278">Vermont</option>
											<option value="VA" data-select2-id="279">Virginia</option>
											<option value="WV" data-select2-id="280">West Virginia</option>
										</select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="3" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_1_validate-container"><span class="select2-selection__rendered" id="select2-select2_1_validate-container" role="textbox" aria-readonly="true" title="California">California</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
										<div class="valid-feedback">Success! You've done it.</div>
										<span class="form-text text-muted">Example help text that remains unchanged.</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-form-label col-lg-3 col-sm-12">Invalid State</label>
									<div class=" col-lg-4 col-md-9 col-sm-12">
										<select class="form-control select2 is-invalid select2-hidden-accessible" id="select2_2_validate" name="param" data-select2-id="select2_2_validate" tabindex="-1" aria-hidden="true">
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV" selected="" data-select2-id="8">Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="7" style="width: 409.983px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-select2_2_validate-container"><span class="select2-selection__rendered" id="select2-select2_2_validate-container" role="textbox" aria-readonly="true" title="Nevada">Nevada</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
					<!--end::card-->
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