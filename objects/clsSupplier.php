<?php
class Supplier
{
    private $conn;
    private $table_name = 'supplier';

    public $id;
    public $supplier_name;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_supplier()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET supplier_name=?, terms=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add = $this->conn->prepare($query);

        $add->bindParam(1, $this->supplier_name);
        $add->bindParam(2, $this->terms);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_supplier()
    {
        $query = 'UPDATE '.$this->table_name.' SET supplier_name=?, terms=? WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd =$this->conn->prepare($query);

        $upd->bindParam(1, $this->supplier_name);
        $upd->bindParam(2, $this->terms);
        $upd->bindParam(3, $this->id);

        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function del_supplier()
    {
        $query = 'UPDATE '.$this->table_name.' SET status=0 WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $del =$this->conn->prepare($query);

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

    public function activate_supplier()
    {
        $query = 'UPDATE '.$this->table_name.' SET status=1 WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $act =$this->conn->prepare($query);

        $act->bindParam(1, $this->id);

        if($act->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function view_suppliers()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY supplier_name ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_active_supplier()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE status != 0 ORDER BY supplier_name ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_supplier_details()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_term()
    {
        $query = 'SELECT terms FROM '.$this->table_name.' WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

        $sel->execute();
        return $sel;
    }
}

?>