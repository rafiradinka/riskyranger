<?php 
class SisMit {
    private $connection;

    function __construct($conn){
        $this->connection = $conn;     
    }

    public function tampil($id = null){
        $db = $this->connection;
        $sql = "SELECT id_risk, tujuan, hood_inh, imp_inh, risk_inh, control, memadai, dijalankan, hood_res, imp_res, risk_res, perlakuan, mitigasi, hood_mit, imp_mit, risk_mit FROM tb_risk";
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

    public function edit($id_risk, $tujuan, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit){
        $db = $this->connection;
        $stmt = $db->prepare("UPDATE tb_risk SET tujuan = ?, hood_inh = ?, imp_inh = ?, risk_inh = ?, control = ?, memadai = ?, dijalankan = ?, hood_res = ?, imp_res = ?, risk_res = ?, perlakuan = ?, mitigasi = ?, hood_mit = ?, imp_mit = ?, risk_mit = ? WHERE id_risk = ?");
        $stmt->bind_param('siiisssiiissiiii', $tujuan, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit,  $id_risk);
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