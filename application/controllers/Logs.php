<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function index() {

        $this->load->view('home-page');
    }

    public function save() {

        $this->load->helper(array('form', 'url'));
        if ($this->input->post('value') != "" && $this->input->post('patientID') != "" && $this->input->post('sessionID') != "") {
            $results = $this->Md->query("SELECT * FROM logs WHERE  sessionID='".$this->input->post('sessionID')."'");

            if (count($results) >= 10) {
                
                  $query = $this->Md->cascade($this->input->post('sessionID'), 'logs', 'sessionID');
            }
                $trans = array('userID' => $this->input->post('patientID'), 'patientID' => $this->input->post('patientID'), 'sessionID' => $this->input->post('sessionID'), 'value' => $this->input->post('value'), 'created' => date('Y-m-d H:i:s'));
                $this->Md->save($trans, 'logs');
                echo 'saved';
            } else {
                echo 'empty';
            }
        
    }

    public function data() {

        $this->load->helper(array('form', 'url'));
        if($this->session->userdata('patientSession')==""){
            $get_result = $this->Md->query("SELECT * FROM logs WHERE patientID = '" . $this->session->userdata('patientID') . "' Order by id DESC limit 1 ");
    
        }
        else{

        $get_result = $this->Md->query("SELECT * FROM logs WHERE patientID = '" . $this->session->userdata('patientSession') . "' Order by id DESC limit 1 ");
        }
        foreach ($get_result as $res) {
//$res->dated
            $x = time() * 1000;
// The y value is a random number
            $y = (int) $res->value;
            // $y=5;
// Create a PHP array and echo it as JSON
            $ret = array($x, $y);
            echo json_encode($ret);
        }
    }

    public function view() {

        $this->load->view('log-page');
    }

}
