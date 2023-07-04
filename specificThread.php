<?php require 'partials/dbconnect.php' ?>
<?php require 'partials/navbar.php' ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Specific Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <?php 
      $id = $_GET['threadId'];
      $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result)){
        $name = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        $sql2 = "SELECT username FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['username'];
      }
    ?>
    <?php
    $showAlert = false;
      $method = $_SERVER['REQUEST_METHOD'];
      if($method == 'POST'){
        //Insert into thread db
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comment` (`comment_content`, `thread_id`, `comment_by`, 
        `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Success!</strong> You data is inserted successfully.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
      }
    ?>
    <div class="container my-4">
      <div class="jumbotron">
        <h1 class="display-4"><?php echo $name; ?></h1>
        <p class="lead"> <?php echo $desc ?> </p>
        <hr class="my-4">
        <p>This forum is only for sharing knowledge.</p>
        <p>Posted by: <?php echo $posted_by; ?></p>
      </div>
    </div>

    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">
        <h1 class="py-2">Post a Comment!</h1>
        <form action="'. $_SERVER["REQUEST_URI"]. '" method="POST">
            <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            </br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>';
    }else{
        echo '<div class="container">
          <h1 class="py-2">Post a Comment!</h1>
          <p class="lead"> You are not logged in</p>
        </div>';
    }
    ?>

    <div class="container">
      <h1>Discussion</h1>
        <?php 
            $id = $_GET['threadId'];
            $sql = "SELECT * FROM `comment` WHERE thread_id=$id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $comment_id = $row['comment_by'];
            $sql2 = "SELECT username FROM `users` WHERE sno='$comment_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="media">
                    <img src="/Bstudio/img/user.png" width="39px" class="mr-3" alt="...">
                    <div class="media-body">
                    <b>'. $row2['username']. ' at '. $comment_time . '</br></b>
                    '.$content.'
                    </div>
                    </div>';
            }
            //echo var_dump($noResult);
            if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-5">No Result found</h1>
                        <p class="lead">Be the first person to ask a question.</p>
                    </div>
                    </div>';
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
<?php require 'partials/footer.php' ?>