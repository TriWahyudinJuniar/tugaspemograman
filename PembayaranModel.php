<?php
class PembayaranModel {
    private $db;

    public function __construct() {
        $this->db = include_once '../app/config/database.php';
    }

    public function getAllPembayaran() {
        $query = "SELECT * FROM pembayaran";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getPembayaranById($id_pembayaran) {
        $query = "SELECT * FROM pembayaran WHERE id_pembayaran = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pembayaran);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $data;
    }
       
    public function createPembayaran($data) {
        $query = "INSERT INTO pembayaran (id_pembayaran, id_pesanan, total, status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $data['id_pembayaran'], $data['id_pesanan'], $data['total'], $data['status']);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function updatePembayaran($id_pembayaran, $data) {
        $query = "UPDATE pembayaran SET id_pesanan = ?, total = ?, status = ? WHERE id_pembayaran = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "issi", $data['id_pesanan'], $data['total'], $data['status'], $id_pembayaran);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function deletePembayaran($id_pembayaran) {
        $query = "DELETE FROM pembayaran WHERE id_pembayaran = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pembayaran);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    
    // Method untuk mendapatkan pembayaran berdasarkan pelanggan (POV pelanggan)
    public function getPembayaranByPelanggan($id_pelanggan) {
        $query = "SELECT * FROM pembayaran WHERE id_pelanggan = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_pelanggan);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $data;
    }
}
?>
