<?php
/* SUPER SIMPLE CHAT SCRIPT
 * Author: Sukualam (github.com/sukualam)
 */

session_start();
date_default_timezone_set('Europe/Istanbul');
error_reporting(0);

if (empty($_SESSION["id"])) {
  header("Location:exit.php");
  /*
  $_SESSION["id"] = "USER_".rand(100, 999);
  $_SESSION["color"] = substr(str_shuffle('ABCDEF0123456789'), 0, 6);
  */
}
// create recent comment
function send_chat($nick, $chat, $color) {
  // read/write
  $filename = "chat.json";
  $fopen = fopen($filename, "r");
  $fgets = fgets($fopen);
  fclose($fopen);
  $decode = json_decode($fgets, true);
  // limit 10
  end($decode);
  if (key($decode) >= 20) {
    array_shift($decode);
    $new_key = 20;
  } else {
    $new_key = key($decode);
    $new_key++;
  }
  $format = array($nick, $chat, $color);
  $decode[$new_key] = $format;
  $encode = json_encode($decode);
  // write
  $fopen_w = fopen($filename, "w");
  fwrite($fopen_w, $encode);
  fclose($fopen_w);
}

function show_chat() {
  $filename = "chat.json";
  $fopen = fopen($filename, "r");
  $fgets = fgets($fopen);
  fclose($fopen);
  $decode = json_decode($fgets, true);
  $val .= "<table>";
  foreach ($decode as $post) {
    $val .= "<tr><td><i style=\"color:#{$post[2]};\" class=\"fas fa-user\"></i> <b style=\"color:#{$post[2]}\">{$post[0]}</b>: {$post[1]}<br></td></tr>";
  }
  $val .= "</table>";
  return $val;
}

if (isset($_POST["chat"]) && $_POST["chat"] != "") {
  $nick = $_SESSION["id"];
  $chat = htmlentities($_POST["chat"]);
  $color = $_SESSION["color"];
  send_chat($nick, $chat, $color);
}

if (isset($_GET["chat"]) && $_GET["chat"] != "") {
  echo show_chat();
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Online Chat</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script>
    setInterval(function () {
      autoloadpage();
    }, 1000); // it will call the function autoload() after each 30 seconds.
    function autoloadpage() {
      $.ajax({
        url: "?chat=1",
        type: "POST",
        success: function(data) {
          $("div#chat").html(data); // here the wrapper is main div
        }
      });
    }
  </script>
  <style>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css");
@import url("https://fonts.googleapis.com/css?family=Oxanium");
    body {
      background: #212121;
    }
    * {
      font-family: Oxanium;
      color: white;
    }
    .msg {
      list-style-type: none;
    }
    .msg .nick {
      text-shadow: 1px 2px 3px red;
    }
    .container {
      position: fixed;
      bottom: 0px;
      top: 0px;
      left: 0px;
      right: 0px;
    }
    #input-chat {
      position: fixed;
      bottom: 0px;
      left: 0px;
      right: 0px;
      padding: 5px 15px 40px 15px;
      background: #34495e;
      border-top: 2px deepskyblue solid;
    }
    #sub{
      width:40%;
      padding:10px;
    }

  </style>
</head>
<body>
  <div style="margin-top:5px" class="container">
    <div class="row">
      <div class="col-md-12" id="chat"></div>
      <div class="col-md-12">
        <form id="input-chat" action="" method="post">
          <div class="form-group">
            <label><?="<b style='color:#".$_SESSION[' color'].";'>".$_SESSION["id"]."</b> | ".date("Y.d.m H:i:s"); ?></label>
            <input type="messages" class="form-control" name="chat" /><br>
            <input ondblclick="$('#sub').attr('disabled','true');setTimeout(function(){$('#sub').removeAttr('disabled');},2000);" id="sub" class="btn btn-sm btn-primary" value="Mesaj Gönder" type="submit" />
            <a href="exit.php" class="btn btn-sm btn-primary">Oturumu Sonlandır</a>
            <i style="position:fixed;bottom:20px;right:5px;font-size:25px;z-index:10;" class="fas fa-chevron-down"></i>
          </div>
        </form>
      </div>
    </div>

  </div>
    <script>
    
      $("#sub").click(function() {
        setTimeout(function() {
          $(".form-control").val('');
        }, 100);
      });
      $("#input-chat").submit(function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
          {
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {},
            error: function(jqXHR, textStatus, errorThrown) {}
          });
        e.preventDefault(); //STOP default action
      });
      $("#input-chat").submit(); //SUBMIT FORM
    </script>
</body>
</html>

