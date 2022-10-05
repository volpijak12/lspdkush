<?php
session_start();
$servername = "";
$username = "";
$password = "";
$db = "";

try
{
  $conn = new PDO("mysql:host=$servername;dbname=$db",$username,$password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


if(isset($_SESSION['user_login']))
{
    echo"<script>window.location.href='index1.php';</script>";
}
else{
    //echo"<script>window.location.href='index.php';</script>";
}

if(isset($_POST['submit']))
{
        $email=$_POST['email'];
        $password=$_POST['password'];

        $sql = $conn->prepare("SELECT COUNT(*) AS `total` FROM `users` WHERE email = :email");
        $sql->execute(array(':email' => $email));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
          $sql = "SELECT * from users WHERE email='$email' AND `password`='$password'";
          $result=$conn->query($sql);
          while($row = $result->fetch())
          {
              $_SESSION['user_login']      = true;
              $_SESSION['user_id']         = $row['id'];
              echo"<script>window.location.href='index1.php';</script>";
          }
          $err_message = "Password o Mail sbagliata";
        }
        else
        {
              $err_message = "l'utente non esiste, se dovresti avere l'accesso contatta volpi_jak#4443.";
        }

}
else{
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <title>LSPD | ADMINLOGIN</title>
</head>
  <li><a href="https://lspdkush.ml/index.html" >home </a>
<body>

<?php include_once("includes/navbar.inc.php");?>

<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
            <?php
            if(isset($err_message))
            {
            ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errore!</strong> <?=$err_message;?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
            }
            ?>
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>
                <form class="mx-1 mx-md-4" method="POST" action="">
                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" name="email" id="form-email" class="form-control" placeholder="Your Email"/>
                    </div>
                  </div>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" name="password" id="form-pass" class="form-control" placeholder="Password"/>
                    </div>
                  </div>
                  <div class="d-grid form-outline flex-fill">
                    <button type="submit" class="btn btn-primary" name="submit">Login</button>
                  </div>
                </form>
              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="img.jpg" class="img-fluid" alt="Sample image" height="100">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


</body>
</html>