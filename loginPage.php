<?php
/*
  if(isset($_COOKIE['username'])){
    header('Location: croppingPage.php');
  }
*/
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <link rel="stylesheet" href="./css/login_and_register_style.css">
      <title>Bejelentkezés</title>
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <h1>Bejelentkezés</h1>
        <form class="login-form">
          <input type="text" placeholder="felhasználó név" required idea id="username-input"/>
          <input type="password" placeholder="jelszó" required id="password-input"/>
          <button id="login-button">Bejelentkezés</button>
          <p class="message">Nincs még fiókja? <a href="./registerPage.php">Regisztráció</a></p>
        </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script>

        function getCookie(name) {
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
        }

        let usernameInput = document.querySelector('#username-input');
        let passwordInput = document.querySelector('#password-input');
        let loginButton = document.querySelector('#login-button');

        loginButton.addEventListener('click',function(){
          let username = usernameInput.value;
          let password = passwordInput.value;

          $.ajax({
              type: "POST",
              dataType: "json",
              url: "loginAction.php",
              data: {
                username: username,
                password: password
              },
              success: function() {

              }
          });
        });

        if(getCookie('passedLog') === 'true'){
          location.href = "croppingPage.php";
        }
        if(getCookie('passedLog') === 'false'){
          alert('Sikertelen bejelentkezés!');
        }

    </script>
  </body>
</html>
