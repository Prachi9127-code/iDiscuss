<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

//connect to the Database
$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
echo "<br>";
// Die if connection was not successful
if(!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `note` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);

    if($result){
        $delete = true;
    }else{
        echo "The record was not deleted successfully because of this error -----> ". mysqli_error($conn);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['snoEdit'])){
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
      
        $sql = "UPDATE `note` SET `title` = '$title', `description` = '$description' WHERE `sno` = '$sno'";
        $result = mysqli_query($conn, $sql);
        if($result){
            $update = true;
        }else{
            echo "The record was not updated successfully because of this error -----> ". mysqli_error($conn);
        }
    }else{
        $title = $_POST["title"];
        $description = $_POST["description"];

        $sql = "INSERT INTO `note` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        //Add a new data to the table
        if($result){
            $insert = true;
        }else{
            echo "The record was not added successfully because of this error -----> ". mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>iNote</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Footer-with-Pricing.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Brand-icons.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

</head>

<body style="background: #f3f4f5;border-bottom-width: 1px;border-bottom-style: solid;">
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit this note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="/Bstudio/index.php" method="post">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3">
                        <label for="title">Note Title</label>
                        <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
                        <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                            rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span>iNote</span></a><button
                class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div id="navcol-1" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul><button class="btn btn-primary" type="button">Login</button><button class="btn btn-primary" type="button"
                    style="border-color: var(--bs-indigo);background: rgb(1,46,113);margin: 5px;">Signup</button>
            </div>
        </div>
    </nav> -->
    <?php require 'partials/navbar.php' ?>
<?php
    if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note is inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note is updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    if($delete){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Deleted!</strong> Your note is deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
?>
    <section><img class="img-fluid d-md-none" src="assets/img/hero-mobile.png">
        <div data-bss-scroll-zoom="true" data-bss-scroll-zoom-speed="1"
            style="background-image: url(&quot;assets/img/hero.jpeg&quot;);background-position: center;background-size: cover;">
            <div class="d-flex flex-column justify-content-center align-items-center hero-content"
                style="padding-left: 5px;padding-right: 15px;padding-bottom: 11px;padding-top: 10px;">
                <form action="/Bstudio/index.php" method="post">
                    <h2>Add a Note</h2>
                    <div class="mb-3">
                        <label for="title">Note Title</label>
                        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Note Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                            rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
                <!-- <h1 class="display-1 fw-bold" style="padding-right: 0px;margin-left: -1px;text-align: center;">One app, all<br>&nbsp;things money</h1>
                <p style="text-align: center;">From easy money management, to travel perks and investments. <br>Open your account in a flash.</p><button class="btn btn-primary" type="button">Get a free account</button> -->
            </div>
            <div class="container">
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 16px;">
                    <div class="card"><img class="card-img w-100 d-block" src="assets/img/payments.jpeg">
                        <div class="card-img-overlay" style="padding: 24px;">
                            <!-- <h4>Pay and get paid, hassle-free</h4>
                            <p>Send and request money with a tap, split bills easily with anyone in 200+ countries.</p><button class="btn btn-primary" type="button">Explore easy payments&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;</button> -->
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM `note`";
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $sno = $sno + 1;
                                        echo "<tr>
                                        <th scope='row'>". $sno."</th>
                                        <td>". $row['title']."</td>
                                        <td>". $row['description']. "</td>
                                        <td> <button class='edit btn btn-sm btn-warning' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['sno']. ">Delete</button> </td>
                                    </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 15px;">
                    <div class="card"><img class="card-img w-100 d-block" src="assets/img/savings.jpeg">
                        <div class="card-img-overlay" style="padding: 24px;">
                            <!-- <h4>Pay and get paid, hassle-free</h4>
                            <p>Send and request money with a tap, split bills easily with anyone in 200+ countries.</p><button class="btn btn-primary" type="button">Explore easy payments&nbsp;<i class="fas fa-arrow-right"></i>&nbsp;</button> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card"><img class="card-img w-100 d-block" src="assets/img/rewards.jpeg">
                        <div class="card-img-overlay" style="padding: 24px;">
                            <h4>Pay and get paid, hassle-free</h4>
                            <p>Send and request money with a tap, split bills easily with anyone in 200+ countries.</p>
                            <button class="btn btn-primary" type="button">Explore easy payments&nbsp;<i
                                    class="fas fa-arrow-right"></i>&nbsp;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'partials/footer.php'?>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=> {
            element.addEventListener("click", (e) => {
                console.log("edit", );
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        }) 

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=> {
            element.addEventListener("click", (e) => {
                console.log("edit", );
                sno = e.target.id.substr(1,);
                if(confirm("Press a button!")){
                    console.log("yes");
                    window.location = `/Bstudio/index.php?delete=${sno}`;
                }else{
                    console.log("no");  
                }
            })
        }) 
    </script>
</body>
</html>