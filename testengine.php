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

// HÄR KOMMER IF SATSEN SOM HANTERAR IFALL ANVÄNDAREN SKRIVER FÖR FÖRSTA GÅNGEN
// ETT MEDDELANDE OCH DERAS NAMN:
// Obs Satsen tar alltså in bodyn's namn och message och med hjälp av dem registrerar användaren till databasen och returnerar en api_key som 
// Sparas i localstorage

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($request_body->name) && isset($request_body->message)) {

        

        if (!isset($request_headers['api_key']) || strlen($request_headers['api_key']) < 10){
                $api_key = makeApi();

                if ($api_key) {
                    $response["api_key"] = $api_key;
                    $response["message"] = "Message send ok";  
                }
                // $response["status"] = "failed";

                $user_id = $request_body->name;
                $customer_name = $request_body->name;
                $message = $request_body->message;

                $stmt1 = $mysqli->prepare("INSERT
                INTO wdbcms_message (
                    chat_id,
                     message)
                VALUES (
                    ?,
                    ?)");
                $stmt1->bind_param("ss",
                        $session_key,
                        $comment
                                );
                $stmt1->execute();


                $stmt = $mysqli->prepare("INSERT
                INTO wdbcms_session (
                    session_key,
                    user_id,
                    customer_name)
                VALUES (
                    ?,
                    ?,
                    ?
                    )");


                    if (!$stmt) {
                            die("SQL ERROR: " . $mysqli->error);
                        }
                        
                        $stmt->bind_param("sss", 
                                $api_key,
                                $user_id,
                                $customer_name   
                            );

                            $stmt->execute();
                        }

        elseif (isset($request_headers['api_key'])){
            
            $chat_id = $request_headers['api_key'];
            $author_id = $request_body->name;
            $message = $request_body->message;
            

            $stmt = $mysqli->prepare("INSERT
            INTO wdbcms_message (
                chat_id,
                author_id,
                message)
            VALUES (
                ?,
                ?,
                ?
                )");


                if (!$stmt) {
                        die("SQL ERROR: " . $mysqli->error);
                    }
                    
                    $stmt->bind_param("sss", 
                            $chat_id,
                            $author_id,
                            $message   
                        );

                        $stmt->execute();

                $response['status'] = "message saved in DB";
                $response["api_key"] = $chat_id;
        }
    
}


// HÄR KOMMER IF SATSEN SOM HANTERAR IFALL EN ANVÄNDARE REDAN HAR STARTAT EN CHATTSESSION
// SATSEN FÅR ANVÄNDAREN api_key OCH MED HJÄLP AV DEN RETURNERAR DEN MEDDELANDEN OCH REGISTRERAR NYA MEDDELANDEN UNDER
// RÄTT CHATTSESSION I DATABASEN:
// Ergo inga mer duplicate api_keys för en och samma session aka "spam av send fyller int upp databasen :)"
// && isset($request_headers['api_key'])
elseif ($_SERVER['REQUEST_METHOD'] == "GET" && isset($request_headers['api_key'])) {
        // $response["working"] = "yes";
        // print("hello world");
        // Använd API Keyn föra att få användarens bokningar
        $stmt = $mysqli->prepare("SELECT
        message
        FROM
        wdbcms_message
        WHERE
        chat_id =  ?");

        // if (!$stmt) die("SQL ERROR: " . $mysqli->error);

        $api_key = $request_headers['api_key'];

        $stmt->bind_param("s", $api_key);

        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
        }    

        $response["result"] = $rows;

}




function makeApi() {


    // create_conn();
    $api_key = sha1(rand());
   
    return $api_key;
     
}






echo json_encode($response);
