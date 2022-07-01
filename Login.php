<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php
  if(isset($_SESSION["UserId"])){
    Redirect_to("Dashboard.php");
  }
  if (isset($_POST["Submit"])) {
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];
    if (empty($UserName)||empty($Password)) {
      $_SESSION["ErrorMessage"]="All fields must be filled out";
      Redirect_to("Login.php");
    }else {
      $Found_Account=Login_Attempt($UserName,$Password);
      if ($Found_Account) {
         $_SESSION['UserId']=$Found_Account["id"];
         $_SESSION['UserName']=$Found_Account["username"];
         $_SESSION['AdminName']=$Found_Account["aname"];
        $_SESSION["SuccessMessage"]= "Wellcom ".$_SESSION["UserName"];
        if (isset($_SESSION["TrackingURL"])) {
          Redirect_to($_SESSION["TrackingURL"]);
        }else {
            Redirect_to("Dashboard.php");
        }

      }else {
        $_SESSION["ErrorMessage"]="Incorrect Username/Password";
        Redirect_to("Login.php");
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scake=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
    </head>
    <body>
 <!--navbar-->
        <div style="height: 10px; background-color: #27aae1;" ></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">ravalkomal.com</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsCMS">
                <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarcollapsCMS">

                    </div>
            </div>

        </nav>
        <div style="height: 10px; background-color: #27aae1;" ></div>
  <!--End navbar-->
 <!--Header-->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </header>
<!--End Header-->
<!--Main area start-->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
      <br><br><br>
      <?php
          echo ErrorMessage();
          echo SuccessMessage();
      ?>
      <div class="card bg-secondary text-light">
        <div class="card-header">
          <h4>Wellcome Back !</h4>
          </div>
          <div class="card-body bg-dark">
        <form class="" action="Login.php" method="post">
          <div class="form-group">
             <label for="username"><span class="FieldInfo">Username:</span></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text text-white bg-info"></span>
              </div>
              <input type="text" class="form-control" name="Username" id="username" value="">
            </div>
          </div>
          <div class="form-group">
             <label for="password"><span class="FieldInfo">Password:</span></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text text-white bg-info"></span>
              </div>
              <input type="password" class="form-control" name="Password" id="password" value="">
            </div>
          </div>
          <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!--Main area End-->



 <!--Footer-->
        <footer class="bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col">
                    <p class="lead text-center"> Theme by | komalraval | <span id="year"></span> &copy; ----All right Reserved. </p>
                </div>
                </div>
            </div>
        </footer>
        <div style="height: 10px; background-color: #27aae1;" ></div>
<!--end footer-->


        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
        <script>
            $('#year').text(new Date().getFullYear());
        </script>
    </body>

</html>
