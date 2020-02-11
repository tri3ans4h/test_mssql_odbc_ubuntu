<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_PTSPService extends CI_Model {
	
	function TestKoneksi(){
			header("Content-Type: application/json");
			
			$output['result'] = array();
	
			 $sql_view = "Select top 3  * from audits";
            $res = $this->db->query($sql_view);
			   if (!$res) {
                $erro = $this->db->_error_number();
                $errMess = $this->db->_error_message();
                // Do something with the error message or just show_404();
                //array_push($errorMsg, 'Query ERROR ' . $this->db->_error_message());
                $output['respon_code'] = "NOT OK";
            } else {
                $$output['data'] = $res->result();
			}
			return $output;

	}
	function GetPTSP($data_in = array()) {
		header("Content-Type: application/json");
        $post = fopen('php://input', 'r');
        $json_param = json_decode(stream_get_contents($post));
        fclose($post);
        $errorMsg = array();
        //Periksa parameter
        $valid_parameter = true;
        if ((isset($json_param->npwpd) || isset($json_param->NPWPD))) {
            
        } else {
            $valid_parameter = false;
        }
       
        $do_query = true;
        if (!$valid_parameter) {
            array_push($errorMsg, "Parameter Invalid");
            $do_query = false;
        }

        //Jika semua syarat terpenuhi
        if ($do_query) {
            $npwpd = (isset($json_param->NPWPD) ? $json_param->NPWPD : (isset($json_param->npwpd) ? $json_param->npwpd : ""));
                    
 $sql_view = "Select top 3  * from view_pembayaranonline Where npwpd='" . $npwpd . "' order by tglbayar desc";


            $res = $this->db->query($sql_view);
//$output['sql'] = $sql_view;
            if (!$res) {
                $erro = $this->db->_error_number();
                $errMess = $this->db->_error_message();
                // Do something with the error message or just show_404();
                //array_push($errorMsg, 'Query ERROR ' . $this->db->_error_message());
                $output['respon_code'] = "NOT OK";
            } else {
                $data_result = $res->result();

                //$output['result'] = ( isset($data_result) ? $data_result : array());
$pajak = array();
$namaop =  "";
//$npwpd_ = "";
foreach($data_result as $v){
$namaop = $v->NamaOP;
	array_push($pajak, array(
		"tahun"=>$v->TahunPajak,
		"bulan"=>$v->MasaPajak,
		"tglbayar "=>$v->TglBayar ,
		//"jumlahbayar"=>$v->JumlahBayar,
		"statusbayar"=>$v->StatusBayar));
}
/*
$output['result'] = array(
	"npwpd"=> $npwpd ,

	"pajak"=>array(
			array(
				"tahun"=>"2019",
				"bulan"=>"Juni", 
				"nominal"=>"Rp 20000"
			) //ini variabel yg berubah
			)
	);*/

$output['result'] = array(
	"npwpd"=> $npwpd ,	
	"namaop"=> $namaop ,
	"pajak"=>$pajak
	);
                $output['respon_code'] = "OK";
            }
        } else {
            $output['result'] = array();
            $output['respon_code'] = implode(",", $errorMsg);
        }
	
        return $output;
	}

function GetInfoSIMPATDA($data_in = array()) {
		header("Content-Type: application/json");
        $post = fopen('php://input', 'r');
        $json_param = json_decode(stream_get_contents($post));
        fclose($post);
        $errorMsg = array();
        //Periksa parameter
        $valid_parameter = true;
        if ((isset($json_param->npwp) || isset($json_param->NPWP))) {
            
        } else {
            $valid_parameter = false;
        }
       
        $do_query = true;
        if (!$valid_parameter) {
            array_push($errorMsg, "Parameter Invalid");
            $do_query = false;
        }

        //Jika semua syarat terpenuhi
        if ($do_query) {
            $npwp = (isset($json_param->NPWP) ? $json_param->NPWP : (isset($json_param->npwp) ? $json_param->npwp : ""));
                    
			$sql_view = "Select distinct npwpd, npwp, StatusBayar, JenisOP, Nama, NamaObjekPajak from View_PembayaranOnline_OP_BelumBayar Where npwp='" . $npwp . "' Order by StatusBayar,JenisOP";

            $res = $this->db->query($sql_view);
			//$output['sql'] = $sql_view;
            if (!$res) {
                $erro = $this->db->_error_number();
                $errMess = $this->db->_error_message();
                // Do something with the error message or just show_404();
                //array_push($errorMsg, 'Query ERROR ' . $this->db->_error_message());
                $output['respon_code'] = "DATA NPWP TIDAK DITEMUKAN";
            } else {
                $data_result = $res->result();

                //$output['result'] = ( isset($data_result) ? $data_result : array());
					$pajak = array();
					$namaop =  "";					
					foreach($data_result as $v){
					$pemilik = $v->Nama;
						array_push($pajak, array(
							"NamaOP"=>$v->NamaObjekPajak,
							"JenisOP"=>$v->JenisOP,
							"statusbayar"=>$v->StatusBayar));
					}
					
			$output['result'] = array(
				"npwp"=> $npwp ,				
				"pemilik"=> $pemilik ,
				"pajak"=>$pajak
				);
					$output['respon_code'] = "OK";
				}
				} else {
					$output['result'] = array();
					$output['respon_code'] = implode(",", $errorMsg);
				}
			
				return $output;
	}
function GetInfoBPHTB($data_in = array()) {
		header("Content-Type: application/json");
        $post = fopen('php://input', 'r');
        $json_param = json_decode(stream_get_contents($post));
        fclose($post);
        $errorMsg = array();
        //Periksa parameter
        $valid_parameter = true;
        if ((isset($json_param->npwp) || isset($json_param->NPWP))) {
            
        } else {
            $valid_parameter = false;
        }
       
        $do_query = true;
        if (!$valid_parameter) {
            array_push($errorMsg, "Parameter Invalid");
            $do_query = false;
        }

        //Jika semua syarat terpenuhi
        if ($do_query) {
            $npwp = (isset($json_param->NPWP) ? $json_param->NPWP : (isset($json_param->npwp) ? $json_param->npwp : ""));
                    
			$sql_view = "Select distinct npwpd, npwp, StatusBayar, JenisOP, Nama, NamaObjekPajak from View_PembayaranOnline_OP_BelumBayar Where npwp='" . $npwp . "' Order by StatusBayar,JenisOP";

            $res = $this->db->query($sql_view);
			//$output['sql'] = $sql_view;
            if (!$res) {
                $erro = $this->db->_error_number();
                $errMess = $this->db->_error_message();
                // Do something with the error message or just show_404();
                //array_push($errorMsg, 'Query ERROR ' . $this->db->_error_message());
                $output['respon_code'] = "DATA NPWP TIDAK DITEMUKAN";
            } else {
                $data_result = $res->result();

                //$output['result'] = ( isset($data_result) ? $data_result : array());
					$pajak = array();
					$namaop =  "";					
					foreach($data_result as $v){
					$pemilik = $v->Nama;
						array_push($pajak, array(
							"NamaOP"=>$v->NamaObjekPajak,
							"JenisOP"=>$v->JenisOP,
							"statusbayar"=>$v->StatusBayar));
					}
					
			$output['result'] = array(
				"npwp"=> $npwp ,				
				"pemilik"=> $pemilik ,
				"pajak"=>$pajak
				);
					$output['respon_code'] = "OK";
				}
				} else {
					$output['result'] = array();
					$output['respon_code'] = implode(",", $errorMsg);
				}
			
				return $output;
	}
}