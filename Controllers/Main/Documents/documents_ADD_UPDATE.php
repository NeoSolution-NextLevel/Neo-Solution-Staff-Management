<?php
include_once __DIR__ . '/../../../imports/need/DB.php';

class documents_ADD_UPDATE
{
    private $id;
    private $user_id = 1;
    private $employee_id = "EMP-001";
    private $employee_name = "";
    private $doc_type = "Document";
    private $file_name = "";
    private $file_path = "";
    private $file_size = "";
    private $status = "Uploaded";
    private $uploaded_date;

    private $ast = "1";
    private $sdt;

    private $error_msg = "";
    private $sql_update_query = "";

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
        $this->uploaded_date = date('Y-m-d H:i:s');
        $this->ensure_table_and_columns();
    }

    private function ensure_table_and_columns()
    {
        $db = new DataBase();
        @$db->get_result("CREATE TABLE IF NOT EXISTS `documents` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `ast` varchar(10) DEFAULT '1',
            `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
            `user_id` int(11) DEFAULT 1,
            `employee_id` varchar(50) DEFAULT 'EMP-001',
            `employee_name` varchar(255) NOT NULL,
            `doc_type` varchar(100) NOT NULL,
            `file_name` varchar(255) NOT NULL,
            `file_path` varchar(500) NOT NULL,
            `file_size` varchar(50) DEFAULT NULL,
            `status` varchar(50) DEFAULT 'Uploaded',
            `uploaded_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        // Check and auto-add missing columns to existing table
        $columns_to_check = [
            'ast'           => "varchar(10) DEFAULT '1'",
            'sdt'           => "datetime DEFAULT CURRENT_TIMESTAMP",
            'user_id'       => "int(11) DEFAULT 1",
            'employee_id'   => "varchar(50) DEFAULT 'EMP-001'",
            'employee_name' => "varchar(255) DEFAULT ''",
            'doc_type'      => "varchar(100) DEFAULT 'Document'",
            'file_name'     => "varchar(255) DEFAULT ''",
            'file_path'     => "varchar(500) DEFAULT ''",
            'file_size'     => "varchar(50) DEFAULT ''",
            'status'        => "varchar(50) DEFAULT 'Uploaded'",
            'uploaded_date' => "datetime DEFAULT CURRENT_TIMESTAMP"
        ];

        foreach ($columns_to_check as $col => $typeDef) {
            $check = $db->get_result("SHOW COLUMNS FROM `documents` LIKE '{$col}'");
            if ($check && $check->num_rows == 0) {
                @$db->get_result("ALTER TABLE `documents` ADD COLUMN `{$col}` {$typeDef}");
            }
        }
    }

    public function set_data(
        $get_employee_name,
        $get_doc_type,
        $get_file_name,
        $get_file_path,
        $get_file_size = "",
        $get_employee_id = "EMP-001",
        $get_user_id = 1,
        $get_status = "Uploaded"
    ) {
        $this->employee_name = addslashes($get_employee_name);
        $this->doc_type      = addslashes($get_doc_type);
        $this->file_name     = addslashes($get_file_name);
        $this->file_path     = addslashes($get_file_path);
        $this->file_size     = addslashes($get_file_size);
        $this->employee_id   = addslashes($get_employee_id);
        $this->user_id       = (int)$get_user_id;
        $this->status        = addslashes($get_status);

        $this->sql_update_query .=
            ", employee_name='" . $this->employee_name . "'" .
            ", doc_type='" . $this->doc_type . "'" .
            ", file_name='" . $this->file_name . "'" .
            ", file_path='" . $this->file_path . "'" .
            ", file_size='" . $this->file_size . "'" .
            ", employee_id='" . $this->employee_id . "'" .
            ", user_id='" . $this->user_id . "'" .
            ", status='" . $this->status . "'";
    }

    public function set_employee_name($get_employee_name)
    {
        $this->employee_name = addslashes($get_employee_name);
        $this->sql_update_query .= ", employee_name='" . $this->employee_name . "'";
    }

    public function set_doc_type($get_doc_type)
    {
        $this->doc_type = addslashes($get_doc_type);
        $this->sql_update_query .= ", doc_type='" . $this->doc_type . "'";
    }

    public function set_file_name($get_file_name)
    {
        $this->file_name = addslashes($get_file_name);
        $this->sql_update_query .= ", file_name='" . $this->file_name . "'";
    }

    public function set_file_path($get_file_path)
    {
        $this->file_path = addslashes($get_file_path);
        $this->sql_update_query .= ", file_path='" . $this->file_path . "'";
    }

    public function set_file_size($get_file_size)
    {
        $this->file_size = addslashes($get_file_size);
        $this->sql_update_query .= ", file_size='" . $this->file_size . "'";
    }

    public function set_employee_id($get_employee_id)
    {
        $this->employee_id = addslashes($get_employee_id);
        $this->sql_update_query .= ", employee_id='" . $this->employee_id . "'";
    }

    public function set_user_id($get_user_id)
    {
        $this->user_id = (int)$get_user_id;
        $this->sql_update_query .= ", user_id='" . $this->user_id . "'";
    }

    public function set_status($get_status)
    {
        $this->status = addslashes($get_status);
        $this->sql_update_query .= ", status='" . $this->status . "'";
    }

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

    // Backward compatibility helper
    public function saveDocument($employeeName, $docType, $originalFileName, $targetRelativePath, $fileSizeStr, $employeeId = 'EMP-001', $userId = 1)
    {
        $this->set_data(
            $employeeName,
            $docType,
            $originalFileName,
            $targetRelativePath,
            $fileSizeStr,
            $employeeId,
            $userId,
            'Uploaded'
        );
        $res = $this->process_new_record();
        if ($res) {
            return [
                'status' => 'success',
                'id' => (int)$this->id,
                'message' => 'Document saved successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => !empty($this->error_msg) ? $this->error_msg : 'Database query error.'
            ];
        }
    }

    // --- Database Processing Methods ---
    public function process_new_record()
    {
        $data_base_obj = new DataBase();

        $get_sql_query = "
            INSERT INTO documents (
                ast, 
                sdt, 
                user_id,
                employee_id,
                employee_name, 
                doc_type, 
                file_name, 
                file_path, 
                file_size, 
                status,
                uploaded_date
            )
            VALUES (
                '" . $this->ast . "',
                '" . $this->sdt . "',
                '" . $this->user_id . "',
                '" . $this->employee_id . "',
                '" . $this->employee_name . "',
                '" . $this->doc_type . "',
                '" . $this->file_name . "',
                '" . $this->file_path . "',
                '" . $this->file_size . "',
                '" . $this->status . "',
                '" . $this->uploaded_date . "'
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
            UPDATE documents 
            SET ast='" . $this->ast . "'" . $this->sql_update_query . " 
            WHERE id='" . $this->id . "'";

        $data_base_obj->get_result($get_sql_query);
        $this->error_msg = $data_base_obj->get_error();
        return $data_base_obj->get_error_state_boolean();
    }
}

// Backward compatibility class aliases
if (!class_exists('Documents_Add_Update')) {
    class Documents_Add_Update extends documents_ADD_UPDATE {}
}
?>