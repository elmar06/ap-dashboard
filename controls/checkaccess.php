<?php
session_start();
if($_SESSION['access'] == 1)
{
    header('Location: ../pages/admin/dashboard.php');
}
elseif($_SESSION['access'] == 2)
{
    header('Location: ../pages/accounting/front-office.php');
}
elseif($_SESSION['access'] == 3)
{
    header('Location: ../pages/accounting/back-office.php');
}
elseif($_SESSION['access'] == 4)
{
    header('Location: ../pages/scm-pmc/dashboard.php');
}
elseif($_SESSION['access'] == 5)
{
    header('Location: ../pages/ea/dashboard.php');
}
elseif($_SESSION['access'] == 6)
{
    header('Location: ../pages/treasury/dashboard.php');
}
elseif($_SESSION['access'] == 7)
{
    header('Location: ../pages/manager/dashboard.php');
}
else
{
    header('Location: ../pages/accounting/access.php');

}
?>