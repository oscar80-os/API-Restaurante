<?php
$host = 'localhost';
$dbname = 'restaurante_pueba';
$username = 'root';
$password = 'Osc@r801223';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

function crearCliente($nombre, $apellido, $direccion, $telefono, $email) {
    global $pdo;

    $query = "INSERT INTO clientes (Nombre, Apellido, Direccion, Telefono, Email) VALUES (:nombre, :apellido, :direccion, :telefono, :email)";
    $statement = $pdo->prepare($query);
    $statement->execute(['nombre' => $nombre, 'apellido' => $apellido, 'direccion' => $direccion, 'telefono' => $telefono, 'email' => $email]);

    $id = $pdo->lastInsertId();

    return $id;
}

function obtenerClientes() {
    global $pdo;

    $query = "SELECT * FROM clientes";
    $statement = $pdo->query($query);
    $clientes = $statement->fetchAll();

    return $clientes;
}

function obtenerClientePorId($id) {
    global $pdo;

    $query = "SELECT * FROM clientes WHERE idCliente = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $id]);
    $cliente = $statement->fetch();

    return $cliente;
}

function actualizarCliente($id, $nombre, $apellido, $direccion, $telefono, $email) {
    global $pdo;

    $query = "UPDATE clientes SET Nombre = :nombre, Apellido = :apellido, Direccion = :direccion, Telefono = :telefono, Email = :email WHERE idCliente = :id";

    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $id, 'nombre' => $nombre, 'apellido' => $apellido, 'direccion' => $direccion, 'telefono' => $telefono, 'email' => $email]);

    return $statement->rowCount();
}

function eliminarCliente($id) {
    global $pdo;

    $query = "DELETE FROM clientes WHERE idCliente = :id";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $id]);

    return $statement->rowCount();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_cliente'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        $clienteId = crearCliente($nombre, $apellido, $direccion, $telefono, $email);

        if ($clienteId) {
            echo "Se ha creado un nuevo cliente con ID: " . $clienteId . "<br>";
        } else {
            echo "Error al crear el cliente.<br>";
        }
    } elseif (isset($_POST['eliminar_cliente'])) {
        $idCliente = $_POST['eliminar_cliente'];

        $eliminados = eliminarCliente($idCliente);

        if ($eliminados > 0) {
            echo "Cliente eliminado correctamente.<br>";
        } else {
            echo "Error al eliminar el cliente.<br>";
        }
    } elseif (isset($_POST['modificar_cliente'])) {
        $idCliente = $_POST['modificar_cliente'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        $actualizados = actualizarCliente($idCliente, $nombre, $apellido, $direccion, $telefono, $email);

        if ($actualizados > 0) {
            echo "Cliente actualizado correctamente.<br>";
        } else {
            echo "Error al actualizar el cliente.<br>";
        }
    }
}

$clientes = obtenerClientes();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/crud_interfaz.css">
    <title>CRUD Interfaz</title>
</head>
<body>
    <h1>Crear Cliente</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <input type="submit" name="crear_cliente" value="Crear">
    </form>

    <h1>Listado de Clientes</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php
        foreach ($clientes as $cliente) {
            echo "<tr>";
            echo "<td>" . $cliente['idCliente'] . "</td>";
            echo "<td>" . $cliente['Nombre'] . "</td>";
            echo "<td>" . $cliente['Apellido'] . "</td>";
            echo "<td>" . $cliente['Direccion'] . "</td>";
            echo "<td>" . $cliente['Telefono'] . "</td>";
            echo "<td>" . $cliente['Email'] . "</td>";
            echo "<td>";
            echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
            echo "<input type='hidden' name='eliminar_cliente' value='" . $cliente['idCliente'] . "'>";
            echo "<input type='submit' value='Eliminar'>";
            echo "</form>";
            echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
            echo "<input type='hidden' name='modificar_cliente' value='" . $cliente['idCliente'] . "'>";
            echo "<label for='nombre'>Nombre:</label>";
            echo "<input type='text' name='nombre' required value='" . $cliente['Nombre'] . "'><br>";
            echo "<label for='apellido'>Apellido:</label>";
            echo "<input type='text' name='apellido' required value='" . $cliente['Apellido'] . "'><br>";
            echo "<label for='direccion'>Dirección:</label>";
            echo "<input type='text' name='direccion' required value='" . $cliente['Direccion'] . "'><br>";
            echo "<label for='telefono'>Teléfono:</label>";
            echo "<input type='text' name='telefono' required value='" . $cliente['Telefono'] . "'><br>";
            echo "<label for='email'>Email:</label>";
            echo "<input type='email' name='email' required value='" . $cliente['Email'] . "'><br>";
            echo "<input type='submit' value='Modificar'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h1>Búsqueda de Cliente por ID</h1>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="idCliente">ID Cliente:</label>
        <input id="busqueda" type="text" name="idCliente" required>
        <input id="busqueda" type="submit" name="buscar_cliente" value="Buscar">
    </form>

    <?php
    if (isset($_GET['buscar_cliente'])) {
        $idCliente = $_GET['idCliente'];
        $cliente = obtenerClientePorId($idCliente);

        if ($cliente) {
            
            echo "<h2>Resultado de la búsqueda</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Dirección</th><th>Teléfono</th><th>Email</th></tr>";
            echo "<tr>";
            echo "<td>" . $cliente['idCliente'] . "</td>";
            echo "<td>" . $cliente['Nombre'] . "</td>";
            echo "<td>" . $cliente['Apellido'] . "</td>";
            echo "<td>" . $cliente['Direccion'] . "</td>";
            echo "<td>" . $cliente['Telefono'] . "</td>";
            echo "<td>" . $cliente['Email'] . "</td>";
            echo "</tr>";
            echo "</table>";
        } else {
            echo "Cliente no encontrado.";
        }
    }
    ?>

<a href="#busqueda">
	    <img class="btn-wsp" src="/img/boton de busqueda.png" alt="BotonDeBusqueda">
	</a>

</body>
</html>
