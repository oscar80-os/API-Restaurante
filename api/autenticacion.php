<?php

$user = $_POST['user'];
$password = $_POST['password'];

if ($user === 'oscar' && $password === '8012') {
    // Autenticación exitosa
    header('Location: http://localhost:3000/navegacion.php');
    exit();
} else {
    // Error de autenticación
    $response = array(
        'success' => false,
        'message' => 'Error en la autenticación'
    );
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
