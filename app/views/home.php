<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Prediction</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>
<body>
	<!-- Simple header with fixed tabs. -->
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
	            mdl-layout--fixed-tabs">
	  <header class="mdl-layout__header">
	    <div class="mdl-layout__header-row">
	      <!-- Title -->
	      <span class="mdl-layout-title">Prediction</span>
	      <div class="mdl-layout-spacer"></div>
	      <nav class="mdl-navigation">
	      	<?php
	      	if (isset($_SESSION['prediction_token']) && !empty($_SESSION['prediction_token'])) :
	      	?>
	        <a class="mdl-navigation__link" href="/logout">Log Out</a>
	        <?php
	        else:
	        ?>
	    	<a class="mdl-navigation__link" href="<?=$authUrl?>">Connect your Google Account</a>
		    <?php
		    endif;
		    ?>
	      </nav>
	    </div>
	    <!-- Tabs -->
	    <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
	      <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Connect</a>
	      <a href="#fixed-tab-2" class="mdl-layout__tab">Train</a>
	      <a href="#fixed-tab-3" class="mdl-layout__tab">Predict</a>
	    </div>
	  </header>
	  <div class="mdl-layout__drawer">
	    <span class="mdl-layout-title">Prediction</span>
	  </div>
	  <main class="mdl-layout__content">
	    <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
	      <div class="page-content">
			<div class="mdl-grid">
			  <div class="mdl-cell mdl-cell--2-col">
			  </div>
			  <div class="mdl-cell mdl-cell--8-col">
			  	<h1 class="mdl-typography--text-center">Please connect your Google Account</h1>
			  </div>
			  <div class="mdl-cell mdl-cell--2-col">
			  </div>
			</div>
	      </div>
	    </section>
	    <section class="mdl-layout__tab-panel" id="fixed-tab-2">
	      <div class="page-content"><!-- Your content goes here --></div>
	    </section>
	    <section class="mdl-layout__tab-panel" id="fixed-tab-3">
	      <div class="page-content"><!-- Your content goes here --></div>
	    </section>
	  </main>
	</div>
</body>
</html>