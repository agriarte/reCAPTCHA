<!DOCTYPE html>
	<html>
	<head>
		<title>reCAPTCHA demo: Render explícito mínimo</title>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
		<script type="text/javascript">

			function onloadCallback() {
				// Renderiza el elemento HTML con id 'ejemplo' como un widget recaptcha			
				grecaptcha.render('ejemplo', {
					'sitekey': '6LeOxLokAAAAABbF3Fn_OulxRlOiM9NwRQB0UgAA',
				});
			};
		</script>
	</head>

	<body>
		<!-- Formulario mínimo -->
		<form action="?" method="POST">
			<div id="ejemplo"></div>
			<br>
			<input type="submit" value="Enviar">
		</form>
	</body>
</html>