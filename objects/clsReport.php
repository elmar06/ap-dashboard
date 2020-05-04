<?php
class Reports
{
    private $conn;
    private $table_name = 'po_details';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function generate_by_company()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.company = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

		$sel->execute();
		return $sel;
    }

    public function generate_by_supplier()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.supplier = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->supplier);

		$sel->execute();
		return $sel;
    }

    public function generate_by_requestor()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND po_details.submitted_by = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);

		$sel->execute();
		return $sel;
    }

    public function generate_by_date($from, $to)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }

    public function generate_by_company_date($from, $to, $comp_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.company = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $comp_id));
		return $sel;
    }

    public function generate_by_supplier_date($from, $to, $supplier_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.supplier = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $supplier_id));
		return $sel;
    }

    public function generate_by_requestor_date($from, $to, $requestor_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.submitted_by = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $requestor_id));
		return $sel;
    }
}

?>