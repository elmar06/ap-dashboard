<?php

class Banks
{
    private $conn;
    private $table_name = 'bank';

    public $id;
    public $name;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_bank()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET name=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->name);
        $add->bindParam(2, $this->status);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_bank()
    {
        $query = 'UPDATE '.$this->table_name.' set name=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->name);
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

    public function remove_bank()
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

    public function view_all_banks()
    {
        $query = 'SELECT * '.$this->table_name.' ORDER BY name ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_bank_details()
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