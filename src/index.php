<?php 
include 'db.php'; 

// --- LÓGICA PARA BORRAR ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql_delete = "DELETE FROM productos WHERE id = $id";
    if ($conn->query($sql_delete)) {
        header("Location: index.php?status=deleted");
        exit();
    }
}

// --- LÓGICA PARA GUARDAR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $talla  = $conn->real_escape_string($_POST['talla']);
    $color  = $conn->real_escape_string($_POST['color']);
    $precio = $conn->real_escape_string($_POST['precio']);

    $sql = "INSERT INTO productos (nombre, talla, color, precio) VALUES ('$nombre','$talla','$color','$precio')";

    if ($conn->query($sql)) {
        header("Location: index.php?status=success");
        exit();
    }
}

// --- ESTADÍSTICAS ---
$stats = $conn->query("SELECT COUNT(*) as total, SUM(precio) as suma FROM productos")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --main-purple: #6f42c1; --vivid-pink: #f73378; }
        body { background: #f4f7f6; font-family: 'Segoe UI', Roboto, sans-serif; }
        .navbar-brand { font-weight: 800; letter-spacing: -1px; color: var(--main-purple) !important; }
        .card { border: none; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.04); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .input-group-text { border: none; background: #eee; border-radius: 10px 0 0 10px !important; }
        .form-control, .form-select { border: 2px solid #eee; border-radius: 0 10px 10px 0 !important; }
        .btn-add { background: var(--vivid-pink); color: white; border: none; border-radius: 12px; font-weight: 700; transition: 0.3s; }
        .btn-add:hover { background: #d81b60; transform: scale(1.02); color: white; }
        .product-img-icon { width: 40px; height: 40px; background: #eef2ff; color: #4f46e5; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container justify-content-center">
        <a class="navbar-brand" href="#"><i class="bi bi-gem me-2"></i>FASHION<span>DOCKER</span></a>
    </div>
</nav>

<div class="container">
    
    <div class="row g-4 mb-4 justify-content-center">
        <div class="col-md-5">
            <div class="card p-3 d-flex flex-row align-items-center justify-content-between border-bottom border-primary border-4">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Total Stock</h6>
                    <h3 class="fw-bold mb-0"><?php echo $stats['total'] ?? 0; ?></h3>
                </div>
                <div class="stat-icon bg-primary text-white shadow-sm"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card p-3 d-flex flex-row align-items-center justify-content-between border-bottom border-success border-4">
                <div>
                    <h6 class="text-muted mb-1 text-uppercase small fw-bold">Valor Total</h6>
                    <h3 class="fw-bold mb-0">$<?php echo number_format($stats['suma'] ?? 0, 2); ?></h3>
                </div>
                <div class="stat-icon bg-success text-white shadow-sm"><i class="bi bi-currency-dollar"></i></div>
            </div>
        </div>
    </div>

    <div class="card p-4 mb-4">
        <h5 class="fw-bold mb-4 text-center"><i class="bi bi-magic me-2 text-primary"></i>Registrar Nueva Tendencia</h5>
        <form method="POST" class="row g-3" id="mainForm">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-alphabet-uppercase"></i></span>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre prenda..." required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-rulers"></i></span>
                    <select name="talla" class="form-select" required>
                        <option value="" selected disabled>Talla</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-palette"></i></span>
                    <input type="text" name="color" class="form-control" placeholder="Color..." required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-add w-100 py-2 shadow-sm">
                    <i class="bi bi-plus-circle-dotted me-2"></i>GUARDAR ITEM
                </button>
            </div>
        </form>
    </div>

    <div class="card p-2 mb-4">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search fs-5 text-muted"></i></span>
            <input type="text" id="smartSearch" class="form-control border-0 bg-transparent" placeholder="Filtrar por nombre, color o talla...">
        </div>
    </div>

    <div class="card overflow-hidden shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="mainTable">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold text-uppercase">
                        <th class="ps-4">Producto</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM productos ORDER BY id DESC");
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="product-img-icon me-3">
                                        <i class="bi bi-bag-heart-fill"></i>
                                    </div>
                                    <div class="fw-bold text-dark"><?php echo $row['nombre']; ?></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border px-3"><?php echo $row['talla']; ?></span></td>
                            <td>
                                <span class="d-flex align-items-center">
                                    <i class="bi bi-circle-fill me-2 small" style="color: <?php echo $row['color']; ?>;"></i>
                                    <?php echo $row['color']; ?>
                                </span>
                            </td>
                            <td><span class="fw-bold text-primary">$<?php echo number_format($row['precio'], 2); ?></span></td>
                            <td class="text-center">
                                <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm border-0 rounded-circle" onclick="return confirm('¿Borrar registro?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No hay productos en stock.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('smartSearch').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#mainTable tbody tr').forEach(tr => {
            tr.style.display = tr.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>