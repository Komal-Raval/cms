<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Session.php"); ?>
<?php Confirm_Login() ?>
<?php
$SearchQueryParameter = $_GET['id'];
if(isset($_POST["Submit"])){
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Upload/".basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];

    $Admin ="komal";
    date_default_timezone_set("Asia/Karachi");
    $CurrentTime=time();
    $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($PostTitle)){
        $_SESSION["ErrorMessage"]= "Title cant be empty";
        Redirect_to("Post.php");
    }elseif (strlen($PostTitle)<5) {
      $_SESSION["ErrorMessage"]= "Post title should br grester then 5 characters";
      Redirect_to("Post.php");
    }
    elseif (strlen($PostText)>9999) {
      $_SESSION["ErrorMessage"]= "Post Description Should be less than 10000 characters";
      Redirect_to("Post.php");
    }else {
      //Query to upadate post in DB When Everything is Fine
      global $ConnectingDB;
      if (!empty($_FILES["Image"]["name"])) {
          $sql = "UPDATE posts SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
           WHERE id='$SearchQueryParameter'";
      }else {
            $sql = "UPDATE posts SET title='$PostTitle', category='$Category', post='$PostText'
            WHERE id='$SearchQueryParameter'";
      }
      $Execute =$ConnectingDB->Query($sql);
      move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
      //var_dump($Execute);
  if($Execute){
        $_SESSION["SuccessMessage"]="Post updated Successfully";
        Redirect_to("Post.php");

      }else {
       $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
       Redirect_to("Post.php");
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
    <title>Edit Post</title>
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
                         <h1>Edit Post</h1>
                    </div>
                </div>
            </div>
        </header>
<!--End Header-->
<!--main area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
                <?php
                    echo ErrorMessage();
                    echo SuccessMessage();
                    //fetching existing content according to fann_descale_output
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows=$stmt->fetch()) {
                    $TitleToBeUpdated = $DataRows['title'];
                    $CategoryToBeUpdated = $DataRows['category'];
                    $ImageToBeUpdated = $DataRows['image'];
                    $PostToBeUpdated =$DataRows['post'];
                    }
                ?>


                <form class="" action="EditPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title hear" value="<?php echo $TitleToBeUpdated; ?>">
                            </div>
                            <div class="form-group">
                              <span class="FieldInfo">Existing Category: </span>
                              <?php echo $CategoryToBeUpdated; ?>
                              <br>
                                <label for="CategoryTitle"> <span class="FieldInfo"> Chose Categroy  </span></label>
                                <select class="form-control" id="CategoryTitle" name="Category">
                                  <?php
                                    //fetchinng all the categories from category mysql_list_tables
                                    global $ConnectingDB;
                                    $sql = "SELECT id,title FROM category";
                                    $stmt = $ConnectingDB->query($sql);
                                    while ($DateRows = $stmt->fetch()){
                                      $Id = $DateRows["id"];
                                      $CategoryName = $DateRows["title"];
                                    ?>
                                    <option> <?php echo $CategoryName; ?> </option>
                                  <?php } ?>
                                </select>
                            </div>
                            <div class="form=group mb-1">
                              <span class="FirldInfo">Existing Image: </span>
                              <img class="mb-1" src="Upload/<?php echo $ImageToBeUpdated;?>" width="170px"; height="70px";/>
                            <div class="custom-file">
                              <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                              <label for="imageSelect" class="custom-file-label"> Select Image </label>
                            </div>
                          </div>
                          <div class="form-group">
                              <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                              <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                  <?php echo $PostToBeUpdated;?>
                              </textarea>
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
