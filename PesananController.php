<?php
require_once '../app/models/PesananModel.php';

class PesananController {
    private $model;

    public function __construct() {
        $this->model = new PesananModel();
    }

    // Admin melihat daftar pesanan
    public function index() {
        $pesanan = $this->model->getAllPesanan();
        require_once '../app/views/admin/pesanan/index.php';
    }

    // Kasir melihat daftar pesanan
    public function indexKasir() {
        $pesanan = $this->model->getAllPesanan();
        require_once '../app/views/kasir/pesanan/index.php';
    }

    public function indexPelanggan() {
        $pesanan = $this->model->getPelangganPesanan();
        require_once '../app/views/pelanggan/pesanan/index.php';
    }

    // Membuat pesanan baru
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->createPesanan($_POST);
            header('Location: ../public/index.php?action=pesanan');
            exit();
        } else {
            require_once '../app/views/admin/pesanan/create.php';
        }
    }   


    // Mengedit pesanan
    public function edit($id) {
        if (!isset($id) || !is_numeric($id)) {
            die("ID Pesanan tidak valid");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['id_reservasi']) && !empty($_POST['id_menu'])) {
                $this->model->updatePesanan($id, $_POST);
                header('Location: index.php?action=pesanan');
                exit();
            } else {
                echo "⚠ Harap isi semua data!";
            }
        } else {
            $pesanan = $this->model->getPesananById($id);
            require_once '../app/views/admin/pesanan/edit.php';
        }
    }

    // Menghapus pesanan
    public function delete($id_pesanan) {
        if (!isset($id_pesanan) || !is_numeric($id_pesanan)) {
            die("ID Pesanan tidak valid");
        }

        $pesanan = $this->model->getPesananById($id_pesanan);
        if (!$pesanan) {
            $_SESSION['error'] = "Pesanan tidak ditemukan!";
        } else {
            if ($this->model->deletePesanan($id_pesanan)) {
                $_SESSION['success'] = "Pesanan berhasil dihapus!";
            } else {
                $_SESSION['error'] = "Gagal menghapus pesanan!";
            }
        }

        header('Location: index.php?action=pesanan');
        exit();
    }
}
?>
