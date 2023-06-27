<?php
// Comprobar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Comprobar que se ha proporcionado la clave secreta de reCAPTCHA
	if (!empty($_POST['g-recaptcha-response'])) {
		// Verificar la respuesta de reCAPTCHA con la clave secreta y la respuesta del usuario
		$respuesta_recaptcha = $_POST['g-recaptcha-response'];
		$clave_secreta_recaptcha = '6LeOxLokAAAAAKE_YC9qUNUpphbA92AYEBwK3zss';
		$respuesta = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . 
            urlencode($clave_secreta_recaptcha) . '&response=' . urlencode($respuesta_recaptcha));
		$respuesta = json_decode($respuesta);
	
		//mostrar objeto en depuración
		print2depurar($respuesta);

		if ($respuesta->success) {
			// La respuesta de reCAPTCHA es válida, procesar el envío del formulario
			$nombre = $_POST['nombre'];
			$email = $_POST['email'];
			$mensaje = $_POST['mensaje'];
			// Hacer lo que sea necesario con los datos del formulario
			echo 'Formulario enviado correctamente';
		} else {
			// La respuesta de reCAPTCHA es inválida, mostrar un mensaje de error
			echo 'Error: por favor, verifica que eres humano';
		}
	} else {
		// La clave secreta de reCAPTCHA no se proporcionó, mostrar un mensaje de error
		echo 'Error: por favor, verifica que eres humano. No marcaste la casilla "No soy un Robot"';
	}
}
?>

<?php
// Diferentes maneras de mostrar un objeto PHP para depurar
function print2depurar($resp)
{
    echo "# Con var_dump()" . "<br><br>";
    var_dump($resp);
    echo "<br><br>";
    
    echo "# Con print_r() entre etiquetas HTML <pre>" . "<br>";
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
    
    echo "# Con json_encode con parámetro JSON_PRETTY_PRINT y nl2br()" . "<br><br>";
    $jsonRespuesta = json_encode($resp, JSON_PRETTY_PRINT);
    //Convertir los saltos de línea (\n) en etiquetas HTML <br>.
    echo nl2br($jsonRespuesta);
    echo "<br><br>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario con reCAPTCHA</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h1>Formulario con reCAPTCHA V2</h1>
    <form action="?" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" required></textarea><br><br>
        <!-- clave sitio web -->
        <div class="g-recaptcha" data-sitekey="6LeOxLokAAAAABbF3Fn_OulxRlOiM9NwRQB0UgAA"></div>
        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>