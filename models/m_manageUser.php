<?php 
class ManUser {
    private $connection;

    function __construct($conn){
        $this->connection = $conn;     
    }

    public function tampil($id = null){
        $db = $this->connection;
        $sql = "SELECT * FROM tb_user";
        if ($id != null) {
            $sql .= " WHERE id_user = ?";
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

    public function tambah($id_user, $username, $level, $unit_terkait, $password) {
        $db = $this->connection;
        $hashedPassword = md5($password);
        $stmt = $db->prepare("INSERT INTO tb_user 
            (username, level, unit_terkait, password) 
            VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', 
            $username, 
            $level, 
            $unit_terkait, 
            $hashedPassword
        );
        $stmt->execute() or die($db->error);
        $stmt->close();
    }

    public function edit($id_user, $username, $level, $unit_terkait){
        $db = $this->connection;
        $stmt = $db->prepare("UPDATE tb_user SET 
            username = ?, 
            level = ?, 
            unit_terkait = ? 
            WHERE id_user = ?"
        );
        $stmt->bind_param('sssi', 
            $username, 
            $level, 
            $unit_terkait, 
            $id_user
        );
        $stmt->execute() or die($db->error);
        $stmt->close();
    }

    public function hapus($id){
        $db = $this->connection;
        $stmt = $db->prepare("DELETE FROM tb_user WHERE id_user = ?");
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
