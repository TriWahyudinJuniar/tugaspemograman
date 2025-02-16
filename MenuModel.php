<?php
class MenuModel {
    private $db;

    public function __construct() {
        $this->db = include '../app/config/database.php'; // Pastikan koneksi database valid
    }

    // Mengambil semua menu atau berdasarkan pencarian
    public function getAllMenus($search = '') {
        $searchQuery = '';
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->db, $search);
            $searchQuery = " WHERE nama LIKE '%$search%'";
        }

        $query = "SELECT * FROM menus" . $searchQuery;
        $result = mysqli_query($this->db, $query);
        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    // Mengambil menu berdasarkan id_menu
    public function getMenuByid_menu($id_menu) {
        $query = "SELECT * FROM menus WHERE id_menu = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_menu);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $menu = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $menu;
    }

    public function createMenu($name, $harga, $gambar) {
        if (!is_numeric($harga)) {
            return "Harga harus berupa angka!";
        }
    
        $gambarName = null;
        if (isset($gambar['name']) && $gambar['error'] == 0) {
            // Tentukan direktori untuk menyimpan gambar
            $targetDir = "../public/uploads/";
            $gambarName = time() . "_" . basename($gambar["name"]);
            $targetFile = $targetDir . $gambarName;

            if (!move_uploaded_file($gambar["tmp_name"], $targetFile)) {
                echo "Gagal memindahkan file ke $targetFile";
                exit();
            }
        }
    
        $query = "INSERT INTO menus (nama, harga, gambar) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "sis", $name, $harga, $gambarName);
        $result = mysqli_stmt_execute($stmt);
    
        if (!$result) {
            echo "Error: " . mysqli_error($this->db);
            exit();
        }
    
        mysqli_stmt_close($stmt);
        return $result;
    }
    
    // Mengupdate menu
    public function updateMenu($id_menu, $name, $harga, $gambar = null) {
        if (!is_numeric($harga)) {
            return "Harga harus berupa angka!";
        }
        if ($gambar) {
            $menu = $this->getMenuByid_menu($id_menu);
            if (!empty($menu['gambar']) && file_exists("../public/uploads/" . $menu['gambar'])) {
                unlink("../public/uploads/" . $menu['gambar']); // Hapus gambar lama
            }
        }
        
        if ($gambar) {
            $query = "UPDATE menus SET nama = ?, harga = ?, gambar = ? WHERE id_menu = ?";
            $stmt = mysqli_prepare($this->db, $query);
            mysqli_stmt_bind_param($stmt, "sisi", $name, $harga, $gambar, $id_menu);
        } else {
            $query = "UPDATE menus SET nama = ?, harga = ? WHERE id_menu = ?";
            $stmt = mysqli_prepare($this->db, $query);
            mysqli_stmt_bind_param($stmt, "sii", $name, $harga, $id_menu);
        }

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Menghapus menu dan gambar terkait
    public function deleteMenu($id_menu) {
        // Ambil data menu sebelum dihapus
        $menu = $this->getMenuByid_menu($id_menu);

        // Hapus gambar jika ada
        if ($menu && !empty($menu['gambar'])) {
            $filePath = "../public/uploads/" . $menu['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data menu
        $query = "DELETE FROM menus WHERE id_menu = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_menu);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }
}
?>