<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Búsqueda</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        table {
            width: 80%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 4px 8px rgba(61, 54, 92, 0.945);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #333;
            border-right: 1px solid #333;
        }
        th {
            background-color: blue;
            color: white;
        }
        td:last-child, th:last-child {
            border-right: none;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:nth-child(even) {
            background-color: #555;
        }
        tr:nth-child(odd) {
            background-color: #333;
        }
        tr:hover {
            background-color: #777;
        }
        .button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin: 10px;
        }
        .button:hover {
            background-color: darkblue;
        }
        .form-container {
            display: none;
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(61, 54, 92, 0.945);
        }
        .form-container input, .form-container button {
            margin: 5px 0;
            padding: 10px;
        }
    </style>
</head>
<body>
<br><br><br><br><br>
<button class="button" onclick="document.getElementById('addBookForm').style.display='block'">Agregar Nuevo Libro</button>

<div id="addBookForm" class="form-container">
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre del libro" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="fecha_publicacion" placeholder="Fecha de publicación" required>
        <input type="text" name="numero_paginas" placeholder="Número de páginas" required>
        <button type="submit" name="agregar">Agregar Libro</button>
    </form>
</div>

<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "idelibros");

// Verificación de la conexión
if (mysqli_connect_errno()) {
    echo "Fallo al conectar con el servidor: " . mysqli_connect_error();
    exit();
}

$ultimo_id = null;

// Procesar el formulario de agregar libro
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $numero_paginas = $_POST['numero_paginas'];

    // Obtener el último ID de la base de datos
    $sql = "SELECT MAX(IDlibros) as max_id FROM libros";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($result);
    $ultimo_id = $row['max_id'] + 1;

    // Insertar el nuevo libro con el ID ajustado
    $sql = "INSERT INTO libros (IDlibros, Nombre, Autor, `Fecha de publicacion`, `Numero de paginas`) 
            VALUES ($ultimo_id, '$nombre', '$autor', '$fecha_publicacion', '$numero_paginas')";
    
    if (mysqli_query($conexion, $sql)) {
        echo "Libro agregado exitosamente.";
    } else {
        echo "Error al agregar el libro: " . mysqli_error($conexion);
    }
}

// Procesar el formulario de editar libro
if (isset($_POST['editar'])) {
    $id_editar = $_POST['id_editar'];
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $numero_paginas = $_POST['numero_paginas'];

    $sql = "UPDATE libros SET Nombre='$nombre', Autor='$autor', `Fecha de publicacion`='$fecha_publicacion', `Numero de paginas`='$numero_paginas' WHERE IDlibros=$id_editar";
    
    if (mysqli_query($conexion, $sql)) {
        echo "Libro editado exitosamente.";
    } else {
        echo "Error al editar el libro: " . mysqli_error($conexion);
    }
}

// Procesar el formulario de borrar libro
if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id_borrar'];

    $sql = "DELETE FROM libros WHERE IDlibros = $id_borrar";
    
    if (mysqli_query($conexion, $sql)) {
        echo "Libro borrado exitosamente.";
    } else {
        echo "Error al borrar el libro: " . mysqli_error($conexion);
    }
}

// Mostrar todos los libros si se ha pulsado el botón "Mostrar Todos los Libros" o si se ha agregado/editado/borrado un libro
if (isset($_POST['mostrar_todos']) || isset($_POST['agregar']) || isset($_POST['borrar']) || isset($_POST['editar'])) {
    $sql = "SELECT * FROM libros";
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Autor</th>
                        <th>Fecha de publicación</th>
                        <th>Número de páginas</th>
                    </tr>";

            while ($mostrar = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>".$mostrar['IDlibros']."</td>
                        <td>".$mostrar['Nombre']."</td>
                        <td>".$mostrar['Autor']."</td>
                        <td>".$mostrar['Fecha de publicacion']."</td>
                        <td>".$mostrar['Numero de paginas']."</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron libros.";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
// Mostrar libro por ID si se ha enviado el formulario de búsqueda
elseif (isset($_POST['buscar']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "SELECT * FROM libros WHERE IDlibros = $id";
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Autor</th>
                        <th>Fecha de publicación</th>
                        <th>Número de páginas</th>
                    </tr>";

            while ($mostrar = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>{$mostrar['IDlibros']}</td>
                        <td>{$mostrar['Nombre']}</td>
                        <td>{$mostrar['Autor']}</td>
                        <td>{$mostrar['Fecha de publicacion']}</td>
                        <td>{$mostrar['Numero de paginas']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron libros con el ID especificado.";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
} else {
    echo "No se ha ingresado ningún ID para buscar.";
}

mysqli_close($conexion);
?>

<?php if ($ultimo_id): ?>
    <form method="POST" action="">
        <input type="hidden" name="id_borrar" value="<?php echo $ultimo_id; ?>">
        <button type="submit" name="borrar" class="button">Borrar Último Libro Agregado</button>
    </form>
    <button class="button" onclick="document.getElementById('editBookForm').style.display='block'">Editar Último Libro Agregado</button>

    <div id="editBookForm" class="form-container">
        <form method="POST" action="">
            <input type="hidden" name="id_editar" value="<?php echo $ultimo_id; ?>">
            <input type="text" name="nombre" placeholder="Nombre del libro" required>
            <input type="text" name="autor" placeholder="Autor" required>
            <input type="text" name="fecha_publicacion" placeholder="Fecha de publicación" required>
            <input type="text" name="numero_paginas" placeholder="Número de páginas" required>
            <button type="submit" name="editar">Editar Libro</button>
        </form>
    </div>
<?php endif; ?>

<div class="bottom-opi">
    <a href="\Proyecto_ADRIAN\proyecto\catalogo\acatalogo.html" class="back-btn">Volver</a>
    <br><br><br>
</div>
</body>
</html>
