<?php

class CheckDetails
{
    private $conn;
    private $table_name = 'check_details';

    public $id;
    public $po_id;
    public $cv_no;
    public $bank;
    public $check_no;
    public $check_date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_details()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET po_id=?, cv_no=?, bank=?, check_no=?, check_date=?, amount=?, tax=?, cv_amount=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->po_id);
        $add->bindParam(2, $this->cv_no);
        $add->bindParam(3, $this->bank);
        $add->bindParam(4, $this->check_no);
        $add->bindParam(5, $this->check_date);
        $add->bindParam(6, $this->amount);
        $add->bindParam(7, $this->tax);
        $add->bindParam(8, $this->cv_amount);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_details()
    {
        $query = 'UPDATE '.$this->table_name.' set cv_no=?, bank=?, check_no=?, check_date=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->po_id);
        $upd->bindParam(2, $this->cv_no);
        $upd->bindParam(3, $this->bank);
        $upd->bindParam(4, $this->check_no);
        $upd->bindParam(5, $this->check_date);
        $upd->bindParam(6, $this->id);

        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    

    public function get_details()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_details_byID()
    {
        $query = 'SELECT check_details.po_id, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, bank.id, bank.name, po_details.receipt FROM check_details, bank, po_details WHERE check_details.bank = bank.id AND check_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->po_id);
        $sel->bindParam(2, $this->id);

        $sel->execute();
        return $sel;
    }
}

?>