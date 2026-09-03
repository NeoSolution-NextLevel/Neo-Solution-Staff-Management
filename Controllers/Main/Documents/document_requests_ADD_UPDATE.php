<?php
/**
 * document_requests_ADD_UPDATE.php
 * ORM-style controller for the document_requests table.
 * Auto-creates the table on first use.
 */
include_once __DIR__ . '/../../../imports/need/DB.php';

class document_requests_ADD_UPDATE
{
    private $id;
    private $ast = '1';
    private $sdt;
    private $requested_by_user_id;
    private $requested_by_name  = '';
    private $target_type        = 'employee';
    private $target_employee_user_id;
    private $target_employee_name = '';
    private $doc_type           = 'Document';
    private $notes              = '';
    private $deadline           = null;
    private $status             = 'Pending';
    private $document_id        = null;
    private $reviewed_at        = null;

    private $error_msg          = '';
    private $sql_update_query   = '';

    public function __construct()
    {
        $this->sdt = date('Y-m-d H:i:s');
        $this->ensure_table();
    }

    private function ensure_table()
    {
        $db = new DataBase();
        @$db->get_result("CREATE TABLE IF NOT EXISTS `document_requests` (
            `id`                       INT(11) NOT NULL AUTO_INCREMENT,
            `ast`                      VARCHAR(1)   DEFAULT '1',
            `sdt`                      DATETIME     DEFAULT CURRENT_TIMESTAMP,
            `requested_by_user_id`     INT(11)      DEFAULT 0,
            `requested_by_name`        VARCHAR(255) DEFAULT '',
            `target_type`              VARCHAR(20)  DEFAULT 'employee',
            `target_employee_user_id`  INT(11)      DEFAULT NULL,
            `target_employee_name`     VARCHAR(255) DEFAULT '',
            `doc_type`                 VARCHAR(100) DEFAULT 'Document',
            `notes`                    TEXT         DEFAULT NULL,
            `deadline`                 DATE         DEFAULT NULL,
            `status`                   VARCHAR(50)  DEFAULT 'Pending',
            `document_id`              INT(11)      DEFAULT NULL,
            `reviewed_at`              DATETIME     DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    }

    // --- Setters ---
    public function set_id($v)   { $this->id = (int)$v; }

    public function set_data(
        $requested_by_user_id,
        $requested_by_name,
        $target_type,
        $target_employee_user_id,
        $target_employee_name,
        $doc_type,
        $notes = '',
        $deadline = null
    ) {
        $this->requested_by_user_id    = (int)$requested_by_user_id;
        $this->requested_by_name       = addslashes($requested_by_name);
        $this->target_type             = addslashes($target_type);
        $this->target_employee_user_id = $target_employee_user_id !== null ? (int)$target_employee_user_id : null;
        $this->target_employee_name    = addslashes($target_employee_name);
        $this->doc_type                = addslashes($doc_type);
        $this->notes                   = addslashes($notes);
        $this->deadline                = !empty($deadline) ? addslashes($deadline) : null;
    }

    public function set_status($v)
    {
        $this->status = addslashes($v);
        $this->sql_update_query .= ", status='" . $this->status . "'";
    }

    public function set_document_id($v)
    {
        $this->document_id = (int)$v;
        $this->sql_update_query .= ", document_id='" . $this->document_id . "'";
    }

    public function set_reviewed_at($v = null)
    {
        $this->reviewed_at = $v ?: date('Y-m-d H:i:s');
        $this->sql_update_query .= ", reviewed_at='" . $this->reviewed_at . "'";
    }

    public function remove() { $this->ast = '0'; }

    public function get_id()    { return $this->id; }
    public function get_error() { return $this->error_msg; }

    public function process_new_record()
    {
        $db  = new DataBase();
        $tid = $this->target_employee_user_id !== null ? "'" . $this->target_employee_user_id . "'" : 'NULL';
        $dl  = $this->deadline ? "'" . $this->deadline . "'" : 'NULL';

        $sql = "INSERT INTO `document_requests`
            (`ast`, `sdt`, `requested_by_user_id`, `requested_by_name`,
             `target_type`, `target_employee_user_id`, `target_employee_name`,
             `doc_type`, `notes`, `deadline`, `status`)
            VALUES
            ('{$this->ast}', '{$this->sdt}', '{$this->requested_by_user_id}',
             '{$this->requested_by_name}', '{$this->target_type}', {$tid},
             '{$this->target_employee_name}', '{$this->doc_type}',
             '{$this->notes}', {$dl}, '{$this->status}')";

        $db->get_result($sql);
        $this->error_msg = $db->get_error();
        $this->id        = $db->get_id();
        return $db->get_error_state_boolean();
    }

    public function process_update()
    {
        $db  = new DataBase();
        $sql = "UPDATE `document_requests`
                SET ast='{$this->ast}' {$this->sql_update_query}
                WHERE id='{$this->id}'";
        $db->get_result($sql);
        $this->error_msg = $db->get_error();
        return $db->get_error_state_boolean();
    }
}
?>
