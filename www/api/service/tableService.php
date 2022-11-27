<?php
include 'model/tableModel.php';
class TableService {
    public function service()
    {   
        $model = new tableModel();
        $select = $model->select();
        $data = $select['data'];

        $response =[];
        $response['status'] =$select['status'];
        $response['msg']    =$select['msg'];  

        $new_data = [];
        $emptyLastNameCounter = 0;
        $emptyGenderCounter = 0;
        $invalidEmailCounter = 0;
        $rows = 0;
        foreach ($data as $lead) {
            $array_temp = [];
            $array_temp['ID']           = $lead['ID'];
            $array_temp['FIRST_NAME']   = $lead['FIRST_NAME'];
            $array_temp['LAST_NAME']    = $lead['LAST_NAME'];

            if (empty($lead['LAST_NAME'])) {
                $emptyLastNameCounter++;
            }
            $array_temp['EMAIL']        = (!empty($lead['EMAIL'])) ? "<a href='mailto: ".$lead['EMAIL']."' target='_blank' class='btn btn-tertiary dataTable_button'>Email</a>" : $lead['EMAIL'];
            if (!filter_var($lead['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                $invalidEmailCounter++;
            }
            $array_temp['GENDER']       = $lead['GENDER'];
            if (empty($lead['GENDER'])) {
                $emptyGenderCounter++;
            }
            
            $array_temp['IP_ADDRESS']   = $lead['IP_ADDRESS'];
            $array_temp['COMPANY']      = $lead['COMPANY'];
            $array_temp['CITY']         = $lead['CITY'];
            $array_temp['TITLE']        = $lead['TITLE'];
            $array_temp['WEBSITE'] = (!empty($lead['WEBSITE'])) ? "<a href='".$lead['WEBSITE']."' target='_blank' class='btn btn-tertiary dataTable_button'>Acessar</a>" : $lead['WEBSITE'];
            
            array_push($new_data,$array_temp);
            $rows++;
        }

        $response['data']=$new_data;
        $response['emptyLastNameCounter']=$emptyLastNameCounter;
        $response['invalidEmailCounter']=$invalidEmailCounter;
        $response['emptyGenderCounter']=$emptyGenderCounter;
        $response['rowsCounter']=$rows;
        
        
        
        return $response;
    }
}
?>