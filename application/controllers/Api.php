<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function client() {

        $result = $this->Md->query("SELECT * FROM user WHERE clientID <>''");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function allusers() {

        $result = $this->Md->query("SELECT * FROM user");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function category() {

        $result = $this->Md->query("SELECT DISTINCT(category) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function method() {

        $result = $this->Md->query("SELECT DISTINCT(method) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function detail() {

        $result = $this->Md->query("SELECT DISTINCT(details) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function bank() {

        $result = $this->Md->query("SELECT DISTINCT(bank) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function account() {

        $result = $this->Md->query("SELECT DISTINCT(account) AS name FROM transactions ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function org() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM org WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function attend() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM attend WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function contacts() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM contacts WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function document() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM document WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function file() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM file WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function item() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM item WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function message() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM message WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function notes() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM notes WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function payment() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM payment WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function rules() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM rules WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function tasks() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM tasks WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function transactions() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM transaction WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function users() {

        $orgID = urldecode($this->uri->segment(3));
        if ($orgID != "") {
            $query = $this->Md->query("SELECT * FROM users WHERE  orgID ='$orgID'");
            if ($query) {
                echo json_encode($query);
            } else {
                echo "";
            }
        }
    }

    public function remote() {

        $this->load->helper(array('form', 'url'));
        $email = $this->input->post('name');
        $org = $this->input->post('orgName');
        $license = $this->input->post('license');
        $password_now = md5($this->input->post('password'));

        $result = $this->Md->query("SELECT * FROM  org WHERE name ='$org' and license='$license'");

        if ($result) {
            echo json_encode($result);
        } else {
            echo 'False';
        }
    }

    public function reminders() {

        $result = $this->Md->query("SELECT *,users.name AS cid FROM reminder INNER JOIN users ON reminder.cid=users.uid");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function utility() {
        $uid = urldecode($this->uri->segment(3));
        if ($uid) {

            $result = $this->Md->query("SELECT *,utility.name AS name,unit.name AS unit FROM utility INNER JOIN unit ON utility.uid=unit.uid WHERE utility.uid='" . $uid . "' ");

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
        $result = $this->Md->query("SELECT *,utility.name AS name,unit.name AS unit FROM utility INNER JOIN unit ON utility.uid=unit.uid ");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function util() {
        $uid = urldecode($this->uri->segment(3));
        if ($uid) {

            $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName,util.cost AS cost FROM util INNER JOIN room ON util.roomID=room.roomID WHERE util.roomID='" . $uid . "' ");

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
        $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName FROM util INNER JOIN room ON util.roomID=room.roomID ");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function roomutil() {
        $uid = urldecode($this->uri->segment(3));


        $result = $this->Md->query("SELECT *,util.name AS name,room.name AS roomName,util.cost AS cost FROM util INNER JOIN room ON util.roomID=room.roomID WHERE util.roomID='" . $uid . "' ");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function tenant() {

        $result = $this->Md->query("SELECT *,user.name AS name,room.name AS room,user.userID AS userID FROM user INNER JOIN room ON user.tenantID = room.tenantID ");

        if ($result) {
            echo json_encode($result);
        }
    }

    //Sending.genUrl + "api/transaction/" + userid+"/"+startdate+"/"+enddate;
    public function userreport() {

        $userid = urldecode($this->uri->segment(3));
        $start = urldecode($this->uri->segment(4));
        $end = urldecode($this->uri->segment(5));
        $method = urldecode($this->uri->segment(6));

        if ($userid != "") {
            $result = $this->Md->query("SELECT * FROM transactions WHERE cid='" . $userid . "' AND DATE(created) BETWEEN '$start' AND '$end'");

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
    }

    public function expense() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "expense.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS cid,property.name AS propert,user.name AS client,room.name as roomID,expense.details AS details,expense.type AS type FROM expense LEFT JOIN property ON expense.propertyID= property.propertyID  LEFT JOIN room ON room.roomID = expense.roomID LEFT JOIN user ON user.clientID = property.clientID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function rent() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "rent.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID,rent.commission AS commission,rent.date AS date,rent.start AS start,rent.end AS end FROM rent LEFT JOIN room ON rent.roomID= room.roomID  LEFT JOIN user ON rent.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function banked() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "bank.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS clientID FROM bank LEFT JOIN user ON bank.clientID= user.clientID ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function partial() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "partial.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID FROM partial LEFT JOIN user ON partial.tenantID= user.tenantID ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function confiscate() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "confiscate.day BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID FROM confiscate LEFT JOIN room ON confiscate.roomID= room.roomID  LEFT JOIN user ON confiscate.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function cost() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "expense.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "cost.date BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,user.name AS tenantID,room.name AS roomID FROM cost LEFT JOIN room ON cost.roomID= room.roomID  LEFT JOIN user ON cost.tenantID = user.tenantID";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function report() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));
        $client = urldecode($this->uri->segment(6));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            $sql[] = "transactions.cid = '$client' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "transactions.created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function advanced() {
        // string url = Sending.genUrl + "api/advanced/" + clientID + "/"+ tenantID + "/" + MethodComboBox.Text + "/" + DetailComboBox.Text+"/" + BankComboBox.Text+"/" +AccountComboBox.Text + "/" +startdate+ "/" + enddate;
        $client = urldecode($this->uri->segment(3));
        $tenant = urldecode($this->uri->segment(4));
        $method = urldecode($this->uri->segment(5));
        $detail = urldecode($this->uri->segment(6));
        $bank = urldecode($this->uri->segment(7));
        $account = urldecode($this->uri->segment(8));
        $start = date("d-m-Y", strtotime($this->uri->segment(9)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(10))));
        $sql[] = NULL;
        unset($sql);

        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "method = '$method' ";
            }
        }
        if ($client) {
            if ($client == "none") {
                
            } else {
                $sql[] = "transactions.cid = '$client' ";
            }
        }
        if ($tenant) {
            if ($tenant == "none") {
                
            } else {
                $sql[] = "transactions.tenant = '$tenant' ";
            }
        }
        if ($method) {
            if ($method == "none") {
                
            } else {
                $sql[] = "transactions.method = '$method' ";
            }
        }
        if ($detail) {
            if ($detail == "none") {
                
            } else {
                $sql[] = "transactions.details = '$detail' ";
            }
        }
        if ($bank) {
            if ($bank == "none") {
                
            } else {
                $sql[] = "transactions.bank = '$bank' ";
            }
        }
        if ($start != "" && $end != "") {
            $sql[] = "transactions.created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function reciept() {

        $tid = $this->uri->segment(3);

        $sql[] = NULL;
        unset($sql);

        if ($tid) {
            $sql[] = "tid = '$tid'";
        }

        $query = "SELECT *,users.name AS cid,transactions.tenant AS tenant,users.name AS cid,estate.name AS eid,unit.name as uid,transactions.category AS category,transactions.commission AS commission FROM transactions LEFT JOIN users ON transactions.cid= users.uid  LEFT JOIN estate ON transactions.eid = estate.eid LEFT JOIN unit ON transactions.uid = unit.uid";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function requisition() {

        $start = date("d-m-Y", strtotime($this->uri->segment(3)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));
        $method = urldecode($this->uri->segment(5));


        $sql[] = NULL;
        unset($sql);

        if ($method) {
            $sql[] = "method = '$method' ";
        }
        if ($start != "" && $end != "") {
            $sql[] = "created BETWEEN '$start' AND '$end' ";
        }

        $query = "SELECT * FROM requisition ";

        if (!empty($sql)) {
            $query .= ' WHERE  ' . implode(' AND ', $sql);
        }

        $result = $this->Md->query($query);
        // $result = $this->Md->query("SELECT * FROM transactions WHERE  created BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
            return;
        }
    }

    public function transaction() {

        $userid = urldecode($this->uri->segment(3));
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $method = urldecode($this->uri->segment(6));

        if ($userid != "") {

            $sql[] = NULL;
            unset($sql);

            if ($method) {
                $sql[] = "method = '$method' ";
            }
            if ($userid) {
                $sql[] = "cid = '$userid' ";
            }
            if ($start != "" && $end != "") {
                $sql[] = "created BETWEEN '$start' AND '$end' ";
            }

            $query = "SELECT * FROM transactions ";

            if (!empty($sql)) {
                $query .= ' WHERE  ' . implode(' AND ', $sql);
            }

            $result = $this->Md->query($query);

            if ($result) {
                echo json_encode($result);
                return;
            }
        } else {
            $start = date("d-m-Y", strtotime($this->uri->segment(3)));
            $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(4))));

            $sql[] = NULL;
            unset($sql);
            if ($start != "" && $end != "") {
                $sql[] = "created BETWEEN '$start' AND '$end' ";
            }

            $query = "SELECT * FROM transactions ";

            if (!empty($sql)) {
                $query .= ' WHERE  ' . implode(' AND ', $sql);
            }

            $result = $this->Md->query($query);

            if ($result) {
                echo json_encode($result);
                return;
            }
        }
    }

    public function property() {

        $result = $this->Md->query("SELECT *,property.name AS name,user.name AS client FROM property INNER JOIN user ON property.clientID= user.clientID ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function EstateStatement() {
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,estate.name AS name,user.name AS Client FROM estate INNER JOIN users ON estate.cid= users.uid WHERE estate.cid='" . $userid . "' ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function rentstatement() {
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,user.name AS tenant,room.name AS room,property.name AS property FROM user LEFT JOIN property ON user.clientID= property.clientID LEFT JOIN room ON property.propertyID = room.propertyID INNER JOIN rent ON room.roomID = rent.roomID WHERE user.clientID='" . $userid . "'AND rent.date BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function expensestatement() {
        $start = date("d-m-Y", strtotime($this->uri->segment(4)));
        $end = date("d-m-Y", strtotime(urldecode($this->uri->segment(5))));
        $userid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT *,property.name AS propert,room.name AS room FROM user LEFT JOIN property ON user.clientID= property.clientID LEFT JOIN room ON property.propertyID = room.propertyID LEFT JOIN expense ON expense.propertyID = property.propertyID WHERE user.clientID='" . $userid . "' AND expense.date BETWEEN '$start' AND '$end'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function UnitStatement() {
        $estateid = urldecode($this->uri->segment(3));

        $result = $this->Md->query("SELECT *,unit.name AS name,estate.name AS estate,users.name AS username FROM unit INNER JOIN estate ON unit.eid = estate.eid INNER JOIN users ON unit.uid = users.unit WHERE unit.eid='" . $estateid . "'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function room() {

        $result = $this->Md->query("SELECT *,room.name AS name,property.propertyID AS propertyID,property.name AS propertyName,user.name AS username,room.commission AS commission FROM room INNER JOIN property ON room.propertyID = property.propertyID LEFT JOIN user ON room.tenantID= user.tenantID  ");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function graph() {

        $this->load->view('view-graph');
    }

    public function user() {
        $this->load->helper(array('form', 'url'));

        $passwordf = $this->encrypt->encode($password, $key);

        $users = array('uid' => $this->input->post('uid'), 'name' => $this->input->post('name'), 'account' => $this->input->post('account'), 'gender' => $this->input->post('gender'), 'contact' => $this->input->post('contact'), 'email' => $this->input->post('email'), 'password' => $password, 'password' => $passwordf, 'category' => $this->input->post('category'), 'starting' => $this->input->post('starting'), 'ending' => $this->input->post('ending'), 'address' => $this->input->post('address'), 'image' => $this->input->post('image'), 'created' => date('Y-m-d H:i:s'), 'status' => 'Active', 'unit' => $this->input->post('unit'));

        $this->Md->save($users, 'users');

        echo "true";
        return;
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $app = urldecode($this->uri->segment(3));
        //cascade($id,$table,$field)
        $query = $this->Md->cascade($app, 'sync_data', 'client');
        if ($this->db->affected_rows() > 0) {
            echo "Pending records deleted";
        }
    }

    public function upload() {
        // echo 'File '. $_FILES['file']['name'] .' uploaded successfully.' ;
        $file_element_name = 'userfile';
        $config['upload_path'] = 'uploads/';
        // $config['upload_path'] = '/uploads/';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
            echo "file uploaded";
        }
        //   move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);

        echo "done";
    }

}
