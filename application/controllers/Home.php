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

           
            return;
        } else if ($this->input->post('type') == "physician") {

            $results = $this->Md->query("SELECT * FROM physician WHERE (contact = '$contact' OR email= '$contact') AND password='$password'");

            if (count($results) > 0) {                            
                foreach ($results as $res) {                    
                    $this->session->set_userdata('name', $res->name);
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

    public function registration() {
        $this->load->helper(array('form', 'url'));

        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $password = $this->input->post('password1');


        if ($fname != "" && $lname != "") {


            $email = $this->input->post('email');
            $password = $password;
            $key = $email;

            $password = $this->encrypt->encode($password, $key);

            $get_result = $this->Md->check($email, 'email', 'student');

            if (!$get_result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                 Email already in use	</strong>									
						</div>');
                redirect('/management/student', 'refresh');
            }


            $file_element_name = 'userfile';



            $config['upload_path'] = 'uploads/';
// $config['upload_path'] = '/uploads/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                echo $msg = $this->upload->display_errors('', '');
            } else {

                $data = $this->upload->data();
                $other = $this->input->post('other');
                $gender = $this->input->post('gender');
                $dob = date('Y-m-d', strtotime($this->input->post('dob')));
                $country = $this->input->post('country');
                if ($this->session->userdata('level') == 1) {

                    $country = $this->session->userdata('country');
                }
                $contact = $this->input->post('contact');
                $cohort = $this->input->post('cohort');
                $submitted = date('Y-m-d');
                $file = $data['file_name'];
                $email = $this->input->post('email');

                $student = array('image' => $file, 'fname' => $fname, 'lname' => $lname, 'other' => $other, 'email' => $email, 'gender' => $gender, 'dob' => $dob, 'country' => $country, 'password' => $password, 'contact' => $contact, 'cohort' => $cohort, 'submitted' => date('Y-m-d H:i:s'), 'status' => 'false');
                $file_id = $this->Md->save($student, 'student');
                ;
                $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                                   
                                                <strong>
                                                 information saved</strong>									
						</div>');

                redirect('/management/student', 'refresh');
            }
        }
    }

    public function info() {

        $this->load->view('info-page', $data);
    }

    public function help() {

        $this->load->view('help-page', $data);
    }

    public function management() {

        $cty = $this->session->userdata('country');

        $name = $this->session->userdata('name');
        $query = $this->Md->get('reciever', $name, 'chat');
//  var_dump($query);
        if ($query) {
            $data['chats'] = $query;
        } else {
            $data['chats'] = array();
        }
        $query = $this->Md->query("SELECT * FROM outbreak where country = '" . $cty . "'");
//  var_dump($query);
        if ($query) {
            $data['outbreaks'] = $query;
        } else {
            $data['outbreaks'] = array();
        }

        $query = $this->Md->query("SELECT * FROM publication where country = '" . $cty . "'");
//  var_dump($query);
        if ($query) {
            $data['pubs'] = $query;
        } else {
            $data['pubs'] = array();
        }
        $query = $this->Md->query("SELECT * FROM student where status = 'false'");
//  var_dump($query);
        if ($query) {
            $data['student_cnt_false'] = $query;
        } else {
            $data['student_cnt_false'] = array();
        }

        $query = $this->Md->query("SELECT * FROM publication where verified = 'false'");
//  var_dump($query);
        if ($query) {
            $data['publication_cnt_review'] = $query;
        } else {
            $data['publication_cnt_review'] = array();
        }
        $query = $this->Md->query("SELECT * FROM publication where accepted = 'no'");
//  var_dump($query);
        if ($query) {
            $data['publication_cnt_accepted'] = $query;
        } else {
            $data['publication_cnt_accepted'] = array();
        }

        $query = $this->Md->query("SELECT * FROM presentation where accepted = 'no'");
//  var_dump($query);
        if ($query) {
            $data['present_cnt_accepted'] = $query;
        } else {
            $data['present_cnt_accepted'] = array();
        }


        $this->load->view('center_page', $data);
    }

    public function projects() {

        $query = $this->Md->show('project');
        if ($query) {
            $data['projects'] = $query;
        } else {
            $data['projects'] = array();
        }


        $this->load->view('projects', $data);
    }

    public function services() {

        $query = $this->Md->show('service');
        if ($query) {
            $data['services'] = $query;
        } else {
            $data['services'] = array();
        }
        $this->load->view('services', $data);
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
