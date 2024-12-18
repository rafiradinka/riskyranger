<?php 
include("../template/_header.php");
include("../models/m_manageUser.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new ManUser($mysqli);
cek_level('Admin');

?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
              <h1>Manage User</h1>
                <ol class="breadcrumb">
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                    <li><a href=""><?= $level_tampilan?></a></li>
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
                    <?php 
                    $no = 1;
                    $tampil = $user->tampil();
                    while($data = $tampil->fetch_object()){
                    ?>
                    <tr>
                      <td><?php echo $data->username; ?></td>
                      <td><?php echo $data->level; ?></td>
                      <td><?php echo $data->unit_terkait; ?></td>
                      <td align="center">
                        <a href="" id="edit_user" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_user; ?>" data-nama="<?php echo $data->username; ?>" data-level="<?php echo $data->level; ?>" data-unter="<?php echo $data->unit_terkait; ?>">
                          <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button></a>
                        <a href="?page=userk&act=del&id=<?php echo $data->id_user; ?>" onclick="return confirm('Yakin akan menghapus data ini?')">
                          <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>Hapus</button>
                        </a>
                      </td>
                    </tr>
                    <?php 
                    }
                    ?>
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

                    <!-- tambah data ke database -->
                    <?php 
                    if(isset($_POST['tambah'])){
                      $username = $mysqli->real_escape_string($_POST['username']);
                      $level = $mysqli->real_escape_string($_POST['level']);
                      $unit_terkait = $mysqli->real_escape_string($_POST['unit_terkait']);
                      $password = $mysqli->real_escape_string($_POST['password']);
                  
                      // Validasi role
                      if ($level !== "Admin" && $level !== "Fakultas") {
                          echo "<script>alert('Role tidak valid!');</script>";
                          exit;
                      }
                  
                      // Proses tambah data
                      $user->tambah('', $username, $level, $unit_terkait, $password);
                      echo "<script>window.location.href = 'manageUser.php';</script>";
                      exit;
                      }
                    ?>
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
                    <form id="form" method="post" enctype="multipart/form-data">
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
              
              <?php 
              if(isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])){
                $id = $mysqli->real_escape_string($_GET['id']);
                $user->hapus($id);
                echo "<script>window.location.href = 'manageUser.php';</script>";
                exit;
              }
              ?>

              <!-- menghubungkan dengan jquery -->
              <script src="assets/js/jquery-1.10.2.js"></script>
              <script type="text/javascript">
                // mengambil data dari line 41
                $(document).on("click", "#edit_user", function(){
                  var iduser = $(this).data('id');
                  var username = $(this).data('nama');
                  var role = $(this).data('level');
                  var fakultas = $(this).data('unter');
                  
                  $("#modal-edit #id_user").val(iduser);
                  $("#modal-edit #username").val(username);
                  $("#modal-edit #level").val(role);
                  $("#modal-edit #unit_terkait").val(fakultas);
                });

                $(document).ready(function(){
                  $("#form").on("submit", (function(e){
                      e.preventDefault();
                      $.ajax({
                        url: '../models/edit_user.php',
                        type: 'POST',
                        data : new FormData(this),
                        contentType : false,
                        cache : false,
                        processData : false,
                        success: function(){
                          location.reload();
                        }
                      })
                  }))
              })
              </script>
              
          </div>
        </div>
      </div>
    </div>

<?php include("../template/_footer.php");?>