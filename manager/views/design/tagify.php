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

								Tagify </h3>

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
									Tagify </a>
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
									Tagify - lightweight input tags plugin.
									<br>
									For more info please visit the plugin's <a class="link font-bold" href="https://yaireo.github.io/tagify/" target="_blank">Demo Page</a> or
									<a class="link font-bold" href="https://github.com/yairEO/tagify" target="_blank">Github Repo</a>.
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">
											Tags Input Examples
										</h3>
									</div>
								</div>
								<!--begin::Form-->
								<form class="form form--label-right">
									<div class="card-body">
										<div class="form-group form-group-last row">
											<label class="col-form-label col-lg-3 col-sm-12">Basic example</label>
											<div class="col-lg-6 col-md-9 col-sm-12">
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
												</tags><input id="tagify_1" name="tags" placeholder="type..." value="css, html, javascript" autofocus="" data-blacklist=".NET,PHP">

												<div class="margin-t-10">
													<a href="javascript:;" id="tagify_1_remove" class="btn btn-label-brand btn-bold">Remove tags</a>
												</div>

												<div class="margin-t-10">
													In this example, the field is pre-ocupied with 4 tags. The last tag (CSS) has the same value as the first tag, and will be removed,
													because the duplicates setting is set to true.
												</div>
											</div>
										</div>

										<div class="separator separator--dashed separator--lg">
										</div>

										<div class="form-group form-group-last row">
											<label class="col-form-label col-lg-3 col-sm-12">Whitelist examples</label>
											<div class="col-lg-6 col-md-9 col-sm-12">
												<tags class="tagify" aria-haspopup="true" aria-expanded="false" role="tagslist">
													<tag title="Back to the Future" contenteditable="false" spellcheck="false" class="tagify__tag tagify--noAnim" role="tag" value="Back to the Future">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">Back to the Future</span></div>
													</tag>
													<tag title="Whiplash" contenteditable="false" spellcheck="false" class="tagify__tag tagify--noAnim" role="tag" value="Whiplash">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">Whiplash</span></div>
													</tag><span contenteditable="" data-placeholder="type..." aria-placeholder="type..." class="tagify__input" role="textbox" aria-multiline="false"></span>
												</tags><input id="tagify_2" placeholder="type..." value="Back to the Future, Whiplash" autofocus="" data-blacklist=".NET,PHP">

												<div class="margin-t-10">
													In this example, the field is pre-ocupied with 3 tags, and last tag is not included in the whitelist, and will be removed because the enforceWhitelist option flag is set to true
												</div>
											</div>
										</div>

										<div class="separator separator--dashed separator--lg">
										</div>

										<div class="form-group form-group-last row">
											<label class="col-form-label col-lg-3 col-sm-12">Templates examples</label>
											<div class="col-lg-6 col-md-9 col-sm-12">
												<tags class="tagify  " aria-haspopup="true" aria-expanded="false" role="tagslist">
													<tag title="Chris Muller" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--brand tagify--noAnim" role="tag" pic="./media/users/100_11.jpg" email="chris.muller@wix.com" value="Chris Muller">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">Chris Muller</span></div>
													</tag>
													<tag title="Lina Nilson" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--brand tagify--noAnim" role="tag" pic="./media/users/100_15.jpg" initialsstate="danger" initials="LN" email="lina.nilson@loop.com" value="Lina Nilson">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">Lina Nilson</span></div>
													</tag><span contenteditable="" data-placeholder="Add users" aria-placeholder="Add users" class="tagify__input" role="textbox" aria-multiline="false"></span>
												</tags><input id="tagify_5" name="tags3" placeholder="Add users" value="Chris Muller, Lina Nilson">

												<div class="margin-t-10">
													Dropdown item and tag templates.
												</div>
											</div>
										</div>

										<div class="separator separator--dashed separator--lg">
										</div>

										<div class="form-group form-group-last row">
											<label class="col-form-label col-lg-3 col-sm-12">Outside of the box example</label>
											<div class="col-lg-6 col-md-9 col-sm-12">
												<span contenteditable="" data-placeholder="write some tags" aria-placeholder="write some tags" class="tagify__input form-control" role="textbox" aria-multiline="false" placeholder="enter tag..."></span>
												<tags class="tagify  tagify tagify--outside" aria-haspopup="true" aria-expanded="false" role="tagslist">
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
													</tag>
												</tags><input id="tagify_3" name="tags-outside" class="tagify tagify--outside" value="css, html, javascript" placeholder="write some tags">

												<div class="margin-t-10">
													Some cases might require addition of tags from outside of the box and not within.
												</div>
											</div>
										</div>

										<div class="separator separator--dashed separator--lg">
										</div>

										<div class="form-group form-group-last row">
											<label class="col-form-label col-lg-3 col-sm-12">Advance examples</label>
											<div class="col-lg-6 col-md-9 col-sm-12">
												<tags class="tagify hasMaxTags" aria-haspopup="true" aria-expanded="false" role="tagslist">
													<tag title="css" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--warning tagify--noAnim" role="tag" value="css">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">css</span></div>
													</tag>
													<tag title="html" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--dark tagify--noAnim" role="tag" value="html">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">html</span></div>
													</tag>
													<tag title="javascript" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--danger tagify--noAnim" role="tag" value="javascript">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">javascript</span></div>
													</tag>
													<tag title="angular" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--success tagify--noAnim" role="tag" value="angular">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">angular</span></div>
													</tag>
													<tag title="vue" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--danger tagify--noAnim" role="tag" value="vue">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">vue</span></div>
													</tag>
													<tag title="react" contenteditable="false" spellcheck="false" class="tagify__tag tagify__tag--success tagify--noAnim" role="tag" value="react">
														<x title="" class="tagify__tag__removeBtn" role="button" aria-label="remove tag"></x>
														<div><span class="tagify__tag-text">react</span></div>
													</tag><span contenteditable="" data-placeholder="Write some tags" aria-placeholder="Write some tags" class="tagify__input" role="textbox" aria-multiline="false"></span>
												</tags><input id="tagify_4" name="tags3" placeholder="Write some tags" pattern="^[A-Za-z_✲ ]{1,15}$" value="css, html, javascript, angular, vue, react">

												<div class="margin-t-10">
													In this example, the dropdown.enabled setting is set (minimum charactes typed to show the dropdown) to 3.
													Maximum number of tags is set to 6
												</div>
											</div>
										</div>
									</div>
									<div class="card__foot">
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