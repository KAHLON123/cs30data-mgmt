<?php
$conn = mysqli_connect('localhost', 'forDataMgmt', 'dataMGMT141312', 'data-mgmt');

if (!$conn) {
    echo 'CONNECTION ERROR: ' . mysqli_connect_error();
}
?>