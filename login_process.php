<?php
include 'config.php';
session_start();

$database = new Database(); 
$db = $database->getConnection(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];


    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: admin.php"); // Redirige a la vista de administración
        exit;
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }
}
?>
