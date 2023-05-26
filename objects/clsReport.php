<?php
class Reports
{
    private $conn;
    private $table_name = 'po_details';

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //ADMINISTRATOR REPORT MODULE
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
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND (po_details.date_submit BETWEEN ? AND ? AND po_details.company = ?) ORDER BY po_other_details.date_received_bo';
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

    public function generate_by_status_date($from, $to, $status)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.status = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $status));
		return $sel;
    }

    public function generate_on_process_date($from, $to, $status)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_bo, po_other_details.received_by_bo, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) find_in_set(8, po_details.status)) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $status));
		return $sel;
    }

    //ACCOUNTING REPORT MODULE
    public function generate_by_company_acc()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.company = ? AND po_other_details.received_by_fo = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);
        $sel->bindParam(2, $this->received_by_fo);

		$sel->execute();
		return $sel;
    }

    public function generate_by_supplier_acc()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.supplier = ? AND po_other_details.received_by_fo = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->supplier);
        $sel->bindParam(2, $this->received_by_fo);

		$sel->execute();
		return $sel;
    }

    public function generate_by_date_acc($from, $to, $requestor_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_other_details.received_by_fo = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $requestor_id));
		return $sel;
    }

    public function generate_by_all_acc($from, $to, $requestor_id, $comp_id, $supplier_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_other_details.received_by_fo = ? AND po_details.company = ? AND po_details.supplier = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $requestor_id,  $comp_id, $supplier_id));
		return $sel;
    }

    //PURCHASING REPORT MODULE
    public function generate_by_company_req()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.company = ? AND po_details.submitted_by = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);
        $sel->bindParam(2, $this->submitted_by);

		$sel->execute();
		return $sel;
    }

    public function generate_by_supplier_req()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = 11 AND po_details.supplier = ? AND po_details.submitted_by = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->supplier);
        $sel->bindParam(2, $this->submitted_by);

		$sel->execute();
		return $sel;
    }

    public function generate_by_status()
    {
        $query = 'SELECT po_details.po_num, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name FROM po_details, po_other_details, company, supplier WHERE po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.status = ? ORDER BY po_details.id ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
    }

    public function generate_by_status_process()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.status = ? ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->status);

		$sel->execute();
		return $sel;
    }

    public function get_all_on_process()
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name" FROM po_details, po_other_details, check_details, company, supplier, bank WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function generate_by_date_req($from, $to, $requestor_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.submitted_by = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $requestor_id));
		return $sel;
    }

    public function generate_by_all_req($from, $to, $requestor_id, $comp_id, $supplier_id)
    {
        $query = 'SELECT po_details.po_num, check_details.check_date, check_details.cv_no, check_details.bank, check_details.check_no, po_details.supplier,po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_received_bo, po_other_details.received_by_fo, po_other_details.received_by_bo, po_other_details.date_release, po_details.or_num, po_details.due_date, po_details.amount, po_details.company, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, bank.id, bank.name as "bank-name", CONCAT(users.firstname, " ", users.lastname) as "req-name" FROM po_details, po_other_details, check_details, company, supplier, bank, users WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.submitted_by = users.id AND po_details.status = 11 AND (po_details.date_submit BETWEEN ? AND ? AND po_details.submitted_by = ? AND po_details.company = ? AND po_details.supplier = ?) ORDER BY po_other_details.date_received_bo';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $requestor_id,  $comp_id, $supplier_id));
		return $sel;
    }

    //TREASURY REPORT MODULE 
    public function generate_by_comp_treasury($from, $to, $comp_id)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) AND (po_details.date_submit BETWEEN ? AND ? AND po_details.company = ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $comp_id));
		return $sel;
    }

    public function generate_by_supp_treasury($from, $to, $supplier_id)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) AND (po_details.date_submit BETWEEN ? AND ? AND po_details.supplier = ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $supplier_id));
		return $sel;
    }

    public function generate_all_treasury($from, $to, $comp_id, $supplier_id)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) AND (po_details.date_submit BETWEEN ? AND ? AND po_details.company = ? AND po_details.supplier = ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to, $comp_id, $supplier_id));
		return $sel;
    }

    public function generate_by_date_treasury($from, $to)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) AND (po_details.date_submit BETWEEN ? AND ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }

    public function generate_report_treasury_5($comp_id, $stat_id, $from, $to)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND po_details.company = ? AND po_details.status =? AND (po_details.date_submit BETWEEN ? AND ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($comp_id, $stat_id, $from, $to));
		return $sel;
    }

    public function generate_report_treasury_6($supplier_id, $stat_id, $from, $to)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND po_details.supplier = ? AND po_details.status =? AND (po_details.date_submit BETWEEN ? AND ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($supplier_id, $stat_id, $from, $to));
		return $sel;
    }

    public function generate_report_treasury_7($comp_id, $supplier_id, $stat_id, $from, $to)
    {
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_other_details.date_on_hold, po_other_details.date_for_release, po_details.due_date, po_details.status, check_details.cv_amount, supplier.id, supplier.supplier_name, company.company as "comp-name" FROM po_details, po_other_details, check_details, supplier, company WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND po_details.company = company.id AND po_details.supplier = ? AND po_details.status =? AND (po_details.date_submit BETWEEN ? AND ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($comp_id, $supplier_id, $stat_id, $from, $to));
		return $sel;
    }

    //PMC REPORT MODULE
    public function get_by_proj_date_pmc($proj, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.project = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $from, $to));
		return $sel;
    }

    public function get_by_comp_date_pmc($comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.company = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $from, $to));
		return $sel;
    }

    public function get_by_supp_date_pmc($supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.supplier = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($supp, $from, $to));
		return $sel;
    }

    public function get_by_stat_date_pmc($stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($stat, $from, $to));
		return $sel;
    }

    public function get_by_stat3_date_pmc($from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }

    public function get_by_date_pmc($from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }

    public function get_by_comp_proj_date_pmc($proj, $comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $from, $to));
		return $sel;
    }

    public function get_by_proj_comp_supp_date_pmc($proj, $comp, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $from, $to));
		return $sel;
    }

    public function get_all_date_pmc($proj, $comp, $supp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $stat, $from, $to));
		return $sel;
    }

    public function get_all_stat_date_pmc($proj, $comp, $supp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.status, po_other_details.date_received_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $stat, $from, $to));
		return $sel;
    }

    //AACOUNTING FRONT OFFICE REPORT QUERY(CHECK FOR RELEASING)
    public function get_by_comp_date_fo($comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_other_details.date_for_release, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.company = ? AND po_details.status != 0 AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $from, $to));
		return $sel;
    }

    public function get_by_proj_date_fo($proj, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_other_details.date_for_release, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.project = ? AND po_details.status != 0 AND po_details.status = 10 AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $from, $to));
		return $sel;
    }

    public function get_by_supp_date_fo($supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_other_details.date_for_release, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = ? AND po_details.status != 0 AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($supp, $from, $to));
		return $sel;
    }

    public function get_by_stat_date_fo($stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.status = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($stat, $from, $to));
		return $sel;
    }

    public function get_by_date_fo($from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_other_details.date_for_release, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.status != 0 AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }

    public function get_by_comp_proj_date_fo($proj, $comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_other_details.date_for_release, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, po_other_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $from, $to));
		return $sel;
    }

    public function get_by_comp_supp_date_fo($comp, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $supp, $from, $to));
		return $sel;
    }

    public function get_all_date_fo($proj, $comp, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, check_details.cv_no, check_details.check_no, check_details.cv_amount FROM po_details, check_details WHERE po_details.status = 10 AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND (po_other_details.date_for_release BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $from, $to));
		return $sel;
    }

    //MANAGER REPORT QUERY
    //ACTION - 1
    public function get_by_proj_date_manager($proj, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.submitted_by = users.id AND po_details.project = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $from, $to));
		return $sel;
    }
    //ACTION - 2
    public function get_by_comp_date_manager($comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.company = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $from, $to));
		return $sel;
    }
    //ACTION - 3
    public function get_by_supp_date_manager($supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.supplier = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($supp, $from, $to));
		return $sel;
    }
    //ACTION - 4
    public function get_by_stat_date_manager($stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.status = ? AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($stat, $from, $to));
		return $sel;
    }
    //ACTION - 4
    public function get_by_stat3_date_manager($from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }
    //ACTION - 5
    public function get_by_comp_proj_date_manager($proj, $comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $from, $to));
		return $sel;
    }
    //ACTION - 6
    public function get_by_proj_comp_supp_date_manager($proj, $comp, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $from, $to));
		return $sel;
    }
    //ACTION - 7
    public function get_all_date_manager($proj, $comp, $supp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.supplier = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $supp, $stat, $from, $to));
		return $sel;
    }
    //ACTION - 8
    public function get_by_date_manager($from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }
    //ACTION - 9
    public function get_by_proj_supp_date_manager($proj, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.supplier = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $supp, $from, $to));
		return $sel;
    }
    //ACTION - 10
    public function get_by_proj_stat_date_manager($proj, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $stat, $from, $to));
		return $sel;
    }
    //ACTION - 10
    public function get_by_proj_stat3_date_manager($proj, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $from, $to));
		return $sel;
    }
    //ACTION - 11
    public function get_by_comp_supp_date_manager($comp, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.company = ? AND po_details.supplier = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $supp, $from, $to));
		return $sel;
    }
    //ACTION - 12
    public function get_by_comp_stat_date_manager($comp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.company = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $stat, $from, $to));
		return $sel;
    }
    //ACTION - 12
    public function get_by_comp_stat3_date_manager($comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.company = ? AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($comp, $from, $to));
		return $sel;
    }
    //ACTION - 13
    public function get_by_supp_stat_date_manager($supp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.supplier = ? AND po_details.status = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($supp, $stat, $from, $to));
		return $sel;
    }
    //ACTION - 13
    public function get_by_supp_stat3_date_manager($supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.supplier = ? AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($supp, $from, $to));
		return $sel;
    }
    //ACTION - 14
    public function get_by_proj_supp_stat_date_manager($proj, $supp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.supplier = ? AND po_details.stat = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $supp, $stat, $from, $to));
		return $sel;
    }

    public function get_by_proj_supp_stat3_date_manager($proj, $supp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.project = ? AND po_details.supplier = ? AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $supp, $from, $to));
		return $sel;
    }
    //ACTION - 15
    public function get_by_proj_comp_stat_date_manager($proj, $comp, $stat, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.status != 0 AND po_details.project = ? AND po_details.company = ? AND po_details.stat = ? AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $stat, $from, $to));
		return $sel;
    }

    public function get_by_proj_comp_stat3_date_manager($proj, $comp, $from, $to)
    {
        $query = 'SELECT po_details.company, po_details.project, po_details.supplier, po_details.or_num, po_details.po_num, po_details.si_num, po_details.amount, po_details.bill_date, po_details.due_date, po_details.memo_no, po_details.status, po_other_details.date_received_fo, po_other_details.received_by_fo, po_other_details.date_to_ea, po_other_details.date_from_ea, po_other_details.date_release, check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, check_details.tax, check_details.cv_amount, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, po_other_details, check_details, users WHERE po_details.submitted_by = users.id AND po_details.id = po_other_details.po_id AND po_details.id = check_details.po_id AND po_details.project = ? AND po_details.company = ? AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) AND po_details.status != 0 AND (po_details.date_submit BETWEEN ? AND ?)';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute(array($proj, $comp, $from, $to));
		return $sel;
    }
}

?>