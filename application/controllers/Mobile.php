<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        // $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $pass = urldecode($this->uri->segment(3));
        if ($pass != "123456") {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong> You are a cheat like Andrew</div>');
            redirect('welcome', 'refresh');
            return;
        }

        $data['users'] = array();
        $data['orgs'] = array();
        $query = $this->Md->query("SELECT * FROM users");
        if ($query)
            $data['users'] = $query;

        $query = $this->Md->query("SELECT * FROM organisation");
        if ($query)
            $data['orgs'] = $query;

        $this->load->view('org-page', $data);
    }

    public function register() {

        $this->load->helper(array('form', 'url'));

        //$name = $this->input->post('name');
        $contact = $this->input->post('contact');
        $password = $this->input->post('password');
        // $password_now = md5($password);
        $get_result = $this->Md->check($contact, 'contact', 'user');
        if (!$get_result) {

            $b["info"] = "invalid username!";
            $b["status"] = "false";
            echo json_encode($b);
            return;
        } else {
            $users = array('name' => $this->input->post('name'), 'email' => $this->input->post('email'), 'password' => md5($this->input->post('password')), 'contact' => $this->input->post('contact'), 'image' => $this->input->post('image'), 'created' => date('Y-m-d H:i:s'), 'status' => 'Active', 'imei' => $this->input->post('imei'));
            $id = $this->Md->save($users, 'user');
            $b["info"] = "Registration successfull";
            $b["status"] = "true";
            $b["name"] = $this->input->post('name');
            $b["contact"] = $this->input->post('contact');
            $b["id"] = $id;
            $b["image"] = $this->input->post('image');
            echo json_encode($b);
            return;
        }
    }

    public function login() {

        $this->load->helper(array('form', 'url'));

        //$name = $this->input->post('name');
        $contact = $this->input->post('contact');
        $password = $this->input->post('password');

        $query = $this->Md->query("SELECT * FROM patient WHERE  contact ='" . $contact . "' AND `password` = '" . md5($password) . "'");
        if ($query) {
            foreach ($query as $res) {

                $b["info"] = "Login successfull";
                $b["status"] = "true";
                $b["name"] = $res->name;
                $b["email"] = $res->email;
                $b["type"] = "patient";
                $b["image"] = $res->image;
                $b["contact"] = $res->contact;
                $b["id"] = $res->patientID;
            }
            echo json_encode($b);
            return;
        } else {
            $query = $this->Md->query("SELECT * FROM physician WHERE  contact ='" . $contact . "' AND `password` = '" . md5($password) . "'");
            if ($query) {
                foreach ($query as $res) {

                    $b["info"] = "Login successfull";
                    $b["status"] = "true";
                    $b["name"] = $res->name;
                    $b["email"] = $res->email;
                    $b["type"] = "physician";
                    $b["image"] = $res->image;
                    $b["contact"] = $res->contact;
                    $b["id"] = $res->physicianID;
                }
                echo json_encode($b);
                return;
            } else {

                $b["info"] = "Invalid user!";
                $b["status"] = "false";
                echo json_encode($b);
                return;
            }
            return;
        }
    }

    public function calendar() {

        $this->load->helper(array('form', 'url'));
        // $info = array('name' =>'true');
        // $username = $this->input->post('username');
        $username = "Douglas Were";

        $query = $this->Md->query("SELECT * FROM attend INNER JOIN tasks ON attend.taskID = tasks.taskID WHERE attend.name ='" . $username . "' AND (attend.sync<>'true')");

        echo json_encode($query);

        return;
    }

    public function updated() {

        $this->load->helper(array('form', 'url'));
        $info = array('sync' => 'true');
        $name = $this->input->post('name');
        $this->Md->update_dynamic($name, "name", "attend", $info);
        return;
    }

    public function users() {


        $data['users'] = array();
        $data['orgs'] = array();
        $query = $this->Md->query("SELECT * FROM users");
        if ($query)
            $data['users'] = $query;

        $query = $this->Md->query("SELECT * FROM organisation");
        if ($query)
            $data['orgs'] = $query;

        $this->load->view('users-page', $data);
    }

    public function procedures() {


        $data['users'] = array();
        $data['orgs'] = array();
        $data['procedures'] = array();
        $query = $this->Md->query("SELECT * FROM users");
        if ($query)
            $data['users'] = $query;

        $query = $this->Md->query("SELECT * FROM organisation");
        if ($query)
            $data['orgs'] = $query;

        $query = $this->Md->query("SELECT * FROM procedures");
        if ($query)
            $data['procs'] = $query;

        $this->load->view('procedure-page', $data);
    }

    public function update() {

        if ($this->session->userdata('level') == 1) {

            $this->load->helper(array('form', 'url'));
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $code = $this->input->post('code');

            $org = array('id' => $id, 'name' => $name, 'address' => $address, 'code' => $code);

            $content = json_encode($org);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'org', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->Md->update($id, $org, 'organisation');
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You may need to re-login for these changes to be carried out' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        }
    }

    public function api() {

        $orgname = urldecode($this->uri->segment(3));
        $verification = urldecode($this->uri->segment(4));
        if ($orgname != "" || $verification != "") {
            $query = $this->Md->query("SELECT * FROM organisation WHERE  name ='" . $orgname . "' AND `keys` = '" . $verification . "'");
            if ($query) {
                foreach ($query as $res) {
                    $clientname = $res->code . "-DESKTOP" . date('y') . "-" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');
                    $orgid = $res->id;
                }
                $client = array('org' => $orgid, 'active' => 'T', 'name' => $clientname, 'created' => date('Y-m-d H:i:s'));
                $this->Md->save($client, 'client');
                $temp = json_encode($query);  //$json={"var1":"value1","var2":"value2"}   
                $temp = substr($temp, 0, -2);
                $temp.=',"oid":"' . $clientname . '"}]';
                echo $temp;
            }
        } else {
            echo "";
        }
    }

    public function exists() {
        $this->load->helper(array('form', 'url'));
        $email = trim($this->input->post('user'));
        if (strlen($email) < 5) {
            echo '<span style="color:#f00"> empty field! too short </span>';
            return;
        }
        $get_result = $this->Md->returns($email, 'email', 'users');
        //href= "index.php/patient/add_chronic/'.$chronic.'"
        if (!$get_result) {
            echo '<span style="color:#008000"> available not in use </span>';
        } else {
            echo '<span style="color:#f00"> not available ! already in use </span> <br>';
            echo '' . $get_result->contact . '<br>';
            echo '' . $get_result->email . '<br>';
            echo '' . $get_result->address . '<br>';
        }
    }

    public function name() {
        $this->load->helper(array('form', 'url'));
        $name = trim($this->input->post('name'));
        if (strlen($name) < 3) {
            echo '<span style="color:#f00"> empty field </span>';
            return;
        }
        $get_result = $this->Md->returns($name, 'name', 'organisation');
        //href= "index.php/patient/add_chronic/'.$chronic.'"
        if (!$get_result) {
            echo '<span style="color:#008000"> available not in use </span>';
        } else {
            echo '<span style="color:#f00"> ! already in use </span> <br>';
        }
    }

    public function code() {
        $this->load->helper(array('form', 'url'));
        $code = trim($this->input->post('code'));
        if (strlen($code) < 1) {
            echo '<span style="color:#f00"> empty field </span>';
            return;
        }
        $get_result = $this->Md->returns($code, 'code', 'organisation');
        //href= "index.php/patient/add_chronic/'.$chronic.'"
        if (!$get_result) {
            echo '<span style="color:#008000"> available not in use </span>';
        } else {
            echo '<span style="color:#f00"> not available ! already in use </span> <br>';
        }
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function generate_key_string() {

        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) {

            $segment = '';

            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
            }

            $key_string .= $segment;

            if ($i < ($num_segments - 1)) {
                $key_string .= '-';
            }
        }

        return $key_string;
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome/logout', 'refresh');
    }

    public function student() {
        $this->load->view('private');
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

    public function list_files() {

        $g = new stdClass();
        // $g->wordpopulation = array();        
        $count = 1;
        $query2 = $this->Md->query("select * from users WHERE category='client'");
        $results = $query2;
        foreach ($results as $res) {

            $r = new stdClass();
            $r->rank = $count++;
            $r->country = $res->category;
            $r->population = $res->contact;
            $r->flag = "http://192.168.1.196/caseprofessionals/uploads/" . $res->image;
            $g->worldpopulation[] = $r;
        }
        header('Content-Type: application/json');
        echo json_encode($g);
    }

}
