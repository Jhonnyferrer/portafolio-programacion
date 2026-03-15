<?php
include 'conexion.php';
date_default_timezone_set('America/Caracas'); // Ajusta a tu zona horaria

// --- LÓGICA PARA AGREGAR NOTA ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_nota'])) {
    $nombreyapellido = $conn->real_escape_string($_POST['nombreyapellido']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $email = $conn->real_escape_string($_POST['email']);
    $nota = $conn->real_escape_string($_POST['nota']);
    $fechanota = date("Y-m-d H:i:s"); // Uso de la función Date()

    $sql_insert = "INSERT INTO comentarios (nombreyapellido, usuario, email, nota, fechanota) 
                   VALUES ('$nombreyapellido', '$usuario', '$email', '$nota', '$fechanota')";
    $conn->query($sql_insert);
    
    // Redirigir para evitar reenvío de formulario
    header("Location: index.php#comentarios");
    exit();
}

// --- LÓGICA PARA ELIMINAR NOTA ---
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    $sql_delete = "DELETE FROM comentarios WHERE id = $id_eliminar";
    $conn->query($sql_delete);
    header("Location: index.php#comentarios");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio | Jhonny Ferrer</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main_header">
        <h1>Jhonny Ferrer</h1>
        <nav>
            <ul class="nav_links">
                <li><a href="#sobre_mi">Sobre Mi</a></li>
                <li><a href="#pasatiempos">Pasatiempos</a></li>
                <li><a href="#favoritos">Favoritos</a></li>
                <li><a href="#comentarios">Comentarios</a></li> </ul>
        </nav>
    </header>

    <main>
        <section id="sobre_mi" class="section_container">
            <h2>Sobre Mí</h2>
            <p>Bienvenido a mi portafolio personal, Mi nombre es Jhonny Ferrer, tengo 22 años y soy estudiante de Ingeniería de Sistemas. Me apasiona aprender cosas que me parezcan utiles o interesantes, el desarrollo y siempre busco la manera de seguir mejorando para ser el mejor en lo que hago.</p>
        </section>

        <section id="pasatiempos" class="section_container">
            <h2>Mis Pasatiempos</h2>
            <p>Cuando no estoy estudiando la carrera, disfruto invertir mi tiempo en las siguientes actividades:</p>
            <ul class="lista_pasatiempos">
                <li>📚 Leer libros.</li>
                <li>⚽ Jugar fútbol.</li>
                <li>🗣️ Practicar y aprender nuevos idiomas.</li>
                <li>💻 Programar y mejorar mi dominio en esta area.</li>
            </ul>
        </section>

        <section id="favoritos" class="section_container">
            <h2>Mis Favoritos</h2>
            <div class="cards_container">
                <div class="card_item">
                    <h3>🎮 Videojuegos</h3>
                    <p>Mi saga favorita es <strong>Resident Evil</strong>.</p>
                </div>
                <div class="card_item">
                    <h3>📺 Anime</h3>
                    <p>Mi anime favorito es <strong>Bleach</strong>.</p>
                </div>
                <div class="card_item">
                    <h3>🎵 Música</h3>
                    <p>Mi banda musical favorita es <strong>Linkin Park</strong> y mi canción preferida es <strong>Number One</strong>.</p>
                </div>
            </div>
        </section>

        <section id="comentarios" class="section_container">
            <h2>Comentarios y Notas</h2>
            
            <form action="index.php#comentarios" method="POST" class="form_comentarios">
                <input type="text" name="nombreyapellido" placeholder="Nombre y Apellido" required>
                <input type="text" name="usuario" placeholder="Usuario (Opcional)">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <textarea name="nota" rows="4" placeholder="Escribe tu nota aquí..." required></textarea>
                <button type="submit" name="submit_nota" class="btn_enviar">Enviar Nota</button>
            </form>

            <div class="lista_notas">
                <?php
                $sql_select = "SELECT * FROM comentarios ORDER BY id DESC";
                $resultado = $conn->query($sql_select);

                if ($resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                        echo "<div class='nota_item'>";
                        echo "<h4>" . htmlspecialchars($fila['nombreyapellido']) . " <span>(" . htmlspecialchars($fila['fechanota']) . ")</span></h4>";
                        if(!empty($fila['usuario'])) echo "<h5>@" . htmlspecialchars($fila['usuario']) . "</h5>";
                        echo "<p>" . nl2br(htmlspecialchars($fila['nota'])) . "</p>";
                        
                        // Botones de acción
                        echo "<div class='acciones_nota'>";
                        echo "<a href='editar.php?id=" . $fila['id'] . "' class='btn_editar'>Editar</a>";
                        echo "<a href='index.php?eliminar=" . $fila['id'] . "' class='btn_eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar esta nota?\")'>Eliminar</a>";
                        echo "</div>";
                        
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aún no hay comentarios. ¡Sé el primero en dejar uno!</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer class="main_footer">
        <p>&copy; 2026 Jhonny Ferrer. Portafolio personal.</p>
    </footer>
</body>
</html>