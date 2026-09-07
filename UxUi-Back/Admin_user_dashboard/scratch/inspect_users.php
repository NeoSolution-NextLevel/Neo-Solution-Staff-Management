<?php
require_once __DIR__ . '/../../../imports/need/DB.php';
require_once __DIR__ . '/../../../imports/security/encrypt_decrypt.php';
$db = new DataBase();
$res = $db->get_result('DESCRIBE employees');
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . ' | ' . $row['Type'] . ' | ' . $row['Null'] . ' | ' . $row['Default'] . PHP_EOL;
}
