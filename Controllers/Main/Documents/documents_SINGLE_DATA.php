<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class documents_SINGLE_DATA
{
    private $id;
    private $user_id;
    private $employee_id;
    private $employee_name;
    private $doc_type;
    private $file_name;
    private $file_path;
    private $file_size;
    private $status;
    private $uploaded_date;
    private $ast = "1";
    private $sdt;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM documents WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id            = $row['id'];
                $this->user_id       = isset($row['user_id']) ? $row['user_id'] : 1;
                $this->employee_id   = isset($row['employee_id']) ? $row['employee_id'] : '';
                $this->employee_name = isset($row['employee_name']) ? $row['employee_name'] : '';
                $this->doc_type      = isset($row['doc_type']) ? $row['doc_type'] : '';
                $this->file_name     = isset($row['file_name']) ? $row['file_name'] : '';
                $this->file_path     = isset($row['file_path']) ? $row['file_path'] : '';
                $this->file_size     = isset($row['file_size']) ? $row['file_size'] : '';
                $this->status        = isset($row['status']) ? $row['status'] : 'Uploaded';
                $this->uploaded_date = isset($row['uploaded_date']) ? $row['uploaded_date'] : '';
                $this->ast           = isset($row['ast']) ? $row['ast'] : '1';
                $this->sdt           = isset($row['sdt']) ? $row['sdt'] : (isset($row['uploaded_date']) ? $row['uploaded_date'] : date('Y-m-d H:i:s'));
            }
        }
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function is_state_of_data()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_employee_id()
    {
        return $this->employee_id;
    }

    public function get_employee_name()
    {
        return $this->employee_name;
    }

    public function get_doc_type()
    {
        return $this->doc_type;
    }

    public function get_file_name()
    {
        return $this->file_name;
    }

    public function get_file_path()
    {
        return $this->file_path;
    }

    public function get_file_size()
    {
        return $this->file_size;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function get_uploaded_date()
    {
        return $this->uploaded_date;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }
}
?>
