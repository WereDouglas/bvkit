<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
        $this->load->library('excel');
    }

    public function index() {
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
        $query = $this->Md->query("SELECT * FROM files where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['files'] = $query;
        } else {
            $data['files'] = array();
        }
        $data['procs'] = array();

        $query = $this->Md->query("SELECT * FROM procedures where org = '" . $this->session->userdata('orgid') . "' OR org=''");
        if ($query)
            $data['procs'] = $query;

        $this->load->view('file-page', $data);
    }

    public function add() {

        $query = $this->Md->query("SELECT * FROM users where orgID = '" . $this->session->userdata('orgID')."' ");

        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $this->load->view('add-file', $data);
    }

    public function import() {

        $orgid = $this->session->userdata('orgid');

        if (isset($_POST["Import"])) {
            $filename = $_FILES["file"]["tmp_name"];
            // echo $filename;
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $file = $filename;

                $objPHPExcel = PHPExcel_IOFactory::load($file);
                //      Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                // Loop through each row of the worksheet in turn
                for ($row = 1; $row < 2; $row++) {
                    //  Read a row of data into an array
                    // echo $row;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    // var_dump($rowData[0]);
                    // echo count($rowData[0]);
                    for ($m = 0; $m < count($rowData[0]); $m++) {
                        // echo $rowData[0][$m]."<br> ";
                    }
                }
                for ($row = 2; $row <= $highestRow; $row++) {
                    //  Read a row of data into an array
                    // echo $row;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // var_dump($rowData);
                    for ($d = 0; $d < count($rowData); $d++) {
                        // var_dump($rowData[$d]);
                        //echo $rowData[$d][0] . "<br>";
                        $fileid = $this->GUID();
                        //get($field, $value, $table)
                        $namer = $this->Md->get('name', $rowData[$d][4], 'files');
                        $filer = $this->Md->get('no', $rowData[$d][1], 'files');
                        //echo $name.'<br>';
                        //return;
                        // var_dump($namer);
                        // return;
                        if (strlen($rowData[$d][0]) > 2 && count($namer) == 0 && count($filer) == 0) {
                            //$users = array('id' => $userid, 'image' => " ", 'email' => $rowData[$d][2], 'name' => $rowData[$d][0], 'org' => $this->session->userdata('orgid'), 'address' => $rowData[$d][4], 'sync' => $rowData[$d][1], 'oid' => " ", 'contact' => $rowData[$d][3], 'password' => " ", 'types' => 'client', 'level' => '4', 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
                            //$users = $this->Md->query_cell("SELECT * FROM users where name = '" .$rowData[$d][0] . "'", 'id');                         
                            $query = $this->Md->query("SELECT * FROM users where name LIKE '" . $rowData[$d][0] . "' AND org= '" . $this->session->userdata('orgid') . "' LIMIT 1");
                            if ($query) {
                                foreach ($query as $res) {
                                    $clientid = $res->id;
                                }
                            }
                            $query2 = $this->Md->query("SELECT * FROM users where name LIKE '" . $rowData[$d][10] . "' AND org= '" . $this->session->userdata('orgid') . "'  LIMIT 1");
                            if ($query2) {
                                foreach ($query2 as $res2) {
                                    $userid = $res2->id;
                                }
                            }
                            if ($clientid == " " || $userid == " ") {

                                continue;
                            }
                            //date('Y-m-d', strtotime($date))
                            $files = array('id' => $fileid, 'users' => $clientid, 'org' => $orgid, 'details' => $rowData[$d][3], 'name' => $rowData[$d][4], 'types' => $rowData[$d][2], 'created' => date('d-m-Y', strtotime($rowData[$d][9])), 'status' => 'T', 'no' => $rowData[$d][1], 'subject' => $rowData[$d][6], 'citation' => $rowData[$d][7], 'law' => $rowData[$d][8], 'co' => $userid);
                            $this->Md->save($files, 'files');
                            $contents = array('id' => $fileid, 'users' => $clientid, 'org' => $orgid, 'details' => $rowData[$d][3], 'name' => $rowData[$d][4], 'types' => $rowData[$d][2], 'created' => date('d-m-Y', strtotime($rowData[$d][9])), 'status' => 'T', 'no' => $rowData[$d][1], 'subject' => $rowData[$d][6], 'citation' => $rowData[$d][7], 'law' => $rowData[$d][8], 'co' => $userid);
                            $content = json_encode($contents);
                            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                            if ($query) {
                                foreach ($query as $res) {
                                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'contents' => $content, 'action' => 'create', 'oid' => $fileid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                                    $this->Md->save($syc, 'sync_data');
                                }
                            }
                            echo 'saving';
                        } else {

                            echo 'Repeated';
                        }
                    }
                }
                //  Insert row data array into your database of choice here
            }
//send the data in an array format

            fclose($file);
        }

        echo '<div class="alert alert-info">   <strong>Information uploaded!  </strong>	</div>';
        redirect('file', 'refresh');
    }

    public function clients() {
        $query = $this->Md->query("SELECT * FROM users  where orgID = '" . $this->session->userdata('orgID') . "' ORDER BY name DESC");
        echo json_encode($query);
    }

    public function user() {
        $query = $this->Md->query("SELECT * FROM users  where org = '" . $this->session->userdata('orgid') . "' AND types<>'client' ORDER BY name DESC");
        echo json_encode($query);
    }

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM files WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }

    public function view() {

        $this->load->helper(array('form', 'url'));
        $fileid = $this->uri->segment(3);

        $query = $this->Md->query("SELECT * FROM files where id = '" . $fileid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['details'] = $res->details;
                $data['types'] = $res->types;
                $data['no'] = $res->no;
                $data['created'] = $res->created;
                $data['subject'] = $res->subject;
            }
        }
        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND file = '" . $fileid . "' ");
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
        $query = $this->Md->query("SELECT * FROM document where org = '" . $this->session->userdata('orgid') . "' AND cases = '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['docs'] = $query;
        } else {
            $data['docs'] = array();
        }
        $query = $this->Md->query("SELECT * FROM note where org = '" . $this->session->userdata('orgid') . "' AND fileID= '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['notes'] = $query;
        } else {
            $data['notes'] = array();
        }
        $query = $this->Md->query("SELECT * FROM bill where org = '" . $this->session->userdata('orgid') . "' AND fileID= '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['bills'] = $query;
        } else {
            $data['bills'] = array();
        }


        $query = $this->Md->query("SELECT * FROM attend where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }
        $data['fileid'] = $fileid;

        $this->load->view('file-view', $data);
    }

    public function schedule() {

        $this->load->helper(array('form', 'url'));
        $fileid = $this->uri->segment(3);

        $query = $this->Md->query("SELECT * FROM files where id = '" . $fileid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['details'] = $res->details;
                $data['types'] = $res->types;
                $data['no'] = $res->no;
                $data['created'] = $res->created;
                $data['subject'] = $res->subject;
            }
        }

        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' AND file='" . $fileid . "' ");
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

        $this->load->view('calendar-file', $data);
    }

    public function table() {
        $query = $this->Md->query("SELECT * FROM file where orgID = '" . $this->session->userdata('orgID') . "'");
        //  var_dump($query);
        if ($query) {
            $data['files'] = $query;
        } else {
            $data['files'] = array();
        }
        $query = $this->Md->query("SELECT * FROM users where  orgID='".$this->session->userdata('orgID')."'");
        if ($query) {
              $data['users'] = $query;
        }
        $this->load->view('view-file', $data);
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
       
        $file = array('name' => $this->input->post('name'), 'type' => $this->input->post('type'), 'details' => $this->input->post('details'), 'subject' => $this->input->post('subject'), 'client' => $this->input->post('client'), 'lawyer' => $this->input->post('lawyer'), 'no' => $this->input->post('no'), 'type' => $this->input->post('type'), 'citation' => $this->input->post('citation'), 'law' => $this->input->post('law'), 'status' => $this->input->post('status'));
        $this->Md-> update_dynamic($id, 'fileID', 'file', $file);
        echo 'FILE INFORMATION UPDATED';
       
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $id = $this->uri->segment(3);
        $query = $this->Md->delete($id, 'files');
        if ($this->db->affected_rows() > 0) {

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'files', 'contents' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('file', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
            redirect('file', 'refresh');
        }
    }

    public function create() {

        $this->load->helper(array('form', 'url'));
        $types = $this->input->post('type');

        $app = "O";
        switch ($types) {
            case Litigation:
                $app = "L";
                break;
            case General:
                $app = "G";
                break;
        }
        $no = $this->session->userdata('code') . "/" . $app . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('ss');
        $orgID = $this->session->userdata('orgID');
        $files = array('fileID' => $this->GUID(), 'client' => $this->input->post('client'), 'lawyer' =>$this->input->post('lawyer'),  'orgID' => $this->session->userdata('orgID'), 'details' =>$this->input->post('details'), 'name' => $this->input->post('name'), 'type' => $this->input->post('type'), 'created' => date('Y-m-d H:i:s'), 'status' => $this->input->post('status'), 'no' => $no, 'subject' => $this->input->post('subject'), 'citation' => $this->input->post('citation'), 'law' => $this->input->post('law'));
        $this->Md->save($files, 'file');
        $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New File Saved</strong>									
						</div>');

        redirect('/file/create', 'refresh');
    }

}
