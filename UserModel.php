<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = include_once '../app/config/database.php';

        if (!$this->db) {
            die("Koneksi database gagal.");
        }
    }

    public function getAllUser() {
        $query = "SELECT * FROM users";
        $result = mysqli_query($this->db, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getUserById($id_user) {
        $query = "SELECT * FROM users WHERE id_user = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function createUser($data) {
        // Hilangkan 'id_user' dari query karena biasanya auto-increment
        $query = "INSERT INTO users (username, password, role, telepon) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Query error: " . mysqli_error($this->db));
        }

        // Tidak menggunakan password_hash, menyimpan password asli
        mysqli_stmt_bind_param($stmt, "ssss", $data['username'], $data['password'], $data['role'], $data['telepon']);

        if (!mysqli_stmt_execute($stmt)) {
            die("Execute error: " . mysqli_stmt_error($stmt));
        }

        return true;
    }

    public function updateUser($id_user, $data) {
        $query = "UPDATE users SET username = ?, password = ?, role = ?, telepon = ? WHERE id_user = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $data['username'], $data['password'], $data['role'], $data['telepon'], $id_user);
        return mysqli_stmt_execute($stmt);
    }

    public function deleteUser($id_user) {
        $query = "DELETE FROM users WHERE id_user = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_user);
        return mysqli_stmt_execute($stmt);
    }
}
?>
