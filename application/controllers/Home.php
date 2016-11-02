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

        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");
        $query = $this->Md->query("SELECT * FROM users where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['users'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM file where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['files'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM message where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['messages'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM tasks where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['tasks'] = $query;
        }

        $query = $this->Md->query("SELECT * FROM transaction where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['transactions'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM payment where  orgID='" . $this->session->userdata('orgID') . "'");
        if ($query) {
            $data['payments'] = $query;
        }
        $this->load->view('home-page', $data);
    }

    public function version() {

        $this->load->view('version');
    }

    public function page() {

        $this->load->view('page');
    }

    public function start() {
        // $query = $this->Md->query("SELECT * FROM users where org='".$this->session->userdata('orgid')."'");
        $query = $this->Md->query("SELECT * FROM users");


//  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }


        $this->load->view('start-page', $data);
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
