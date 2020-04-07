<?php
class Access
{
    private $conn;
    private $table_name = 'access';

    public $id;
    public $user_id;
    public $company;

    public function __construct($db)
	{
		$this->conn = $db;
    }
    
    public function add_access()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET user_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->user_id);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function add_user_access()
	{
		$query = 'UPDATE '.$this->table_name.' SET company=? WHERE user_id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->company);
		$upd->bindParam(2, $this->user_id);

		if($upd->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }
    
    public function get_company()
 	{
 		$query = 'SELECT id, user_id, company as "comp-access" FROM '.$this->table_name.' WHERE user_id = ?'; 
 		$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $sel = $this->conn->prepare($query);
         
        $sel->bindParam(1, $this->user_id);
 		$sel->execute();

 		return $sel;
	 }
	 
}
?>