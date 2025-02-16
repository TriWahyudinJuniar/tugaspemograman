<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Resto</title>
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

    <div class="menu-container">
        <h2>Daftar Menu</h2>
        
        <!-- Search Bar dengan tombol di sebelah kanan -->
        <form action="index.php?action=menu" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari Menu..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit">Cari</button>
        </form>

        <div class="menu-list">
            <?php foreach ($menus as $menu): ?>
                <div class="menu-item">
                    <div class="menu-image">
                        <?php if ($menu['gambar']): ?>
                            <img src="../public/uploads/<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['nama']) ?>" />
                        <?php else: ?>
                            <img src="../public/uploads/default.png" alt="Default Image" />
                        <?php endif; ?>
                    </div>
                    <div class="menu-details">
                        <h3><?= htmlspecialchars($menu['nama']) ?></h3>
                        <p>Start From: Rp. <?= htmlspecialchars($menu['harga']) ?></p>
                        <a href="index.php?action=menu&subaction=edit&id=<?= $menu['id_menu'] ?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?action=menu&subaction=delete&id=<?= $menu['id_menu'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="index.php?action=menu&subaction=create" class="btn btn-primary">Tambah Menu Baru</a>
    </div>
</div>
</body>
</html>
