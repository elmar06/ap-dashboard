<?php
class Department
{
    private $conn;
    private $table_name = 'departments';

    public $id;
    public $department;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_department()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET department=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add = $this->conn->prepare($query);

        $add->bindParam(1, $this->department);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_department()
    {
        $query = 'UPDATE '.$this->table_name.' SET department=? WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd =$this->conn->prepare($query);

        $upd->bindParam(1, $this->department);
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

    public function del_department()
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

    public function activate_department()
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

    public function view_department()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY department ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_department_details()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_active_department()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE status=1';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);
        $sel->execute();
        return $sel;
    }
}
?>