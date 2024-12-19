<?php 
class ManageUserController {
    private $mysqli;
    private $user;

    public function __construct($mysqli, $userModel) {
        $this->mysqli = $mysqli;
        $this->user = $userModel;
    }

    public function handleRequest() {
        if (isset($_POST['tambah'])) {
            $this->handleAddUser();
        } elseif (isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])) {
            $this->handleDeleteUser();
        } elseif (isset($_POST['edit'])) {
            header('Content-Type: application/json');
            $this->handleEditUser();
            return;
        }
    }

    private function handleAddUser() {
        try {
            $username = $this->mysqli->real_escape_string($_POST['username']);
            $level = $this->mysqli->real_escape_string($_POST['level']);
            $unit_terkait = $this->mysqli->real_escape_string($_POST['unit_terkait']);
            $password = $this->mysqli->real_escape_string($_POST['password']);

            // Validate role
            if ($level !== "Admin" && $level !== "Fakultas") {
                throw new Exception('Role tidak valid!');
            }

            // Add user
            $this->user->tambah('', $username, $level, $unit_terkait, $password);
            $this->redirect('manageUser.php');
        } catch (Exception $e) {
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }

    private function handleEditUser() {
        try {
            header('Content-Type: application/json');
            // Validasi input
            if (!isset($_POST['id_user']) || empty($_POST['id_user'])) {
                throw new Exception('ID pengguna tidak ditemukan.');
            }

            if (empty($_POST['username']) || empty($_POST['level']) || 
                empty($_POST['unit_terkait'])) {
                throw new Exception('Semua field harus diisi!');
            }

            // buat keluaran input
            $id_user = $this->mysqli->real_escape_string($_POST['id_user']);
            $username = $this->mysqli->real_escape_string($_POST['username']);
            $level = $this->mysqli->real_escape_string($_POST['level']);
            $unit_terkait = $this->mysqli->real_escape_string($_POST['unit_terkait']);

            // Validate role
            if ($level !== "Admin" && $level !== "Fakultas") {
                throw new Exception('Role tidak valid!');
            }

            // cek tidak ada username yang sama
            $checkQuery = "SELECT id_user FROM tb_user WHERE username = ? AND id_user != ?";
            $stmt = $this->mysqli->prepare($checkQuery);
            $stmt->bind_param('si', $username, $id_user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                throw new Exception('Username sudah digunakan oleh pengguna lain!');
            }

            // Edit user
            $this->user->edit($id_user, $username, $level, $unit_terkait);
            
            ob_clean(); // untuk membersihkan output buffer
            echo json_encode([
                'success' => true,
                'message' => 'User berhasil diupdate'
            ]);
            exit;

        } catch (Exception $e) {
            ob_clean(); 
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    private function handleDeleteUser() {
        $id = $this->mysqli->real_escape_string($_GET['id']);
        $this->user->hapus($id);
        $this->redirect('manageUser.php');
    }

    private function redirect($page) {
        echo "<script>window.location.href = '$page';</script>";
        exit;
    }

    public function renderUserTable() {
        $tampil = $this->user->tampil();
        $no = 1;
        while($data = $tampil->fetch_object()):
        ?>
        <tr>
            <td><?= htmlspecialchars($data->username); ?></td>
            <td><?= htmlspecialchars($data->level); ?></td>
            <td><?= htmlspecialchars($data->unit_terkait); ?></td>
            <td align="center">
                <a href="" id="edit_user" data-toggle="modal" data-target="#edit" 
                   data-id="<?= $data->id_user; ?>" 
                   data-nama="<?= htmlspecialchars($data->username); ?>" 
                   data-level="<?= htmlspecialchars($data->level); ?>" 
                   data-unter="<?= htmlspecialchars($data->unit_terkait); ?>">
                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                </a>
                <a href="?page=userk&act=del&id=<?= $data->id_user; ?>" 
                   onclick="return confirm('Yakin akan menghapus data ini?')">
                    <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>Hapus</button>
                </a>
            </td>
        </tr>
        <?php 
        endwhile;
    }
}
?>