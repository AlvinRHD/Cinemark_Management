<!DOCTYPE html>
<html lang="en">
<head>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/login.css?v=1.0">
</head>
<body>

    <video autoplay muted loop id="bg-video">
        <source src="../assets/video/videoCine.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de video.
    </video>
    
    <form action="procesos_login.php" method="post">
        <h1>Iniciar Sesión</h1>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" class="input-field" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" class="input-field" required>
        <br>
        <button type="submit" class="input-field">Iniciar Sesión</button>
    </form>
</body>
</html>