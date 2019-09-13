<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@<?php echo $config['twitter']['username']; ?> - <?php echo $config['twitter']['name']; ?> - Tweets</title>
	<link href="<?php echo $config['system']['baseUrl']; ?>assets/bootstrap4/css/bootstrap-reboot.min.css" rel="stylesheet">
	<link href="<?php echo $config['system']['baseUrl']; ?>assets/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $config['system']['baseUrl']; ?>css/archive.css" rel="stylesheet">
	<link href="<?php echo $config['system']['baseUrl']; ?>?atom=1" rel="alternate" title="Tweets for <?php echo $config['twitter']['name']; ?>" type="application/atom+xml" />
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body class="amt-<?php echo $pageType; ?>">

	<nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
		<button aria-controls="navbar" data-target="#navbar" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a href="<?php echo $config['system']['baseUrl']; ?>" class="navbar-brand">
			<img style="d-inline-block align-top" src="<?php echo $config['system']['baseUrl']; ?>img/avatar.gif" height="30">
			@<?php echo $config['twitter']['username']; ?>
		</a>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo $config['system']['baseUrl']; ?>stats">Stats</a>
				</li>
			</ul>
			<form class="form-inline" action="<?php echo $config['system']['baseUrl']; ?>" method="get">
				<input class="form-control mr-sm-2" name="q" value="" placeholder="Search my tweets" type="text">
				<button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>

	<div class="container-fluid" style="margin-top: 20px;">
		<div class="row">

			<?php echo $content; ?>

		</div><!-- /.row -->
	</div><!-- /.container -->

	<div class="footer" id="footer">
		<div class="container">
			<p>This is a fork of Archive My Tweets <small>(with stats, an Atom feed and Bootstrap 4)</small> by <a href="https://kdy.ch">MKody</a>.</p>
			<p><a href="http://amwhalen.com/projects/archive-my-tweets/">Archive My Tweets</a> by <a href="http://amwhalen.com">Andrew M. Whalen</a>.</p>
		</div><!-- /.container -->
	</div><!-- /.footer -->

	<script src="<?php echo $config['system']['baseUrl']; ?>assets/jquery/jquery-3.1.1.min.js"></script>
	<script src="<?php echo $config['system']['baseUrl']; ?>assets/bootstrap4/js/bootstrap.min.js"></script>
</body>
</html>
