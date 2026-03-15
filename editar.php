<?php
include 'conexion.php';

// Obtener los datos actuales de la nota
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $resultado = $conn->query("SELECT * FROM comentarios WHERE id = $id");
    $nota_actual = $resultado->fetch_assoc();
}

// Actualizar la nota
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_nota'])) {
    $id = (int)$_POST['id'];
    $nombreyapellido = $conn->real_escape_string($_POST['nombreyapellido']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $email = $conn->real_escape_string($_POST['email']);
    $nota = $conn->real_escape_string($_POST['nota']);

    $sql_update = "UPDATE comentarios SET nombreyapellido='$nombreyapellido', usuario='$usuario', email='$email', nota='$nota' WHERE id=$id";
    $conn->query($sql_update);
    
    header("Location: index.php#comentarios");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Nota</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="section_container">
        <h2>Editar Nota</h2>
        <form action="editar.php" method="POST" class="form_comentarios">
            <input type="hidden" name="id" value="<?php echo $nota_actual['id']; ?>">
            <input type="text" name="nombreyapellido" value="<?php echo htmlspecialchars($nota_actual['nombreyapellido']); ?>" required>
            <input type="text" name="usuario" value="<?php echo htmlspecialchars($nota_actual['usuario']); ?>">
            <input type="email" name="email" value="<?php echo htmlspecialchars($nota_actual['email']); ?>" required>
            <textarea name="nota" rows="4" required><?php echo htmlspecialchars($nota_actual['nota']); ?></textarea>
            <button type="submit" name="update_nota" class="btn_enviar">Actualizar Nota</button>
            <a href="index.php#comentarios" style="display:block; text-align:center; margin-top:10px;">Cancelar</a>
        </form>
    </section>
</body>
</html>