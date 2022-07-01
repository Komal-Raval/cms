<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scake=1.0">
    <meta http-equiv="X-UA-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Posts</title>
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
                         <h1> Blog Post</h1>
                    </div>
                    <div class="col-lg-3 mb-2">
                      <a href="AddNewPost.php" class="btn btn-primary btn-block"> Add New Post</a>
                    </div>
                    <div class="col-lg-3 mb-2">
                      <a href="Categories.php" class="btn btn-info btn-block"> Add New Category</a>
                    </div>
                    <div class="col-lg-3 mb-2">
                      <a href="Admins.php" class="btn btn-warning btn-block"> Add New Admin</a>
                    </div>
                    <div class="col-lg-3 mb-2">
                      <a href="Comments.php" class="btn btn-success btn-block"> Add New Comments</a>
                    </div>

                </div>
            </div>
        </header>
<!--End Header-->
<!--Main area end-->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="col-lg-12">
      <?php
          echo ErrorMessage();
          echo SuccessMessage();
      ?>
      <table class="table table-striped table-hover\">
        <thead class="thead-dark">
        <tr>
          <th>#</th>
            <th>Title</th>
              <th>Category</th>
                <th>Date&Time</th>
                  <th>Author</th>
                    <th>Banner</th>
                    <th>Comments</th>
                    <th>Action</th>
                    <th>Live Preview</th>
            </tr>
          </thead>
              <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM posts order by id desc";
                  $stmt = $ConnectingDB->query($sql);
                  $Sr = 0;
                  while ($DataRows = $stmt->fetch()) {
                    $Id         = $DataRows["id"];
                    $DateTime   = $DataRows["datetime"];
                    $PostTitle   = $DataRows["title"];
                    $Category   = $DataRows["category"];
                    $Admin   = $DataRows["author"];
                    $Image   = $DataRows["image"];
                    $PostText   = $DataRows["post"];
                    $Sr++;
                  ?>
                  <tbody>
                  <tr>
                    <td><?php echo $Sr;?></td>
                    <td>
                      <?php if (strlen($PostTitle)>20){$PostTitle= substr($PostTitle,0,18).'..';}
                      echo $PostTitle;?>
                    </td>
                    <td>
                      <?php if (strlen($DateTime)>11){$DateTime= substr($DateTime,0,13).'..';} echo $Category;?>
                    </td>
                    <td><?php echo $DateTime;?></td>
                    <td><?php echo $Admin;?></td>
                    <td><img src="Upload/<?php echo $Image ;?>" width="170px;" height="50px;"</td>
                    <td>
                        <?php  $Total =ApproveCommentsAccordingtoPost($Id);
                          if ($Total>0){
                            ?>
                            <span class="badge badge-success">
                              <?php
                                echo $Total;  ?>
                                  </span>
                              <?php } ?>
                            </span>
                            <?php  $Total =DisApproveCommentsAccordingtoPost($Id);
                              if ($Total>0){
                                ?>
                                <span class="badge badge-danger">
                                  <?php
                                    echo $Total;  ?>
                                      </span>
                                  <?php } ?>
                                </span>

                    </td>
                    <td>
                      <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                        <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                    </td>
                    <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
                      </td>
                  </tr>
                </tbody>
                <?php }?>
      </table>

    </div>
  </div>
</section>
<!--End main area-->

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
