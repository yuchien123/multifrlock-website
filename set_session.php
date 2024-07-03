<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['staffid']) && isset($_POST['staffname'])) {
        // Set session variable
        $_SESSION['staffid'] = $_POST['staffid'];
        $_SESSION['staffname'] = $_POST['staffname'];
        echo 'success';
    } else {
        echo 'error';
    }
}
?>