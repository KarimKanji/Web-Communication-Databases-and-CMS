<?php 

 $mysqli = new mysqli("mysql.arcada.fi", "kanjikar", "sQv99j3HKx", "kanjikar");
 if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error); 

header('content-type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE");

parse_str($_SERVER['QUERY_STRING'], $request_vars);
$request_headers = apache_request_headers();

$request_json = file_get_contents('php://input');
$request_body = json_decode($request_json);

$response = [ 
    "request_method" => $_SERVER['REQUEST_METHOD'],
    "request_body" => $request_body,
    "query_string" => $_SERVER['QUERY_STRING'],
    "request_vars" => $request_vars,
    "request_headers" => $request_headers
];

// $response["message"] = "Authentication FAILED";


if ($_SERVER['REQUEST_METHOD'] == "POST"    
    && isset($request_body->username) 
    && isset($request_body->password)) {

    $api_key = authenticate($request_body->username, $request_body->password);

    if ($api_key) {
        $response["api_key"] = $api_key;
        $response["message"] = "Login OK";  
    }
}

// Man kan skapa saltade hashar i php med password_hash("Passw0rd",  PASSWORD_BCRYPT)

function authenticate($username, $password) {
    $mysqli = new mysqli("mysql.arcada.fi", "kanjikar", "sQv99j3HKx", "kanjikar");
    if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error);

    $stmt = $mysqli->prepare("SELECT password FROM wbdcms_user WHERE username = ?");


    if (!$stmt) {
        die("SQL ERROR: " . $mysqli->error);
    }
    
    
    $stmt->bind_param("s", $username); 

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    

    // Vi verifierar det inmatade lösenordet mot hashen
    if (password_verify($password, $row['password'])) {



        $session_key = sha1(rand());

        return $session_key;

   

    }
    return false;
}

echo json_encode($response);