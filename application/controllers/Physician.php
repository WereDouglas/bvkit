<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Physician extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }
        $this->load->view('add-user');
    }

    public function add() {

        $this->load->view('add-user');
    }

    public function create() {

        $this->load->helper(array('form', 'url'));

        //user information
        $physicianID = $this->GUID();
        $contact = $this->input->post('contact');


        if ($contact != "") {

            $result = $this->Md->check($contact, 'contact', 'physician');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 Contact already in use please try again	</strong>									
						</div>');
                redirect('/home/register_physician', 'refresh');
            }
            ///organisation image uploads
            $file_element_name = 'userfile';
            $config['file_name'] = $patientID;
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'errors';
                $msg = $this->upload->display_errors('', '');
                $status .= '<div class="alert alert-error"> <strong>' . $msg . '</strong></div>';
            }
            $data = $this->upload->data();
            $userfile = $data['file_name'];
            $users = array('physicianID' => $physicianID, 'name' => $this->input->post('name'), 'email' => $this->input->post('email'), 'designation' => $this->input->post('designation'), 'contact' => $this->input->post('contact'), 'password' => md5($this->input->post('password')), 'gender' => $this->input->post('gender'), 'image' => $userfile, 'address' => $this->input->post('address'), 'contact' => $this->input->post('contact'), 'country' => $this->input->post('country'), 'city' => $this->input->post('city'), 'region' => $this->input->post('region'), 'created' => date('Y-m-d H:i:s'), 'state' => 'Active');
            $this->Md->save($users, 'physician');
            $status .= '<div class="alert alert-success">  <strong>You have successfully registered with us please login to continue</strong></div>';
            $this->session->set_flashdata('msg', $status);

            redirect('/home', 'refresh');
        }
    }

    public function api() {
        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM users WHERE org ='" . $orgid . "'");

        $all = array();

        foreach ($result as $res) {
            $resv = new stdClass();
            $resv->id = $res->id;
            $resv->name = $res->name;
            $resv->org = $res->org;
            $resv->address = $res->address;
            $resv->image = $res->image;
            $resv->contact = $res->contact;
            $resv->password = $this->encrypt->decode($res->password, $res->email);
            $resv->types = $res->types;
            $resv->level = $res->level;
            $resv->created = $res->created;
            $resv->status = $res->status;
            $resv->email = $res->email;

            array_push($all, $resv);
        }
        echo json_encode($all);
    }

    public function update_image() {

        $this->load->helper(array('form', 'url'));
        //user information

        $userID = $this->input->post('userID');
        $namer = $this->input->post('namer');

        $fileUrl = $this->Md->query_cell("SELECT image FROM users WHERE userID ='" . $userID . "'", 'image');

        $this->Md->file_remove($fileUrl, 'uploads');


        $file_element_name = 'userfile';
        // $new_name = $userID;
        $config['file_name'] = $userID;
        $config['upload_path'] = 'uploads/';
        $config['encrypt_name'] = FALSE;
        $config['allowed_types'] = 'jpg';
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
            $this->session->set_flashdata('msg', '<div class="alert alert-error"> <strong>' . $msg . '</strong></div>');
            redirect('/user/profile/' . $namer, 'refresh');

            return;
        }
        $data = $this->upload->data();
        $userfile = $data['file_name'];
        $user = array('image' => $userfile);
        $this->Md->update_dynamic($userID, 'userID', 'users', $user);

        $this->session->set_flashdata('msg', '<div class="alert alert-success">  <strong>Image updated saved</strong></div>');

        redirect('/user/profile/' . $namer, 'refresh');
    }

    public function home() {
        if ($this->session->userdata('name') == "" || $this->session->userdata('sessionName') == "") {
            $this->session->sess_destroy();
            redirect('home', 'refresh');
        }
        $this->load->view('home-page', $data);
    }

    public function update_password() {

        $this->load->helper(array('form', 'url'));
        //user information
        $this->load->library('email');



        $password = $this->input->post('password');
        //$password = '123456';
        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('userID');
        $email = $this->Md->query_cell("SELECT email FROM users WHERE userID ='" . $id . "'", 'email');
        $name = $this->Md->query_cell("SELECT name FROM users WHERE userID='" . $id . "'", 'name');

        $new_password = md5($password);

        $info = array('password' => $new_password);
        $this->Md->update_dynamic($id, 'userID', 'users', $info);

        $body = $name . '  ' . ' Your password has been reset to ' . $password . " Please click the link below to access your Case Professional account: caseprofessional.org";

        $from = "noreply@caseprofessional.org";
        $subject = "Password reset ";
        if ($email != "") {

            $this->email->from($from, 'Case Professional');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($body);
            $this->email->send();
            echo $this->email->print_debugger();
            echo "email has been sent";
            //return;
        }

        echo 'INFORMATION UPDATED';
        $this->session->set_flashdata('msg', '<div class="alert alert-success">  <strong>USER PASSWORD CHANGED</strong></div>');

        redirect('/user/profile/' . $name, 'refresh');
    }

    public function exists() {
        $this->load->helper(array('form', 'url'));
        $user = trim($this->input->post('user'));
        //returns($value,$field,$table)
        $get_result = $this->Md->returns($user, 'name', 'users');
        //href= "index.php/patient/add_chronic/'.$chronic.'"
        if (!$get_result)
            echo '<span style="color:#f00"> This client <strong style="color:#555555" >' . $user . '</strong> does not exist in our database.' . '<a href= "' . $user . '" value="' . $user . '" id="myLink" style="background #555555;color:#0749BA;" onclick="NavigateToSite()">Click here to add </a></span>';
        else
            echo '' . $get_result->contact . '<br>';
        echo '' . $get_result->email . '<br>';
        echo '' . $get_result->address . '<br>';
        echo'<span class="span-data" name="userid" id="userid" style="visibility:hidden" >' . $get_result->name . '</span>';
    }

    public function add_user() {

        $user = $this->input->post('name');
        $get_result = $this->Md->returns($user, 'name', 'users');
        if (!$get_result) {
            if ($user != "") {
                $this->load->helper(array('form', 'url'));
                //user information
                $userid = $this->GUID();
                $email = ' ';
                $name = $user;
                $password = $this->session->userdata('code');
                $email = " ";
                $contact = " ";
                $address = " ";
                $level = 1;
                $type = 'client';
                $orgid = $this->session->userdata('orgid');


                $submitted = date('Y-m-d');
                $userfile = $data['file_name'];

                $users = array('id' => $userid, 'image' => '', 'email' => '', 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => ' ', 'oid' => '', 'contact' => '', 'password' => '', 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
                $this->Md->save($users, 'users');
                $content = json_encode($users);

                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'contents' => $content, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $file_id = $this->Md->save($syc, 'sync_data');
                    }
                }
            }
        } else {
            echo '<span style="color:#f00"> This client <strong style="color:#555555" >' . $user . '</strong> exists in our database.' . '<a href= "' . $user . '" value="' . $user . '" id="myLink" style="background #555555;color:#0749BA;" onclick="NavigateToSite()">Click here to add </a></span>';
        }
    }

    public function clients() {

        $this->load->helper(array('form', 'url'));


        $query = $this->Md->query("SELECT * FROM users where  orgID='" . $this->session->userdata('orgID') . "' AND category='Client'");
        if ($query) {
            $data['users'] = $query;
        }
        $this->load->view('view-client', $data);
    }

    public function staff() {

        $this->load->helper(array('form', 'url'));
        $query = $this->Md->query("SELECT * FROM users where  orgID='" . $this->session->userdata('orgID') . "' AND category='Staff'");
        if ($query) {
            $data['users'] = $query;
        }
        $this->load->view('view-staff', $data);
    }

    public function charges() {

        $this->load->helper(array('form', 'url'));
        $query = $this->Md->query("SELECT * FROM users where  orgID='" . $this->session->userdata('orgID') . "' AND category='Staff'");
        if ($query) {
            $data['users'] = $query;
        }
        $this->load->view('view-charges', $data);
    }

    public function users() {
        $query = $this->Md->query("SELECT * FROM users where types <>'client' AND orgID='" . $this->session->userdata('orgID') . "'");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
        $this->load->view('user-page', $data);
    }

    public function profile() {

        $this->load->helper(array('form', 'url'));
        $name = urldecode($this->uri->segment(3));

        $query = $this->Md->query("SELECT * FROM events where orgID = '" . $this->session->userdata('orgID') . "'AND user='" . $name . "' ");

        if ($query) {
            $data['events'] = $query;
        } else {
            $data['events'] = array();
        }
        $query = $this->Md->query("SELECT * FROM users where name ='" . $name . "' AND orgID='" . $this->session->userdata('orgID') . "'");

        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
        $this->load->helper(array('form', 'url'));
        $query = $this->Md->query("SELECT * FROM file where orgID = '" . $this->session->userdata('orgID') . "' AND lawyer='" . $name . "' ");

        if ($query) {
            $data['files'] = $query;
        } else {
            $data['files'] = array();
        }
        $query = $this->Md->query("SELECT * FROM  tasks where orgID = '" . $this->session->userdata('orgID') . "' AND userID = '" . $name . "' ");
        if ($query) {
            $data['sch'] = $query;
        } else {
            $data['sch'] = array();
        }
        $query = $this->Md->query("SELECT * FROM attend where orgID = '" . $this->session->userdata('orgID') . "'");
        //  var_dump($query);
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }
        $query = $this->Md->query("SELECT * FROM document where orgID = '" . $this->session->userdata('orgID') . "' AND lawyer = '" . $name . "' OR client = '" . $name . "' ");

        if ($query) {
            $data['docs'] = $query;
        } else {
            $data['docs'] = array();
        }
        $query = $this->Md->query("SELECT * FROM client where  orgID='" . $this->session->userdata('orgID') . "' AND lawyer = '" . $name . "'");
        if ($query) {
            $data['clients'] = $query;
        }
        $this->load->view('user-profile', $data);
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function update() {

        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('id');

        $user = array('name' => $this->input->post('name'), 'address' => $this->input->post('address'), 'contact' => $this->input->post('contact'), 'designation' => $this->input->post('designation'), 'status' => $this->input->post('status'), 'address' => $this->input->post('address'), 'category' => $this->input->post('category'));
        // $this->Md->update($id, $user, 'users');
        $this->Md->update_dynamic($id, 'userID', 'users', $user);
        echo 'USER INFORMATION UPDATED';
        return;
    }

    public function updateclient() {
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) {
            $this->load->helper(array('form', 'url'));
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            $email = $this->input->post('email');
            $address = $this->input->post('details');
            $user = array('id' => $id, 'name' => $name, 'address' => $address, 'email' => $email, 'contact' => $contact, 'created' => date('Y-m-d H:i:s'));

            $content = json_encode($user);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'client', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->Md->update($id, $user, 'users');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('/user', 'refresh');
        }
    }

    public function delete() {

        $this->load->helper(array('form', 'url'));
        $userID = $this->uri->segment(3);
        $query = $this->Md->cascade($userID, 'users', 'userID');

        redirect('user/client', 'refresh');
    }

    public function user() {
        $this->load->helper(array('form', 'url'));
        $userid = $this->uri->segment(3);
        $query = $this->Md->query("SELECT * FROM users where id = '" . $userid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['address'] = $res->address;
                $data['image'] = $res->image;
                $data['contact'] = $res->contact;
                $data['created'] = $res->created;
                $data['email'] = $res->email;
            }
        }
        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }

        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND client = '" . $userid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['trans'] = $query;
        } else {
            $data['trans'] = array();
        }
        //  echo 'we are coming from the controller';
        $query = $this->Md->query("SELECT * FROM payments where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['pay'] = $query;
        } else {
            $data['pay'] = array();
        }
        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' AND file= '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['sch'] = $query;
        } else {
            $data['sch'] = array();
        }
        $query = $this->Md->query("SELECT * FROM attend where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }
        $data['fileid'] = $fileid;

        $this->load->view('client-page', $data);
    }

    public function add_client() {


        $this->load->helper(array('form', 'url'));

        //user information
        $userid = $this->GUID();
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $password = $this->session->userdata('code');
        $email = $this->input->post('email');
        $contact = $this->input->post('contact');
        $address = $this->input->post('address');
        $level = 4;
        $type = 'client';
        $orgid = $this->session->userdata('orgid');

        if ($name != "") {
            $password = $password;
            $key = $email;
            $password = $this->encrypt->encode($password, $key);
            $result = $this->Md->check($email, 'email', 'users');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 email already in use please try again	</strong>									
						</div>');
                redirect('/user/client', 'refresh');
            }

            ///organisation image uploads
            $file_element_name = 'userfile';

            $config['upload_path'] = 'uploads/';
            // $config['upload_path'] = '/uploads/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>' . $msg . '</strong></div>');
            }
            $data = $this->upload->data();

            $submitted = date('Y-m-d');
            $userfile = $data['file_name'];

            $users = array('id' => $userid, 'image' => $userfile, 'email' => $email, 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $file_id = $this->Md->save($users, 'users');
            $content = array('id' => $userid, 'image' => $userfile, 'email' => $email, 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');

            $content = json_encode($content);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'contents' => $content, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New client saved</strong>									
						</div>');

            redirect('/user/client', 'refresh');
        }
        $this->client();
    }

    public function updater() {
        $this->load->helper(array('form', 'url'));

        if (!empty($_POST)) {

            foreach ($_POST as $field_name => $val) {
                //clean post values
                $field_id = strip_tags(trim($field_name));
                $val = strip_tags(trim($val));
                //from the fieldname:user_id we need to get user_id
                $split_data = explode(':', $field_id);
                $user_id = $split_data[1];
                $field_name = $split_data[0];
                if (!empty($user_id) && !empty($field_name) && !empty($val)) {
                    //update the values
                    $task = array($field_name => $val);
                    // $this->Md->update($user_id, $task, 'tasks');
                    $this->Md->update_dynamic($user_id, 'userID', 'users', $task);
                    echo "Updated";
                } else {
                    echo "Invalid Requests";
                }
            }
        } else {
            echo "Invalid Requests";
        }
    }

}
