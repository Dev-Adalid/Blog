<?php
include_once 'config.php';
include_once 'Post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Agregar una nueva publicación
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->image_path = 'ruta_de_la_imagen'; 
        $post->create();
    } elseif (isset($_POST['edit'])) {
        // Editar una publicación existente
        $post->id = $_POST['post_id'];
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->image_path = 'ruta_de_la_imagen'; 
        $post->update();
    }
     elseif (isset($_POST['delete'])) {
        // Eliminar una publicación (no funciona)//
        $post->id = $_POST['post_id'];
        $post->delete();
    }
    if (isset($_FILES['image'])) {
        $uploadDir = 'directorio_de_subida/'; 
        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            $post->image_path = $uploadedFile;
            $post->create(); 
        } else {
            echo "Error al subir la imagen.";
        }
    }
    
}

$posts = $post->readAll();

session_start();

if (!isset($_SESSION["user_id"])) {
    // El usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Administrativo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        form {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Panel Administrativo</h1>

   
       <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Título" required>
    <textarea name="content" placeholder="Contenido" required></textarea>
    <input type="file" name="image" accept="image/*">
    <button type="submit" name="add">Agregar Publicación</button>
    <button type="submit" name="edit">Editar Publicación</button>
</form>


    <h2>Publicaciones</h2>
    <ul>
        <?php
        while ($row = $posts->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>";
            echo $row['title'];
            echo "<a href='admin.php?edit=" . $row['id'] . "'>Editar</a>";
            echo "<a href='admin.php?delete=" . $row['id'] . "'>Eliminar</a>";
            echo "</li>";
        }
        ?>
    </ul>

    <?php
    if (isset($_GET['edit'])) {
        // Cargar los datos de la publicación para la edición
        $post->id = $_GET['edit'];
        $result = $post->readOne();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<input type='text' name='title' value='" . $row['title'] . "' required>";
        echo "<textarea name='content' required>" . $row['content'] . "</textarea>";
        echo "<input type='file' name='image' accept='image/*'>";
        echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='edit'>Guardar Cambios</button>";
        echo "</form>";
    }
    
    ?>
</body>
</html>

