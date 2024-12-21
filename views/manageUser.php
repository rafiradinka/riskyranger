<?php 
include("../template/_header.php");
include("../models/m_manageUser.php");
include("../controller/userController.php");

// Koneksi Database
$database = new Database();
$dbConnection = $database->getConnection();

// buat model user dan controller
$user = new ManUser($dbConnection);
$controller = new ManageUserController($dbConnection, $user);

// cek admin bukan
$sessionManager->cekLevel('Admin');

// buat cek POST dan GET
$controller->handleRequest();
?>

<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
          <h1><b>Manage User</b></h1>
            <ol class="breadcrumb">
            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                <li><a href=""><?= htmlspecialchars($level); ?></a></li>
                <li class="active">Manage User</li>
            </ol>
        </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="datatables">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Departemen</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php $controller->renderUserTable(); ?>
              </tbody>          
            </table>
          </div>
          
          <!-- Tambah User HTML -->
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah">Tambah User</button>
              <div id="tambah" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Tambah User</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="form-group">
                          <label class="control-label" for="username">Username</label>
                          <input type="text" name="username" class="form-control" id="username" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="level">Role</label>
                          <select name="level" class="form-control" id="level" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Fakultas">Fakultas</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="unit_terkait">Fakultas</label>
                          <input type="text" name="unit_terkait" class="form-control" id="unit_terkait" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="password">Password</label>
                          <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <input type="submit" class="btn btn-success" name="tambah" value="Simpan">
                      </div>
                    </form>
                  </div>
                </div>
              </div>

          <!-- Edit data html -->
          <div id="edit" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Data User</h4>
                </div>
                <form id="form" action="manageUser.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body" id="modal-edit">
                    <div class="form-group">
                      <label class="control-label" for="username">Username</label>
                      <input type="hidden" name="id_user" id="id_user">
                      <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="level">Role</label>
                      <select name="level" class="form-control" id="level" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Fakultas">Fakultas</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="unit_terkait">Fakultas</label>
                      <input type="text" name="unit_terkait" class="form-control" id="unit_terkait" required>
                    </div>
                  </div>
                  <div class="modal-footer"> 
                    <input type="submit" class="btn btn-success" name="edit" value="Simpan">
                  </div>
                </form>
              </div>
            </div>
          </div>

          <script type="text/javascript">
          // klik tombol edit
          document.addEventListener('DOMContentLoaded', function() {
          document.querySelector('tbody').addEventListener('click', function(e) {
              const editButton = e.target.closest('#edit_user');
              if (editButton) {
                  e.preventDefault();
                  const iduser = editButton.dataset.id;
                  const username = editButton.dataset.nama;
                  const role = editButton.dataset.level;
                  const fakultas = editButton.dataset.unter;
                  
                  document.querySelector("#modal-edit #id_user").value = iduser;
                  document.querySelector("#modal-edit #username").value = username;
                  document.querySelector("#modal-edit #level").value = role;
                  document.querySelector("#modal-edit #unit_terkait").value = fakultas;
              }
          });

          // kirim form edit
          document.getElementById('form').addEventListener('submit', function(e) {
              e.preventDefault();
              const formData = new FormData(this);
              formData.append('edit', 'true');
              
              fetch(window.location.href, {
                  method: 'POST',
                  body: formData
              })
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(data => {
                  if(data.success) {
                      alert(data.message || 'User berhasil diupdate!');
                      window.location.reload();
                  } else {
                      alert(data.message || 'Terjadi kesalahan saat mengedit user');
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  alert('Terjadi kesalahan dalam proses edit user');
              });
            });
          });
          </script>
      </div>
    </div>
  </div>
</div>

<?php include("../template/_footer.php");?>