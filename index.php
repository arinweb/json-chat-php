<?php
session_start();
if (!empty($_SESSION["id"])) {
  header("Location:x.php");
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <!--Meta Verileri-->
  <meta charset="UTF-8">
  <meta http-equiv="content-language" content="tr">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="theme-color" content="#212121">
  <!--Meta Verileri-->
  <link rel="icon" type="image/png" sizes="16x16" href="FAVİCON">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <title>Online Chat Kayıt Ekranı</title>
</head>
<body>

  <form method="post">
    <div class="dialog-name">
      <b>Kullanıcı Adını Belirle</b>
      <input name="name" id="nameEdit" type="name" value="<?= $_SESSION["id"]; ?>" />
      <div>
        <button id="guncelleName" class="btn btn-sm btn-primary">Devam Et</button>
      </div>
    </div>
  </form>

  <?php

  $name = $_POST["name"];

  if ($_POST) {
    if (!empty($name)) {
      $_SESSION["id"] = $name;
      $_SESSION["color"] = substr(str_shuffle('ABCDEF0123456789'), 0, 6);
      header("Refresh:2");
      echo "<b id='noti' style='background:yellowgreen;display:block'>Sohbet Açılıyor...</b>";
    } else {
      echo "<b id='noti' style='display:block'>Boş Bırakmayın</b>";
    }
  }

  ?>


  <style>
@import url("https://fonts.googleapis.com/css?family=Oxanium");
    * {
      color: white;
      font-family: Oxanium;
    }
    #noti{
      position:fixed;
      z-index:10;
      top:0px;
      left:0px;
      right:0px;
      background:orange;
      display:none;
      }
    .dialog-name {
      position: fixed;
      z-index: 10;
      top: 0px;
      left: 0px;
      right: 0px;
      bottom: 0px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      background:#00ccff;
    }
    .dialog-name input {
      width: 80%;
      height: 40px;
      padding:10px;
      border:none;
      border-radius: 5px;
      margin: 5px;
      color: black;
    }
    .dialog-name div {
      display: flex;
    }
    .dialog-name button {
      font-size: 15px;
      padding: 10px 50px;
      display: flex;
      margin: 5px 10px;
    }
    .dialog-name-aktif {
      display: flex;
    }
    .dialog-name-pasif {
      display: none;
    }

  </style>
</body>
</html>
