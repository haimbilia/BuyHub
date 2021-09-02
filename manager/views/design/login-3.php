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



<body class="is-login login-3">
	<div class="login login-V3">
		<div class="login__wrapper">
			<div class="login-aside" style="background-image: url(./media/bg/bg-page-section.png)">
				<div class="login-aside__head">
					<a href="#" class="login-aside__logo"><img src="media/logos/logo-icon-sm.png" /></a>
				</div>
				<div class="login-aside___body">
					<div class="login-aside__content">
						<h3>Welcome to fatbit!</h3>
						<p>The ultimate Bootstrap & Angular 6 admin theme framework for next generation web apps.</p>
					</div>
				</div>

				<div class="login-aside__footer">
					<p class="version text-white mt-2"><strong>Admin version 2019</strong></p>
				</div>
			</div>
			<div class="login-main">
				<div class="login-main__body">
					<form class="form form--login">
						<h3 class="mb-4">Welcome Back</h3>
						<div class="form-group">
							<input class="form-control" title="Username" placeholder="Username" type="text" value="">
						</div>
						<div class="form-group">
							<input class="form-control" title="Password" placeholder="Password" type="password" value="">
						</div>
						<div class="row pt-3 pb-3">
							<div class="col-6">
								<div class="field-set ">
									<label class="switch switch--sm remember-me">
										<input type="checkbox" name="">
										<span></span>Remember Me </label>
								</div>
							</div>
							<div class="col-6">
								<div class="field-set text-right">
									<a href="" class="link">Forgot Password?</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input disabled="" title="" type="submit" value="Login" class="btn btn-primary btn-lg btn-block not-allowed">
							</div>
						</div>
					</form>


				</div>



			</div>
		</div>
	</div>

</body>


</html>