<?php 

    require('../require/init.php');
    require('../require/db.php');


    $diarydates = mysqli_query($conn,"SELECT * FROM `diary` WHERE `no`=1 ORDER BY `year` ASC, `month` ASC,`day` ASC");

    $monthinitial = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diary | TinagritProject</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    <script src="/require/init.js"></script>
    <script>
        let diarydates = [<?php while ($row = mysqli_fetch_array($diarydates)) {echo "'".$row['day']."/".$row['month']."/".$row['year']."',";} ?>];
    </script>

    
</head>
<body>
    
    
    <div id="pagecontent">
        

        <div class="bannertop">
            <?php include('../template/navigation.php') ?>
            <style>
                nav {
                    position: sticky;
                }
            </style>
            <div class="shrinksm">
                <div class="bottomposthead">
                <h1 class="todate">It's <?php echo date('l jS \of F'); ?></h1>
                
                <?php 
                
                    $today_st = mysqli_query($conn,"SELECT * FROM `diary` WHERE `year`='".date("Y")."' AND `month`='".date("m")."' AND `day`='".date('j')."' ORDER BY `no` DESC");
                    $today_rc = mysqli_num_rows($today_st);

                    if ($today_rc == 0) {
                        $yesterdaydate = date('j') - 1;
                        $yesterday_st = mysqli_query($conn,"SELECT * FROM `diary` WHERE `year`='".date("Y")."' AND `month`='".date("m")."' AND `day`='".$yesterdaydate."' ORDER BY `no` DESC");
                        $yesterday_rc = mysqli_num_rows($yesterday_st);    

                        if ($yesterday_rc == 0) {
                            echo "<h3 class='bottomposthead'>There are no posts for a while, these are the latest posts</h3></div>";
                            $latest_st = mysqli_query($conn,"SELECT * FROM `diary` ORDER BY `year` DESC, `month` DESC,`day` DESC,`no` DESC LIMIT 3");
                            while ($latest = mysqli_fetch_array($latest_st)) {
                                echo '
                                <a class="daycon" href="'.strtolower($monthinitial[$latest['month'] - 1]).'/'.$latest['day'].'/'.$latest['year'].'/'.$latest['no'].'">
                                    <div class="date">
                                        <span class="mon">'.$monthinitial[$latest['month'] - 1].'</span>
                                        <span class="day">'.$latest['day'].'</span>
                                    </div>
                                    <span class="title ibm">'.$latest['title'].'</span>
                                </a>';
                            }
                        } else {
                            echo "<h3>There's nothing yet for today, take a look at the yesterday's posts</h3></div>";
                            while ($yesterday = mysqli_fetch_array($yesterday_st)) {
                                echo '
                                <a class="daycon" href="'.strtolower($monthinitial[$yesterday['month'] - 1]).'/'.$yesterday['day'].'/'.$yesterday['year'].'/'.$yesterday['no'].'">
                                    <div class="date">
                                        <span class="mon">'.$monthinitial[$yesterday['month'] - 1].'</span>
                                        <span class="day">'.$yesterday['day'].'</span>
                                    </div>
                                    <span class="title ibm">'.$yesterday['title'].'</span>
                                </a>';
                            }
                        }
                    } else {
                        echo '</div>';
                        while ($today = mysqli_fetch_array($today_st) ) {
                            echo '
                                <a class="daycon" href="'.strtolower($monthinitial[$today['month'] - 1]).'/'.$today['day'].'/'.$today['year'].'/'.$today['no'].'">
                                    <div class="date">
                                        <span class="mon">'.$monthinitial[$today['month'] - 1].'</span>
                                        <span class="day">'.$today['day'].'</span>
                                    </div>
                                    <span class="title ibm">'.$today['title'].'</span>
                                </a>';
                        }
                    };
                
                ?>
                <div style="height: 30px;"></div>

             </div> <!-- shrinksm -->
        </div>

        <?php include('navigation.php') ?>

        <div class="shrinksm shrink-tb">
            <h2>The Month of <?php echo date('F'); ?></h2>

            <?php 
            
                $month_st = mysqli_query($conn,"SELECT * FROM `diary` WHERE `year`='".date("Y")."' AND `month`='".date("m")."' ORDER BY `day` ASC, `no` ASC");
                $month_rc = mysqli_num_rows($month_st);

                if ($month_rc == 0) {
                    echo "<p class='nothingtoshow'>Sorry, there's nothing yet</p>";
                } else {
                    while ($month_po = mysqli_fetch_array($month_st) ) {
                        echo '
                                <a class="daycon daycondown" href="'.strtolower($monthinitial[$month_po['month'] - 1]).'/'.$month_po['day'].'/'.$month_po['year'].'/'.$month_po['no'].'">
                                    <div class="date">
                                        <span class="mon">'.$monthinitial[$month_po['month'] - 1].'</span>
                                        <span class="day">'.$month_po['day'].'</span>
                                    </div>
                                    <span class="title ibm">'.$month_po['title'].'</span>
                                </a>';
                    }

                }
            
            ?>

            <a href="history" class="seefullhistory btn ibm">See Full History</a>
        </div>
        <style>
            a.seefullhistory {
                background-color: white;
                border: 1px solid black;
                color: black;
                width: 100%;
                margin: 30px auto 50px auto;
                display: block;
                text-align: center;
                transition-duration: 0.3s;
                box-sizing: border-box;
            }
            a.seefullhistory:hover {
                background-color: black;
                color: white;
            }

            .todate {
                padding-top: 15px;
            }

            .gb__red    {background: linear-gradient(to right, #e53935, #e35d5b);}
            .gb__yellow {background: linear-gradient(to right, #ff8008, #ffc837);}
            .gb__pink   {background: linear-gradient(to right, #ec008c, #fc6767);}
            .gb__green  {background: linear-gradient(to right, #add100, #7b920a);}
            .gb__orange {background: linear-gradient(to right, #fe8c00, #f83600);}
            .gb__blue   {background: linear-gradient(to right, #021B79, #0575E6);}
            .gb__violet {background: linear-gradient(to right, #6a3093, #a044ff);}

            .bannertop {
                color: white;
                padding: 0;
            }

            .bottomposthead {
                margin-bottom: 10px;
            }

            .daycon {
                display: block;
                background-color: white;
                color: black;
                border-radius: 10px;
                width: 100%;
                margin: 10px 0;
                padding: 10px;
                box-sizing: border-box;
                min-height: 67px;
                cursor: pointer;
            }

            .daycondown {
                border: 1px solid black;
            }

            .daycon .date {
                position: absolute;
                width: 40px;
                text-align: center;
            }

            .daycon .date span {
                display: block;
            }

            .daycon .date .day {
                font-size: 27px;
                margin-top: -5px;
            }

            .daycon .title {
                margin-left: 50px;
                font-weight: bold;
                font-size: 25px;
                min-height: 57px;
                width: calc(100% - 50px);
                margin-top: -5px;
                display: inline-flex;
                align-items: center;
                overflow-wrap: break-word;
                word-break: break-word;
                text-overflow: ellipsis;
                line-height: 35px;
            }

            .nothingtoshow {
                text-align: center;
                margin: 15px 0;
            }
        </style>
        <script>
            let date = new Date();
            let day = date.getDay();

            let bannertop = document.querySelector('.bannertop').classList

            switch (day) {
                case 0: bannertop.add('gb__red'); break;
                case 1: bannertop.add('gb__yellow'); break;
                case 2: bannertop.add('gb__pink'); break;
                case 3: bannertop.add('gb__green'); break;
                case 4: bannertop.add('gb__orange'); break;
                case 5: bannertop.add('gb__blue'); break;
                case 6: bannertop.add('gb__violet'); break;
            }
        </script>
    </div>
</body>
</html>