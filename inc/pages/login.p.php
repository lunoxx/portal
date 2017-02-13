
	<div class="page-header title hidden-xs">
		<h1>Autentificare <span class="sub-title"></span></h1>
	</div>

	<div class="page-header title visible-xs">
		<h1>Autentificare <span class="sub-title"></span></h1>
	</div>

	<form method="post" action="dologin.php" class="form-horizontal">
		<input type="hidden" name="token" value="f9668d0c7ed3f41f368d08838446cc581f136ac0">

		<fieldset>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="username">Adresa email:</label>
				<div class="col-sm-9">
					<input class="col-xs-12 col-sm-3" name="username" id="username" type="text">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label" for="password">Parola:</label>
				<div class="col-sm-9">
					<input class="col-xs-12 col-sm-3" name="password" id="password" type="password">
				</div>
			</div>
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<input type="submit" class="btn btn-primary" value="Autentifică-te"> 
					<input type="checkbox" name="rememberme"> <strong>nu mă uita</strong>
				</div>
				</div>
		</fieldset>
		<div class="col-md-offset-3 col-md-9">
			<p><a href="pwreset.php" class="btn btn-xs btn-inverse">Solicită regenerarea parolei</a></p>
			<br><br><br><br><br>
		</div>
	</form>

	<script type="text/javascript">
	$("#username").focus();
	</script>
