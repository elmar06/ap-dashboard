<?php
class Project
{
    private $conn;
    private $table_name = 'project';

    public $id;
    public $project;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_project()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET project=?, status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->project);

        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_project()
    {
        $query = 'UPDATE '.$this->table_name.' set project=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);
        
        $upd->bindParam(1, $this->project);
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

    public function remove_project()
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

    public function activate_project()
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

    public function view_all_project()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY project ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function view_project_by_id()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }
}
?>