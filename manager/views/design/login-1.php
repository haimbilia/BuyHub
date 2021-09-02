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


<body class="is-login  login-1">
	<div id="particles-js"></div>
	<div class="login-page">
		<div class="container">
			<div class="row align-item-center justify-content-center">
				<div class="col-md-4">
					<div class="card">
						<div class="card-head">
							<figure class="logo text-center p-4 mx-auto">
								<a href="index.php"><img title="Yo!Kart" src="media/logos/logo-coloured.png" alt="Yo!Kart"></a></figure>
						</div>
						<div class="card-body p-5">
							<form class="form">
						
								<div class="form-group"><input class="form-control" title="Username" placeholder="Username" type="text" value="">
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
										<input disabled title="" type="submit" value="Login" class="btn btn-primary btn-lg btn-block not-allowed">
									</div>
								</div>
							</form>
						</div>
					</div>
					<p class="version text-white text-center mt-5"><strong>Admin version 2019</strong></p>
				</div>
			</div>
		</div>
	</div>
	<script src="js/vendors/particles.min.js"></script>
	<script src="js/vendors/script.js"></script>
</body>

</html>