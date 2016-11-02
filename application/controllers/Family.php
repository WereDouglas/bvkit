<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        if ($this->session->userdata('name') == "" || $this->session->userdata('sessionName') == "") {
            $this->session->sess_destroy();
            redirect('home', 'refresh');
        }
          $query = $this->Md->query("SELECT * FROM patient  WHERE  familyID='" . $this->session->userdata('patientID') . "'");
        
        if ($query) {
            $data['patients'] = $query;
        }
        $this->load->view('family-page', $data);
    }
    public function view() {
        if ($this->session->userdata('name') == "" || $this->session->userdata('sessionName') == "") {
            $this->session->sess_destroy();
            redirect('home', 'refresh');
        }
         $query = $this->Md->query("SELECT * FROM patient  WHERE  familyID='" . $this->session->userdata('patientID') . "'");
        
        if ($query) {
            $data['patients'] = $query;
        }
         $this->load->view('family-page', $data);
    }

 

  public function create() {

        $this->load->helper(array('form', 'url'));

        //user information
        $patientID = $this->GUID();
        $contact = $this->input->post('contact');

        if ($contact != "") {

            $result = $this->Md->check($contact, 'contact', 'patient');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 Contact already in use please try again	</strong>									
						</div>');
                redirect('/family', 'refresh');
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
            $users = array('patientID' => $patientID, 'name' => $this->input->post('name'), 'email' => $this->input->post('email'), 'dob' => date("Y-m-d", strtotime($this->input->post('dob'))), 'contact' => $this->input->post('contact'), 'password' => md5($this->input->post('password')), 'gender' => $this->input->post('gender'), 'image' => $userfile, 'address' => $this->input->post('address'), 'contact' => $this->input->post('contact'), 'country' => $this->input->post('country'), 'city' => $this->input->post('city'), 'region' => $this->input->post('region'), 'created' => date('Y-m-d H:i:s'), 'state' => 'Active','familyID' =>$this->session->userdata('patientID'));
            $this->Md->save($users, 'patient');
        
            
            
            $status .= '<div class="alert alert-success">  <strong>Family member saved</strong></div>';
            $this->session->set_flashdata('msg', $status);

            redirect('/family', 'refresh');
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

 
    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }


    public function delete() {

        $this->load->helper(array('form', 'url'));
        $userID = $this->uri->segment(3);
        $query = $this->Md->cascade($userID, 'patient', 'patientID');

        redirect('family', 'refresh');
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
                    $this->Md->update_dynamic($user_id, 'patientID', 'patient', $task);
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
