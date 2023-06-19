<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    
    <title>Restaurante login</title>
</head>
<body>
    <div class="img">
        <img src="img/cocinera_logo.png" alt="logo">
    </div>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="api/autenticacion.php" method="POST">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="user" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Iniciar Sesión</button>
            </div>
        </form>

        <div class="register-link">
            ¿No tienes una cuenta? <a href="registro.html">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>
