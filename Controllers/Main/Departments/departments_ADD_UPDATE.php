<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class departments_ADD_UPDATE
{
    private $id;
    private $name;
    private $head;
    private $employees = 0;

    private $color;
    private $ast = "1";
    private $sdt;

    private $error_msg;
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
    }

    public function set_data(
        $get_name,
        $get_head,
        $get_employees = 0,
        $get_color = ""
    ) {
        $this->name = $get_name;
        $this->head = $get_head;
        $this->employees = $get_employees;
        $this->color = $get_color;

        $this->sql_update_query .=
            ", name='" . addslashes($this->name) . "'" .
            ", head_name='" . addslashes($this->head) . "'" .
            ", head='" . addslashes($this->head) . "'" .
            ", employees='" . (int)$this->employees . "'" .
            ", color='" . addslashes($this->color) . "'";
    }

    public function set_name($get_name)
    {
        $this->name = $get_name;
        $this->sql_update_query .= ", name='" . addslashes($this->name) . "'";
    }

    public function set_head($get_head)
    {
        $this->head = $get_head;
        $this->sql_update_query .= ", head_name='" . addslashes($this->head) . "', head='" . addslashes($this->head) . "'";
    }

    public function set_employees($get_employees)
    {
        $this->employees = $get_employees;
        $this->sql_update_query .= ", employees='" . $this->employees . "'";
    }

    public function set_color($get_color)
    {
        $this->color = $get_color;
        $this->sql_update_query .= ", color='" . $this->color . "'";
    }

    // --- Utility and Getter Methods ---

    public function remove()
    {
        $this->ast = "0";
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_id($get_id)
    {
        $this->id = $get_id;
    }

    public function get_error()
    {
        return $this->error_msg;
    }

    // --- Database Processing Methods ---

    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        // Ensure both head and head_name columns are populated if present
        $cols = "ast, sdt, name, employees, color";
        $vals = "'" . $this->ast . "', '" . $this->sdt . "', '" . $this->name . "', '" . $this->employees . "', '" . $this->color . "'";

        $chkHead = $data_base_obj->get_result("SHOW COLUMNS FROM departments LIKE 'head'");
        if ($chkHead && $chkHead->num_rows > 0) {
            $cols .= ", head";
            $vals .= ", '" . addslashes($this->head) . "'";
        }
        $chkHeadName = $data_base_obj->get_result("SHOW COLUMNS FROM departments LIKE 'head_name'");
        if ($chkHeadName && $chkHeadName->num_rows > 0) {
            $cols .= ", head_name";
            $vals .= ", '" . addslashes($this->head) . "'";
        }

        $get_sql_query = "INSERT INTO departments ($cols) VALUES ($vals)";

        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        // Build safe update string checking column existence
        $updates = "ast='" . $this->ast . "', name='" . addslashes($this->name) . "', employees='" . (int)$this->employees . "', color='" . addslashes($this->color) . "'";
        $chkHead = $data_base_obj->get_result("SHOW COLUMNS FROM departments LIKE 'head'");
        if ($chkHead && $chkHead->num_rows > 0) {
            $updates .= ", head='" . addslashes($this->head) . "'";
        }
        $chkHeadName = $data_base_obj->get_result("SHOW COLUMNS FROM departments LIKE 'head_name'");
        if ($chkHeadName && $chkHeadName->num_rows > 0) {
            $updates .= ", head_name='" . addslashes($this->head) . "'";
        }

        $get_sql_query = "
            UPDATE departments 
            SET " . $updates . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}

