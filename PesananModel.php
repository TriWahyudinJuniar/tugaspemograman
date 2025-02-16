<?php
class PesananModel {
    private $db;

    public function __construct() {
        $this->db = include_once '../app/config/database.php';
        
        if (!$this->db) {
            die("Koneksi database gagal.");
        }
    }

    public function getAllPesanan() {
        $query = "SELECT * FROM pesanan";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            return [];
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getPesananById($id_pesanan) {
        $query = "SELECT * FROM pesanan WHERE id_pesanan = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_pesanan);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($result);
        }

        return null;
    }

    // Retrieve orders with customer details
    public function getPelangganPesanan() {
        $query = "SELECT
                        p.id_pesanan,
                        p.id_reservasi,
                        r.tanggal,
                        r.jumlah_tamu,
                        p.id_menu,
                        m.nama,
                        m.harga
                    FROM
                        pesanan AS p
                    JOIN
                        reservasi AS r
                    ON
                        p.id_reservasi = r.id_reservasi
                    JOIN
                        menus AS m
                    ON
                        p.id_menu = m.id_menu";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            return [];
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function createPesanan($data) {
        $query = "INSERT INTO pesanan (id_reservasi, id_menu) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $data['id_reservasi'], $data['id_menu']);
            return mysqli_stmt_execute($stmt);
        }

        return false;
    }


    public function create() {
        session_start();
        
        // Pastikan ID reservasi diambil dari input form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['id_reservasi']) && !empty($_POST['menu_pesanan']) && !empty($_POST['jumlah_pesanan'])) {
                // Ambil data ID Reservasi dan pesanan
                $id_reservasi = $_POST['id_reservasi'];
                $menu_pesanan = $_POST['menu_pesanan'];
                $jumlah_pesanan = $_POST['jumlah_pesanan'];
    
                // Simpan pesanan ke dalam database
                foreach ($menu_pesanan as $id_menu) {
                    $jumlah = $jumlah_pesanan[$id_menu];
                    
                    // Simpan pesanan ke dalam database
                    $this->model->createPesanan([
                        'id_reservasi' => $id_reservasi,
                        'id_menu' => $id_menu,
                        'jumlah' => $jumlah
                    ]);
                }
    
                $_SESSION['success'] = "Pesanan Anda telah dikonfirmasi!";
            } else {
                $_SESSION['error'] = "Anda belum memilih menu atau memasukkan ID reservasi.";
            }
            
            header('Location: ../public/index.php?action=pesanan');
            exit();
        }
    }
    

    public function updatePesanan($id_pesanan, $data) {
        $query = "UPDATE pesanan SET id_reservasi = ?, id_menu = ? WHERE id_pesanan = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iii", $data['id_reservasi'], $data['id_menu'], $id_pesanan);
            return mysqli_stmt_execute($stmt);
        }

        return false;
    }

    public function deletePesanan($id_pesanan) {
        $query = "DELETE FROM pesanan WHERE id_pesanan = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_pesanan);
            return mysqli_stmt_execute($stmt);
        }

        return false;
    }
}
?>
