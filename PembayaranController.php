<?php
require_once '../app/models/PembayaranModel.php';
require_once '../app/models/UserModel.php';

class PembayaranController {
    private $model;

    public function __construct() {
        $this->model = new PembayaranModel();
    }

    public function index() {
        $pembayaran = $this->model->getAllPembayaran();
        require_once '../app/views/admin/pembayaran/index.php';
    }

    public function indexKasir() {
        $pembayaran = $this->model->getAllPembayaran();
        require_once '../app/views/kasir/pembayaran/index.php';
    }

    public function indexPelanggan() {
        $pembayaran = $this->model->getAllPembayaran();
        require_once '../app/views/pelanggan/pembayaran/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->createPembayaran($_POST);
            header('Location: ../public/index.php?action=Pembayaran');
            exit();
        } else {
            require_once '../app/views/admin/pembayaran/create.php';
        }
    }

    public function edit($id) {
        // Pastikan ID valid
        if (!isset($id) || !is_numeric($id)) {
            die("ID Pembayaran tidak valid");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input sebelum update
            if (!empty($_POST['id_pesanan']) && !empty($_POST['total']) && !empty($_POST['status'])) {
                $this->model->updatePembayaran($id, $_POST);
                header('Location: ../public/index.php?action=pembayaran');
                exit();
            } else {
                echo "⚠ Harap isi semua data!";
            }
        } else {
            // Perbaiki variabel agar sesuai dengan edit.php
            $pembayaran = $this->model->getPembayaranById($id);
            require_once '../app/views/admin/pembayaran/edit.php';
        }
    }
    

    public function delete($id_pembayaran) {
        // Cek apakah pembayaran ada sebelum dihapus
        $pembayaran = $this->model->getPembayaranById($id_pembayaran);
    
        if (!$pembayaran) {
            $_SESSION['error'] = "Pembayaran tidak ditemukan!";
            header('Location:../public/index.php?action=pembayaran');
            exit();
        }
    
        // Proses hapus
        $deleteResult = $this->model->deletePembayaran($id_pembayaran);
    
        if ($deleteResult) {
            $_SESSION['success'] = "Pembayaran berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus pembayaran!";
        }
    
        header('Location:../public/index.php?action=pembayaran');
        exit();
    }
}
?>
