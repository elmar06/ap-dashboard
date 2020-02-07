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
    public $due_date;
    public $days_due;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add_po()
    {
        $query = 'INSERT INTO '.$this->table_name.' SET bill_date=?, terms=?, due_date=?, days_due=?, bill_no=?, po_num=?, company=?, supplier=?, date_submit=?, status=1';
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
        $add->bindParam(9, $this->date_submit);
        
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
        $query = 'UPDATE '.$this->table_name.' SET bill_date=?, terms=?, due_date=?, days_due=?, bill_no=?, po_num=?, company=?, supplier=? WHERE id=?';
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
        $upd->bindParam(9, $this->id);


        if($upd->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_submitted_po()
    {
        $query = 'SELECT po_details.id, po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.submitted_by, po_details.status, company.id, company.company, departments.id, departments.department, supplier.id, supplier.supplier_name, project.id, project.project FROM po_details, company, departments, supplier, project WHERE po_details.company = company.id, AND po_details.supplier = supplier.id AND po_details.department = department.id AND po_details.project = project.id';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_details_pending()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.date_submit, company.id, company.company as "company-name", supplier.id, supplier.supplier_name FROM po_details, company, supplier WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.status = 1 ORDER BY po_details.date_submit DESC LIMIT 6';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sel = $this->conn->prepare($query);

		$sel->execute();
		return $sel;
    }

    public function get_po_by_id()
    {
        $query = 'SELECT po_details.id as "po-id", po_details.po_num, po_details.company, po_details.supplier, po_details.bill_no, po_details.bill_date, po_details.terms, po_details.due_date, po_details.days_due, po_details.date_submit, company.id as "comp-id", company.company as "company-name", supplier.id as "supp-id", supplier.supplier_name FROM po_details, company, supplier WHERE po_details.company = company.id AND po_details.supplier = supplier.id AND po_details.status = 1 AND po_details.id=?';
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
        $query = 'SELECT count(id) as "return-count" FROM '.$this->table_name.' WHERE status=7';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_on_process()
    {
        $query = 'SELECT count(id) as "process-count" FROM '.$this->table_name.' WHERE status=2';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }

    public function count_releasing()
    {
        $query = 'SELECT count(id) as "releasing-count" FROM '.$this->table_name.' WHERE status=5';
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $sel = $this->conn->prepare($query);

        $sel->execute();
        return $sel;
    }
}

?>