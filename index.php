<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizador de Intercambio de Regalos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #dc3545;
            border-radius: 10px 10px 0 0;
            color: white;
            font-size: 24px;
            padding: 20px;
            text-align: center;
        }
        .form-control {
            border-radius: 25px;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .register-link {
            color: #dc3545;
        }
        .register-link:hover {
            text-decoration: none;
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Iniciar Sesión
                    </div>
                    <div class="card-body">
                        <?php include 'login_form.php'; ?>
                        <p class="text-center mt-3">¿No tienes una cuenta? <a href="register.php" class="register-link">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
