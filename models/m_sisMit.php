<?php 
class SisMit {
    private $connection;

    function __construct($conn){
        $this->connection = $conn;     
    }

    private function calculateRiskValue($likelihood, $impact) {
        return $likelihood * $impact;
    }

    public function tampil($id = null){
        $db = $this->connection;
        $sql = "SELECT id_risk, kode_risk, hood_inh, imp_inh, 
                        (hood_inh * imp_inh) AS risk_inh, 
                        control, memadai, dijalankan, 
                        hood_res, imp_res, 
                        (hood_res * imp_res) AS risk_res, 
                        perlakuan, mitigasi, 
                        hood_mit, imp_mit, 
                        (hood_mit * imp_mit) AS risk_mit 
                FROM tb_risk";        
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

    public function edit($id_risk, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit){
        $db = $this->connection;
        $risk_inh = $this->calculateRiskValue($hood_inh, $imp_inh);
        $risk_res = $this->calculateRiskValue($hood_res, $imp_res);
        $risk_mit = $this->calculateRiskValue($hood_mit, $imp_mit);
        $stmt = $db->prepare("UPDATE tb_risk SET 
            hood_inh = ?, 
            imp_inh = ?, 
            risk_inh = ?, 
            control = ?, 
            memadai = ?, 
            dijalankan = ?, 
            hood_res = ?, 
            imp_res = ?, 
            risk_res = ?, 
            perlakuan = ?, 
            mitigasi = ?, 
            hood_mit = ?, 
            imp_mit = ?, 
            risk_mit = ? 
            WHERE id_risk = ?");
        $stmt->bind_param('iiisssiiissiiii', 
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
            $risk_mit,  
            $id_risk
        );     

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