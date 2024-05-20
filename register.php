<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        h1 {
            text-align: center;
            color: #dc3545;
            margin-bottom: 30px;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #dc3545;
        }
        a:hover {
            text-decoration: none;
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <?php include 'register_form.php'; ?>
        <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
