<!DOCTYPE html>
<?php
session_start();
$mejlErr = $pswErr = $imeErr = $prezErr = $prijavaErr = "";
$email = "";
$psw = "";
$ime = "";
$prezime = "";
$password1 = "";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
    <title>Login</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">LOGO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="pages/home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
   Prijava
  </button>
  <ul id="prozor" class="dropdown-menu" aria-labelledby="dropdown">
  <button id="reg" onclick="document.getElementById('id02').style.display='block'">Registruj se</button>
  <button id="log" onclick="document.getElementById('id01').style.display='block'"> Prijavi se </button>
  </ul>
</div>
<ul class="navbar-nav m-auto">
                        <li class="nav-item">
                        <button id="logout" onclick=""> LogOut</button>
                        </li>
                    </ul>
        </nav>
    </header>

    <!-- modul 1 -->
    <div id="id01" class="modal">

        <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2>Login</h2>
            </div>

            <div class="container">
                <label for="email"><b>E mail:</b></label>
                <input type="email" placeholder="Unesi email" name="emailp" required>

                <label for="psw"><b>Password: </b></label>
                <input type="password" placeholder="Unesi sifru" name="passwordp" required>

                <input id="prijava" type="submit" name="prijava" value="Prijavi se" />
            </div>
            <?php echo $prijavaErr; ?>
        </form>
    </div>

    <!-- modul 2 -->
    <div id="id02" class="modal">

        <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h2>Register</h2>
            </div>

            <div class="container">
            <label for="psw"><b>Ime: </b></label>
                <input type="text" placeholder="Unesi ime" name="ime" require> <?php echo $imeErr; ?>

                <label for="psw"><b>Prezime: </b></label>
                <input type="text" placeholder="Unesi prezime" name="prezime" require> <?php echo $prezErr; ?>

                <label for="email"><b>E mail:</b></label>
                <input type="email" placeholder="Unesi email" name="email" required><?php echo $mejlErr; ?>

                <label for="psw"><b>Password: </b></label>
                <input type="password" placeholder="Unesi sifru" name="password" required> <?php echo $pswErr; ?>

                <label for="psw"><b>Ponovi password: </b></label>
                <input type="password" placeholder="Ponovi sifru" name="password1" required> <?php echo $pswErr; ?>

               

                <input id="prijava" type="submit" name="prijava" value="Regisruj se" />
            </div>
        </form>
    </div>
    <!-- modul 3 -->


    <?php
    

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        /* registracija */
        if(isset($_POST['registracija'])) {
            $email = "";
            $psw = "";
            $ime = "";
            $prezime = "";
            $password1 = "";
            /* unos u polja */
            if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password1']) && !empty($_POST['ime']) && !empty($_POST['prezime'])) {
                
                $email = $_POST['email'];
                $psw = $_POST['password'];
                $password1 = $_POST['password1'];
                $ime = $_POST['ime'];
                $prezime = $_POST['prezime'];

                if($psw != $password1) {
                    $pswErr="Sifre se ne podudaraju";
                }
                else {
                    require './baza/konekcija.php';
                    $sql = "INSERT INTO korisnik(email, password, ime, prezime) VALUES('$email', '$psw', '$ime', '$prezime')";
                    if (mysqli_query($conn, $sql)) {
                        
                    }else {
                        echo "<script>alert('Greska pri logovanju, pokusajte ponovo!');</script>";
                    }
                }
            }
        }



        if(isset($_POST['prijava'])) {
            require './baza/konekcija.php';
            $email = "";
            $psw = "";
            $ime = "";
            $prezime = "";
            if(!empty($_POST['emailp']) && !empty($_POST['passwordp'])) {
                $email = $_POST['emailp'];
                $psw = $_POST['passwordp'];

                $sql = "SELECT * FROM korisnik WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $i=0;
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $i= $i+1;
                    
						if ($psw == $row['password']){
                            $_SESSION['ime'] = $row['ime'];
                            $_SESSION['prezime'] = $row['prezime'];
							
                        }
						else
							echo "<script>alert('Pogresna lozinka, pokusajte ponovo!');</script>";
                    }
                  } else {
                    echo "<script>alert('Ovaj korisnik ne postoji, registrujte se!');</script>";
                  }
            }
        }
    }
    
    ?>

    <footer>
      
    </footer>

    <script src="./script/script.js"></script>

     <!-- JavaScript Bundle with Popper  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>