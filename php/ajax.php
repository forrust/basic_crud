<?php 
// check if ajax call
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' && strpos($_SERVER['HTTP_REFERER'],getenv('HTTP_HOST'))==false ){
    die('Something went wrong');
}else{
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    require_once("functions_db.php");
}

// get records for index
if(isset($_POST['get_records'])){	
    $rec_r=db_get("SELECT id, firstname, lastname, email, field1, field2 FROM records WHERE active=1");
    $return_r = array();
    foreach($rec_r as $k=>$rec){
        $return_r[$k]['name']=$rec['firstname'].' '.$rec['lastname'];
        $return_r[$k]['email']=$rec['email']; 
        $return_r[$k]['field1']=$rec['field1']; 
        $return_r[$k]['field2']=$rec['field2']; 
        $return_r[$k]['id']=$rec['id'];    
    }
    print json_encode($return_r);
}

if(isset($_POST['rec_id']) && isset($_POST['rec_firstname']) && isset($_POST['rec_lastname']) && isset($_POST['rec_email'])){
    $id         = filter_input(INPUT_POST,'rec_id',FILTER_SANITIZE_STRING);
    $firstname  = filter_input(INPUT_POST,'rec_firstname',FILTER_SANITIZE_STRING);
    $lastname   = filter_input(INPUT_POST,'rec_lastname',FILTER_SANITIZE_STRING);
    $email      = filter_input(INPUT_POST,'rec_email',FILTER_SANITIZE_STRING);
    $field1     = filter_input(INPUT_POST,'rec_field1',FILTER_SANITIZE_STRING);
    $field2     = filter_input(INPUT_POST,'rec_field2',FILTER_SANITIZE_STRING);
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // E-mail incorrect
        print json_encode(array('status' => 'Wrong email'));
    }elseif($id=='new'){
        // New record insert
        $fields = array();
        $fields[] = array('firstname', $firstname);
        $fields[] = array('lastname', $lastname);
        $fields[] = array('email', $email);
        $fields[] = array('field1', $field1);
        $fields[] = array('field2', $field2);
        
        if (db_insert($fields, 'records')){
    	   print json_encode(array('status' => 'success'));
        }else{ 
           print json_encode(array('status' => 'error'));
        }
    }elseif(is_numeric($id)){
        // Existing record update
        $criteria   = array();
        $criteria[] = array('id', $id);
        
        $fields     = array();
        $fields[]   = array('firstname', $firstname);
        $fields[]   = array('lastname', $lastname);
        $fields[]   = array('email', $email);
        $fields[]   = array('field1', $field1);
        $fields[]   = array('field2', $field2);
        
        if (db_update($fields, $criteria, 'records')){
    	   print json_encode(array('status' => 'success'));
        }else{ 
           print json_encode(array('status' => 'error'));
        }
    }
}

if(isset($_POST['delete_id'])){
    $id = filter_input(INPUT_POST,'delete_id',FILTER_SANITIZE_NUMBER_INT);
    if(is_numeric($id)){
        // Existing record update
        $criteria   = array();
        $criteria[] = array('id', $id);
        
        $fields     = array();
        $fields[]   = array('active', 0);
        
        if (db_update($fields, $criteria, 'records')){
    	   print json_encode(array('status' => 'success'));
        }else{ 
           print json_encode(array('status' => 'error'));
        }
    }
}

?>
