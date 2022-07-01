<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<?php
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql ="SELECT * FROM admins WHERE id='$AdminId'";
$stmt =$ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()){
    $ExistingName = $DataRows["aname"];
    $ExistingUsername = $DataRows["username"];
      $ExistingHeadline = $DataRows["aheadline"];
        $ExistingBio = $DataRows["abio"];
          $ExistingImage = $DataRows["aimage"];

}
if(isset($_POST["Submit"])){
    $AName = $_POST["Name"];
    $AHeadline  = $_POST["Headline"];
    $ABio   = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "images/".basename($_FILES["Image"]["name"]);
  if (strlen($AHeadline)>30) {
      $_SESSION["ErrorMessage"]= "Headline should be less than 30 characters";
      Redirect_to("MyProfile.php");
    }
    elseif (strlen($ABio)>500) {
      $_SESSION["ErrorMessage"]= "Post Description Should be less than 500 characters";
      Redirect_to("MyProfile.php");
    }else {
      //Query to update post in DB When Everything is Fine
      global $ConnectingDB;
      if (!empty($_FILES["Image"]["name"])) {
          $sql = "UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
           WHERE id='$AdminId'";
      }else {
        $sql = "UPDATE admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
         WHERE id='$AdminId'";
      }
      $Execute =$ConnectingDB->Query($sql);
      move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
      if($Execute ){
        $_SESSION["SuccessMessage"]=" Details Updated Successfully";
        Redirect_to("MyProfile.php");
      }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
        Redirect_to("MyProfile.php");
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
    <link rel="stylesheet" href="css/style.css">
    <title>MyProfile</title>
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
                        <a href="MyProfile.php" class="nav-link">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="post.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Logout.php" class="nav-link">Logout</a></li>
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
                    <div class="col-md-12">
                         <h1>@<?php echo $ExistingUsername; ?></h1>
                         <small><?php echo $ExistingHeadline; ?></small>
                    </div>
                </div>
            </div>
        </header>
<!--End Header-->
<!--main area-->
    <section class="container py-2 mb-4">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="card-header bg-dark text-light">
                <h3><?php echo $ExistingName; ?></h3>
              </div>
              <div class="card-body">
                <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
              </div>
              <div class="">
                <p><?php echo $ExistingBio; ?></p>
              </div>
            </div>

          </div>
            <div class="col-md-9" style="min-height:400px;">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                      <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                      </div>
                        <div class="card-body">
                            <div class="form-group">
                              <input class="form-control" type="text" name="Name" id="title" placeholder="your name" value="">

                            </div>
                            <div class="form-group">
                              <input class="form-control" type="text"  id="title" placeholder="Headline" name="Headline">
                              <small class="text-muted">Add a Professional headline like, 'Engineer' at XYZ or 'Architect' </small>
                              <span class="text-danger">Not more then 30 characters</span>
                            </div>
                            <div class="form-group">
                                <textarea placeholder="Bio" class="form-control" id="Bio" name="Bio" rows="8" cols="80"></textarea>
                            </div>
                            <div class="form=group mb-1">
                            <div class="custom-file">
                              <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                              <label for="imageSelect" class="custom-file-label"> Select Image </label>
                            </div>
                          </div>

                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block">Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" value="submit" class="btn btn-success btn-block">
                                      Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

<!--Endmain area-->



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
