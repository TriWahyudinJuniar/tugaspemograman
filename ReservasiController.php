<?php
require_once '../app/models/ReservasiModel.php';

class ReservasiController {
    private $model;

    public function __construct() {
        $this->model = new ReservasiModel();
    }

    public function index() {
        $reservasi = $this->model->getAllReservasi();
        require_once '../app/views/admin/reservasi/index.php';
    }

    public function indexKasir() {
        $reservasi = $this->model->getAllReservasi();
        require_once '../app/views/kasir/reservasi/index.php';
    }

    public function indexPelanggan() {
        $reservasi = $this->model->getAllReservasi();
        require_once '../app/views/pelanggan/reservasi/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->createReservasi($_POST);
            header('Location: ../public/index.php?action=reservasi');
            exit();
        } else {
            require_once '../app/views/admin/reservasi/create.php';
        }
    }

    public function edit($id) {
        // Pastikan ID valid
        if (!isset($id) || !is_numeric($id)) {
            die("ID Reservasi tidak valid");
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi input sebelum update
            if (!empty($_POST['id_user']) && !empty($_POST['tanggal']) && !empty($_POST['jumlah_tamu'])) {
                $this->model->updateReservasi($id, $_POST);
                header('Location: ../public/index.php?action=reservasi');
                exit();
            } else {
                echo "⚠ Harap isi semua data!";
            }
        } else {
            // Perbaiki variabel agar sesuai dengan edit.php
            $reservasi = $this->model->getReservasiById($id);
            if (!$reservasi) {
                die("Reservasi tidak ditemukan");
            }
            require_once '../app/views/admin/reservasi/edit.php';
        }
    }
    

    public function delete($id_reservasi) {
        // Cek apakah user ada sebelum dihapus
        $reservasi = $this->model->getReservasiById($id_reservasi);
    
        if (!$reservasi) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = "Reservasi tidak ditemukan!";
            header('Location: ../public/index.php?action=reservasi');
            exit();
        }
    
        // Proses hapus
        $deleteResult = $this->model->deleteReservasi($id_reservasi);
    
        if (!isset($_SESSION)) {
            session_start();
        }
    
        if ($deleteResult) {
            $_SESSION['success'] = "Reservasi berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus reservasi!";
        }
    
        header('Location: ../public/index.php?action=reservasi');
        exit();
    }
}
?>
