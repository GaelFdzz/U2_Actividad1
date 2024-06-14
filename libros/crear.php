<?php
$conexion = mysqli_connect('localhost', 'root', '', 'libreria', '3306');

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $precio = $_POST['precio'];
    $editorial = $_POST['editorial'];
    $imagen = $_FILES['imagen'];

    if ($isbn === '') {
        $errores[] = 'Debes especificar un ISBN';
    }
    if ($nombre === '') {
        $errores[] = 'Debes especificar un Nombre';
    }
    if ($autor === '') {
        $errores[] = 'Debes especificar un Autor';
    }
    if ($precio === '') {
        $errores[] = 'Debes especificar un Precio';
    }
    if ($editorial === '') {
        $errores[] = 'Debes especificar una Editorial';
    }
    if ($imagen === '') {
        $errores[] = 'Debes subir una Imagen';
    }

    //Manejo de la carga de la imagen
    if (empty($errores)) {
        $target_dir = "/libreria/admin/libros/uploads_images_users/";
        $target_file = $target_dir . basename($imagen["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen real
        $check_imagesize = getimagesize($imagen["tmp_name"]);
        if ($check_imagesize === false) {
            $errores[] = "El archivo no es una imagen válida";
        }

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            $errores[] = "El archivo ya existe";
        }

        // Verificar el tamaño del archivo
        if ($imagen["size"] > 500000) {
            $errores[] = "El archivo es demasiado pesado";
        }

        // Permitir cierto formato de archivos
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errores[] = "El tipo de archivo no está soportado (intenta con .png, .jpg, .jpeg)";
        }

        // Verificar si hay errores antes de copiar el archivo
        if (empty($errores)) {
            if (copy($imagen["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
                $peticionInsertar = "INSERT INTO libros(isbn, nombre, autor, precio, editorial, imagen) VALUES ('$isbn', '$nombre', '$autor', '$precio', '$editorial', '$target_file')";

                if (mysqli_query($conexion, $peticionInsertar)) {
                    echo "Datos insertados correctamente";
                } else {
                    echo "Error al insertar los datos: " . mysqli_error($conexion);
                }
            } else {
                $errores[] = "Lo siento, hubo un error al copiar el archivo";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/libreria/admin/frontend/styles/crear.css">
    <link rel="stylesheet" href="/libreria/admin/frontend/styles/notify.css">

    <script src="/Libreria/admin/backend/scripts/notify.js"></script>

    <title>Crear un libro</title>
</head>

<body>
    <h1>Registrar un libro</h1>

    <div id="toast-container" class="toast-container" href="notify.css"></div>

    <!-- Formulario de registro de un libro -->
    <form action="crear.php" method="POST" enctype="multipart/form-data">
        <label for="">ISBN</label>
        <input type="text" name="isbn" placeholder="Ingresa el ISBN">
        <label for="">Nombre</label>
        <input type="text" name="nombre" placeholder="Ingresa el nombre del libro">
        <label for="">Autor</label>
        <input type="text" name="autor" placeholder="Ingresa el autor del libro">
        <label for="">Precio</label>
        <input type="number" name="precio" placeholder="Ingesa el precio del libro">
        <label for="">Editorial</label>
        <input type="text" name="editorial" placeholder="Ingresa la editorial del libro">
        <label for="">Imagen</label>
        <input type="file" name="imagen" placeholder="Portada del libro">

        <input type="submit" value="Enviar">
    </form>

    <a href="/libreria/admin/index.php" class="return-button">Regresar</a>

    <!-- JavaScript para mostrar notificaciones -->
    <?php if (!empty($errores)): ?>
        <script>
            <?php foreach ($errores as $error): ?>
                showToast('<?php echo $error; ?>');
            <?php endforeach; ?>
        </script>
    <?php endif; ?>
    
</body>

</html>