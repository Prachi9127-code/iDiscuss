<?php
$servername = "myserverdiscuss.mysql.database.azure.com";
$username = "bhhjkfgtkk";
$password ="Prachi12a";
$database = "idiscuss-database";


$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/Users/prachisharma/Downloads/DigiCertGlobalRootCA.crt (2).pem", NULL, NULL);
mysqli_real_connect($conn, "myserverdiscuss.mysql.database.azure.com", $username, $password, $database, 3306, MYSQLI_CLIENT_SSL);
// $conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
//     echo "success";
// }else{
    die("Error".mysqli_connect_error());
}
?>

