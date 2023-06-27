<?php
// Comprobar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Comprobar que se ha proporcionado la clave secreta de reCAPTCHA
	if (!empty($_POST['token'])) {
		// Verificar la respuesta de reCAPTCHA con la clave secreta y la respuesta del usuario
		$respuesta_recaptcha = $_POST['token'];
		$clave_secreta_recaptcha = '6LezJyImAAAAAHOMtWmJcYsy-xGSKygLaTpvnZ_w';
		$respuesta = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . 
            urlencode($clave_secreta_recaptcha) . '&response=' . urlencode($respuesta_recaptcha));
		$respuesta = json_decode($respuesta);
	
		//mostrar objeto JSON con el resultado. Sólo en depuración.
		echo "# Respuesta de la API reCAPTCHA V3" . "<br>";
        echo "<pre>";
        print_r($respuesta);
        echo "</pre>";

        // Verificar si el reCAPTCHA es correcto
        if ($respuesta->success && $respuesta->score > .6 ) {
                // Aquí vendría el procesamiento adicional de los datos al superar el reCAPTCHA
                // ...
                echo "¡El formulario se ha enviado correctamente!";
            } else {
                // El reCAPTCHA no fue válido, mostrar un mensaje de error
                echo "Error: reCAPTCHA inválido. Por favor, inténtalo de nuevo.";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario con reCAPTCHA</title>
    <script src="https://www.google.com/recaptcha/api.js?render=6LezJyImAAAAAMY_aVlRAY1apDz7_seiwQPycg1_"
        data-badge="bottomright"></script>

</head>
<body>
    <h1>Formulario con reCAPTCHA V3</h1>
    <form  id="miForm" action="?" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" required></textarea><br><br>
        
        <!-- Agrega aquí el campo oculto para el token de reCAPTCHA -->
        <input type="hidden" name="token" id="recaptchaToken">
        
        <br>
        <input type="submit" value="Enviar" onclick="enviarToken(event)">
    </form>
    
    <script>
        function enviarToken(event) {
            event.preventDefault();

            grecaptcha.ready(function() {
                grecaptcha.execute('6LezJyImAAAAAMY_aVlRAY1apDz7_seiwQPycg1_', { action: 'submit' }).then(function(token) {
                    // Lógica para enviar el token al servidor backend
                    document.getElementById("recaptchaToken").value = token;
                    document.getElementById("miForm").submit();
                });
            });
        }
    </script>
    
</body>
</html>
