<?php

class Users
{
	private $conn;
	private $table_name = 'users';

	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $logcount;
	public $access;
	public $status;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function add_user()
	{
		$query = 'INSERT INTO '.$this->table_name.' SET firstname=?, lastname=?, email=?, username=?, password=?, logcount=?, access=?, status=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ins = $this->conn->prepare($query);

		$ins->bindParam(1, $this->firstname);
		$ins->bindParam(2, $this->lastname);
		$ins->bindParam(3, $this->email);
		$ins->bindParam(4, $this->username);
		$ins->bindParam(5, $this->password);
		$ins->bindParam(6, $this->logcount);
		$ins->bindParam(7, $this->access);
		$ins->bindParam(8, $this->status);

		if($ins->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update_user()
	{
		$query = 'UPDATE '.$this->table_name.' set firstname=?, lastname=?, email=?, access=?, username=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->firstname);
		$upd->bindParam(2, $this->lastname);
		$upd->bindParam(3, $this->email);
		$upd->bindParam(4, $this->access);
		$upd->bindParam(5, $this->username);
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

	public function update_user_settings()
	{
		$query = 'UPDATE '.$this->table_name.' set firstname=?, lastname=?, email=?, access=?, username=?, password=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$upd = $this->conn->prepare($query);

		$upd->bindParam(1, $this->firstname);
		$upd->bindParam(2, $this->lastname);
		$upd->bindParam(3, $this->email);
		$upd->bindParam(4, $this->access);
		$upd->bindParam(5, $this->username);
		$upd->bindParam(6, $this->password);
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

	public function activate_user()
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

	public function remove_user()
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

	public function reset_user_password()
	{
		$query = 'UPDATE '.$this->table_name.' SET password=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$res = $this->conn->prepare($query);

		$res->bindParam(1, $this->password);
		$res->bindParam(2, $this->id);

		if($res->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function change_password()
	{
		$query = 'UPDATE '.$this->table_name.' SET password=?, logcount=1 WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$res = $this->conn->prepare($query);

		$res->bindParam(1, $this->password);
		$res->bindParam(2, $this->id);

		if($res->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_user_detail_byid()
	{
		$query = 'SELECT * FROM '.$this->table_name.' WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
	}

	public function view_all_user()
	{
		$query = 'SELECT id, CONCAT(firstname, " ", lastname) as "fullname", firstname, lastname, email, access, username, status FROM '.$this->table_name.' ORDER BY access ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
	}

	public function reset_password()
	{
		$query = 'UPDATE '.$this->table_name.' SET password=? WHERE id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->password);
		$sel->bindParam(2, $this->id);

		if($sel->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function login()
	{
		$query = 'SELECT id, CONCAT(firstname, " ", lastname) as "fullname", firstname, lastname, email, password, logcount, access FROM users WHERE username=? AND password=? AND status != 0';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->bindParam(1, $this->username);
		$sel->bindParam(2, $this->password);

		$sel->execute();
		return $sel;
	}

	public function logout()
	{
		session_start();
		if(session_destroy())
		{
			return true;
			unset($_SESSION['fullname']);
		}
		else
		{
			return false;
		}
	}

	
}

?>