// rest-test js
var namn;
$(function() {
    console.log('jQuery works!');

    setInterval(getMessages(), 1000);
    setInterval(getMess(), 1000);

    $(document).on("change", "#chats", function() {
        var namn = $(this).val();
        getMess(namn);
        return namn;
     
    });


    getChats();
});


// Här är click_listener för complete_session

$(document).on("click", "#complete_session", function() {
    var namn = $("#chats").val();
    
    completeSession(namn);
    
 
});

$(document).on("click", "#pswChange", function() {
    console.log("hejjsan från pswCHange");

    $.ajax({
        type: "PUT",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/admin_backend.php/",
        data: JSON.stringify({  
            password: $("#newPsw").val()
        }),
        dataType: "json",
        success: function(data) {
            console.log(data);
        }
    }); 
 
});




$(document).on("click", "#send", function() {

    /**
     * Inloggnings-request, vi skickar användarnamn och lösenord och får en API Key i utbyte.
     * Vi skickar meddelande + namn och får api key i byte* 
     */
    $.ajax({
        type: "POST",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/testengine.php/",
        headers: {'api_key': localStorage.getItem('api_key') },
        data: JSON.stringify({ 
            "name": $("#name").val(), 
            "message": $("#typedText").val() 
        }),
        success: function(data) {
            console.log(data);
            // Vi sparar apikey i localstorage
            console.log("so far in ajax in script");
            console.log("din apiKey är: " + data.api_key);
            if (data.api_key){
            localStorage.setItem('api_key', data.api_key);
            getMessages();
            }
            
        }
    });
})


$(document).on("click", "#sendadmin", function() {

    /**
     * Inloggnings-request, vi skickar användarnamn och lösenord och får en API Key i utbyte.
     * Vi skickar meddelande + namn och får api key i byte* 
     */
     getMessages();

    $.ajax({
        type: "POST",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/adminsend.php/",
        headers: {'api_key': localStorage.getItem('api_key'), 'customer_name': namn },
        data: JSON.stringify({ 
            "name": $("#name").val(), 
            "message": $("#typedText").val() 
        }),
        success: function(data) {
            console.log(data);
            // Vi sparar apikey i localstorage
            // console.log("so far in ajax in script");
            // console.log("din apiKey är: " + data.api_key);
            // if (data.api_key){
            getMessages();
            // }
            
        }
    });
})




function getMessages() {
    // Här kan vi köra en GET-request för en specifik guestid
    // console.log("this is api_key from getMessages():" + api_key);
    console.log("so far in getMessages()");
    $.ajax({
        type: "GET",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/testengine.php/",
        headers: { 'api_key': localStorage.getItem('api_key') },
        success: function(data) {
            console.log(data);
            // $("#medelande").html('');
            $.each(data.result, function(i, value) {
                insertChat("me", value.message);
                
            });
            
        }
    });    
}

$(document).on("click", "#reset", function() {

    reset();
    location.reload();
        
});





function reset(){

    alert("Are you sure you want to reset your chat and your session? all of your messages will be deleted");
    localStorage.clear();
}

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
$(document).on("click", "#login", function() {

   
    $.ajax({
        type: "POST",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/auth.php/",
        data: JSON.stringify({ 
            "username": $("#usr").val(), 
            "password": $("#pwd").val() 
        }),
        success: function(data) {
            console.log(data);
            localStorage.setItem('apikey', data.api_key);
            if(data.api_key){
            window.location.href ="https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/admin.php";
             }
        }
    });
})

function getChats() {
    
    $.ajax({
        type: "GET",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/admin_backend.php/",
        headers: { 'api_key': localStorage.getItem('api_key') },
        success: function(data) {
            console.log(data);
            $("#chats").html('');
            $.each(data.result, function(i, value) {
                $("#chats").append('<option>'
                + value.customer_name
                + '</option>');

                // $("#customer_apikey").append('<div>' 
                // + value.api_key)
            });
        }
    });    
}

function getMess(namn) {
    console.log(namn);
    function resetChat() {
        $("ul").empty();
    }
    resetChat();
    $.ajax({
        type: "GET",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/admin_backend2.php/" ,
        headers: {'customer_name': namn},
    
        success: function(data) {
            console.log(data);
            
            $("#mess").html('');
            $.each(data.result, function(i, value) {
                insertChat("you", value.message);
            });
        }
    });    
}


function completeSession(namn) {

    console.log("this is completeSession and we are completing for user: " + namn);
    $.ajax({
        type: "DELETE",
        url: "https://cgi.arcada.fi/~kanjikar/WDCMS/wdbocms-projekt-1-kanji-bazbaz/admin_backend.php/",
        headers: {'api_key': localStorage.getItem('api_key'), 'customer_name': namn },

        success: function(data) {
            console.log(data);
            location.reload();

        }
    });
}





