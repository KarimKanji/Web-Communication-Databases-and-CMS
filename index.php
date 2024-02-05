    <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt 1 - Kundtjänst-chatt </title>
    

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
    

        <h1>Welcome to Kanji&Fallström Co.</h1> <br>
        <h4> We offer support in any matter concerning: </h4>
        <h4> Web communication </h4>
        <h4> Databases </h4>
        <h4> Content management systems</h4>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 " style="background-color:rgba(119, 119, 153, 0.842);"> <br>
                <p style="color:white;">Customer service <button id="chatbtn" type="button" class="btn btn-primary"
                        >Chat</button> 
                        <button id="reset" type="button" class="btn btn-primary" >Reset chat token</button>
                        </p>
            </div>
            <div class="col-sm-4" style="background-color:rgba(55, 180, 118, 0.842);"> <br>
                <p style="color: white;"> Sign in as admin <button type="button" class="btn btn-info"
                        onclick="showLogin()"> Admin </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Här kommer chatten, tagen och editerad från bootsnipp.com-->
    <br>

    <div class="container">
        <div id="show" class="col-sm-5 frame">
            <ul></ul>
            <div>
                <div class="msj-rta macro" style="margin:auto">
                    <div class="text text-r" style="background:whitesmoke !important">
                        <input type="text" id="typedText" class="mytext" placeholder="Type a message" />
                    </div>
                    <div class="text text-r" style="background:whitesmoke !important">
                        <input type="text" id="name" placeholder="Type your name"/>

                    </div>
                </div>
                <div class="col">
                    <button id="send" type="button" class="btn btn-info" >Send</button>
                </div>
            </div>
        </div>

    

        <!-- Här kommer admin login form-->

        <div class="col-sm-4" id="loginplace">
            <form>
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input type="text" class="form-control" name="usr" id="usr">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" name="pwd" id="pwd">
                </div>
                <div>
                    <!-- <input type="hidden" name="stage" value="login"> -->
                    <button id="login" type="button" class="btn btn-primary">Login</button>

                </div>
            </form>
        </div>
    </div>


</body>

</html>