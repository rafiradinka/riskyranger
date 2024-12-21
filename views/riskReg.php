<?php 
include("../template/_header.php");
include("../models/m_riskReg.php");
include("../controller/riskRegController.php");

$database = new Database();
$dbConnection = $database->getConnection();;

$riskReg = new RiskReg($dbConnection);
$controller = new RiskRegController($dbConnection, $riskReg);

$controller->handleRequest();

?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <h1><b>Risk Register</b></h1>
                <ol class="breadcrumb">
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                    <li><a href=""><?= htmlspecialchars($level); ?></a></li>
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
                      <?php $controller->renderRiskTable(); ?>
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
                            <select name="unit_terkait" class="form-control" id="unit_terkait" required>
                              <option value="" disabled selected>Pilih Unit</option>
                              <option value="ptipd">PTIPD</option>
                              <option value="Fakultas Sains dan Teknologi">Fakultas Sains dan Teknologi</option>
                              <option value="Fakultas Ekonomi dan Bisnis Islam">Fakultas Ekonomi dan Bisnis Islam</option>
                              <option value="Fakultas Dakwah dan Komunikasi">Fakultas Dakwah dan Komunikasi</option>
                              <option value="Fakultas Ilmu Sosial dan Humaniora">Fakultas Ilmu Sosial dan Humaniora</option>
                              <option value="Fakultas Ilmu Tarbiyah dan Keguruan">Fakultas Ilmu Tarbiyah dan Keguruan</option>
                              <option value="Fakultas Ushuluddin dan Pemikiran Islam">Fakultas Ushuluddin dan Pemikiran Islam</option>
                              <option value="Fakultas Syariah dan Hukum">Fakultas Syariah dan Hukum</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label class="control-label" for="hood_inh">Inherent Likelihood</label>
                            <input type="number" name="hood_inh" class="form-control" id="hood_inh" min="1" max="5" pattern="[1-5]" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label" for="imp_inh">Inherent Impact</label>
                            <input type="number" name="imp_inh" class="form-control" id="imp_inh" min="1" max="5" pattern="[1-5]" required>
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
                            <input type="number" name="hood_res" class="form-control" id="hood_res" min="1" max="5" pattern="[1-5]" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label" for="imp_res">Residual Impact</label>
                            <input type="number" name="imp_res" class="form-control" id="imp_res" min="1" max="5" pattern="[1-5]" required>
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
                            <input type="text" name="mitigasi" class="form-control" id="mitigasi" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label" for="hood_mit">Mitigasi Likelihood</label>
                            <input type="number" name="hood_mit" class="form-control" id="hood_mit" min="1" max="5" pattern="[1-5]" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label" for="imp_mit">Mitigasi Impact</label>
                            <input type="number" name="imp_mit" class="form-control" id="imp_mit" min="1" max="5" pattern="[1-5]" required>
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
                            <select name="unit_terkait" class="form-control" id="unit_terkait" required>
                              <option value="" disabled selected>Pilih Unit</option>
                              <option value="ptipd">PTIPD</option>
                              <option value="Fakultas Sains dan Teknologi">Fakultas Sains dan Teknologi</option>
                              <option value="Fakultas Ekonomi dan Bisnis Islam">Fakultas Ekonomi dan Bisnis Islam</option>
                              <option value="Fakultas Dakwah dan Komunikasi">Fakultas Dakwah dan Komunikasi</option>
                              <option value="Fakultas Ilmu Sosial dan Humaniora">Fakultas Ilmu Sosial dan Humaniora</option>
                              <option value="Fakultas Ilmu Tarbiyah dan Keguruan">Fakultas Ilmu Tarbiyah dan Keguruan</option>
                              <option value="Fakultas Ushuluddin dan Pemikiran Islam">Fakultas Ushuluddin dan Pemikiran Islam</option>
                              <option value="Fakultas Syariah dan Hukum">Fakultas Syariah dan Hukum</option>
                            </select>
                          </div>
                          <div class="modal-footer"> 
                            <input type="submit" class="btn btn-success" name="edit" value="Simpan">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <script type="text/javascript">
                // klik tombol edit
                document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('tbody').addEventListener('click', function(e) {
                    const editButton = e.target.closest('#edit_risk');
                    if (editButton) {
                        e.preventDefault();
                        const idrisk = editButton.dataset.id;
                        const tujuan = editButton.dataset.tujuan;
                        const kode_risk = editButton.dataset.kode;
                        const jenis_risk = editButton.dataset.jenis;
                        const bisnis_risk = editButton.dataset.bisnis;
                        const sumber_risk = editButton.dataset.sumber;
                        const uraian_risk = editButton.dataset.uraian;
                        const penyebab_risk = editButton.dataset.penyebab;
                        const kualitatif_risk = editButton.dataset.kualitatif;
                        const kuantitatif_risk = editButton.dataset.kuantitatif;
                        const risk_owner = editButton.dataset.owner;
                        const unit_terkait = editButton.dataset.unit;
                        
                        document.querySelector("#modal-edit #id_risk").value = idrisk;
                        document.querySelector("#modal-edit #tujuan").value = tujuan;
                        document.querySelector("#modal-edit #kode_risk").value = kode_risk;
                        document.querySelector("#modal-edit #jenis_risk").value = jenis_risk;
                        document.querySelector("#modal-edit #bisnis_risk").value = bisnis_risk;
                        document.querySelector("#modal-edit #sumber_risk").value = sumber_risk;
                        document.querySelector("#modal-edit #uraian_risk").value = uraian_risk;
                        document.querySelector("#modal-edit #penyebab_risk").value = penyebab_risk;
                        document.querySelector("#modal-edit #kualitatif_risk").value = kualitatif_risk;
                        document.querySelector("#modal-edit #kuantitatif_risk").value = kuantitatif_risk;
                        document.querySelector("#modal-edit #risk_owner").value = risk_owner;
                        document.querySelector("#modal-edit #unit_terkait").value = unit_terkait;
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

                // biar likelihood dan impact hanya bisa angka 1-5
                document.addEventListener('DOMContentLoaded', function() {
                    function validateInput(input) {
                        const value = parseInt(input.value);
                        if (isNaN(value) || value < 1 || value > 5) {
                            if (!input.dataset.alertShown) {
                                alert('Nilai harus antara 1-5');
                                input.dataset.alertShown = 'true';
                            }
                            input.value = ''; 
                            return false;
                        }
                        input.dataset.alertShown = 'false';
                        return true;
                    }

                    const numberInputs = [
                        'hood_inh', 'imp_inh', 'hood_res', 
                        'imp_res', 'hood_mit', 'imp_mit'
                    ];

                    numberInputs.forEach(inputId => {
                        const input = document.getElementById(inputId);
                        if (input) {
                            input.addEventListener('input', function() {
                                const value = this.value;
                                if (value !== '' && (value < 1 || value > 5)) {
                                    if (!this.dataset.alertShown) {
                                        alert('Nilai harus antara 1-5');
                                        this.dataset.alertShown = 'true';
                                    }
                                    this.value = '';
                                } else {
                                    this.dataset.alertShown = 'false';
                                }
                            });

                            input.addEventListener('keypress', function(e) {
                                if (!/[1-5]/.test(e.key)) {
                                    e.preventDefault();
                                }
                            });

                            const form = input.closest('form');
                            if (form && !form.dataset.validationAdded) {
                                form.dataset.validationAdded = 'true';
                                form.addEventListener('submit', function(e) {
                                    let isValid = true;
                                    numberInputs.forEach(id => {
                                        const input = document.getElementById(id);
                                        if (input && !validateInput(input)) {
                                            isValid = false;
                                        }
                                    });
                                    if (!isValid) {
                                        e.preventDefault();
                                    }
                                });
                            }
                        }
                    });
                });
                </script>
                
            </div>
          </div>
      </div>
    </div>

<?php include("../template/_footer.php");?>