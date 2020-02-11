<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

    function index_get() {
        echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Server Rest Api</title>
    </head>

    <body>
        <h1>Rest Api PTSP Sukses</h1>
    </body>

</html>';
    }
  
    function GetPTSP_post() {//INI POST< PAKE POSTMAN BUAT CEK
        $this->load->model('M_PTSPService');
        $data_in = $this->post();
        $result = $this->M_PTSPService->GetPTSP($data_in);//BIKIN DI MODEL FUNGSI GETPTSP
        if ($result) {
            $this->response($result, 200);
        } else {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
	function GetInfoSIMPATDA_post() {//INI POST< PAKE POSTMAN BUAT CEK
        $this->load->model('M_PTSPService');
        $data_in = $this->post();
        $result = $this->M_PTSPService->GetInfoSIMPATDA($data_in);//BIKIN DI MODEL FUNGSI GETPTSP
        if ($result) {
            $this->response($result, 200);
        } else {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }



   function getBPHTBService_post() {
        $this->load->model('m_BPPRDService');
        $data_in = $this->post();
        $result = $this->m_BPPRDService->getBPHTBService($data_in);
        if ($result) {
           // $this->response($result, 200);
$data =  json_encode($result);
$data = str_replace("\\/", "/", $data);
echo  $data;
        } else {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

}

?>