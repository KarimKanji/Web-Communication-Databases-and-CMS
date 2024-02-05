<?php 

// include("../../../../../local/mysql_env_real.php");
// $mysqli = new mysqli("mysql.arcada.fi", MYSQLUSER, MYSQLPASS, MYSQLUSER);
// if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error);
 

 $mysqli = new mysqli("mysql.arcada.fi", "kanjikar", "sQv99j3HKx", "kanjikar");
 if ($mysqli->connect_error) die("MySQL Connect ERROR:" . $mysqli->connect_error); 

// include "init.php";

header('content-type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, GET, OPTIONS, DELETE");

// Spara URL-variablerna ur query string i array $request_vars
parse_str($_SERVER['QUERY_STRING'], $request_vars);
$request_headers = apache_request_headers();

// Hämta data från request body och spara i array $request_body
$request_json = file_get_contents('php://input');
$request_body = json_decode($request_json);

$response = [ 
    "request_method" => $_SERVER['REQUEST_METHOD'],
    "request_body" => $request_body,
    "query_string" => $_SERVER['QUERY_STRING'],
    "request_vars" => $request_vars,
    "request_headers" => $request_headers
];


if ($_SERVER['REQUEST_METHOD'] == "GET" && !isset($request_vars["customer_name"])) {
    
   $response['sofar'] = "so far in admin_backend";

    $stmt = $mysqli->prepare("SELECT
    customer_name
    FROM
    wdbcms_session
    ORDER BY id DESC");

    if (!$stmt) {
        die("SQL ERROR: " . $mysqli->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }    

    $response["result"] = $rows;

}


// Här kommer complete_session php scriptet,
// Scriptet "slutar" en session då kunden är nöjd

if ($_SERVER['REQUEST_METHOD'] == "DELETE" ) {

    $response['sofar'] = "so far in complete_session";

    $stmt = $mysqli->prepare("DELETE
    FROM
    wdbcms_session
    WHERE user_id = ?");

    if (!$stmt) {
        die("SQL ERROR: " . $mysqli->error);
    }

    $stmt->bind_param("s", $request_headers['customer_name']); 


    $stmt->execute();
   
}

if ($_SERVER['REQUEST_METHOD'] == "PUT") {

    $response["result"] = "PUT works!";
    $password = $request_body->password;
    $pass = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("UPDATE wbdcms_user SET
    password = ?
    WHERE username = 'basse'");
    if (!$stmt) {
        die("SQL ERROR: " . $mysqli->error);
    }
    $stmt->bind_param("s", 
        $pass
    );

    $stmt->execute();

    $response['Status'] = "Password changed";
}
echo json_encode($response);

?>