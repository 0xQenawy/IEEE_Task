<?php

$conn = new mysqli("localhost","root","","auth_system");

if ($conn->connect_error) {
    die("Database connection failed");
}
echo "connected";

?>