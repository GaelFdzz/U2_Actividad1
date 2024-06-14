<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Listado de Libros</h1>
    <?php
    // Paso 1: Conexión a la Base de Datos
    $conexion = mysqli_connect('localhost', 'root', '', 'libreria', '3306');

    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Paso 2: Consulta SQL para Obtener Libros
    $query = "SELECT * FROM libros";
    $resultado = mysqli_query($conexion, $query);

    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
    ?>

    <!-- Paso 3: Impresión de la Tabla HTML -->
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
            // Paso 4: Iterar sobre los Resultados y Mostrar en la Tabla
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
    // Paso 5: Liberar Resultado y Cerrar Conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>
</html>
