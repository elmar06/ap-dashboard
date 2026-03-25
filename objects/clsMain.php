<?php
class clsMain
{
    private $connMain;
    private $table_name = 'users';

    public function __construct($db)
    {
        $this->connMain = $db;
    }

    public function get_user_details()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE id = ?';
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_supplier_details()
    {
        $query = 'SELECT supplier_name FROM supplier WHERE id = ?';
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function view_all_currency()
    {
        $query = "SELECT * FROM currency WHERE status != 0 ORDER BY id";
		$this->connMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->connMain->prepare($query);

		$sel->execute();
		return $sel;
    }
}

?>