<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
 Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scake=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Comments</title>
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
                         <h1> Manage Comments</h1>
                    </div>
                </div>
            </div>
        </header>
<!--End Header-->
<!--Main Area Start-->
  <div class="container py-2 mb-4">
    <div class="row" style="min-height:30px;">
      <div class="col-lg-12" style="min-height:400px;">
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
        <h2>Un-Approved Comments</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No.</th>
              <th>Date&Time</th>
              <th>Name</th>
              <th>Comment</th>
                <th>Aprove</th>
              <th>Action</th>
              <th>Details</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
          $Execute =$ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows=$Execute->fetch()) {
            $CommentId = $DataRows["id"];
            $DateTimeOfComment = $DataRows["datetime"];
            $CommenterName = $DataRows["name"];
            $CommentContent = $DataRows["comment"];
            $CommentPostId = $DataRows["post_id"];
            $SrNo++;
          ?>
          <tbody>
            <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                  <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                <td><?php echo htmlentities($CommenterName); ?></td>
                <td><?php echo htmlentities($CommentContent); ?></td>
                <td><a href="ApproveComments.php?id=<?php echo $CommentId;?>" class="btn btn-success">Approve</a></td>
                <td><a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">Delete</a></td>
                <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
            </tr>
          </tbody>
        <?php } ?>
          </table>
          <h2>Approved Comments</h2>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No.</th>
                <th>Date&Time</th>
                <th>Name</th>
                <th>Comment</th>
                  <th>Revert</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
            $Execute =$ConnectingDB->query($sql);
            $SrNo = 0;
            while ($DataRows=$Execute->fetch()) {
              $CommentId = $DataRows["id"];
              $DateTimeOfComment = $DataRows["datetime"];
              $CommenterName = $DataRows["name"];
              $CommentContent = $DataRows["comment"];
              $CommentPostId = $DataRows["post_id"];
              $SrNo++;
            ?>
            <tbody>
              <tr>
                  <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                  <td><?php echo htmlentities($CommenterName); ?></td>
                  <td><?php echo htmlentities($CommentContent); ?></td>
                  <td><a href="DisApproveComments.php?id=<?php echo $CommentId;?>" class="btn btn-warning">Dis-Approve</a></td>
                  <td><a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">Delete</a></td>
                  <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
              </tr>
            </tbody>
          <?php } ?>
            </table>
      </div>
    </div>
  </div>
<!--Main Area End-->



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
