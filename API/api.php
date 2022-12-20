<?php
/*
if(!($_SERVER['HTTP_REFERER'] === 'easy-online-api-test.com'
    || $_SERVER['HTTP_REFERER'] === 'http://www.easy-online-api-test.com/'
    || $_SERVER['HTTP_REFERER'] === 'https://www.easy-online-api-test.com/'
)){
    die('Unauthorized access');
}
*/

$responseArr = array();
$responseArr['Domain call'] = $_SERVER['HTTP_REFERER'];
$responseArr['Method'] = $_SERVER['REQUEST_METHOD'];
// $responseArr['text'] = 'hey there';

$putfp = fopen('php://input', 'r');
$putdata = '';
while($data = fread($putfp, 1024))
$putdata .= $data;
fclose($putfp);


$responseArr['Received data'] = $putdata;

$received_headers = array();
foreach (getallheaders() as $name => $value) {
    $item = array();
    $item["name"] = $name;
    $item["value"] = $value;
    array_push($received_headers,$item);
}

/*
$list = array();
    $row = 0;
    while($row <= 3) {
        $item = array();
        $item["id"] = $row;
        $item["name"] = "name_".$row;
        array_push($list,$item);
        $row++;
    }
    
    $responseArr['list'] = $list;
*/

$responseArr['Received headers'] = $received_headers;

