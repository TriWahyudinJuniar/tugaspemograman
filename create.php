<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="../public/static/menu.css">
</head>
<body>
<div class="banner">
    
    <!-- Sidebar -->
    <nav class="sidebar">
        <h2>Admin Panel</h2>
        <div><a href="index.php?action=dashboard">🏠 Dashboard</a></div>
        <div><a href="index.php?action=user">👤 User</a></div>
        <div><a href="index.php?action=reservasi">📅 Reservasi</a></div>
        <div class="nav-item active"><a href="index.php?action=menu">🍽️ Menu</a></div>
        <div><a href="index.php?action=pembayaran">💰 Pembayaran</a></div>
        <div><a href="index.php?action=pesanan">📃 Pesanan</a></div>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <div class="form-container">
        <h2>Tambah Menu Baru</h2>

        <!-- Pesan sukses atau error -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Formulir untuk menambah menu -->
        <form action="index.php?action=menu&subaction=create" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Menu:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" id="harga" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Menu:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Menu</button>
        </form>

        <!-- Link untuk kembali ke daftar menu -->
        <a href="index.php?action=menu" class="btn btn-secondary">Kembali ke Daftar Menu</a>
    </div>
</div>
</body>
</html>
