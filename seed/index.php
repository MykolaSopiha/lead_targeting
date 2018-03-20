<?php

require '../libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=ipdatabase',
    'root', '' );

$data = $_POST;
$errors = [];


function storeIP($str, $conn) {
    $sql = "SELECT id FROM ips WHERE adress = " . $str;
    $result = $conn->query($sql);
    
    if ($result->num_rows == 0) {
        
        $sql = "INSERT INTO ips (adress) VALUES ('" . $str . "')";
        
        if ($conn->query($sql) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
        
    } else {
        return FALSE;
    }
}


if (isset($data['ips'])) {
    
    $text = preg_replace('/[ ]{2,}|[\t]|[\r]/', ' ', trim($data['ips']));
    $text = str_replace(' ', '', $text);
    $lines = explode("\n", $text);
    
    echo '<pre>';
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ipdatabase";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    foreach ($lines as $line) {
        
        $digits = explode('.', $line);
        
        if (strpos($digits[3], '/') == false) {
            storeIP($line, $conn);
        } else {
            $range = explode('/', $digits[3]);
            
            if ($range[0] > $range[1]) {
                $rangeStart = intval($range[1]);
                $rangeEnd = intval($range[0]);
            } else {
                $rangeStart = intval($range[0]);
                $rangeEnd = intval($range[1]);
            }

            for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                storeIP($digits[0].'.'.$digits[1].'.'.$digits[2].'.'.$i, $conn);
            }
        }
    }
    
    $conn->close();
    
} else {
    $errors[] = 'No data found!';
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Seeder</title>
    </head>
    <body>

    	<form action="#" method="post">
    		<div>
    			<textarea rows="10" cols="10" name="ips"></textarea>
    		</div>
    		<div>
    			<input type="submit" name="go_send" value="Send!" />
    		</div>
    	</form>


<?php

if (empty($errors)) {
    echo "No errors. Data saved!";
}

?>


    </body>
</html>