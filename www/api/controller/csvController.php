<?php
include 'service/csvService.php';
class CsvController {
    public function __construct()
    {
        if (isset($_POST)) {
            $file = isset($_FILES['file']) ? $_FILES['file'] : null;

            if (!$file || $file === '') {
                return json_encode(['status' => 0, 'msg' => 'Arquivo não encontrado']);
                // exit(json_encode('The file could not be found'));
            }else{
                $service = new csvService();
                var_dump($service->service($file));
            }
        }
    }

}
