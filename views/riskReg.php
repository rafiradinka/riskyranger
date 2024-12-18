<?php 
include("../template/_header.php");
include("../models/m_riskReg.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new RiskReg($mysqli);

?>
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
                <th>Tujuan</th>
                <th>Kode</th>
                <th>Jenis Risiko</th>
                <th>Proses Bisnis</th>
                <th>Sumber Risiko</th>
                <th>Uraian Risiko</th>
                <th>Penyebab Risiko</th>
                <th>Kerugian kualitatif</th>
                <th>Kerugian Kuantitatif</th>
                <th>Pemilik Risiko</th>
                <th>Unit Terkait</th>
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
                <td><?php echo $data->tujuan; ?></td>
                <td><?php echo $data->kode_risk; ?></td>
                <td><?php echo $data->jenis_risk; ?></td>
                <td><?php echo $data->bisnis_risk; ?></td>
                <td><?php echo $data->sumber_risk; ?></td>
                <td><?php echo $data->uraian_risk; ?></td>
                <td><?php echo $data->penyebab_risk; ?></td>
                <td><?php echo $data->kualitatif_risk; ?></td>
                <td><?php echo $data->kuantitatif_risk; ?></td>
                <td><?php echo $data->risk_owner; ?></td>
                <td><?php echo $data->unit_terkait; ?></td>
                <td align="center">
                  <a href="" id="edit_risk" data-toggle="modal" data-target="#edit" data-id="<?php echo $data->id_risk; ?>" data-tujuan="<?php echo $data->tujuan; ?>" data-kode="<?php echo $data->kode_risk; ?>" data-jenis="<?php echo $data->jenis_risk; ?>" data-bisnis="<?php echo $data->bisnis_risk; ?>" data-sumber="<?php echo $data->sumber_risk; ?>" data-uraian="<?php echo $data->uraian_risk; ?>" data-penyebab="<?php echo $data->penyebab_risk; ?>" data-kualitatif="<?php echo $data->kualitatif_risk; ?>" data-kuantitatif="<?php echo $data->kuantitatif_risk; ?>" data-owner="<?php echo $data->risk_owner; ?>" data-unit="<?php echo $data->unit_terkait; ?>">
                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                  </a>
                  <a href="?page=riskg&act=del&id=<?php echo $data->id_risk; ?>" onclick="return confirm('Yakin akan menghapus data ini?')">
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
                    <label class="control-label" for="tujuan">tujuan</label>
                    <textarea name="tujuan" id="tujuan" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kode_risk">Kode Risiko</label>
                    <input type="text" name="kode_risk" class="form-control" id="kode_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="jenis_risk">Jenis Risiko</label>
                    <select name="jenis_risk" class="form-control" id="jenis_risk" required>
                      <option value="" disabled selected>Pilih Jenis Risiko</option>
                      <option value="strategis">Strategis</option>
                      <option value="finansial">Finansial</option>
                      <option value="operasional">Operasional</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="bisnis_risk">Bisnis Risiko</label>
                    <select name="bisnis_risk" class="form-control" id="bisnis_risk" required>
                      <option value="" disabled selected>Pilih Bisnis Risiko</option>
                      <option value="akademik">Akademik</option>
                      <option value="keuangan">Keuangan</option>
                      <option value="kepegawaian">Kepegawaian</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="sumber_risk">Sumber Risiko</label>
                    <select name="sumber_risk" class="form-control" id="sumber_risk" required>
                      <option value="" disabled selected>Pilih Bisnis Risiko</option>
                      <option value="internal">Internal</option>
                      <option value="eksternal">Eksternal</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="uraian_risk">Uraian Risiko</label>
                    <textarea name="uraian_risk" id="uraian_risk" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="penyebab_risk">Penyebab Risiko</label>
                    <textarea name="penyebab_risk" id="penyebab_risk" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kualitatif_risk">Kerugian Kualitatif</label>
                    <input type="text" name="kualitatif_risk" class="form-control" id="kualitatif_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kuantitatif_risk">Kerugian Kuantitatif</label>
                    <input type="text" name="kuantitatif_risk" class="form-control" id="kuantitatif_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="risk_owner">Pemilik Risiko</label>
                    <input type="text" name="risk_owner" class="form-control" id="risk_owner" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="unit_terkait">Unit Terkait</label>
                    <input type="text" name="unit_terkait" class="form-control" id="unit_terkait" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="hood_inh">Inherent Likelihood</label>
                    <input type="number" name="hood_inh" class="form-control" id="hood_inh" placeholder="1-5"  required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="imp_inh">Inherent Impact</label>
                    <input type="number" name="imp_inh" class="form-control" id="imp_inh" placeholder="1-5" required>
                  </div>
                  <!-- <div class="form-group">
                    <label class="control-label" for="risk_inh">Inherent Risiko</label>
                    <input type="number" name="risk_inh" class="form-control" id="risk_inh" placeholder="1-5" required>
                  </div> -->
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
                  <!-- <div class="form-group">
                    <label class="control-label" for="risk_res">Residual Risiko</label>
                    <input type="number" name="risk_res" class="form-control" id="risk_res" placeholder="1-5" required>
                  </div> -->
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
                    <input type="text" name="mitigasi" class="form-control" id="mitigasi" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="hood_mit">Mitigasi Likelihood</label>
                    <input type="number" name="hood_mit" class="form-control" id="hood_mit" placeholder="1-5" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="imp_mit">Mitigasi Impact</label>
                    <input type="number" name="imp_mit" class="form-control" id="imp_mit" placeholder="1-5" required>
                  </div>
                  <!-- <div class="form-group">
                    <label class="control-label" for="risk_mit">Mitigasi Risiko</label>
                    <input type="number" name="risk_mit" class="form-control" id="risk_mit" placeholder="1-5" required>
                  </div>   -->
                </div>
                <div class="modal-footer">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <input type="submit" class="btn btn-success" name="tambah" value="Simpan">
                </div>
              </form>

              <!-- tambah data ke database -->
              <?php 
              if(isset($_POST['tambah'])){
                $tujuan = $mysqli->real_escape_string($_POST['tujuan']);
                $kode_risk = $mysqli->real_escape_string($_POST['kode_risk']);
                $jenis_risk = $mysqli->real_escape_string($_POST['jenis_risk']);
                $bisnis_risk = $mysqli->real_escape_string($_POST['bisnis_risk']);
                $sumber_risk = $mysqli->real_escape_string($_POST['sumber_risk']);
                $uraian_risk = $mysqli->real_escape_string($_POST['uraian_risk']);
                $penyebab_risk = $mysqli->real_escape_string($_POST['penyebab_risk']);
                $kualitatif_risk = $mysqli->real_escape_string($_POST['kualitatif_risk']);
                $kuantitatif_risk = $mysqli->real_escape_string($_POST['kuantitatif_risk']);
                $risk_owner = $mysqli->real_escape_string($_POST['risk_owner']);
                $unit_terkait = $mysqli->real_escape_string($_POST['unit_terkait']);
                $hood_inh = $mysqli->real_escape_string($_POST['hood_inh']);
                $imp_inh = $mysqli->real_escape_string($_POST['imp_inh']);
                $risk_inh = $mysqli->real_escape_string($_POST['risk_inh']);
                $control = $mysqli->real_escape_string($_POST['control']);
                $memadai = $mysqli->real_escape_string($_POST['memadai']);
                $dijalankan = $mysqli->real_escape_string($_POST['dijalankan']);
                $hood_res = $mysqli->real_escape_string($_POST['hood_res']);
                $imp_res = $mysqli->real_escape_string($_POST['imp_res']);
                $risk_res = $mysqli->real_escape_string($_POST['risk_res']);
                $perlakuan = $mysqli->real_escape_string($_POST['perlakuan']);
                $mitigasi = $mysqli->real_escape_string($_POST['mitigasi']);
                $hood_mit = $mysqli->real_escape_string($_POST['hood_mit']);
                $imp_mit = $mysqli->real_escape_string($_POST['imp_mit']);
                $risk_mit = $mysqli->real_escape_string($_POST['risk_mit']);

                // Proses tambah data
                $user->tambah('', $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit);
                echo "<script>window.location.href = 'riskReg.php';</script>";
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
                <h4 class="modal-title">Edit Data Risiko</h4>
              </div>
              <form id="form" method="post" enctype="multipart/form-data">
                <div class="modal-body" id="modal-edit">
                <div class="form-group">
                    <label class="control-label" for="tujuan">tujuan</label>
                    <input type="hidden" name="id_risk" id="id_risk">
                    <textarea name="tujuan" id="tujuan" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kode_risk">Kode Risiko</label>
                    <input type="text" name="kode_risk" class="form-control" id="kode_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="jenis_risk">Jenis Risiko</label>
                    <select name="jenis_risk" class="form-control" id="jenis_risk" required>
                      <option value="" disabled selected>Pilih Jenis Risiko</option>
                      <option value="strategis">Strategis</option>
                      <option value="finansial">Finansial</option>
                      <option value="operasional">Operasional</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="bisnis_risk">Bisnis Risiko</label>
                    <select name="bisnis_risk" class="form-control" id="bisnis_risk" required>
                      <option value="" disabled selected>Pilih Bisnis Risiko</option>
                      <option value="akademik">Akademik</option>
                      <option value="keuangan">Keuangan</option>
                      <option value="kepegawaian">Kepegawaian</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="sumber_risk">Sumber Risiko</label>
                    <select name="sumber_risk" class="form-control" id="sumber_risk" required>
                      <option value="" disabled selected>Pilih Bisnis Risiko</option>
                      <option value="internal">Internal</option>
                      <option value="eksternal">Eksternal</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="uraian_risk">Uraian Risiko</label>
                    <textarea name="uraian_risk" id="uraian_risk" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="penyebab_risk">Penyebab Risiko</label>
                    <textarea name="penyebab_risk" id="penyebab_risk" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kualitatif_risk">Kerugian Kualitatif</label>
                    <input type="text" name="kualitatif_risk" class="form-control" id="kualitatif_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="kuantitatif_risk">Kerugian Kuantitatif</label>
                    <input type="text" name="kuantitatif_risk" class="form-control" id="kuantitatif_risk" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="risk_owner">Pemilik Risiko</label>
                    <input type="text" name="risk_owner" class="form-control" id="risk_owner" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="unit_terkait">Unit Terkait</label>
                    <input type="text" name="unit_terkait" class="form-control" id="unit_terkait" required>
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
          echo "<script>window.location.href = 'riskReg.php';</script>";
          exit;
        }
        ?>

        <!-- menghubungkan dengan jquery -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <script type="text/javascript">
          
          $(document).on("click", "#edit_risk", function(){
            var idrisk = $(this).data('id');
            var tujuan = $(this).data('tujuan');
            var kode_risk = $(this).data('kode');
            var jenis_risk = $(this).data('jenis');
            var bisnis_risk = $(this).data('bisnis');
            var sumber_risk = $(this).data('sumber');
            var uraian_risk = $(this).data('uraian');
            var penyebab_risk = $(this).data('penyebab');
            var kualitatif_risk = $(this).data('kualitatif');
            var kuantitatif_risk = $(this).data('kuantitatif');
            var risk_owner = $(this).data('owner');
            var unit_terkait = $(this).data('unit');
            
            $("#modal-edit #id_risk").val(idrisk);
            $("#modal-edit #tujuan").val(tujuan);
            $("#modal-edit #kode_risk").val(kode_risk);
            $("#modal-edit #jenis_risk").val(jenis_risk);
            $("#modal-edit #bisnis_risk").val(bisnis_risk);
            $("#modal-edit #sumber_risk").val(sumber_risk);
            $("#modal-edit #uraian_risk").val(uraian_risk);
            $("#modal-edit #penyebab_risk").val(penyebab_risk);
            $("#modal-edit #kualitatif_risk").val(kualitatif_risk);
            $("#modal-edit #kuantitatif_risk").val(kuantitatif_risk);
            $("#modal-edit #risk_owner").val(risk_owner);
            $("#modal-edit #unit_terkait").val(unit_terkait);
          });

          $(document).ready(function(){
            $("#form").on("submit", (function(e){
                e.preventDefault();
                $.ajax({
                  url: '../models/edit_riskReg.php',
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


<?php include("../template/_footer.php");?>