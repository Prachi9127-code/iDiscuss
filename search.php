<?php require 'partials/navbar.php' ?>
<?php require 'partials/dbconnect.php' ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss - Coding Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
        <?php 
            $noresults = true;
            $query = $_GET["search"];
            $sql = "select * from threads where match (thread_title, thread_desc) against ('$query')"; 
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $title = $row['thread_title'];
                $desc = $row['thread_desc']; 
                $thread_id= $row['thread_id'];
                $url = "threads.php?threadId=". $thread_id;
                $noresults = false;

                // Display the search result
                echo '<div class="result">
                            <h3><a href="'. $url. '" class="text-dark">'. $title. '</a> </h3>
                            <p>'. $desc .'</p>
                    </div>'; 
                }
            if ($noresults){
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No Results Found</p>
                            <p class="lead"> Suggestions: <ul>
                                    <li>Make sure that all words are spelled correctly.</li>
                                    <li>Try different keywords.</li>
                                    <li>Try more general keywords. </li></ul>
                            </p>
                        </div>
                    </div>';
            }        
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
<?php require 'partials/footer.php' ?>