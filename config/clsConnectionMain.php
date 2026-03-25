<?php
class clsConnectionMain
{
	private $host = '192.168.2.2';
	private $dbname = 'maindb';
	private $username = 'admin';
	private $password = 'admin';

	private $connRCP;

	public function connectMain()
	{
		$this->connMain = null;

		try
		{
			$this->connMain = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
		}
		catch(PDOException $exception)
		{
			echo 'Connection Error: '.$exception->getMessage();
		}
		return $this->connMain;
	}

	public function disconnect()
	{
		$this->connMain = null;
		return $this->connMain;
	}
}

?>