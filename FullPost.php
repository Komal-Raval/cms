<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php
if(isset($_POST["Submit"])){
    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }elseif (strlen($Comment)>200) {
      $_SESSION["ErrorMessage"]= "comment length should be less then 500 characters";
        Redirect_to("FullPost.php?id={$SearchQueryParameter}");
          }
    else {
      global $ConnectingDB;
      $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
      $sql .="VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:PostIdFromURL)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindvalue(':dateTime', $DateTime);
      $stmt->bindvalue(':name', $Name);
      $stmt->bindvalue(':email', $Email);
      $stmt->bindvalue(':comment', $Comment);
      $stmt->bindvalue(':PostIdFromURL', $SearchQueryParameter);
      $Execute=$stmt->execute();
      //var_dump($Execute);

      if($Execute ){
        $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
          Redirect_to("FullPost.php?id={$SearchQueryParameter}");
      }else {
        $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
          Redirect_to("FullPost.php?id={$SearchQueryParameter}");
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
    <title>Blog Page</title>
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
                        <a href="Blog.php" class="nav-link">Blog</a>
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
      <div class="container">
        <div class="row mt-4">
          <!--main area start-->
          <div class="col-sm-8">
            <h1>The complete Responsive CMS Blog</h1>
            <h1 class="lead">The complete blog by using PHP by Komal Raval</h1>
            <?php
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
            <?php
            global $ConnectingDB;
              if(isset($_GET["SearchButton"])){
                  $Search = $_GET["Search"];
                  $sql = "SELECT * FROM posts
                  WHERE datetime LIKE :search
                  OR title LIKE :search
                  OR category LIKE :search
                  OR post LIKE :search";
                  $stmt = $ConnectingDB->prepare($sql);
                  $stmt->bindValue(':search','%'.$Search.'%');
                  $stmt->execute();
              }
              else {
                $PostIdFromURL = $_GET["id"];
                if (!isset($PostIdFromURL)) {
                  $_SESSION["ErrorMessage"]="Bas Request !";
                  Redirect_to("Blog.php");
                }
                $sql = "SELECT  * FROM posts WHERE id= '$PostIdFromURL'";
                $stmt =$ConnectingDB->query($sql);

              }
                while ($DataRows = $stmt->fetch()) {
                $PostId    = $DataRows["id"];
                $DateTime    = $DataRows["datetime"];
                $PostTitle    = $DataRows["title"];
                $Category    = $DataRows["category"];
                $Admin    = $DataRows["author"];
                $Image    = $DataRows["image"];
                $PostDescription    = $DataRows["post"];
             ?>
             <div class="card">
               <img src="Upload/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
               <div class="card-body">
                 <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                  <small class="text-muted">Category: <span class="text-dark"> <?php echo htmlentities($Category); ?> </span> & Written by <span class="text-dark"> <?php echo htmlentities($Admin); ?> </span> on <?php echo htmlentities($DateTime);?></small>
                 <hr>
                 <p class="card-text">
                   <?php  echo htmlentities($PostDescription); ?></p>

               </div>
          </div>
             <?php } ?>
             <!--comment part start-->
             <!--fetching existing comment start-->
             <br>
               <b><span class="FieldInfo">Comments</span></b>
               <br><br>
             <?php
             global $ConnectingDB;
             $sql = "SELECT * FROM comments
             WHERE post_id='$SearchQueryParameter' AND status='ON'";
             $stmt =$ConnectingDB->query($sql);
             while ($DataRows =$stmt->fetch()) {
               $CommentData = $DataRows['datetime'];
               $CommenterName = $DataRows['name'];
               $CommentContent = $DataRows['comment'];
              ?>
              <div>

                <div class="media CommentBlock">
                  <img class="d-block img-fluid align-self-start" src="images/user.png" alt="user"/>
                  <div class="media-body ml-2">
                    <h6 class="lead"><?php echo $CommenterName; ?></h6>
                    <p class="small"><?php echo $CommentData; ?></p>
                    <p><?php echo $CommentContent; ?></p>
                  </div>

                </div>
              </div>
              <hr>
            <?php } ?>
                <!--fetching existing comment End-->
             <div class="">
               <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>;" method="post">
                 <div class="card mb-3">
                   <div class="card-header">
                    <h5 class="FieldInfo">Share your thougts about this post</h5>
                   </div>
                   <div class="card-body">
                     <div class="form-group">
                       <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                       </div>
                     </div>
                     <div class="form-group">
                       <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"></span>
                          </div>
                          <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="">
                       </div>
                     </div>
                     <div class="form-group">
                       <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                     </div>
                     <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                   </div>
                 </div>

               </form>
               </div>
             <!--comment part end-->

          </div>
<!--End main area start-->
<!--Side area end-->
<div class="col-sm-4">
  <div class="card mt-4">
    <div class="card-body">
      <img src="images\How-to-Start-a-Blog.webp" class="d-block img-fluid mb-3" alt="">
      <div class="text-center">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
        </div>
    </div>
  </div>
  <br>
  <div class="card">
    <div class="card-header bg-dark text-light">
      <h2 class="lead">Sign Up</h2>
    </div>
    <div class="card-body">
      <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
      <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
          <div class="input-group-append">
            <button type="button" class="btn btn-primary btn-block text-center text-white" name="button">Subscribe Now</button>
          </div>
        </div>
    </div>
  </div>
<br>
<div class="card">
  <div class="card-header bg-primary text-light">
    <h2 class="lead">Categories</h2>
    </div>
    <div class="card-body">
      <?php
        global $ConnectingDB;
        $sql = "SELECT *FROM category ORDER BY id desc";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
            $CategoryId = $DataRows["id"];
            $CategoryName = $DataRows["title"];
      ?>
    <a href="Blog.php?category=<?php echo $CategoryName; ?>"> <span class="heading"><?php echo $CategoryName; ?></span><br>
    <?php } ?>

  </div>
</div>
<br>
<div class="card">
  <div class="card-header bg-info text-white">
    <h2 class="lead">Recent Posts</h2>
  </div>
  <div class="card-body">
    <?php
      global $ConnectingDB;
      $sql= "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
      $stmt=$ConnectingDB->query($sql);
      while ($DataRows=$stmt->fetch()){
        $Id = $DataRows['id'];
        $Title = $DataRows['title'];
        $DateTime = $DataRows['datetime'];
        $Image = $DataRows['image'];
      ?>
      <div class="media">
        <img src="Upload/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
        <div class="media-body ml-2">
            <a href="FullPost.php?id<?php echo htmlentities($Id);?>" target="_blank"><h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
            <p class="small"><?php echo htmlentities($DateTime); ?></p>
        </div>
      </div>
      <hr>
    <?php   } ?>
  </div>
</div>

</div>
<!--End Side area end-->


      </div>
<!--End Header-->

           <br>

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
