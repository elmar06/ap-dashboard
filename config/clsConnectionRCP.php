<?php
class clsConnectionRCP
{
	private $host = '192.168.2.2';
	private $dbname = 'rcpdb';
	private $username = 'admin';
	private $password = 'admin';

	private $connRCP;

	public function connectRCP()
	{
		$this->connRCP = null;

		try
		{
			$this->connRCP = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->username, $this->password);
		}
		catch(PDOException $exception)
		{
			echo 'Connection Error: '.$exception->getMessage();
		}
		return $this->connRCP;
	}

	public function disconnect()
	{
		$this->connRCP = null;
		return $this->connRCP;
	}
}

?>