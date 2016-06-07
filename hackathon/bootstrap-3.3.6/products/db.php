<?php
$limit = 1;
$adjacent = 3;
$con = mysqli_connect("localhost","root","","hackathon");
if(mysqli_connect_errno()){
echo "Database did not connect";
exit();
}
?>