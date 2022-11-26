<?php
include 'controller/csvController.php';

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
    case 'csv':
        new CSVController();
        break;
    default:
        exit();
        break;
}