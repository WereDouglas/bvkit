<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {

        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");

        $this->load->view('login-page', $data);
    }

    public function register_patient() {
        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");

        $this->load->view('register-patient', $data);
    }

    public function register_physician() {
        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");

        $this->load->view('register-physician', $data);
    }

    public function register_center() {
        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");

        $this->load->view('register-center', $data);
    }

    public function home() {

     
        $this->load->view('start-page');
    }

    public function version() {

        $this->load->view('version');
    }

    public function page() {

        $this->load->view('page');
    }

    public function start() {
         $this->load->view('start-page');
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('home', 'refresh');
    }

    public function login() {

        $this->load->helper(array('form', 'url'));
        $contact = $this->input->post('email');
        $password = md5($this->input->post('password'));
        // echo md5($password) ;
        if ($this->input->post('type') == "patient") {
              $results = $this->Md->query("SELECT * FROM patient WHERE (contact = '$contact' OR email= '$contact') AND password='$password'");

            if (count($results) > 0) {                            
                foreach ($results as $res) {                    
                    $this->session->set_userdata('name', $res->name);
                    $this->session->set_userdata('patientID', $res->patientID);
                    $this->session->set_userdata('email', $res->email);
                    $this->session->set_userdata('designation', $res->designation);
                    $this->session->set_userdata('gender', $res->gender);
                    $this->session->set_userdata('address', $res->address);
                    $this->session->set_userdata('country', $res->country);
                    $this->session->set_userdata('city', $res->city);
                    $this->session->set_userdata('image', $res->image);
                    $this->session->set_userdata('state', $res->state);
                    $this->session->set_userdata('contact', $res->contact); 
                     $this->session->set_userdata('sessionName', 'patient'); 
                    $this->session->set_userdata($newdata);
                }
                redirect('patient/home', 'refresh');
            } else {

                $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! User does not exist</div>');
                redirect('home', 'refresh');
            }
            return;
        } else if ($this->input->post('type') == "physician") {

            $results = $this->Md->query("SELECT * FROM physician WHERE (contact = '$contact' OR email= '$contact') AND password='$password'");

            if (count($results) > 0) {                            
                foreach ($results as $res) {                    
                    $this->session->set_userdata('name', $res->name);
                    $this->session->set_userdata('physicianID', $res->physicianID);
                    $this->session->set_userdata('email', $res->email);
                    $this->session->set_userdata('designation', $res->designation);
                    $this->session->set_userdata('gender', $res->gender);
                    $this->session->set_userdata('address', $res->address);
                    $this->session->set_userdata('country', $res->country);
                    $this->session->set_userdata('city', $res->city);
                    $this->session->set_userdata('image', $res->image);
                    $this->session->set_userdata('state', $res->state);
                    $this->session->set_userdata('contact', $res->contact); 
                     $this->session->set_userdata('sessionName', 'physician'); 
                    $this->session->set_userdata($newdata);
                }
                redirect('physician/home', 'refresh');
            } else {

                $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! Physician does not exist</div>');
                redirect('home', 'refresh');
            }


            return;
        } else {
            echo 'select a user type';
            return;
        }
    }

    public function student() {
        $this->load->view('private');
    }

   

    public function help() {

        $this->load->view('help-page', $data);
    }

  
    public function profile() {

        $query = $this->Md->show('profile');
        if ($query) {
            $data['profiles'] = $query;
        } else {
            $data['profiles'] = array();
        }
        $this->load->view('profile', $data);
    }

    public function contact() {
        $this->load->view('contact');
    }

    public function project() {
        $this->load->view('project');
    }

}
