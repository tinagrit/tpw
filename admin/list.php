<?php 
    require('../require/init.php');
    require('../require/db.php');

    if (!isset($_SESSION['admin'])) {
        header('location: .');
    }
    $monthlist= ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List - Diary | TinagritProject</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    
</head>
<body>
    <?php include('../template/navigation.php') ?>
    <div id="pagecontent">
        <div class="shrinklg shrink-tb">
            <div class="template headerbtn header">
                <?php if (!isset($_REQUEST['all'])) { ?>
                    <h1>Diaries This Month</h1>
                <?php  } else { ?>
                    <h1>All Diaries</h1>
                <?php } ?>
                <a href="create.php" class="btn ibm" >Add New</a>
            </div>
            <hr style="margin-bottom: 10px;">
            <?php
            
                if (isset($_SESSION['addsuccess'])) {
                    echo '<p class="success">Diary Added</p>';
                    unset($_SESSION['addsuccess']);
                }

                if (isset($_SESSION['updatesuccess'])) {
                    echo '<p class="success">Diary Updated</p>';
                    unset($_SESSION['updatesuccess']);
                }

                if (isset($_SESSION['deletesuccess'])) {
                    echo '<p class="success">Diary Deleted</p>';
                    unset($_SESSION['deletesuccess']);
                }
             
            ?>
        <div class="dbp">

        <table id="table" class="dashboard ibm" cellspacing='0'>
            <colgroup>
                <col span='1' width='25%'>
                <col span='1' width='10%'>
                <col span='1' width='50%'>
                <col span='1' width='80px'>
            </colgroup>
            <tbody>
                <?php 
                
                    if (!isset($_REQUEST['all'])) {
                        $result = mysqli_query($conn,"SELECT * FROM `diary` WHERE `year`='".date("Y")."' AND `month`='".date("m")."' ORDER BY `day` DESC,`no` DESC");
                    } else {
                        $result = mysqli_query($conn,"SELECT * FROM `diary` ORDER BY `year` DESC, `month` DESC,`day` DESC,`no` DESC");
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        
                    
                
                ?>

                <tr>
                    <td class="mns"><?php echo $monthlist[$row['month'] - 1].' '.$row['day'].', '.$row['year'] ?></td>
                    <td><?php echo '# '.$row['no']?></td>
                    <td class="title"><?php echo '<strong>'.$row['title'].'</strong>' ?></td>
                    <td><a href="update.php?diary=<?php echo $row['id'] ?>" class='btn'>Edit</a></td>
                </tr>


                <?php } ?>
            </tbody>
        </table>

        </div>

        <?php if (!isset($_REQUEST['all'])) { ?>
            <a href="?all" class="btn loadmoreyears" style="">Load Others</a>
        <?php } ?>

        </div>
        <style>
            p.success {
                width: 100%;
                box-sizing: border-box;
                display: block;
                padding: 10px 20px;
                font-weight: bold;
                font-size: 20px;
                background-color: #adb;
                color: #353;
                border-radius: 10px;
            }
            .dashboard {
                width: 90%;
                max-width: 600px;
                margin: 10px auto;
                table-layout: fixed;
            }
            .dashboard td {
                padding: 0.75rem;
                vertical-align: center;
                border-top: 1px solid #dee2e6;
                overflow: hidden;
            }
            .dashboard td.title {
                text-overflow: ellipsis;
            }
            tr:hover {
                background-color: rgba(0, 0, 0, 0.075);
            }
            @media only screen and (max-width: 768px) {

                .dbp {
                    overflow: scroll;
                }
                .dashboard {
                    width: 550px;
                    max-width: none;
                }
            }
            a.loadmoreyears {
                text-align:center;display:block;width:fit-content;margin:0 auto;background-color:white;color:black;border:1px solid black;
            }
        </style>
        <script src="/require/init.js"></script>
        <script>

        </script>
    </div>
</body>
</html>