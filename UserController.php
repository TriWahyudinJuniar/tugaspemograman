<?php
require_once '../app/models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function index() {
        $user = $this->model->getAllUser();
        require_once '../app/views/admin/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->createUser($_POST);
            header('Location: ../public/index.php?action=user');
            exit();
        } else {
            require_once '../app/views/admin/user/create.php';
        }
    }

    public function edit($id) {
        // Pastikan ID valid
        if (!isset($id) || !is_numeric($id)) {
            die("ID User tidak valid");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input sebelum update
            if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['role']) && !empty($_POST['telepon'])) {
                $this->model->updateUser($id, $_POST);
                header('Location: ../public/index.php?action=user');
                exit();
            } else {
                echo "⚠ Harap isi semua data!";
            }
        } else {
            // Perbaiki variabel agar sesuai dengan edit.php
            $user = $this->model->getUserById($id);
            require_once '../app/views/admin/user/edit.php';
        }
    }
    

    public function delete($id_user) {
        // Cek apakah user ada sebelum dihapus
        $user = $this->model->getUserById($id_user);
    
        if (!$user) {
            $_SESSION['error'] = "User tidak ditemukan!";
            header('Location:../public/index.php?action=user');
            exit();
        }
    
        // Proses hapus
        $deleteResult = $this->model->deleteUser($id_user);
    
        if ($deleteResult) {
            $_SESSION['success'] = "User berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus user!";
        }
    
        header('Location:../public/index.php?action=user');
        exit();
    }
}
?>
