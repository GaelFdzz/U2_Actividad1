<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/libreria/admin/frontend/styles/mostrar_libros.css">
    <title>Listado de Libros</title>
</head>
<body>
    <h1>Listado de Libros</h1>
    <a href="/libreria/admin/index.php">Regresar</a>
    <?php
    //Conexión a la Base de Datos
    $conexion = mysqli_connect('localhost', 'root', '', 'libreria', '3306');

    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    //Consulta SQL para Obtener Libros
    $query = "SELECT * FROM libros";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
    ?>

    <!-- Impresión de la Tabla HTML -->
    <table>
        <thead>
            <tr>
                <th>ISBN</th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Precio</th>
                <th>Editorial</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterar sobre los Resultados y Mostrar en la Tabla
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['isbn']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['autor']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['precio']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['editorial']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($fila['imagen']) . "' alt='Portada' style='max-width: 100px;'></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Liberar Resultado y Cerrar Conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>
</html>
