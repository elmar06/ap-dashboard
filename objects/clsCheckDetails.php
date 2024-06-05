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
        $query = 'INSERT INTO '.$this->table_name.' SET po_id=?, cv_no=?, bank=?, check_no=?, check_date=?, amount=?, tax=?, cv_amount=?, status=1';
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
        $query = 'UPDATE '.$this->table_name.' set cv_no=?, bank=?, check_no=?, check_date=?, tax=?, cv_amount=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->cv_no);
        $upd->bindParam(2, $this->bank);
        $upd->bindParam(3, $this->check_no);
        $upd->bindParam(4, $this->check_date);
        $upd->bindParam(5, $this->tax);
        $upd->bindParam(6, $this->cv_amount);
        $upd->bindParam(7, $this->id);

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
        $query = 'SELECT * FROM '.$this->table_name.' WHERE po_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->po_id);

		$sel->execute();
		return $sel;
    }

    public function get_all_check_details()
    {
        $query = 'SELECT id, po_id, cv_no, bank, check_no, check_date, amount, tax, cv_amount FROM '.$this->table_name.' WHERE status != 0';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel; 
    }

    public function get_active_check()
    {
        $query = 'SELECT id, po_id, check_no, cv_amount FROM '.$this->table_name.' WHERE status != 0';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_details_byID($po_id)
    {
        $query = 'SELECT check_details.id as "check-id", check_details.po_id, check_details.cv_no, check_details.cv_amount, check_details.bank, check_details.check_no, check_details.tax, check_details.check_date, bank.id, bank.name, po_details.receipt FROM check_details, bank, po_details WHERE check_details.bank = bank.id AND check_details.po_id = po_details.id AND check_details.status != 0 AND check_details.po_id LIKE :search';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute(array(':search' => '%'.$po_id.'%'));
        return $sel;
    }

    public function get_check_details_byID($po_id)
    {
        $query = 'SELECT check_details.id as "check-id", check_details.po_id, check_details.cv_no, check_details.cv_amount, check_details.bank, check_details.check_no, check_details.tax, check_details.check_date, po_details.receipt FROM check_details, po_details WHERE check_details.po_id = po_details.id AND (check_details.status != 0 OR check_details.status != 2) AND check_details.po_id LIKE :search';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        // $sel->bindParam(1, $this->po_id);
        $sel->execute(array(':search' => '%'.$po_id.'%'));

        $sel->execute();
        return $sel;
    }

    public function get_check_details()
    {
        $query = 'SELECT check_details.id as "check-id", check_details.po_id, check_details.cv_no, check_details.cv_amount, check_details.bank, check_details.check_no, check_details.tax, check_details.check_date, po_details.id, po_details.receipt FROM check_details, po_details WHERE check_details.po_id = po_details.id AND check_details.status != 0';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function mark_as_stale_check()
    {
        $query = 'UPDATE '.$this->table_name.' SET stale_date = ?, status = 2 WHERE po_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->stale_date);
        $upd->bindParam(2, $this->po_id);

        return ($upd->execute()) ? true : false;
    }

    public function get_staled_check($from, $to)
    {
        $query = 'SELECT po_details.id, po_details.company as "comp-id", po_details.supplier as "supp-id", check_details.po_id, check_details.check_date, check_details.check_no, check_details.cv_no, check_details.bank, check_details.tax, check_details.cv_amount, check_details.stale_date FROM check_details, po_details WHERE check_details.po_id = po_details.id AND check_details.status = 2 AND (check_details.stale_date BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute(array($from, $to));
        return $sel;
    }

    public function get_staled_check_details()
    {
        $query = 'SELECT * FROM check_details WHERE check_details.status = 2';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }
}

?>