<?php 
include("../template/_header.php");
include("../models/m_sisMit.php");
include("../controller/sisMitController.php");

// Koneksi Database
$database = new Database();
$dbConnection = $database->getConnection();

$sisMit = new SisMit($dbConnection);
$controller = new MitigasiController($dbConnection, $sisMit);

// buat cek POST dan GET
$controller->handleRequest();
?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1><b>Analisis dan Mitigasi</b></h1>
              <ol class="breadcrumb">
              <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                  <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                  <li><a href=""><?= htmlspecialchars($level); ?></a></li>
                  <li class="active">Analisi dan Mitigasi</li>
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
                    <?php $controller->renderMitTable(); ?>
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
                          <label class="control-label" for="imp_res">Residuak Impact</label>
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
                          <textarea name="mitigasi" id="mitigasi" class="form-control" required></textarea>
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
                  const editButton = e.target.closest('#edit_risk');
                  if (editButton) {
                      e.preventDefault();
                      const idrisk = editButton.dataset.id;
                      const hood_inh = editButton.dataset.hood_i;
                      const imp_inh = editButton.dataset.imp_i;
                      const control = editButton.dataset.control;
                      const memadai = editButton.dataset.memadai;
                      const dijalankan = editButton.dataset.dijalankan;
                      const hood_res = editButton.dataset.hood_r;
                      const imp_res = editButton.dataset.imp_r;
                      const perlakuan = editButton.dataset.perlakuan;
                      const mitigasi = editButton.dataset.mitigasi;
                      const hood_mit = editButton.dataset.hood_m;
                      const imp_mit = editButton.dataset.imp_m;
                      
                      document.querySelector("#modal-edit #id_risk").value = idrisk;
                      document.querySelector("#modal-edit #hood_inh").value = hood_inh;
                      document.querySelector("#modal-edit #imp_inh").value = imp_inh;
                      document.querySelector("#modal-edit #control").value = control;
                      document.querySelector("#modal-edit #memadai").value = memadai;
                      document.querySelector("#modal-edit #dijalankan").value = dijalankan;
                      document.querySelector("#modal-edit #hood_res").value = hood_res;
                      document.querySelector("#modal-edit #imp_res").value = imp_res;
                      document.querySelector("#modal-edit #perlakuan").value = perlakuan;
                      document.querySelector("#modal-edit #mitigasi").value = mitigasi;
                      document.querySelector("#modal-edit #hood_mit").value = hood_mit;
                      document.querySelector("#modal-edit #imp_mit").value = imp_mit;
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