<?php
session_start();
if($_SESSION['access'] == 1)
{
    header('Location: ../pages/admin/dashboard.php');
}
elseif($_SESSION['access'] == 2)
{
    header('Location: ../pages/accounting/dashboard.php');
}
else
{
    header('Location: ../pages/purchasing/dashboard.php');
}
?>