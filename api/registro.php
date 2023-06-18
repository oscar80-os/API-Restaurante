<?php
// Recibe los parámetros de usuario, contraseña y correo electrónico
$user = $_POST['user'];
$password = $_POST['password'];
$email = $_POST['email'];



// Ejemplo de respuesta
$response = array(
    'success' => true,
    'message' => 'Registro exitoso'
);

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
