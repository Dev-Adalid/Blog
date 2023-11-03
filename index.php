
<!DOCTYPE html>
<html>
<head>
    <title>Mi Blog de arte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .post {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        img {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <h1>Publicaciones del Blog</h1>

    <?php
    while ($row = $posts->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='post'>";
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<img src='" . $row['image_path'] . "' alt='Imagen de la publicación'>";
        echo "</div>";
    }
    ?>
</body>
</html>
