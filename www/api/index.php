<?php
include 'controller/csvController.php';
include 'controller/tableController.php';

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
    case 'csv':
        new CSVController();
        break;
    case 'table':
        new TableController();
        break;
    default:
        exit();
        break;
}