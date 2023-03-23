<?php
session_start();

    include("connection.php");
    include("functions.php");

    // if($_SERVER['REQUEST_METHOD']==="POST"){
    //     $nome=$_POST['nome'];
    //     $cognome=$_POST['cognome'];
    //     $email=$_POST['email'];
    //     $password=$_POST['password'];


    //     $readValue = "SELECT `email` FROM utenti WHERE email='$email'";

    //     $res= mysqli_query($conn, $readValue);
    //     if($res && mysqli_num_rows($res)>0){
    //         header("Location:login.php");
    //         die();
    //     }else{
    //         if(!empty($nome)&& !empty($cognome) && !empty($email) && !empty($password) && !is_numeric($nome) && !is_numeric($cognome)){

    //             $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES
    //             ('$nome', '$cognome','$email','$password')";
    //             mysqli_query($conn, $sql);
    
    //             header("Location:index.php");
    //             die();
    //         }else{
    //             echo 'Inserire i dati nel formato corretto';
    //         }
    //     }

        

    // }

    if($_SERVER['REQUEST_METHOD']==="POST"){
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $email=$_POST['email'];
        $password=$_POST['password'];


        $readValue = "SELECT `email` FROM utenti WHERE email='$email'";

        $res= mysqli_query($conn, $readValue);

        if((mysqli_num_rows($res)==0) && (!empty($nome)&& !empty($cognome) && !empty($email) && !empty($password) && !is_numeric($nome) && !is_numeric($cognome))){
            $sql = "INSERT INTO utenti (nome, cognome, email, password) VALUES('$nome', '$cognome','$email','$password')";
            mysqli_query($conn, $sql);
            $_SESSION['new-user']="Nuovo utente registrato correttamente";
            header("Location:index.php");
            die();
        }
    }


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
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
            Crea il tuo account
        </h2>
        <div class="form-container">            
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                    <label for="nome">
                        Inserisci il nome
                    </label>
                    <div class="input-field">
                        <input type="text" name="nome" placeholder="Mario" id="nome" required>
                        <span class="focus-border"></span>
                    </div>
                    <label for="cognome">
                        Inserisci il cognome
                    </label>
                    <div class="input-field">
                        <input type="text" name="cognome" placeholder="Rossi" id="cognome" required>
                        <span class="focus-border"></span>
                    </div>
                    <label for="email">
                        Inserisci l'email
                    </label>
                    <div class="input-field">
                        <input type="email" name="email" placeholder="name@example.com" id="email" required>
                        <span class="focus-border"></span>
                    </div>
                     <label for="password">
                         Inserisci la password
                     </label>
                    <div class="input-field">
                        <input type="password" name="password" placeholder="Scrivila qui" id="password" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                        <span class="focus-border"></span>
                        <i class="fa-solid fa-eye-slash" id="toggle-pw"></i>

                        <div style="font-size: 0.8rem;line-height:0.7rem;text-align: start;" class="blue" id="psw-check">La password deve contenere almeno
                            <span class="pw-invalid" id="chars">8 caratteri</span>
                            tra cui almeno
                            <span class="pw-invalid" id="low-letters">una lettera minuscola</span> e <span class="pw-invalid" id="cap-letters">una maiuscola</span>.
                        </div>
                    </div>
                    <input type="submit" value="REGISTRATI" id="button-r">
                </form>
                <p>Hai gi&agrave; un account? <strong><a href="login.php">Accedi</a></strong></p>
            </div>
        </div>
    </main>
 </body>

</html>



<script>
    $( document ).ready(function() {
        const togglePassword = document.getElementById('toggle-pw');
        const password = document.getElementById('password');
        const lowLetters=document.getElementById('low-letters')
        const capLetters=document.getElementById('cap-letters')
        const chars=document.getElementById('chars')
        document.getElementById("psw-check").style.display = "none";

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


      
    });
</script>