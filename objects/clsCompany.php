<?php

class Company
{
    private $conn;
    private $table_name = 'company';

    public $id;
    public $company;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_company()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET company=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->company);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_company()
    {
        $query = 'UPDATE '.$this->table_name.' set company=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->company);
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

    public function remove_company()
    {
        $query = 'UPDATE '.$this->table_name.' set status=0 WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$del = $this->conn->prepare($query);

		$del->bindParam(1, $this->id);

		if($del->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function activate_company()
    {
        $query = 'UPDATE '.$this->table_name.' set status=1 WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$del = $this->conn->prepare($query);

		$del->bindParam(1, $this->id);

		if($del->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function view_company()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY company ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function view_all_company()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY company ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_active_company()
    {
        $query = 'SELECT id, company, status FROM '.$this->table_name.' WHERE status != 0 ORDER BY company ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_company_detail()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }
}

?>