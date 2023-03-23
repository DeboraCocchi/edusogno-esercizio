<?php

session_start();
  include("connection.php");
  include("functions.php");

  $_SESSION['alert']='';

  $newPw=$_POST['new-pw'];
  $confPw=$_POST['confirm-pw'];
  $usermail=$_POST['usermail'];

  $sql = "SELECT * FROM utenti WHERE email='$usermail' LIMIT 1";
  $result= mysqli_query($conn, $sql);
  
  if(isset($usermail) && mysqli_num_rows($result)===0){
    $_SESSION['alert']="Questa e-mail non è presente nel nostro database";
  }elseif(!empty($confPw) && !empty($newPw) && $confPw!= $newPw){
    $_SESSION['alert']="Le password devono coincidere";
  }elseif($result && mysqli_num_rows($result)>0){
    $query="UPDATE utenti SET password='$confPw' WHERE email='$usermail'";
    $res=mysqli_query($conn, $query);
      if($res){
        $_SESSION['alert']="Password aggiornata correttamente. Puoi effettuare il login";
      }    
  }else{
    $_SESSION['alert']=''; 
  }


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edusogno</title>
    <style>
    .pw-invalid{
        color:red;
        }

    .pw-valid{
        color:green;
        }
    .blue{
        color: #0057FF;
    }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    
    <!-- <div class="bg"> -->
        <img src="assets/img/Vector 5.png" alt="vector5" id="vector-5">
        <img src="assets/img/Vector 4.png" alt="vector4" id="vector-4">
        <img src="assets/img/Vector 1.png" alt="vector1" id="vector-1">
        
        <img src="assets/img/rocket.svg" alt="rocket" id="rocket">
        <div id="circle-1" class="circle"></div>
        <div id="circle-2" class="circle"></div>
    <!-- </div> -->
    <header>
        <nav>
            <img src="assets/img/Logo-edusogno.png" alt="logo">
        </nav>
    </header>
    <main>

        <div class="container">
            <h2>
                Modifica password
            </h2>
            <div class="form-container">

                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <?php if($_SESSION['alert']):?>
                        <p style="color:red"><?php echo $_SESSION['alert'] ;?></p>
                    <?php endif ;?>
                    <label for="email">
                        Inserisci la tua e-mail
                    </label>
                    <div class="input-field">
                      <input type="email" name="usermail" placeholder="name@example.com" id="email" required>
                      <span class="focus-border"></span>
                    </div>
                   
                    <label for="new-pw">
                        Scegli una nuova password
                    </label>
                    <div class="input-field">
                      <input type="password" name="new-pw" placeholder="Inserisci una nuova password" id="new-pw" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                      <span class="focus-border"></span>
                      <i class="fa-solid fa-eye-slash" id="toggle-pw"></i>
                      <div style="font-size: 0.8rem;line-height:0.7rem;text-align: start;" class="blue" id="psw-check" >La password deve contenere almeno
                            <span class="pw-invalid" id="chars">8 caratteri</span>
                            tra cui almeno
                            <span class="pw-invalid" id="low-letters">una lettera minuscola</span> e <span class="pw-invalid" id="cap-letters">una maiuscola</span>.
                        </div>
                    </div>
                    <label for="confirm-pw">
                        Conferma password
                    </label>
                    <div class="input-field">
                      <input type="password" name="confirm-pw" placeholder="Conferma password" id="confirm-pw" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                      <span class="focus-border"></span>
                      <i class="fa-solid fa-eye-slash" id="confirm-toggle-pw"></i>
                      <div style="font-size: 0.8rem;line-height:0.7rem;text-align: start;" class="blue" id="psw-double-check">Le password
                            <span class="pw-invalid" id="identical">devono coincidere.</span></div>
                    </div>             
                    <input type="submit" id="button-l" value="CONFERMA NUOVA PASSWORD">
                   
                </form>
                <p><strong><a href="register.php">Registrati</a></strong> | <strong><a href="login.php">Accedi</a></strong></p>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    $( document ).ready(function() {
        const togglePassword = document.getElementById('toggle-pw');
        const password = document.getElementById('new-pw');
        const confTogglePassword = document.getElementById('confirm-toggle-pw');
        const confPassword = document.getElementById('confirm-pw');

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute('type', type);

            if(this.classList.contains('fa-eye-slash')){
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }else{
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        })
        confTogglePassword.addEventListener("click", function () {
            const type = confPassword.getAttribute("type") === "password" ? "text" : "password";
            confPassword.setAttribute('type', type);

            if(this.classList.contains('fa-eye-slash')){
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }else{
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        })

        const lowLetters=document.getElementById('low-letters')
        const capLetters=document.getElementById('cap-letters')
        const chars=document.getElementById('chars')
        document.getElementById("psw-check").style.display = "none";
        document.getElementById("psw-double-check").style.display = "none";

        password.onfocus = function() {
                document.getElementById("psw-check").style.display = "block";
            }
        
            password.onkeyup = function() {
            // Validate lowercase letters
            const lowerCaseLetters = /[a-z]/g;
            if(password.value.match(lowerCaseLetters)) {
                lowLetters.classList.remove("pw-invalid");
                lowLetters.classList.add("pw-valid");
            } else {
                lowLetters.classList.remove("pw-valid");
                lowLetters.classList.add("pw-invalid");
            }

            const upperCaseLetters = /[A-Z]/g;
            if(password.value.match(upperCaseLetters)) {
                capLetters.classList.remove("pw-invalid");
                capLetters.classList.add("pw-valid");
            } else {
                capLetters.classList.remove("pw-valid");
                capLetters.classList.add("pw-invalid");
            }

            if(password.value.length >= 8) {
                chars.classList.remove("pw-invalid");
                chars.classList.add("pw-valid");
            } else {
                chars.classList.remove("pw-valid");
                chars.classList.add("invalid");
            }
        }

        confPassword.onfocus = function() {
                document.getElementById("psw-double-check").style.display = "block";
            }

        confPassword.onkeyup = function() {
            // Validate vales
            if(password.value === confPassword.value) {
                console.log(true);
                identical.classList.remove("pw-invalid");
                identical.classList.add("pw-valid");
            } else {
                identical.classList.add("pw-invalid");
                identical.classList.remove("pw-valid");
            }
        }
      
    });
</script>