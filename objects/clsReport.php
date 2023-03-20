<?php
class Reports
{
    private $conn;
    private $table_name = 'po_details';

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //Administrator report functions
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

    //Accounting report functions
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

    //Purchasing report functions
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

    //Treasury 
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
        $query = 'SELECT check_details.check_date, check_details.cv_no, po_details.due_date, check_details.check_no, po_details.supplier, po_details.bill_date, po_other_details.date_received_fo, po_details.due_date, check_details.cv_amount, supplier.id, supplier.supplier_name FROM po_details, po_other_details, check_details, supplier WHERE po_details.id = check_details.po_id AND po_details.id = po_other_details.po_id AND po_details.supplier = supplier.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) AND (po_details.date_submit BETWEEN ? AND ?)';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

		$sel->execute(array($from, $to));
		return $sel;
    }
}

?>