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
        $conn = $data_base_obj->get_data_base_connction();

        // Inspect actual columns from database
        $existingCols = [];
        $resCols = @$conn->query("SHOW COLUMNS FROM `departments`");
        if ($resCols) {
            while ($row = $resCols->fetch_assoc()) {
                $existingCols[strtolower($row['Field'])] = true;
            }
        }

        $fields = ['ast', 'sdt', 'name'];
        $values = ["'" . $this->ast . "'", "'" . $this->sdt . "'", "'" . addslashes($this->name) . "'"];

        if (isset($existingCols['head'])) {
            $fields[] = '`head`';
            $values[] = "'" . addslashes($this->head) . "'";
        }
        if (isset($existingCols['head_name'])) {
            $fields[] = '`head_name`';
            $values[] = "'" . addslashes($this->head) . "'";
        }
        if (isset($existingCols['employees'])) {
            $fields[] = '`employees`';
            $values[] = "'" . (int)$this->employees . "'";
        }
        if (isset($existingCols['color'])) {
            $fields[] = '`color`';
            $values[] = "'" . addslashes($this->color) . "'";
        }

        $colsStr = implode(', ', $fields);
        $valsStr = implode(', ', $values);
        $get_sql_query = "INSERT INTO `departments` ($colsStr) VALUES ($valsStr)";

        $data_base_obj->get_result($get_sql_query);

        $this->error_msg = $data_base_obj->get_error();
        $this->id = $data_base_obj->get_id();
        return $data_base_obj->get_error_state_boolean();
    }

    public function process_update()
    {
        $data_base_obj = new DataBase();
        $conn = $data_base_obj->get_data_base_connction();

        $existingCols = [];
        $resCols = @$conn->query("SHOW COLUMNS FROM `departments`");
        if ($resCols) {
            while ($row = $resCols->fetch_assoc()) {
                $existingCols[strtolower($row['Field'])] = true;
            }
        }

        $updates = ["ast='" . $this->ast . "'"];
        if (isset($existingCols['name'])) {
            $updates[] = "`name`='" . addslashes($this->name) . "'";
        }
        if (isset($existingCols['head'])) {
            $updates[] = "`head`='" . addslashes($this->head) . "'";
        }
        if (isset($existingCols['head_name'])) {
            $updates[] = "`head_name`='" . addslashes($this->head) . "'";
        }
        if (isset($existingCols['employees'])) {
            $updates[] = "`employees`='" . (int)$this->employees . "'";
        }
        if (isset($existingCols['color'])) {
            $updates[] = "`color`='" . addslashes($this->color) . "'";
        }

        $updatesStr = implode(', ', $updates);
        $get_sql_query = "
            UPDATE `departments` 
            SET " . $updatesStr . " 
            WHERE id='" . (int)$this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}

