<?php
include_once __DIR__ . '/../../../database.php';

class Documents_Delete
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function deleteDocument($id)
    {
        $conn = $this->db->get_data_base_connction();
        $id = intval($id);

        $getSql = "SELECT file_path FROM `documents` WHERE `id` = {$id} LIMIT 1";
        $getRes = $conn->query($getSql);

        if ($getRes && $getRes->num_rows > 0) {
            $row = $getRes->fetch_assoc();
            $filePath = __DIR__ . '/../../../' . ltrim($row['file_path'], '/');
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $delSql = "DELETE FROM `documents` WHERE `id` = {$id}";
        $delRes = $conn->query($delSql);

        return [
            'status' => $delRes ? 'success' : 'error',
            'message' => $delRes ? 'Document removed successfully.' : $conn->error
        ];
    }
}
