<?php
require_once '../app/models/MenuModel.php';

class MenuController {
    private $model;

    public function __construct() {
        $this->model = new MenuModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $menus = $this->model->getAllMenus($search);
        require_once '../app/views/admin/menu/index.php';
    }

    public function indexKasir() {
    $menus = $this->model->getAllMenus();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../app/models/PesananModel.php';
        $pesananModel = new PesananModel();
        
        $selectedMenus = $_POST['menu_pesanan']; // id_menu yang dipilih
        $jumlahMenus = $_POST['jumlah_pesanan']; // Jumlah per menu

        foreach ($selectedMenus as $id_menu) {
            if (isset($jumlahMenus[$id_menu]) && $jumlahMenus[$id_menu] > 0) {
                $data = [
                    'id_reservasi' => 1, // Ubah dengan ID reservasi yang sesuai
                    'id_menu' => $id_menu,
                    'jumlah' => $jumlahMenus[$id_menu]
                ];
                $pesananModel->createPesanan($data);
            }
        }

        $_SESSION['success'] = "Pesanan berhasil disimpan!";
        header('Location: index.php?action=pesanan');
        exit();
    }

    require_once '../app/views/kasir/menu/index.php';
}


    public function indexPelanggan() {
        $menus = $this->model->getAllMenus();
        require_once '../app/views/pelanggan/menu/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $harga = $_POST['harga'];
            $gambar = $_FILES['gambar']; // Mengambil gambar
            
            // Pastikan gambar dan data lainnya berhasil diterima
            $result = $this->model->createMenu($name, $harga, $gambar);
        
            if ($result) {
                $_SESSION['success'] = "Menu berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan menu!";
            }
        
            // Redirect ke daftar menu
            header('Location: ?action=menu');
            exit();
        } else {
            require_once '../app/views/admin/menu/create.php';
        }
    }
        
    
    public function edit($id_menu) {
        $menu = $this->model->getMenuByid_menu($id_menu);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $harga = $_POST['harga'];
    
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $gambar = $_FILES['gambar'];
            } else {
                $gambar = null; // Tidak ada gambar baru
            }
    
            // Panggil fungsi model untuk mengupdate menu
            $result = $this->model->updateMenu($id_menu, $name, $harga, $gambar);
            
            if ($result) {
                $_SESSION['success'] = "Menu berhasil diubah!";
            } else {
                $_SESSION['error'] = "Gagal mengubah menu!";
            }
    
            header('Location: ?action=menu');
            exit();
        } else {
            require_once '../app/views/admin/menu/edit.php';
        }
    }
    
    public function delete($id_menu) {
        $result = $this->model->deleteMenu($id_menu);
        
        if ($result) {
            $_SESSION['success'] = "Menu berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus menu!";
        }
    
        header('Location: ?action=menu');
        exit();
    }
    
}
?>
