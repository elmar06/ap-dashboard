<?php
class PO_Details
{
    private $conn;
    private $table_name = 'po_details';

    public $id;
    public $po_num;
    public $company;
    public $supplier;
    public $bill_no;
    public $bill_date;
    public $terms;
    public $amount;
    public $due_date;
    public $days_due;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_po()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET bill_date=?, terms=?, due_date=?, days_due=?, bill_no=?, po_num=?, company=?, supplier=?, project=?, department=?, date_submit=?, submitted_by=?, reports=?, status=1, amount=?, si_num=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->bill_date);
        $add->bindParam(2, $this->terms);
        $add->bindParam(3, $this->due_date);
        $add->bindParam(4, $this->days_due);
        $add->bindParam(5, $this->bill_no);
        $add->bindParam(6, $this->po_num);
        $add->bindParam(7, $this->company);
        $add->bindParam(8, $this->supplier);
        $add->bindParam(9, $this->project);
        $add->bindParam(10, $this->department);
        $add->bindParam(11, $this->date_submit);
        $add->bindParam(12, $this->submitted_by);
        $add->bindParam(13, $this->reports);
        $add->bindParam(14, $this->amount);
        $add->bindParam(15, $this->si_num);
        
        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upload_po()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET bill_date=?, terms=?, due_date=?, days_due=?, bill_no=?, po_num=?, company=?, supplier=?, project=?, department=?, date_submit=?, submitted_by=?, reports=?, status=1, amount=?, si_num=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add =$this->conn->prepare($query);

        $add->bindParam(1, $this->bill_date);
        $add->bindParam(2, $this->terms);
        $add->bindParam(3, $this->due_date);
        $add->bindParam(4, $this->days_due);
        $add->bindParam(5, $this->bill_no);
        $add->bindParam(6, $this->po_num);
        $add->bindParam(7, $this->company);
        $add->bindParam(8, $this->supplier);
        $add->bindParam(9, $this->project);
        $add->bindParam(10, $this->department);
        $add->bindParam(11, $this->date_submit);
        $add->bindParam(12, $this->submitted_by);
        $add->bindParam(13, $this->reports);
        $add->bindParam(14, $this->amount);
        $add->bindParam(15, $this->si_num);
        
        if($add->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function upd_details()
    {
        $query = 'UPDATE '.$this->table_name.' SET bill_date=?, terms=?, due_date=?, days_due=?, bill_no=?, po_num=?, company=?, supplier=?, project=?, department=?, amount=?, amount=?, si_num=?, status=? WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd =$this->conn->prepare($query);

        $upd->bindParam(1, $this->bill_date);
        $upd->bindParam(2, $this->terms);
        $upd->bindParam(3, $this->due_date);
        $upd->bindParam(4, $this->days_due);
        $upd->bindParam(5, $this->bill_no);
        $upd->bindParam(6, $this->po_num);
        $upd->bindParam(7, $this->company);
        $upd->bindParam(8, $this->supplier);
        $upd->bindParam(9, $this->project);
        $upd->bindParam(10, $this->department);
        $upd->bindParam(11, $this->amount);
        $upd->bindParam(12, $this->amount);
        $upd->bindParam(13, $this->si_num);
        $upd->bindParam(14, $this->status);
        $upd->bindParam(15, $this->id);


        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_po_num()
    {
        $query = 'SELECT * FROM po_details WHERE po_num = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);
        
        $sel->bindParam(1, $this->po_num);

        $sel->execute();
		return $sel;
    }

    public function update_check_details()
    {
        $query = 'UPDATE check_details SET cv_no=?, bank=?, check_no=?, check_date=? WHERE po_id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->cv_no);
        $upd->bindParam(2, $this->bank);
        $upd->bindParam(3, $this->check_no);
        $upd->bindParam(4, $this->check_date);
        $upd->bindParam(5, $this->po_id);

        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save_old_details()
    {
        $query = 'INSERT INTO old_check_details SET cv_no=?, bank=?, check_no=?, check_date=?, po_id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->cv_no);
        $upd->bindParam(2, $this->bank);
        $upd->bindParam(3, $this->check_no);
        $upd->bindParam(4, $this->check_date);
        $upd->bindParam(5, $this->po_id);

        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_req_amount()
    {
        $query = 'SELECT amount FROM '.$this->table_name.' WHERE id=?';
        $this->conn->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

        $sel->execute();
        return $sel;
    }

    public function get_submitted_po()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_submitted_po_acc()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status != 10 ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_for_releasing_fo()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status = 10 ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_details_for_releasing()
    {
        $query = 'SELECT check_details.cv_no, check_details.bank, check_details.check_no, check_details.check_date, po_details.po_num, po_details.si_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.amount, supplier.supplier_name, company.company as "comp-name", bank.name as "bank-name" FROM check_details, po_details, supplier, company, bank WHERE check_details.bank = bank.id AND check_details.po_id = po_details.id AND po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_released_fo()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, po_other_details.date_release, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, check_details.cv_no, check_details.check_no FROM po_details, po_other_details, company, departments, supplier, project, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.id = check_details.po_id AND po_details.status = 11 AND po_details.id = po_other_details.po_id ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_submitted_po_by_user()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project FROM po_details, company, departments, supplier, project WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = ? ORDER BY po_details.date_submit DESC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);

		$sel->execute();
		return $sel;
    }

    public function get_pending_po()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status = 1 ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_returned_po()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status = 2 ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_process_po()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_releasing_po()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status = 10 ORDER BY po_details.date_submit ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_details_pending()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.date_submit, company.id, company.company as "company-name", supplier.id, supplier.supplier_name FROM po_details, company, supplier WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.status = 1 AND po_details.status != 0 AND po_details.submitted_by = ? ORDER BY po_details.date_submit';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);

		$sel->execute();
		return $sel;
    }

    public function get_po_by_id()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company as "comp-id", po_details.project as "proj-id", po_details.department as "dept-id", po_details.supplier as "supp-id", po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.amount, po_details.submitted_by, po_details.si_num, po_details.reports, po_details.status, company.id, company.company as "comp-name", departments.id as "dept-id", departments.department, supplier.id, supplier.supplier_name, project.id, project.project, po_other_details.po_id, po_other_details.remarks FROM po_details, po_other_details, company, departments, supplier, project WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.id = po_other_details.po_id AND po_details.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_po_by_id_wo_dept()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company as "comp-id", po_details.project as "proj-id", po_details.department as "dept-id", po_details.supplier as "supp-id", po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.amount, po_details.submitted_by, po_details.si_num, po_details.reports, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, project.id, project.project, po_other_details.po_id, po_other_details.remarks FROM po_details, po_other_details, company, supplier, project WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.project = project.id AND po_details.id = po_other_details.po_id AND po_details.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_po_by_id_for_cancel()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.bill_no, po_details.company as "comp-id", po_details.supplier as "supp-id", po_details.bill_date, po_details.due_date, company.company as "comp-name", supplier.supplier_name as "supp-name", check_details.cv_no, check_details.bank as "bank-id", check_details.check_no, check_details.check_date, bank.name as "bank-name" FROM po_details, company, supplier, check_details, bank WHERE po_details.id = check_details.po_id AND po_details.company = company.id AND po_details.supplier = supplier.id AND check_details.bank = bank.id AND po_details.id = ?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

		$sel->execute();
		return $sel;
    }

    public function get_po_id()
    {
        $query = "SELECT max(id) + 1 as 'po-id' FROM po_details";
	  	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	  	$sel = $this->conn->prepare($query);

	  	$sel->execute();
	  	return $sel;
    }

    public function get_po_status()
    {
        $query = 'SELECT status FROM '.$this->table_name.' WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

        $sel->execute();
	  	return $sel;
    }

    public function get_po_list_by_status()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.status = ? ORDER BY po_details.status ASC';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->status);

        $sel->execute();
	  	return $sel;
    }

    public function get_po_list_process()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status)) ORDER BY po_details.status ASC';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->status);

        $sel->execute();
	  	return $sel;
    }

    public function get_all_process_bo()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname" FROM po_details, company, departments, supplier, project, users WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND (find_in_set(3, po_details.status) || find_in_set(4, po_details.status)) AND company.id = ? ORDER BY po_details.status ASC'; 
        $sel = $this->conn->prepare($query);
        
        $sel->bindParam(1, $this->id);

        $sel->execute();
	  	return $sel;
    }

    public function get_all_for_signature_bo()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status as "po-stat", company.id, company.company as "comp-name", departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project, users.id, CONCAT(users.firstname, " ", users.lastname) as "fullname", check_details.cv_no, check_details.check_no FROM po_details, company, departments, supplier, project, users, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.department = departments.id AND po_details.project = project.id AND po_details.submitted_by = users.id AND po_details.id = check_details.po_id AND (find_in_set(4, po_details.status) || find_in_set(5, po_details.status) || find_in_set(6, po_details.status) || find_in_set(7, po_details.status)) AND company.id = ? ORDER BY po_details.date_submit ASC'; 
        $sel = $this->conn->prepare($query);
        
        $sel->bindParam(1, $this->id);

        $sel->execute();
	  	return $sel;
    }

    public function get_list_for_ea()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND (find_in_set(6, po_details.status) || find_in_set(7, po_details.status) || find_in_set(8, po_details.status)) ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_for_signature_ea()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND po_details.status = 6 ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_signed_ea()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND po_details.status = 7 ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_return_from_ea()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND (find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_list_checker()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND (find_in_set(8, po_details.status) || find_in_set(9, po_details.status) || find_in_set(10, po_details.status)) ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_for_verification()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND po_details.status=8 ORDER BY po_details.id ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_on_hold_check()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND po_details.status=9 ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_for_releasing_checker()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name, check_details.po_id, check_details.cv_no, check_details.check_no FROM po_details, company, supplier, check_details WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.id = check_details.po_id AND (find_in_set(10, po_details.status) || find_in_set(11, po_details.status)) ORDER BY po_details.status ASC';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_for_releasing_bo()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_date, po_details.status, company.id, company.company as "comp-name", supplier.id, supplier.supplier_name FROM po_details, company, supplier WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.status = 10 AND company.id = ? ORDER BY po_details.status ASC'; 
        $sel = $this->conn->prepare($query);
        
        $sel->bindParam(1, $this->id);

        $sel->execute();
	  	return $sel;
    }

    public function count_pending()
    {
        $query = 'SELECT count(id) as "pending-count" FROM '.$this->table_name.' WHERE status=1';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_return()
    {
        $query = 'SELECT count(id) as "return-count" FROM '.$this->table_name.' WHERE status=2';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_on_process()
    {
        $query = 'SELECT count(id) as "process-count" FROM '.$this->table_name.' WHERE (find_in_set(3, status) || find_in_set(4, status) || find_in_set(5, status) || find_in_set(6, status) || find_in_set(7, status) || find_in_set(8, status) || find_in_set(9, status))';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_releasing()
    {
        $query = 'SELECT count(id) as "releasing-count" FROM '.$this->table_name.' WHERE status=10';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_pending_by_user()
    {
        $query = 'SELECT count(id) as "pending-count" FROM '.$this->table_name.' WHERE status=1 AND submitted_by = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);

        $sel->execute();
        return $sel;
    }

    public function count_return_by_user()
    {
        $query = 'SELECT count(id) as "return-count" FROM '.$this->table_name.' WHERE status=2 AND submitted_by = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);

        $sel->execute();
        return $sel;
    }

    public function count_on_process_by_user()
    {
        $query = 'SELECT count(id) as "process-count" FROM '.$this->table_name.' WHERE (find_in_set(3, status) || find_in_set(4, status) || find_in_set(5, status) || find_in_set(6, status) || find_in_set(7, status) || find_in_set(8, status) || find_in_set(9, status)) AND submitted_by = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);
        
        $sel->execute();
        return $sel;
    }

    public function count_releasing_by_user()
    {
        $query = 'SELECT count(id) as "releasing-count" FROM '.$this->table_name.' WHERE status = 10 AND submitted_by = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->submitted_by);
        
        $sel->execute();
       
        return $sel;
    }

    public function count_for_process_bo()
    {
        $query = 'SELECT count(id) as "pending-count" FROM '.$this->table_name.' WHERE status=4';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function count_for_signature()
    {
        $query = 'SELECT count(id) as "count" FROM '.$this->table_name.' WHERE (find_in_set(5, status) || find_in_set(6, status))';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function count_signed()
    {
        $query = 'SELECT count(id) as "count" FROM '.$this->table_name.' WHERE status=7';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function count_return_from_ea()
    {
        $query = 'SELECT count(id) as "count" FROM '.$this->table_name.' WHERE (find_in_set(8, status) || find_in_set(9, status))';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function count_for_verification()
    {
        $query = 'SELECT count(id) as "count" FROM '.$this->table_name.' WHERE status=8';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function count_on_hold()
    {
        $query = 'SELECT count(id) as "count" FROM '.$this->table_name.' WHERE status=9';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->company);

        $sel->execute();
        return $sel;
    }

    public function mark_as_returned()
    {
        $query = 'UPDATE '.$this->table_name.' set status=? WHERE id=?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->id);
        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_for_processing()
    {
        $query = 'UPDATE po_details, po_other_details set po_details.status=?, po_details.reports=?, po_other_details.date_received_fo=?, po_other_details.received_by_fo=? WHERE po_details.id=? AND po_other_details.po_id=?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->reports);
        $upd->bindParam(3, $this->date_received_fo);
        $upd->bindParam(4, $this->received_by_fo);
        $upd->bindParam(5, $this->id);
        $upd->bindParam(6, $this->po_id);
        
        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_received_bo()
    {
        $query = 'UPDATE po_details, po_other_details set po_details.status = 4, po_other_details.date_received_bo = ?, po_other_details.received_by_bo = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->date_received_bo);
        $upd->bindParam(2, $this->received_by_bo);
        $upd->bindParam(3, $this->po_id);
        $upd->bindParam(4, $this->id);
        
        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    } 
    public function mark_bo_process()
    {
        $query = 'UPDATE po_details set po_details.status = 5 WHERE po_details.id=?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->id);
        
        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_sent_to_ea()
    {
        $query = 'UPDATE po_other_details, po_details SET po_details.status = 6, po_other_details.date_to_ea = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->date_to_ea);
        $upd->bindParam(2, $this->po_id);
        $upd->bindParam(3, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_as_signed()
    {
        $query = 'UPDATE '.$this->table_name.' set status=? WHERE id=?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->id);
        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_return_from_ea()
    {
        $query = 'UPDATE po_other_details, po_details SET po_details.status = ?, po_other_details.date_from_ea = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->date_from_ea);
        $upd->bindParam(3, $this->po_id);
        $upd->bindParam(4, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_for_verification()
    {
        $query = 'UPDATE po_other_details, po_details SET po_details.status = ?, po_other_details.date_from_ea = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->date_from_ea);
        $upd->bindParam(3, $this->po_id);
        $upd->bindParam(4, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_on_hold()
    {
        $query = 'UPDATE po_other_details, po_details SET po_details.status = ?, po_other_details.date_on_hold = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->date_on_hold);
        $upd->bindParam(3, $this->po_id);
        $upd->bindParam(4, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_for_release()
    {
        $query = 'UPDATE po_other_details, po_details SET po_details.status = ?, po_other_details.date_for_release = ? WHERE po_other_details.po_id = ? AND po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->status);
        $upd->bindParam(2, $this->date_for_release);
        $upd->bindParam(3, $this->po_id);
        $upd->bindParam(4, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_for_releasing()
    {
        $query = 'UPDATE po_details SET po_details.status = 8 WHERE po_details.id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function mark_released()
    {
        $query = 'UPDATE po_details, po_other_details SET po_details.status = 11, po_details.or_num = ?, po_other_details.date_release = ?, po_other_details.released_by = ? WHERE po_details.id = ? AND po_other_details.po_id = ?';
        $this->conn->setAttribute(PDO::ERRMODE_WARNING, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->or_num);
        $upd->bindParam(2, $this->date_release);
        $upd->bindParam(3, $this->released_by);
        $upd->bindParam(4, $this->id);
        $upd->bindParam(5, $this->po_id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    //other_po_details
    public function save_other_details()
    {
        $query = 'INSERT INTO po_other_details set po_id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add = $this->conn->prepare($query);

        $add->bindParam(1, $this->po_id);

        if($add->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function upload_other_details()
    {
        $query = 'INSERT INTO po_other_details set po_id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $add = $this->conn->prepare($query);

        $add->bindParam(1, $this->po_id);

        if($add->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function upd_date_returned()
    {
        $query = 'UPDATE po_other_details set date_returned_req = ?, remarks = ? WHERE po_id = ?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->date_returned_req);
        $upd->bindParam(2, $this->remarks);
        $upd->bindParam(3, $this->po_id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }

    public function check_po_dept()
    {
        $query = 'SELECT department FROM '.$this->table_name. ' WHERE id=?';
        $this->conn->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->bindParam(1, $this->id);

        $sel->execute();
        return $sel;
    }

    public function remove_po()
    {
        $query = 'UPDATE '.$this->table_name.' SET status = 0 WHERE id=?';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $upd = $this->conn->prepare($query);

        $upd->bindParam(1, $this->id);

        if($upd->execute())
        {
            return true;
        }else{
            return false;
        }
    }
}

?>