<?php 
include("../template/_header.php");
include("../models/m_sisMit.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new SisMit($mysqli);

?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1>Risk Register</h1>
              <ol class="breadcrumb">
              <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                  <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                  <li><a href=""><?= $level_tampilan?></a></li>
                  <li class="active">Risk Register</li>
              </ol>
          </div>
        </div>

        <!-- tabel utama -->
        <div class="row">
          <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="datatables">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kode Risiko</th>
                      <th>Inherent Likelhood</th>
                      <th>Inherent Impact</th>
                      <th>Inherent Risiko</th>
                      <th>Control</th>
                      <th>Memadai</th>
                      <th>Dijalankan</th>
                      <th>Residual Likelihood</th>
                      <th>Residual Impact</th>
                      <th>Residual Risiko</th>
                      <th>Perlakuan</th>
                      <th>Tindakan Mitigasi</th>
                      <th>Mitigasi Likelihood</th>
                      <th>Mitigasi Impact</th>
                      <th>Mitigasi Risiko</th>
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
                      <td align="center"><?php echo $no++."."; ?></td>
                      <td><?php echo $data->kode_risk; ?></td>
                      <td><?php echo $data->hood_inh; ?></td>
                      <td><?php echo $data->imp_inh; ?></td>
                      <td><?php echo $data->risk_inh; ?></td>
                      <td><?php echo $data->control; ?></td>
                      <td><?php echo $data->memadai; ?></td>
                      <td><?php echo $data->dijalankan; ?></td>
                      <td><?php echo $data->hood_res; ?></td>
                      <td><?php echo $data->imp_res; ?></td>
                      <td><?php echo $data->risk_res; ?></td>
                      <td><?php echo $data->perlakuan; ?></td>
                      <td><?php echo $data->mitigasi; ?></td>
                      <td><?php echo $data->hood_mit; ?></td>
                      <td><?php echo $data->imp_mit; ?></td>
                      <td><?php echo $data->risk_mit; ?></td>
                      <td align="center">
                        <a href="" id="edit_risk" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_risk;?>" data-hood_i="<?php echo $data->hood_inh; ?>" data-imp_i="<?php echo $data->imp_inh; ?>" data-risk_i="<?php echo $data->risk_inh; ?>" data-control="<?php echo $data->control; ?>" data-memadai="<?php echo $data->memadai; ?>" data-dijalankan="<?php echo $data->dijalankan; ?>" data-hood_r="<?php echo $data->hood_res; ?>" data-imp_r="<?php echo $data->imp_res; ?>" data-risk_r="<?php echo $data->risk_res; ?>" data-perlakuan="<?php echo $data->perlakuan; ?>" data-mitigasi="<?php echo $data->mitigasi; ?>" data-hood_m="<?php echo $data->hood_mit; ?>" data-imp_m="<?php echo $data->imp_mit; ?>" data-risk_m="<?php echo $data->risk_mit; ?>">
                          <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                        </a>
                      </td>
                    </tr>
                    <?php 
                    }
                    ?>
                  </tbody>          
                </table>
              </div>
              

              <!-- Edit data html -->
              <div id="edit" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Data Risiko</h4>
                    </div>
                    <form id="form" method="post" enctype="multipart/form-data">
                      <div class="modal-body" id="modal-edit">
                        <div class="form-group">
                          <input type="hidden" name="id_risk" id="id_risk">
                          <label class="control-label" for="hood_inh">Inherent Likelihood</label>
                          <input type="number" name="hood_inh" class="form-control" id="hood_inh" placeholder="1-5" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="imp_inh">Inherent Impact</label>
                          <input type="number" name="imp_inh" class="form-control" id="imp_inh" placeholder="1-5" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="control">Kontrol</label>
                          <select name="control" class="form-control" id="control" required>
                            <option value="" disabled selected> --- </option>
                            <option value="ada">Ada</option>
                            <option value="tidak">Tidak</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="memadai">Memadai</label>
                          <select name="memadai" class="form-control" id="memadai" required>
                            <option value="" disabled selected> --- </option>
                            <option value="memadai">Memadai</option>
                            <option value="belum">Belum Memadai</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="dijalankan">Dijalankan</label>
                          <select name="dijalankan" class="form-control" id="dijalankan" required>
                            <option value="" disabled selected> --- </option>
                            <option value="100%">Telah dijalankan</option>
                            <option value="50%">Belum selesai dijalankan</option>
                            <option value="<50%">Belum dijalankan</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="hood_res">Residual Likelihood</label>
                          <input type="number" name="hood_res" class="form-control" id="hood_res" placeholder="1-5" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="imp_res">Residuak Impact</label>
                          <input type="number" name="imp_res" class="form-control" id="imp_res" placeholder="1-5" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="perlakuan">Opsi Perlakuan</label>
                          <select name="perlakuan" class="form-control" id="perlakuan" required>
                            <option value="" disabled selected> --- </option>
                            <option value="accept">Accept </option>
                            <option value="reduce">Reduce </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="mitigasi">Tindakan Mitigasi</label>
                          <textarea name="mitigasi" id="mitigasi" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="hood_mit">Mitigasi Likelihood</label>
                          <input type="number" name="hood_mit" class="form-control" id="hood_mit" placeholder="1-5" required>
                        </div>
                        <div class="form-group">
                          <label class="control-label" for="imp_mit">Mitigasi Impact</label>
                          <input type="number" name="imp_mit" class="form-control" id="imp_mit" placeholder="1-5" required>
                        </div>
                      </div>
                      <div class="modal-footer"> 
                        <input type="submit" class="btn btn-success" name="edit" value="Simpan">
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- menghubungkan dengan jquery -->
              <script src="assets/js/jquery-1.10.2.js"></script>
              <script type="text/javascript">
                
                $(document).on("click", "#edit_risk", function(){
                  var idrisk = $(this).data('id');
                  var hood_inh = $(this).data('hood_i');
                  var imp_inh = $(this).data('imp_i');
                  var risk_inh = $(this).data('risk_i');
                  var control = $(this).data('control');
                  var memadai = $(this).data('memadai');
                  var dijalankan = $(this).data('dijalankan');
                  var hood_res = $(this).data('hood_r');
                  var imp_res = $(this).data('imp_r');
                  var risk_res = $(this).data('risk_r');
                  var perlakuan = $(this).data('perlakuan');
                  var mitigasi = $(this).data('mitigasi');
                  var hood_mit = $(this).data('hood_m');
                  var imp_mit = $(this).data('imp_m');
                  var risk_mit = $(this).data('risk_m');
                  
                  $("#modal-edit #id_risk").val(idrisk);
                  $("#modal-edit #hood_inh").val(hood_inh);
                  $("#modal-edit #imp_inh").val(imp_inh);
                  $("#modal-edit #risk_inh").val(risk_inh);
                  $("#modal-edit #control").val(control);
                  $("#modal-edit #memadai").val(memadai);
                  $("#modal-edit #dijalankan").val(dijalankan);
                  $("#modal-edit #hood_res").val(hood_res);
                  $("#modal-edit #imp_res").val(imp_res);
                  $("#modal-edit #perlakuan").val(perlakuan);
                  $("#modal-edit #mitigasi").val(mitigasi);
                  $("#modal-edit #hood_mit").val(hood_mit);
                  $("#modal-edit #imp_mit").val(imp_mit);
                  $("#modal-edit #risk_mit").val(risk_mit);
                });

                $(document).ready(function(){
                  $("#form").on("submit", (function(e){
                      e.preventDefault();
                      $.ajax({
                        url: '../models/edit_sisMit.php',
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