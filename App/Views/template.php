<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Prediction</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<script src="/App/Callers/Predict.js"></script>
	<script src="/App/Callers/Train.js"></script>
	<script src="/App/Callers/State.js"></script>

	<script>
		var authenticated = '<?=isset($_SESSION['prediction_token'])?>';
	</script>
</head>
<body>
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
	  	<header class="mdl-layout__header">
			<div class="mdl-layout__header-row">
			    <span class="mdl-layout-title">Prediction</span>
				<div class="mdl-layout-spacer"></div>
				<nav class="mdl-navigation">
				    <?php
				    if (isset($_SESSION['prediction_token'])) :
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
				<a href="#fixed-tab-1" class="mdl-layout__tab is-active js-connect-tab">Connect</a>
				<a href="#fixed-tab-2" class="mdl-layout__tab js-train-tab">Train</a>
				<a href="#fixed-tab-3" class="mdl-layout__tab">Predict</a>
			</div>
	  	</header>
		<div class="mdl-layout__drawer">
			<span class="mdl-layout-title">Prediction</span>
		</div>
	  	<main class="mdl-layout__content">
			<section class="mdl-layout__tab-panel is-active js-connect-tab" id="fixed-tab-1">
				<div class="page-content">
					<div class="mdl-grid">
					    <div class="mdl-cell mdl-cell--2-col"></div>

					    <div class="mdl-cell mdl-cell--8-col">

                            <?php
                            if (isset($_SESSION['prediction_token'])) :
                                ?>
								<h1 class="mdl-typography--text-center">Go to "Train" tab</h1>
                                <?php
                            else:
                                ?>
								<h1 class="mdl-typography--text-center">Please connect your Google Account</h1>
                                <?php
                            endif;
                            ?>
					    </div>

					    <div class="mdl-cell mdl-cell--2-col"></div>
					</div>
				</div>
			</section>
			<section class="mdl-layout__tab-panel js-train-tab" id="fixed-tab-2">
			    <div class="page-content">
				    <div class="mdl-grid">
					    <div class="mdl-cell mdl-cell--4-col">
							<p>Training status: loading</p>
						</div>

						<div class="mdl-cell mdl-cell--4-col">
							<form class="js-train">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" type="text" id="fileName" name="fileName">
									<label class="mdl-textfield__label" for="fileName">Enter the file name</label>
								</div>

								<input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" value="Train!">
							</form>
						</div>

						<div class="mdl-cell mdl-cell--4-col"></div>
					</div>
			    </div>
			</section>
			<section class="mdl-layout__tab-panel" id="fixed-tab-3">
			    <div class="page-content">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--4-col"></div>

						<div class="mdl-cell mdl-cell--4-col">
							<h3>Send prediction data</h3>

							<form class="js-predict">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" type="text" id="predictContent" name="predictContent">
									<label class="mdl-textfield__label" for="predictContent">Predict this content</label>
								</div>

								<input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" value="Train!">
							</form>
						</div>

						<div class="mdl-cell mdl-cell--4-col">
							<h3>Prediction results</h3>

							<div class="prediction-results"></div>
						</div>
					</div>
			    </div>
			</section>
	  	</main>
	</div>
</body>
</html>