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
		$query = 'INSERT INTO '.$this->table_name.' SET user_id=?, company=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->user_id);
		$ins->bindParam(2, $this->company);

		if($ins->execute())
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