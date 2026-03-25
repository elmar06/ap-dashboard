<?php
class RCP_Details
{
    private $connRCP;
    private $table_name = 'rcp_details';

    public function __construct($db)
    {
        $this->connRCP = $db;
    }

    public function mark_returned_RCP()
    {
        $query = 'UPDATE '.$this->table_name.' SET ap_remark=?, status=8 WHERE id=?';
        $this->connRCP->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->connRCP->prepare($query);
        $upd->bindParam(1, $this->ap_remark);
        $upd->bindParam(2, $this->id);

        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_rcp_details()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id = ?';
        $this->connRCP->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connRCP->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }
}

?>