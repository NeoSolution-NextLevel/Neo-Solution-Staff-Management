<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class departments_SINGLE_DATA
{
    private $id;
    private $name;
    private $head;
    private $employees;
    private $color;
    private $ast = "1";
    private $sdt;

    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = $id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM departments WHERE id = '" . $this->id . "'";

        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            while ($result && $row = $result->fetch_assoc()) {
                $this->id        = $row['id'];
                $this->name      = $row['name'];
                $this->head      = $row['head'];
                $this->employees = $row['employees'];
                $this->color     = $row['color'];
                $this->ast       = $row['ast'];
                $this->sdt       = $row['sdt'];
            }
        }
    }

    // --- Getter functions ---

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_head()
    {
        return $this->head;
    }

    public function get_employees()
    {
        return $this->employees;
    }
    public function get_color()
    {
        return $this->color;
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

