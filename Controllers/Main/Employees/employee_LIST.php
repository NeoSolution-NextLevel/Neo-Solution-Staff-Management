<?php
include_once __DIR__ . '/employee_details_LIST.php';

if (!class_exists('employee_LIST')) {
    class employee_LIST extends employee_details_LIST {}
}
?>
