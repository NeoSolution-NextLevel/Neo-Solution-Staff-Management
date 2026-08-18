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
            ", name='" . $this->name . "'" .
            ", head='" . $this->head . "'" .
            ", employees='" . $this->employees . "'" .
            ", color='" . $this->color . "'";
    }

    public function set_name($get_name)
    {
        $this->name = $get_name;
        $this->sql_update_query .= ", name='" . $this->name . "'";
    }

    public function set_head($get_head)
    {
        $this->head = $get_head;
        $this->sql_update_query .= ", head='" . $this->head . "'";
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

        $get_sql_query = "
            INSERT INTO departments (
                ast, 
                sdt, 
                name, 
                head, 
                employees, 
                color
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->name . "',
                '" . $this->head . "',
                '" . $this->employees . "',
                '" . $this->color . "'
            )";

        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            UPDATE departments 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}

