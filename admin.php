<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN </title>
    

    <!-- Alla includes:-->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <script src="./chatscript.js"></script>

    <script src="./testscript.js"></script>


    <link rel="stylesheet" href="./chatstyle.css">

    <?php   
        // include "chatengine.php";
        // include "login.php";
        // include "testengine.php";
     ?>

</head>

<body>
    <div class="container">
    

        <h1>Administrator view</h1> 
        <h4> You are now signed in as ADMIN </h4>
        
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 " style="background-color:rgba(119, 119, 153, 0.842);"> <br>
                <p style="color:white;">Customer service window
                        <button id="complete_session" type="button" class="btn btn-primary" >Complete customer session</button>
                </p>
            </div>
        <div class="row">
            <div class="col-sm-5 " style="background-color:rgba(34, 139, 34, 0.75);"> <br>
            
                <p style="color:black;"> Här kommer en lista på öppna chatsessioner
                <select id="chats">
                    <option>-- Välj person</option>
                </select>
                <button id="pswChange" type="button" class="btn btn-primary" >ChangePsw</button>
                <input type="text" id="newPsw" placeholder="Insert new password">

                </p>
                <div id="customer_apikey"> </div>
               
               
                
            </div>
            
             
             
            </div>
        </div>
            </div>
        </div>
    </div>



    <!-- Här kommer chatten, tagen och editerad från bootsnipp.com-->
    <br>

    <div class="container">
        <div class="col-sm-5 frame">
            <ul></ul>
            <div>
                <div class="msj-rta macro" style="margin:auto">
                    <div class="text text-r" style="background:whitesmoke !important">
                        <input type="text" id="typedText" class="mytext" placeholder="Type a message" />
                    </div>
                    
                </div>
                
                <div class="col">
                    <button id="sendadmin" type="button" class="btn btn-info" >Send</button>
                </div>
            </div>
            
        </div>
    </div>
        
       
    <hr>
    

</body>

</html>