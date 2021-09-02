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
	
	<link href="/yokart/public/manager.php?url=js-css/css&f=css%2Fmain-ltr.css" rel="stylesheet" type="text/css" />
	
	<link rel="shortcut icon" href="images/favicon.ico" />
</head>



<body class="">
	<div class="wrapper">

		<?php
  include 'includes/header.php';
?>

		<div class="body" id="body">
			<div class="content content--fit-top  grid__item grid__item--fluid grid grid--hor" id="content">

				<!-- begin:: Subheader -->
				<div id="subheader" class="subheader" >
					<div class="container ">
						<div class="subheader__main">
							<h3 class="subheader__title">Typography</h3>

							<div class="subheader__breadcrumbs">
								<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Components </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Base </a>
								<span class="subheader__breadcrumbs-separator"></span>
								<a href="" class="subheader__breadcrumbs-link">
									Typography </a>
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
						<div class="col-md-6">
							<!--begin::card-->
							<div class="card card--tab">
								<div class="card-head">
									<div class="card-head-label">
										<span class="card-head-icon hide">
											<i class="la la-gear"></i>
										</span>
										<h3 class="card-head-title">
											Headings
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											All HTML headings, <code>&lt;h1&gt;</code> through <code>&lt;h6&gt;</code>, are available.
										</span>
										<div class="section__content section__content--solid">
											<div class="row">
												<div class="col-md-6">
													<h1>h1. Heading 1</h1>
													<div class="space-10"></div>
													<h2>h2. Heading 2</h2>
													<div class="space-10"></div>
													<h3>h3. Heading 3</h3>
													<div class="space-10"></div>
													<h4>h4. Heading 4</h4>
													<div class="space-10"></div>
													<h5>h5. Heading 5</h5>
													<div class="space-10"></div>
													<h6>h6. Heading 6</h6>
												</div>
												<div class="col-md-6">
													<h1 class="font-success">h1. Heading 1</h1>
													<div class="space-10"></div>
													<h2 class="font-info">h2. Heading 2</h2>
													<div class="space-10"></div>
													<h3 class="font-warning">h3. Heading 3</h3>
													<div class="space-10"></div>
													<h4 class="font-danger">h4. Heading 4</h4>
													<div class="space-10"></div>
													<h5 class="font-primary">h5. Heading 5</h5>
													<div class="space-10"></div>
													<h6 class="font-brand">h6. Heading 6</h6>
												</div>
											</div>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Use the included utility classes to recreate the small secondary heading text.
										</span>
										<div class="section__content section__content--solid">
											<h3>
												Fancy display heading
												<small class="text-muted">With faded secondary text</small>
											</h3>
										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Larger, slightly more opinionated heading styles.
										</span>
										<div class="section__content section__content--solid">
											<h3 class="display-1">Display 1</h3>
											<h3 class="display-2">Display 2</h3>
											<h3 class="display-3">Display 3</h3>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Make a paragraph stand out by adding <code>.lead</code>.
										</span>
										<div class="section__content section__content--solid">
											<p class="lead">
												Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.
											</p>

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
											General
										</h3>
									</div>
								</div>
								<div class="card-body">

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Styling for common inline HTML5 elements:
										</span>
										<div class="section__content section__content--solid">
											<p>You can use the mark tag to
												<mark>highlight</mark> text.</p>
											<p><del>This line of text is meant to be treated as deleted text.</del></p>
											<p><s>This line of text is meant to be treated as no longer accurate.</s></p>
											<p><ins>This line of text is meant to be treated as an addition to the document.</ins></p>
											<p><u>This line of text will render as underlined</u></p>
											<p><small>This line of text is meant to be treated as fine print.</small></p>
											<p><strong>This line rendered as bold text.</strong></p>
											<p><em>This line rendered as italicized text.</em></p>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Stylized abbreviations implementation of HTML’s <code>&lt;abbr&gt;</code> element:
										</span>
										<div class="section__content section__content--solid">
											<p><abbr title="attribute">attr</abbr></p>
											<p><abbr title="HyperText Markup Language" class="initialism">HTML</abbr></p>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Quoting blocks of content:
										</span>
										<div class="section__content section__content--solid">
											<div class="demo" data-code-preview="true" data-code-html="true" data-code-js="false">
												<div class="demo__preview">
													<blockquote class="blockquote">
														<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
														<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
													</blockquote>

													<blockquote class="blockquote blockquote-reverse">
														<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
														<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
													</blockquote>
												</div>
											</div>
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
											Text
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Basic text examples:
										</span>
										<div class="section__content section__content--solid">
											<p><span>Example text</span></p>
											<p><span class="font-bold">Example bold text</span></p>
											<p><span class="font-bolder">Example bolder text</span></p>
											<p><span class="font-boldest">Example boldest text</span></p>
											<p><span class="font-transform-u">Example uppercase text</span></p>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											State colors:
										</span>
										<div class="section__content section__content--solid">
											<p><span class="font-success">Success state text</span></p>
											<p><span class="font-warning">Warning state text</span></p>
											<p><span class="font-info">Info state text</span></p>
											<p><span class="font-danger">Danger state text</span></p>
											<p><span class="font-primary">Primary state text</span></p>
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
											Links
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Basic link examples:
										</span>
										<div class="section__content section__content--solid">
											<p><a href="#" class="link">Example link</a></p>
											<p><a href="#" class="link font-bold">Example bold link</a></p>
											<p><a href="#" class="link font-bolder">Example bolder link</a></p>
											<p><a href="#" class="link font-boldest">Example boldest link</a></p>
											<p><a href="#" class="link font-transform-u">Example uppercase link</a></p>

										</div>
									</div>
									<!--end::Section-->

									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											State colors:
										</span>
										<div class="section__content section__content--solid">
											<p><a href="#" class="link link--state link--success">Success state</a></p>
											<p><a href="#" class="link link--state link--warning">Warning state</a></p>
											<p><a href="#" class="link link--state link--info">Info state</a></p>
											<p><a href="#" class="link link--state link--danger">Danger state</a></p>
											<p><a href="#" class="link link--state link--primary">Primary state</a></p>

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
											Divider
										</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<span class="section__info">
											Basic divider:
										</span>
										<div class="section__content section__content--solid">
											<div class="divider">
												<span></span>
												<span>or</span>
												<span></span>
											</div>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
							<!--end::card-->

							<!--begin::card-->
							<div class="card">
								<div class="card-head">
									<div class="card-head-label">
										<h3 class="card-head-title">Section</h3>
									</div>
								</div>
								<div class="card-body">
									<!--begin::Section-->
									<div class="section">
										<div class="section__title">
											Section Title
										</div>
										<div class="section__desc">
											Section description text.
										</div>
										<div class="section__content">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
										</div>

										<div class="separator separator--space-lg separator--border-dashed"></div>

										<div class="section__info">
											Other info text.
										</div>

										<div class="section__content">
											Aipiscing ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
											Aadipiscing elit, sed do eiusmod tempor, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
										</div>

										<div class="separator separator--space-lg separator--border-solid"></div>

										<div class="section__desc">
											Other description text.
										</div>

										<div class="section__content">
											Aipiscing ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
											Aadipiscing elit, sed do eiusmod tempor, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
										</div>
									</div>
									<!--end::Section-->
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