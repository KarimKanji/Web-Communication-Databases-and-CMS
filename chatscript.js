var me = {};

var you = {};


// function showChat() {

//     /* var show 0 = hidden, var show 1 = visible*/
    
//     if (document.getElementById("show").style.visibility = 'hidden' )  {
//         console.log("so far");
//         document.getElementById("show").style.visibility = 'visible';
      
//     }
//     else if (document.getElementById("show").style.visibility = 'visible'){
//         console.log("so far1");
//         document.getElementsById("show").style.visibility = 'hidden';
//     }
// }

function showLogin() {
    if (document.getElementById("login").style.visibility = 'hidden' )  {
        console.log("so far3");
        document.getElementById("login").style.visibility = 'visible';
      
    }
}

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

//-- No use time. It is a javaScript effect.
function insertChat(who, text, time = 0) {
    var control = "";
    var date = formatAMPM(new Date());
    // var text = document.getElementById("typedText").value; 

    if (who == "you") {

        control =  '<li style="width:100%">' +
            '<div class="msj macro">' +
            '<div class="text text-l">' +
            '<p>' + text + '</p>' +
            '<p><small>' + date + '</small></p>' +
            '</div>' +
            '</div>' +
            '</li>';
    } else {
        control = '<li style="width:100%;">' +
            '<div class="msj-rta macro">' +
            '<div class="text text-r">' +
            '<p>' + text + '</p>' +
            '<p><small>' + date + '</small></p>' +
            '</div>' +
            '<div class="avatar" style="padding:0px 0px 0px 10px !important"></div>' +
            '</li>';
    }
    setTimeout(
        function () {
            $("ul").append(control);

        }, time);

}

function resetChat() {
    $("ul").empty();
}

$(".mytext").on("keyup", function (e) {
    if (e.which == 13) {
        var text = $(this).val();
        if (text !== "") {
            insertChat("me", text);
            $(this).val('');
        }
    }
});

//-- Clear Chat
//resetChat();

