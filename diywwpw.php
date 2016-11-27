<?php
/**
* Plugin Name: DIYWW Passwort Reset
* Plugin URI: http://diyww.de
* Description: DIY Werkstatt Wilhelmshaven Passwort reset
* Version: v1.0.0
* Author: Johannes Rudolph
* Author http://githup.com/PowerPan
* License: GPLv3
*/

function the_replacer($content) {

    if (strpos($content, '[diyww-passwort-forget]') !== false) {

        $form = 'eMail: <input id="email" type="text" placeholder="eMail" value="'.$email.'"/><br>
                    <input type="button" value="Passwort vergessen"  onclick="diywwSendForm()"/>'; 

        $javascript = '<script type="text/javascript">

        function diywwSendForm() { 
            var email = document.getElementById("email").value;

            var data = { email: email}

            xhr = new XMLHttpRequest();

            xhr.open("POST", "https://api.diyww.de/users/passwordforget");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(JSON.stringify(data));
        }  

        </script>';

        $content = str_replace( '[diyww-passwort-forget]' , $form.$javascript , $content);
    }
    
    
    if (strpos($content, '[diyww-passwort-reset]') !== false) {
        $token = $_GET["token"];
        $email = $_GET["email"];

        $form = 'eMail: <input id="email" type="text" placeholder="eMail" value="'.$email.'"/><br>
                    Token: <input id="token" placeholder="Token" type="text" value="'.$token.'" /><br>
                    Neues Passwort <input id="password" type="password" placeholder="" /><br>
                    <input type="button" value="Passwort zur&uuml;cksetzen"  onclick="diywwSendForm()"/>'; 

        $javascript = '<script type="text/javascript">

        function diywwSendForm() { 
            var email = document.getElementById("email").value;
            var token = document.getElementById("token").value;
            var password = document.getElementById("password").value;

            var data = { email: email, token: token, password: password }

            xhr = new XMLHttpRequest();

            xhr.open("POST", "https://api.diyww.de/users/passwordreset");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(JSON.stringify(data));

        }  

        </script>';

        $content = str_replace( '[diyww-passwort-reset]' , $form.$javascript , $content);
    }
    
    

    return $content;
}


add_filter('the_content', 'the_replacer');

?>
