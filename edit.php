<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="../public/static/menu.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Menu</h2>

        <!-- Formulir untuk mengedit menu -->
        <form action="index.php?action=menu&subaction=edit&id=<?= $menu['id_menu'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Menu:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($menu['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" id="harga" value="<?= htmlspecialchars($menu['harga']) ?>" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Menu:</label>
                <input type="file" name="gambar" id="gambar" accept="image/*">
                <br>
                <label>Gambar saat ini:</label><br>
                <?php if ($menu['gambar']): ?>
                    <img src="public/uploads/<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['nama']) ?>" width="150">
                <?php else: ?>
                    <p>Gambar tidak tersedia</p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>

        <!-- Kembali ke daftar menu -->
        <a href="index.php?action=menu" class="btn btn-secondary">Kembali ke Daftar Menu</a>
    </div>
</body>
</html>