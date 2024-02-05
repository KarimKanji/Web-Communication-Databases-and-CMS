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

// Här kommer scriptet som hanterar adminens möjlighet att få se öppna chatsessioner
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($request_headers['customer_name'])) {
    
    $response['sofar'] = "messages?";


    $stmt = $mysqli->prepare("SELECT
    wdbcms_message.message
    FROM
        wdbcms_message
    INNER JOIN wdbcms_session ON
        wdbcms_message.chat_id = wdbcms_session.session_key
    WHERE wdbcms_session.customer_name = ?
    ORDER BY wdbcms_message.created_at ASC");

    if (!$stmt) {
        die("SQL ERROR: " . $mysqli->error);
    }


    $stmt->bind_param("s", $request_headers['customer_name']); 

    $stmt->execute();

    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    } 
    $response['result'] = $rows;

    $response['vars'] = $request_headers['customer_name'];
    
}

echo json_encode($response);

?>