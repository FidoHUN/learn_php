<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <link rel="stylesheet" href="./css/login_and_register_style.css">
      <title>Regisztráció</title>
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <h1>Regisztráció</h1>
        <form class="login-form">
          <input type="text" placeholder="felhasználó név" id="username-input"/>
          <input type="password" placeholder="jelszó" id="password-input"/>
          <input type="password" placeholder="jelszó újra" id="password-again-input"/>
          <button id="registration-button">Regisztráció</button>
          <p class="message">Már van fiókja? <a href="./loginPage.php">Bejelentkezés</a></p>
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
        let passwordAgainInput = document.querySelector('#password-again-input');
        let registrationButton = document.querySelector('#registration-button');

        registrationButton.addEventListener('click',function(){
          let username = usernameInput.value;
          let password = passwordInput.value;
          let passwordAgain = passwordAgainInput.value;
          let greenlight = true;

          if(username === '' || password === '' || passwordAgain === ''){
            alert('Minden mezőt kötelező kitölteni!');
            greenlight = false;
          }
          if(password !== passwordAgain){
            alert('A két jelszó nem egyezik!');
            greenlight = false;
          }
          if(greenlight){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "registerAction.php",
                data: {
                  username: username,
                  password: password
                },
                success: function() {}
            });
          }
        });

        if(getCookie('passedReg') === 'true'){
          alert('Sikeres regisztráció');
        }
        if(getCookie('passedReg') === 'false'){
          alert('A név már foglalt!');
        }
    </script>
  </body>
</html>
