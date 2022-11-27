<?php
include 'service/tableService.php';
class TableController {
    public function __construct()
    {
        $service = new tableService();                
        die(json_encode($service->service(),JSON_PARTIAL_OUTPUT_ON_ERROR));
    }
}