<?php
class clsConnection
{
	private $host = 'localhost';
	private $dbname = 'ap_dashboard';
	private $username = 'root';
	private $password = '';

	private $conn;

	public function connect()
	{
		$this->conn = null;

		try
		{
			$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
		}
		catch(PDOException $exception)
		{
			echo 'Connection Error: '.$exception->getMessage();
		}
		return $this->conn;
	}

	public function disconnect()
	{
		$this->conn = null;
		return $this->conn;
	}
}

?>