<?php 

    require('../require/init.php');
    require('../require/db.php');


    $monthlist= ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];
    $monthinitial = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archive - Diary | TinagritProject</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    <script src="/require/init.js"></script>
    
</head>
<body>
    <?php include('../template/navigation.php') ?>
    <style>
        nav {
            position: relative;
        }
    </style>
    <div id="pagecontent">
        <?php include('navigation.php') ?>
        <div class="shrinklg shrink-tb">
            <?php 
            
                $select_year = mysqli_query($conn, "SELECT DISTINCT `year` FROM `diary` ORDER BY `year` DESC");
                while ($syr= mysqli_fetch_array($select_year)) {
                    echo "<div class='yearcon'>";
                    echo "<h1 class='yearlink'>".$syr['year']."</h1><hr>";
                    $select_month = mysqli_query($conn, "SELECT DISTINCT `month` FROM `diary` WHERE `year`=".$syr['year']." ORDER BY `month` ASC");
                    while ($smt= mysqli_fetch_array($select_month)) {
                        echo "<div class='monthcon'>";
                        echo "<h2 class='monthlink'>".$monthlist[$smt['month'] - 1]."</h2>";
                        $select_note = mysqli_query($conn, "SELECT * FROM `diary` WHERE `year`=".$syr['year']." AND `month`=".$smt['month']." ORDER BY `day` ASC,`no` ASC");
                        while ($sno= mysqli_fetch_array($select_note)) {
                            echo "<a class='notelink'".' href="'.strtolower($monthinitial[$sno['month'] - 1]).'/'.$sno['day'].'/'.$sno['year'].'/'.$sno['no'].'"'.">Day ".$sno['day']." - #".$sno['no']." - ".$sno['title']."</a>";
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                }
            
            ?>
        </div>
        <style>
            .yearcon {
                margin-bottom: 20px;
                
            }
            .yearlink {
                font-size: 40px;
            }
            .yearcon hr,
            .monthcon {
                margin-bottom: 10px;
            }
            .monthlink {
                margin-bottom: 7px;
                font-size: 32px;
                margin-left: 15px;
            }
            .notelink {
                margin-bottom: 3px;
                display: block;
                overflow-wrap: break-word;
                font-size: 25px;
                margin-left: 30px;
            }

            @media only screen and (max-width: 778px) {
                .yearcon {
                    margin-bottom: 50px;
                }
                .yearlink {
                    text-align: center;
                }
                .monthlink {
                    margin-left: 0;
                }
                .notelink {
                    margin-bottom: 7px;
                }
            }
        </style>
        <script>
            
        </script>
    </div>
</body>
</html>