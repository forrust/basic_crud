<?php
/*************************************************************************************
*
*  functions_db.php
*
*  (PDO) Database functies
*  PDO = PHP Data Objects
*  Documentation: http://us.php.net/manual/en/pdo.connections.php
*
*************************************************************************************/

function db_connect() {
    $user="maurivz53_crud";
    $pass="AESzyKafS6";
    $db="maurivz53_crud";

    try{
        return $dbh = new PDO("mysql:host=localhost;dbname=".$db,$user,$pass);
    }catch(PDOException $e){
        exception_handler($e);
        return false;
    }
}


function db_get($sql, $parameter1 = null, $parameter2 = null) {
	try {
		$data = array();
		$conn = db_connect();	
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$rs = $conn->prepare($sql);
		$parameters = array($parameter1);
		$rs->execute($parameters);
		$data = $rs->fetchAll();
   		$rs = null; // Close thread
		$conn = null; // Close connection 
		return $data;
	}
	catch(PDOException $e) {
		exception_handler($e);
        return false;
	}		
}


function db_update($fields, $criteria, $table) {
     // when datatypes are missing, add string datatypes as default (2 = PDO::PARAM_STR)
	for ($i = 0; $i < count($criteria); $i++) { if (count($criteria[$i]) == 2) { $criteria[$i][2] = 2; } }
	for ($i = 0; $i < count($fields); $i++) { if (count($fields[$i]) == 2) { $fields[$i][2] = 2; } }
	
	// serialize fieldnames = values
	foreach($fields as $field) { $serialized_fields .= $field[0] . ' = :'.$field[0] . ', '; }
    $serialized_fields = substr($serialized_fields, 0, -2);

    // serialize criterium fields
	foreach($criteria as $criterium) { $criterium_fields .= ' AND ' . $criterium[0] . ' = :'.$criterium[0]; }
    $criterium_fields = substr($criterium_fields, 5);	

    // form query
	$sql = 'UPDATE ' . $table . ' SET ' . $serialized_fields . ' WHERE ' . $criterium_fields;

	foreach($criteria as $criterium) { $waarden_arr .= $criterium[0] . ': ' . $criterium[1] . "\n"; }
	foreach($fields as $field) { $waarden_arr .= $field[0] . ': ' . $field[1] . "\n"; }
	

	try {
		$conn = db_connect();
		$s = $conn->prepare($sql);

		// bind criteria
		for ($i = 0; $i < count($criteria); $i++) {
			$s->bindParam(':' . $criteria[$i][0], $criteria[$i][1], $criteria[$i][2]);
		}
		// bind fields and values
		for ($i = 0; $i < count($fields); $i++) {
			$s->bindParam(':' . $fields[$i][0], $fields[$i][1], $fields[$i][2]);
		}

		$s->execute();
   		$s = null; // Close thread
		$conn = null; // Close connection 
        return true;
	}
	
	catch(PDOException $e) {
		exception_handler($e, 'db_update');
        return false;
	}	
}



function db_insert($fields, $table) {	
	$field_values = array();
	$field_names = array();

    // when datatypes are missing, add string datatypes as default
	for ($i = 0; $i < count($fields); $i++) { if (count($fields[$i]) == 2) { $fields[$i][2] = 2; } }
	
	// serialize field names and values (and convert strings)
	foreach($fields as $field) { 
	  $field_names[] = $field[0];
	  $field_values[] = ':'.$field[0];
	}
	$serialized_field_names = implode(", ", $field_names);
	$serialized_field_values = implode(", ", $field_values);	

    // form query
	$sql = 'INSERT INTO ' . $table . ' (' . $serialized_field_names . ') VALUES (' . $serialized_field_values . ')';
	
	foreach($fields as $field) { $waarden_arr .= $field[0] . ': ' . $field[1] . "\n"; }

	try {
		$conn = db_connect();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		$s = $conn->prepare($sql);
		// bind fields and values
		for ($i = 0; $i < count($fields); $i++) {
			$s->bindParam(':' . $fields[$i][0], $fields[$i][1], $fields[$i][2]);
		}
		$s->execute();
   		$s = null; // Close thread
		$conn = null; // Close connection 
        return true;
	}
	
	catch(PDOException $e) {
		// $conn->rollback(); // draait alle queries terug (als transaction/commit in gebruik)
		//alert_email('db update error', $e, 'info@forrust.com');
		exception_handler($e, 'db_insert');
        return false;
	}	
}

function exception_handler($e, $type){
    // print error
    print($type.': '.$e);
    
    // mail error
    // $to = 'info@forrust.com';
    // $mailheaders .= 'From: WebAlert@forrust.com' ."\r\n";
    // $mailheaders .= "MIME-Version: 1.0\r\n";
    // $mailheaders .= 'Content-Transfer-Encoding: 8bit' ."\r\n";
    // $mailheaders .= 'Content-Type: text/plain; charset=UTF-8' ."\r\n";
    // $mailheaders .= 'X-Originating-IP: ' .$_SERVER["REMOTE_ADDR"] ."\r\n";
    // mail($to, 'Exeption '.$type, $e , $mailheaders,"-f " . $to);
}

?>