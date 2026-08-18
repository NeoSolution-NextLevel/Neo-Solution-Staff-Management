<?php
if (!class_exists('DataBase')) {
    if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
        include_once __DIR__ . '/../../../imports/need/DB.php';
    } elseif (file_exists(__DIR__ . '/../../../database.php')) {
        include_once __DIR__ . '/../../../database.php';
    }
}

class job_roles_SINGLE_DATA
{
    private $id;
    private $job_title;
    private $departments;
    private $number_of_employees;
    private $state_of_data = false;

    public function __construct($id)
    {
        $this->id = (int)$id;

        $data_base_obj = new DataBase();
        $get_sql_query = "SELECT * FROM job_roles WHERE id = '" . $this->id . "'";
        $result = $data_base_obj->get_result($get_sql_query);

        if (!$result || $result->num_rows == 0) {
            $this->state_of_data = false;
        } else {
            $this->state_of_data = true;
            if ($row = $result->fetch_assoc()) {
                $this->id                  = $row['id'];
                $this->job_title           = $row['job_title'];
                $this->departments         = $row['departments'];
                $this->number_of_employees = $row['number_of_employees'];
            }
        }
    }

    public function get_state()
    {
        return $this->state_of_data;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_job_title()
    {
        return $this->job_title;
    }

    public function get_departments()
    {
        return $this->departments;
    }

    public function get_number_of_employees()
    {
        return $this->number_of_employees;
    }

    public function to_array()
    {
        return [
            'id'                  => (int)$this->id,
            'job_title'           => $this->job_title,
            'departments'         => $this->departments,
            'number_of_employees' => $this->number_of_employees
        ];
    }
}
?>
