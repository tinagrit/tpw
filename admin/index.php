<?php 
    require('../require/init.php');

    $_ADMINS_PASSCODE_PLEASE_KEEP_THIS_SECRET_ = '1234';

    if (isset($_POST['validate'])) {
        if (!empty($_POST['pin'])) {
            if (md5($_POST['pin']) == md5($_ADMINS_PASSCODE_PLEASE_KEEP_THIS_SECRET_)) {
                $_SESSION['admin'] = 'true';
            } else {
                $err = 'Incorrect Passcode';
            }
        } else {
            $err = 'Passcode cannot by empty or null';
        }
    }

    if (isset($_GET['signout'])) {
        session_destroy();
        unset($_SESSION["admin"]);
        header('location: .');
    }

    if (isset($_SESSION['admin'])){
        if ($_SESSION['admin'] == 'true') {
            $loggedin = 2;
        } else {
            $loggedin = 1;
        }
    } else {
        $loggedin = 1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Dairy | TinagritProject</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    <script src="/require/init.js"></script>
</head>
<body>
    <?php include('../template/navigation.php') ?>
    <div id="pagecontent">
        <div class="shrinklg shrink-tb">

            <div class="template headerbtn header">
                <h1>Administration</h1>
            </div>
            <hr style="margin-bottom: 10px;">
            
            <?php if ($loggedin == 2) { ?>
                <h1>Admin Menu</h1>
                <a href="?signout">Sign Out</a>
                <a href="create.php">Create new diary</a>
                <a href="list.php">Edit dairy</a>
            <?php } else if ($loggedin == 1) { ?>
                <h2 style="">Please Enter Your Administration Passcode</h2>
                <?php if (isset($err)) {
                    echo '<h3 style="color:red; text-align: center" >'.$err.'</h3>';
                } ?>
                <form method="post">
                    <input type="password" name="pin" pattern="[0-9]{4}" maxlength="4" style="" required>
                    <input type="submit" name="validate" value="Validate" class="btn">
                </form>
            <?php } ?>

        </div>
        <style>
            h2 {
                text-align: center
            }
            form input[type=password] {
                display: block;
                font-size: 50px;
                width: 200px;
                margin: 10px auto;
                text-align: center;
                border-radius: 10px;
                border: 1px solid black;
                outline: none;
            }
            form input[type=submit] {
                display: block;
                text-align: center;
                margin: 0 auto;
                font-size: 20px;
            }
        </style>
    </div>
</body>
</html>