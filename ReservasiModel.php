<?php
class ReservasiModel {
    private $db;

    public function __construct() {
        $this->db = include_once '../app/config/database.php';
    }

    public function getAllReservasi() {
        $query = "SELECT
                        r.id_reservasi,
                        r.id_user,
                        u.username,
                        r.tanggal,
                        r.jumlah_tamu
                    FROM
                        reservasi AS r
                    JOIN
                        users AS u
                    ON
                        r.id_user = u.id_user";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getReservasiById($id_reservasi) {
        $query = "SELECT * FROM reservasi WHERE id_reservasi = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_reservasi);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function createReservasi($data) {
        $query = "INSERT INTO reservasi (id_reservasi, id_user, tanggal, jumlah_tamu) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $data['id_reservasi'], $data['id_user'], $data['tanggal'], $data['jumlah_tamu']);
        return mysqli_stmt_execute($stmt);
    }

    public function updateReservasi($id, $data) {
        $sql = "UPDATE reservasi SET id_user = ?, tanggal = ?, jumlah_tamu = ? WHERE id_reservasi = ?";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            die("Kesalahan SQL: " . $this->db->error);
        }
        
        // Bind parameter
        $stmt->bind_param("isii", $data['id_user'], $data['tanggal'], $data['jumlah_tamu'], $id);
        
        $result = $stmt->execute();
        
        if (!$result) {
            die("Kesalahan Eksekusi: " . $stmt->error);
        }
        
        return $result;
    }
    

    public function deleteReservasi($id_reservasi) {
        $query = "DELETE FROM reservasi WHERE id_reservasi = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_reservasi);
        return mysqli_stmt_execute($stmt);
    }
}
?>
