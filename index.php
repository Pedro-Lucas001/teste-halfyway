<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: views/dashboard.php');
} else {
    header('Location: views/login.php');
}
exit;
