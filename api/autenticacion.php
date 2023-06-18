<?php

// Recibe los parámetros de usuario y contraseña
// mediante elmetodo POST 
//este es enviado mediante un formulario HTML
$user = $_POST['user'];
$password = $_POST['password'];

// Lógica de autenticación
//Se compara el usuario y la contraseña ingresados con los valores esperados ('usuario' y 'contrasena' en este caso). Si ambos coinciden, se crea un array llamado $response con el campo 'success' establecido en true y un mensaje de autenticación satisfactoria. Si no coinciden, se crea el mismo array $response, pero con 'success' establecido en false y un mensaje de error en la autenticación.
if ($user === 'ligia' && $password === '8956') {
    // Autenticación exitosa
    $response = array(
        'success' => true,
        'message' => 'Autenticación satisfactoria'
    );
} else {
    // Error de autenticación
    $response = array(
        'success' => false,
        'message' => 'Error en la autenticación'
    );
}

// Devuelve la respuesta en formato JSON
//Esta parte se encarga de enviar la respuesta al cliente en formato JSON. Establece la cabecera de respuesta con el tipo de contenido 'application/json' para indicar que se enviará una respuesta en JSON. Luego, se utiliza la función json_encode() para convertir el array $response en una cadena JSON y se envía la respuesta al cliente con echo.
header('Content-Type: application/json');
echo json_encode($response);
