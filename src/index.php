<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Ropa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <h2 class="text-center mb-4">🛍️ Tienda de Ropa</h2>

    <!-- FORMULARIO -->
    <div class="card p-4 shadow mb-4">
        <h4>Agregar producto</h4>

        <form method="POST">
            <div class="row">
                <div class="col">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col">
                    <input type="text" name="talla" class="form-control" placeholder="Talla" required>
                </div>
                <div class="col">
                    <input type="text" name="color" class="form-control" placeholder="Color" required>
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                </div>
                <div class="col">
                    <button class="btn btn-primary w-100">Guardar</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    if ($_POST) {
        $nombre = $_POST['nombre'];
        $talla = $_POST['talla'];
        $color = $_POST['color'];
        $precio = $_POST['precio'];

        $sql = "INSERT INTO productos (nombre, talla, color, precio)
                VALUES ('$nombre','$talla','$color','$precio')";

        $conn->query($sql);
    }
    ?>

    <!-- TABLA -->
    <div class="card p-4 shadow">
        <h4>Lista de productos</h4>

        <table class="table table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Talla</th>
                    <th>Color</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $result = $conn->query("SELECT * FROM productos");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['talla']}</td>
                        <td>{$row['color']}</td>
                        <td>$ {$row['precio']}</td>
                      </tr>";
            }
            ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>