header('Access-Control-Allow-Origin: *');
/*
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

*/
header("Content-Type: application/json");
echo json_encode($responseArr);
exit();
/*
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

$responseArr = array();
$responseArr['method'] = $method;

// retrieve the table and key from the path
// api.php/param0/param1/....
$param0 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param1 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param2 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param3 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param4 = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));

$servername = "localhost";
$username = "gvoguctchema";
$password = "BenitoPepe2134";
$dbname = "gvoguctchema";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
     // die("DDBB connection failed: " . $conn->connect_error);
     $resp["result"] = 'ERROR';
     $resp["errorMsg"] = "DDBB connection failed: " .$conn->connect_error;
}else{
   
    if($method == 'POST'){
        $action = $_POST['action'];
        $resp["action"] = $action;

        $resp["ip"] = $_SERVER['REMOTE_ADDR'];

        if($action=="getClinicsAmount"){
            $sql = "SELECT COUNT(*) FROM `clinics_data`";
            $resp["sql"] = $sql;
            if($conn->query($sql)){
                $resp["clinicsAmount"] = mysqli_fetch_assoc($conn->query($sql));
                $resp["result"] = 'SUCCESS';
            }       
                else
                $resp["result"] = 'ERROR';
        }

        if($action=="sqlQuery"){
            $sql = $_POST['sql'];
            $resp["sql"] = $sql;
            if($conn->query($sql)){
                $result = $conn->query($sql);
                $list = array();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $clinic = array();
                        $clinic["clinicId"] = $row["clinic_id"];
                        $clinic["id"] = $row["id"];
                        $clinic["name"] = $row["name"];
                        $clinic["address"] = $row["address"];
                        $clinic["zipcode"] = $row["zipcode"];
                        $clinic["town"] = $row["town"];
                        $clinic["state"] = $row["state"];
                        $clinic["phone"] = $row["phone"];
                        $clinic["lat"] = $row["lat"];
                        $clinic["lng"] = $row["lng"];
                        $clinic["otherInfo"] = $row["other_info"];
                        array_push($list,$clinic);
                    }
                }
                
                $resp["sql"] = $sql;
                $resp["clinicsList"] = $list;
                $resp["result"] = 'SUCCESS';
            }       
                else
                $resp["result"] = 'ERROR';
        }

        if($action=="insert"){
            $id = $_POST["id"];
            $name = $_POST["name"];
            $lat = $_POST["lat"];
            $lng = $_POST["lng"];
            $address = $_POST["address"];
            $zipcode = $_POST["zipcode"];
            $town = $_POST["town"];
            $state = $_POST["state"];
            $phone = $_POST["phone"];
            $otherInfo = $_POST["otherInfo"];
            $sql = "INSERT INTO `clinics_data` (`clinic_id`, `id`, `name`, `lat`, `lng`, `address`, `zipcode`, `town`, `state`, `phone`, `other_info`) VALUES (NULL, '".$id."', '".$name."', '".$lat."', '".$lng."', '".$address."', '".$zipcode."', '".$town."', '".$state."', '".$phone."', '".$otherInfo."');";

            $resp["sql"] = $sql;
            if($conn->query($sql))        
                $resp["result"] = 'SUCCESS';
                else
                $resp["result"] = 'ERROR';
        }
        
        if($action == "searchByCoordinates"){

            $sql = "SELECT * FROM `clinics_data` WHERE ";

            
            $sql .= "`clinic_id` != 'ABCDEF'"; // this line is to start string with it and avoid error for the res "AND"
            
            $result = $conn->query($sql);
            $list = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $distance = getDistance($row["lat"], $row["lng"], $_POST["lat"], $_POST["lng"]);
                    if($distance <= $_POST["miles"]){
                        $clinic = array();
                        $clinic["clinicId"] = $row["clinic_id"];
                        $clinic["id"] = $row["id"];
                        $clinic["name"] = $row["name"];
                        $clinic["address"] = $row["address"];
                        $clinic["zipcode"] = $row["zipcode"];
                        $clinic["town"] = $row["town"];
                        $clinic["state"] = $row["state"];
                        $clinic["phone"] = $row["phone"];
                        $clinic["lat"] = $row["lat"];
                        $clinic["lng"] = $row["lng"];
                        $clinic["otherInfo"] = $row["other_info"];
                        $clinic["distance"] = $distance;
                        array_push($list,$clinic);
                    }
                }
            }
            
            $resp["sql"] = $sql;
            $resp["clinicsList"] = $list;
            $resp["result"] = 'SUCCESS';
        }

        if($action=="search"){

            $sql = "SELECT * FROM `clinics_data` WHERE ";

            if(rtrim($_POST["clinicId"]) != "") 
                $sql .= "`clinic_id`='".$_POST["clinicId"]."'";
                else
                $sql .= "`clinic_id` != 'ABCDEF'"; // this line is to start string with it and avoid error for the res "AND"
            
            if(rtrim($_POST["id"]) != "") $sql .= " AND `id`='".$_POST["id"]."'";
            if(rtrim($_POST["name"]) != "") $sql .= " AND `name`='".$_POST["name"]."'";
            if(rtrim($_POST["address"]) != "") $sql .= " AND `address`='".$_POST["address"]."'";
            if(rtrim($_POST["zipcode"]) != "") $sql .= " AND `zipcode`='".$_POST["zipcode"]."'";
            if(rtrim($_POST["town"]) != "") $sql .= " AND `town`='".$_POST["town"]."'";
            if(rtrim($_POST["state"]) != "") $sql .= " AND `state`='".$_POST["state"]."'";
            if(rtrim($_POST["phone"]) != "") $sql .= " AND `phone`='".$_POST["phone"]."'";
            if(rtrim($_POST["lat"]) != "") $sql .= " AND `lat`='".$_POST["lat"]."'";
            if(rtrim($_POST["lng"]) != "") $sql .= " AND `lng`='".$_POST["lng"]."'";
            if(rtrim($_POST["otherInfo"]) != "") $sql .= " AND `other_info`='".$_POST["otherInfo"]."'";
            
            $result = $conn->query($sql);
            $list = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $clinic = array();
                    $clinic["clinicId"] = $row["clinic_id"];
                    $clinic["id"] = $row["id"];
                    $clinic["name"] = $row["name"];
                    $clinic["address"] = $row["address"];
                    $clinic["zipcode"] = $row["zipcode"];
                    $clinic["town"] = $row["town"];
                    $clinic["state"] = $row["state"];
                    $clinic["phone"] = $row["phone"];
                    $clinic["lat"] = $row["lat"];
                    $clinic["lng"] = $row["lng"];
                    $clinic["otherInfo"] = $row["other_info"];
                    array_push($list,$clinic);
                }
            }
            
            $resp["sql"] = $sql;
            $resp["clinicsList"] = $list;
            $resp["result"] = 'SUCCESS';
        }
    }

    header('Content-type: application/json');
    echo json_encode($resp); 
}
*/


?>