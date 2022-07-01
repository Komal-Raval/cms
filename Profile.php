<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php
  $SearchQueryParameter = $_GET["username"];
  global $ConnectingDB;
  $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
  $stmt =$ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $SearchQueryParameter);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if($Result==1) {
    while ($DataRows = $stmt->fetch()) {
      $ExistingName = $DataRows["aname"];
      $ExistingBio = $DataRows["abio"];
      $ExistingImage = $DataRows["aimage"];
      $ExistingHeadline = $DataRows["aheadline"];
    }
  }else {
    $_SESSION["ErrorMessage"]="Bad Request !!";
    Redirect_to("Blog.php?page=1");
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
    <title>Profile</title>
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
                     <ul class="navbar-nav mr-auto">
                         <li class="nav-item">
                             <a href="Blog.php" class="nav-link">Home</a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a href="Blog.php?page=1" class="nav-link">Blog</a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link">Contact Us</a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link">Features</a>
                         </li>
                     </ul>
                     <ul class="navbar-nav ml-auto">
                         <form class="form-inline d-none d-sm-block" action="Blog.php">
                           <div class="form-group">
                           <input class="form-control mr-2" type="text" name="Search" placeholder="Type Hear" value="">
                           <button  class="btn btn-primary" name="SearchButton">Go</button>

                         </div>
                         </form>
                     </ul>
                         </div>
                 </div>

             </nav>
             <div style="height: 10px; background-color: #27aae1;" ></div>
       <!--End navbar-->
 <!--Header-->
        <header class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                         <h1> <?php echo $ExistingName; ?> </h1>
                         <h3><?php echo $ExistingHeadline; ?></h3>
                    </div>
                </div>
            </div>
        </header>
<!--End Header-->
<br>
<section class="container py-2 mb-4">
  <div class="row">
    <div class="col-md-3">
      <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
    </div>
    <div class="col-md-9" style="min-height:400px;">
      <div class="card">
        <div class="card-body">
          <p class="lead"><?php echo $ExistingBio; ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
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
