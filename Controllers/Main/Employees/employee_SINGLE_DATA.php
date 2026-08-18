<?php

include_once __DIR__ . '/../../../imports/need/DB.php';

class employee_SINGLE_DATA
{
    private $id;
    private $initials = "";
    private $fullname = "";
    private $email_address = "";
    private $department = "";
    private $job_role = "";
    private $status = "active";
    private $joined_date = "";

    private $sdt = "";
    private $ast = "1";

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;
        $obj_database = new DataBase();
        $this->ensure_table_exists($obj_database);

        $get_sql_query = "SELECT * FROM employees WHERE id = '" . addslashes($this->id) . "'";
        $result = $obj_database->get_result($get_sql_query);

        if ($result && $result->num_rows > 0) {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id            = $row["id"];
                $this->fullname      = isset($row["fullname"]) ? $row["fullname"] : (isset($row["name"]) ? $row["name"] : "");
                $this->email_address = isset($row["email_address"]) ? $row["email_address"] : (isset($row["email"]) ? $row["email"] : "");
                $this->department    = isset($row["department"]) ? $row["department"] : (isset($row["dept"]) ? $row["dept"] : "");
                $this->job_role      = isset($row["job_role"]) ? $row["job_role"] : (isset($row["role"]) ? $row["role"] : "");
                $this->status        = isset($row["status"]) ? $row["status"] : "active";
                $this->joined_date   = isset($row["joined_date"]) ? $row["joined_date"] : (isset($row["joined"]) ? $row["joined"] : "");
                $this->initials      = isset($row["initials"]) ? $row["initials"] : "";
                if (empty($this->initials) && !empty($this->fullname)) {
                    $words = explode(' ', trim($this->fullname));
                    $in = '';
                    foreach ($words as $w) {
                        if (!empty($w)) $in .= strtoupper($w[0]);
                    }
                    $this->initials = substr($in, 0, 2) ?: 'EM';
                }
                $this->sdt           = isset($row["sdt"]) ? $row["sdt"] : "";
                $this->ast           = isset($row["ast"]) ? $row["ast"] : "1";
            }
        } else {
            $this->state_of_data = false;
        }
    }

    private function ensure_table_exists($db)
    {
        $create_sql = "CREATE TABLE IF NOT EXISTS `employees` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `initials` varchar(10) DEFAULT NULL,
            `fullname` varchar(255) NOT NULL,
            `email_address` varchar(255) NOT NULL,
            `department` varchar(100) DEFAULT 'Engineering',
            `job_role` varchar(100) DEFAULT 'Staff',
            `status` varchar(50) DEFAULT 'active',
            `joined_date` varchar(50) DEFAULT NULL,
            `ast` tinyint(1) DEFAULT 1,
            `sdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
        $db->get_result($create_sql);
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_state_of_data()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_initials()
    {
        return $this->initials;
    }

    public function get_fullname()
    {
        return $this->fullname;
    }

    public function get_name()
    {
        return $this->fullname;
    }

    public function get_email_address()
    {
        return $this->email_address;
    }

    public function get_email()
    {
        return $this->email_address;
    }

    public function get_department()
    {
        return $this->department;
    }

    public function get_dept()
    {
        return $this->department;
    }

    public function get_job_role()
    {
        return $this->job_role;
    }

    public function get_role()
    {
        return $this->job_role;
    }

    public function get_status()
    {
        return $this->status;
    }

    public function get_joined_date()
    {
        return $this->joined_date;
    }

    public function get_joined()
    {
        return $this->joined_date;
    }

    public function get_sdt()
    {
        return $this->sdt;
    }

    public function get_ast()
    {
        return $this->ast;
    }

    public function to_array()
    {
        return [
            'id'       => (int)$this->id,
            'initials' => $this->initials,
            'name'     => $this->fullname,
            'email'    => $this->email_address,
            'dept'     => $this->department,
            'role'     => $this->job_role,
            'status'   => strtolower($this->status),
            'joined'   => $this->joined_date,
            'ast'      => $this->ast
        ];
    }
}

// Backward compatibility class aliases
if (!class_exists('DATA_SINGLE_DATA')) {
    class DATA_SINGLE_DATA extends employee_SINGLE_DATA {}
}
if (!class_exists('data_SINGLE_DATA')) {
    class data_SINGLE_DATA extends employee_SINGLE_DATA {}
}
?>