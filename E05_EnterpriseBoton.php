<?php
// Comprobar que se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprobar que se ha proporcionado la clave secreta de reCAPTCHA
    if (!empty($_POST['g-recaptcha-response'])) {
        // Verificar la respuesta de reCAPTCHA con la clave secreta y la respuesta del usuario
        $respuesta_recaptcha = $_POST['g-recaptcha-response'];
        $clave_secreta_recaptcha = '6LeeMoomAAAAAE5GPNfj-rF28G9KFyRqkImP-RcJ';
        $respuesta = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' .
            urlencode($clave_secreta_recaptcha) . '&response=' . urlencode($respuesta_recaptcha));
        $respuesta = json_decode($respuesta);
        //mostrar objeto JSON con el resultado. Sólo en depuración.
        echo "# Respuesta de la API reCAPTCHA Enterprise" . "";
        echo "";
        print_r($respuesta);
        echo "";
        // Verificar si el reCAPTCHA es correcto
        if ($respuesta->success && $respuesta->action == "opinion" && $respuesta->score > .6) {
            // Aquí vendría el procesamiento adicional de los datos al superar el reCAPTCHA
            // ...
            echo "<br>" . "¡El formulario se ha enviado correctamente!";
        } else {
            // El reCAPTCHA no fue válido, mostrar un mensaje de error
            echo "<br>" . "Error: reCAPTCHA inválido. Por favor, inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario con reCAPTCHA</title>

    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LeeMoomAAAAAHMKm0AlFmALlWkSnHy01VQTy0J0" 
                data-badge="bottomright"></script>

</head>

<body>
    <h1>Formulario con reCAPTCHA Enterprise</h1>
    <form id="miForm" action="?" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" required></textarea><br><br>
        
        <br>
        <button class="g-recaptcha" 
        data-sitekey="6LeeMoomAAAAAHMKm0AlFmALlWkSnHy01VQTy0J0" 
        data-callback='onSubmit'
        data-theme="dark"
        data-action='opinion'>Enviar</button>
    </form>
    
   <script>
   function onSubmit(token) {
     document.getElementById("miForm").submit();
   }
 </script>
</body>
</html>