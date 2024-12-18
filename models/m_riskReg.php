<?php 
class RiskReg {
    private $connection;

    function __construct($conn){
        $this->connection = $conn;     
    }

    public function tampil($id = null){
        $db = $this->connection;
        $sql = "SELECT id_risk, tujuan, kode_risk, jenis_risk, 
                        bisnis_risk, sumber_risk, uraian_risk, 
                        penyebab_risk, kualitatif_risk, 
                        kuantitatif_risk, risk_owner, 
                        unit_terkait FROM tb_risk";
        if ($id != null) {
            $sql .= " WHERE id_risk = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            $query = $db->query($sql) or die($db->error);
            return $query;
        }
    }

    public function tambah($id_risk, $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit) {
        $db = $this->connection;
        $stmt = $db->prepare("INSERT INTO tb_risk 
            (tujuan, kode_risk, jenis_risk, bisnis_risk, 
            sumber_risk, uraian_risk, penyebab_risk, 
            kualitatif_risk, kuantitatif_risk, 
            risk_owner, unit_terkait, hood_inh, imp_inh, 
            risk_inh, control, memadai, dijalankan,
            hood_res, imp_res, risk_res, perlakuan,
            mitigasi, hood_mit, imp_mit, risk_mit)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssssssiiisssiiissiii', 
            $tujuan, 
            $kode_risk, 
            $jenis_risk, 
            $bisnis_risk, 
            $sumber_risk, 
            $uraian_risk, 
            $penyebab_risk, 
            $kualitatif_risk, 
            $kuantitatif_risk, 
            $risk_owner, 
            $unit_terkait, 
            $hood_inh, 
            $imp_inh, 
            $risk_inh, 
            $control, 
            $memadai, 
            $dijalankan, 
            $hood_res, 
            $imp_res, 
            $risk_res, 
            $perlakuan, 
            $mitigasi, 
            $hood_mit, 
            $imp_mit, 
            $risk_mit);

        $stmt->execute() or die($db->error);
        $stmt->close();
    }

    public function edit($id_risk, $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait){
        $db = $this->connection;
        $stmt = $db->prepare("UPDATE tb_risk SET 
            tujuan = ?, 
            kode_risk = ?, 
            jenis_risk = ?, 
            bisnis_risk = ?, 
            sumber_risk = ?, 
            uraian_risk = ?, 
            penyebab_risk = ?, 
            kualitatif_risk = ?, 
            kuantitatif_risk = ?, 
            risk_owner = ?, 
            unit_terkait = ? 
            WHERE id_risk = ?"
        );
        $stmt->bind_param('sssssssssssi', 
        $tujuan, 
        $kode_risk, 
        $jenis_risk, 
        $bisnis_risk, 
        $sumber_risk, 
        $uraian_risk, 
        $penyebab_risk, 
        $kualitatif_risk, 
        $kuantitatif_risk, 
        $risk_owner, 
        $unit_terkait,  
        $id_risk
    );
        $stmt->execute() or die($db->error);
        $stmt->close();
    }

    public function hapus($id){
        $db = $this->connection;
        $stmt = $db->prepare("DELETE FROM tb_risk WHERE id_risk = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute() or die($db->error);
        $stmt->close();
    }

    function __destruct(){
        if (isset($this->connection)) {
            $this->connection->close();
        }
    }
}
?>