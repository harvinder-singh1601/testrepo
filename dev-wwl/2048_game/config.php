<?php
$conn = mysqli_connect("localhost", "winwinlabs", "winwinlabs2017", "winwinlabs_database");

if (!$conn) {
    die("Error : ".mysqli_error($conn));
}

