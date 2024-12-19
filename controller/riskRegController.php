<?php 
class RiskRegController {
    private $mysqli;
    private $riskReg;

    public function __construct($mysqli, $riskModel) {
        $this->mysqli = $mysqli;
        $this->riskReg = $riskModel;
    }

    public function handleRequest() {
        if (isset($_POST['tambah'])) {
            $this->handleAddRisk();
        } elseif (isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])) {
            $this->handleDeleteRisk();
        } elseif (isset($_POST['edit'])) {
            header('Content-Type: application/json');
            $this->handleEditRisk();
            return;
        }
    }

    private function validateNumericInput($value) {
        $value = intval($value);
        return ($value >= 1 && $value <= 5);
    }

    private function handleAddRisk() {
        try {
            $tujuan = $this->mysqli->real_escape_string($_POST['tujuan']);
            $kode_risk = $this->mysqli->real_escape_string($_POST['kode_risk']);
            $jenis_risk = $this->mysqli->real_escape_string($_POST['jenis_risk']);
            $bisnis_risk = $this->mysqli->real_escape_string($_POST['bisnis_risk']);
            $sumber_risk = $this->mysqli->real_escape_string($_POST['sumber_risk']);
            $uraian_risk = $this->mysqli->real_escape_string($_POST['uraian_risk']);
            $penyebab_risk = $this->mysqli->real_escape_string($_POST['penyebab_risk']);
            $kualitatif_risk = $this->mysqli->real_escape_string($_POST['kualitatif_risk']);
            $kuantitatif_risk = $this->mysqli->real_escape_string($_POST['kuantitatif_risk']);
            $risk_owner = $this->mysqli->real_escape_string($_POST['risk_owner']);
            $unit_terkait = $this->mysqli->real_escape_string($_POST['unit_terkait']);
            $hood_inh = $this->mysqli->real_escape_string($_POST['hood_inh']);
            $imp_inh = $this->mysqli->real_escape_string($_POST['imp_inh']);
            $risk_inh = $this->mysqli->real_escape_string($_POST['risk_inh']);
            $control = $this->mysqli->real_escape_string($_POST['control']);
            $memadai = $this->mysqli->real_escape_string($_POST['memadai']);
            $dijalankan = $this->mysqli->real_escape_string($_POST['dijalankan']);
            $hood_res = $this->mysqli->real_escape_string($_POST['hood_res']);
            $imp_res = $this->mysqli->real_escape_string($_POST['imp_res']);
            $risk_res = $this->mysqli->real_escape_string($_POST['risk_res']);
            $perlakuan = $this->mysqli->real_escape_string($_POST['perlakuan']);
            $mitigasi = $this->mysqli->real_escape_string($_POST['mitigasi']);
            $hood_mit = $this->mysqli->real_escape_string($_POST['hood_mit']);
            $imp_mit = $this->mysqli->real_escape_string($_POST['imp_mit']);
            $risk_mit = $this->mysqli->real_escape_string($_POST['risk_mit']);
            

            // Validate angka untuk likelihood dan impact
            $numericFields = [
                'hood_inh', 'imp_inh', 'hood_res',
                'imp_res', 'hood_mit', 'imp_mit'
            ];

            foreach ($numericFields as $field) {
                if (!$this->validateNumericInput($_POST[$field])) {
                    throw new Exception("Nilai $field harus antara 1-5");
                }
            }

            // Add risk
            $this->riskReg->tambah('', $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit);
            $this->redirect('riskReg.php');
        } catch (Exception $e) {
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }
    }

    private function handleEditRisk() {
        try {
            header('Content-Type: application/json');
            // Validasi input
            if (!isset($_POST['id_risk']) || empty($_POST['id_risk'])) {
                throw new Exception('ID pengguna tidak ditemukan.');
            }

            if (empty($_POST['tujuan']) || empty($_POST['kode_risk']) || empty($_POST['jenis_risk']) || 
                empty($_POST['bisnis_risk']) || empty($_POST['sumber_risk']) || empty($_POST['uraian_risk']) || 
                empty($_POST['penyebab_risk']) || empty($_POST['kualitatif_risk']) || 
                empty($_POST['kuantitatif_risk']) || empty($_POST['risk_owner']) || empty($_POST['unit_terkait'])){
                throw new Exception('Semua field harus diisi!');
            }

            // buat keluaran input
            $id_risk = $this->mysqli->real_escape_string($_POST['id_risk']);
            $tujuan = $this->mysqli->real_escape_string($_POST['tujuan']);
            $kode_risk = $this->mysqli->real_escape_string($_POST['kode_risk']);
            $jenis_risk = $this->mysqli->real_escape_string($_POST['jenis_risk']);
            $bisnis_risk = $this->mysqli->real_escape_string($_POST['bisnis_risk']);
            $sumber_risk = $this->mysqli->real_escape_string($_POST['sumber_risk']);
            $uraian_risk = $this->mysqli->real_escape_string($_POST['uraian_risk']);
            $penyebab_risk = $this->mysqli->real_escape_string($_POST['penyebab_risk']);
            $kualitatif_risk = $this->mysqli->real_escape_string($_POST['kualitatif_risk']);
            $kuantitatif_risk = $this->mysqli->real_escape_string($_POST['kuantitatif_risk']);
            $risk_owner = $this->mysqli->real_escape_string($_POST['risk_owner']);
            $unit_terkait = $this->mysqli->real_escape_string($_POST['unit_terkait']);

            // Check tidak ada kode yang sama
            $checkQuery = "SELECT id_risk FROM tb_risk WHERE kode_risk = ? AND id_risk != ?";
            $stmt = $this->mysqli->prepare($checkQuery);
            $stmt->bind_param('si', $kode_risk, $id_risk);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                throw new Exception('Kode sudah terpakai!');
            }

            // Edit risiko
            $this->riskReg->edit($id_risk, $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait);
            
            ob_clean(); // untuk membersihkan output buffer
            echo json_encode([
                'success' => true,
                'message' => 'Risiko berhasil diupdate'
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

    private function handleDeleteRisk() {
        $id = $this->mysqli->real_escape_string($_GET['id']);
        $this->riskReg->hapus($id);
        $this->redirect('riskReg.php');
    }

    private function redirect($page) {
        echo "<script>window.location.href = '$page';</script>";
        exit;
    }

    public function renderRiskTable() {
        $tampil = $this->riskReg->tampil();
        $no = 1;
        while($data = $tampil->fetch_object()):
        ?>
        <tr>
            <td align="center"><?php echo $no++."."; ?></td>
            <td><?= htmlspecialchars($data->tujuan); ?></td>
            <td><?= htmlspecialchars($data->kode_risk); ?></td>
            <td><?= htmlspecialchars($data->jenis_risk); ?></td>
            <td><?= htmlspecialchars($data->bisnis_risk); ?></td>
            <td><?= htmlspecialchars($data->sumber_risk); ?></td>
            <td><?= htmlspecialchars($data->uraian_risk); ?></td>
            <td><?= htmlspecialchars($data->penyebab_risk); ?></td>
            <td><?= htmlspecialchars($data->kualitatif_risk); ?></td>
            <td><?= htmlspecialchars($data->kuantitatif_risk); ?></td>
            <td><?= htmlspecialchars($data->risk_owner); ?></td>
            <td><?= htmlspecialchars($data->unit_terkait); ?></td>
            <td align="center">
                <a href="" id="edit_risk" data-toggle="modal" data-target="#edit" 
                    data-id="<?= $data->id_risk; ?>" 
                    data-tujuan="<?= htmlspecialchars($data->tujuan); ?>" 
                    data-kode="<?= htmlspecialchars($data->kode_risk); ?>" 
                    data-jenis="<?= htmlspecialchars($data->jenis_risk); ?>" 
                    data-bisnis="<?= htmlspecialchars($data->bisnis_risk); ?>"
                    data-sumber="<?= htmlspecialchars($data->sumber_risk); ?>" 
                    data-uraian="<?= htmlspecialchars($data->uraian_risk); ?>" 
                    data-penyebab="<?= htmlspecialchars($data->penyebab_risk); ?>" 
                    data-kualitatif="<?= htmlspecialchars($data->kualitatif_risk); ?>" 
                    data-kuantitatif="<?= htmlspecialchars($data->kuantitatif_risk); ?>" 
                    data-owner="<?= htmlspecialchars($data->risk_owner); ?>" 
                    data-unit="<?= htmlspecialchars($data->unit_terkait); ?>">
                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                </a>
                <a href="?page=risk&act=del&id=<?= $data->id_risk; ?>" 
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