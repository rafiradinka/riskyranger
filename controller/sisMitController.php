<?php 
class MitigasiController {
    private $mysqli;
    private $sisMit;

    public function __construct($mysqli, $mitModel) {
        $this->mysqli = $mysqli;
        $this->sisMit = $mitModel;
    }

    public function handleRequest() {
        // Handle different actions based on request
        if (isset($_POST['edit'])) {
            header('Content-Type: application/json');
            $this->handleEditMit();
            return;
        }
    }

    private function validateNumericInput($value) {
        $value = intval($value);
        return ($value >= 1 && $value <= 5);
    }


    private function handleEditMit() {
        try {
            header('Content-Type: application/json');
            // Validasi input
            if (!isset($_POST['id_risk']) || empty($_POST['id_risk'])) {
                throw new Exception('ID pengguna tidak ditemukan.');
            }

            if (empty($_POST['hood_inh']) || empty($_POST['imp_inh']) || empty($_POST['imp_inh']) || 
            empty($_POST['control']) || empty($_POST['memadai']) || empty($_POST['dijalankan']) || 
            empty($_POST['hood_res']) || empty($_POST['imp_res']) || empty($_POST['perlakuan']) || 
            empty($_POST['mitigasi']) || empty($_POST['hood_mit'])  || empty($_POST['imp_mit'])){
            throw new Exception('Semua field harus diisi!');
        }

            // buat keluaran input
            $id_risk = $this->mysqli->real_escape_string($_POST['id_risk']);
            $hood_inh = $this->mysqli->real_escape_string($_POST['hood_inh']);
            $imp_inh = $this->mysqli->real_escape_string($_POST['imp_inh']);
            $risk_inh = $hood_inh * $imp_inh;
            $control = $this->mysqli->real_escape_string($_POST['control']);
            $memadai = $this->mysqli->real_escape_string($_POST['memadai']);
            $dijalankan = $this->mysqli->real_escape_string($_POST['dijalankan']);
            $hood_res = $this->mysqli->real_escape_string($_POST['hood_res']);
            $imp_res = $this->mysqli->real_escape_string($_POST['imp_res']);
            $risk_res = $hood_res * $imp_res;
            $perlakuan = $this->mysqli->real_escape_string($_POST['perlakuan']);
            $mitigasi = $this->mysqli->real_escape_string($_POST['mitigasi']);
            $hood_mit = $this->mysqli->real_escape_string($_POST['hood_mit']);
            $imp_mit = $this->mysqli->real_escape_string($_POST['imp_mit']);
            $risk_mit = $hood_mit * $imp_mit;

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

            // Edit Data Analisis
            $this->sisMit->edit($id_risk, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit);
            
            ob_clean(); // untuk membersihkan output buffer
            echo json_encode([
                'success' => true,
                'message' => 'Data Analisis berhasil diupdate'
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
    
    public function renderMitTable() {
        $tampil = $this->sisMit->tampil();
        $no = 1;
        while($data = $tampil->fetch_object()):
        ?>
        <tr>
            <td align="center"><?= $no++."."; ?></td>
            <td><?= htmlspecialchars($data->kode_risk); ?></td>
            <td><?= htmlspecialchars($data->hood_inh); ?></td>
            <td><?= htmlspecialchars($data->imp_inh); ?></td>
            <td><?= htmlspecialchars($data->risk_inh); ?></td>
            <td><?= htmlspecialchars($data->control); ?></td>
            <td><?= htmlspecialchars($data->memadai); ?></td>
            <td><?= htmlspecialchars($data->dijalankan); ?></td>
            <td><?= htmlspecialchars($data->hood_res); ?></td>
            <td><?= htmlspecialchars($data->imp_res); ?></td>
            <td><?= htmlspecialchars($data->risk_res); ?></td>
            <td><?= htmlspecialchars($data->perlakuan); ?></td>
            <td><?= htmlspecialchars($data->mitigasi); ?></td>
            <td><?= htmlspecialchars($data->hood_mit); ?></td>
            <td><?= htmlspecialchars($data->imp_mit); ?></td>
            <td><?= htmlspecialchars($data->risk_mit); ?></td>
            <td align="center">
                <a href="" id="edit_risk" data-toggle="modal" data-target="#edit" 
                    data-id="<?php echo $data->id_risk;?>" 
                    data-hood_i="<?php echo $data->hood_inh; ?>" 
                    data-imp_i="<?php echo $data->imp_inh; ?>" 
                    data-risk_i="<?php echo $data->risk_inh; ?>" 
                    data-control="<?php echo $data->control; ?>" 
                    data-memadai="<?php echo $data->memadai; ?>" 
                    data-dijalankan="<?php echo $data->dijalankan; ?>" 
                    data-hood_r="<?php echo $data->hood_res; ?>" 
                    data-imp_r="<?php echo $data->imp_res; ?>" 
                    data-risk_r="<?php echo $data->risk_res; ?>" 
                    data-perlakuan="<?php echo $data->perlakuan; ?>" 
                    data-mitigasi="<?php echo $data->mitigasi; ?>" 
                    data-hood_m="<?php echo $data->hood_mit; ?>" 
                    data-imp_m="<?php echo $data->imp_mit; ?>" 
                    data-risk_m="<?php echo $data->risk_mit; ?>">
                    <button class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Edit</button>
                </a>
            </td>
        </tr>
        <?php 
        endwhile;
    }
}
?>