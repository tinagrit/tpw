<?php 

    require('../require/init.php');
    require('../require/db.php');


    $monthl = strtolower($_GET['m']);
    if ($monthl == 'jan') {$month = 1;}
    elseif ($monthl == 'feb') {$month = 2;}
    elseif ($monthl == 'mar') {$month = 3;}
    elseif ($monthl == 'apr') {$month = 4;}
    elseif ($monthl == 'may') {$month = 5;}
    elseif ($monthl == 'jun') {$month = 6;}
    elseif ($monthl == 'jul') {$month = 7;}
    elseif ($monthl == 'aug') {$month = 8;}
    elseif ($monthl == 'sep') {$month = 9;}
    elseif ($monthl == 'oct') {$month = 10;}
    elseif ($monthl == 'nov') {$month = 11;}
    elseif ($monthl == 'dec') {$month = 12;}
    
    $day = $_GET['d'];
    $year = $_GET['y'];

    if (isset($_GET['n'])) {
        $no = $_GET['n'];
    } else {
        $check_sql = "SELECT * FROM `diary` WHERE `year`='".$year."' AND `month`='".$month."' AND `day`='".$day."' ORDER BY `no` ASC";
        $check_no = mysqli_query($conn,$check_sql);
        $check_rc = mysqli_num_rows($check_no);
        if ($check_rc != 1 && $check_rc != 0) {
            $user_choose_no = 1;
        } else {
            $no = 1;
        }
    }



    $monthinitial = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
    $monthlist= ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];

    if (!in_array($monthl, $monthinitial)) {
        $user_invalid = 'Monthl is not in a list of initial';
    }

    // switch ($monthl) {
    //     case 'jan': $month = 1 ; break;
    //     case 'feb': $month = 2 ; break;
    //     case 'mar': $month = 3 ; break;
    //     case 'apr': $month = 4 ; break;
    //     case 'may': $month = 5 ; break;
    //     case 'jun': $month = 6 ; break;
    //     case 'jul': $month = 7 ; break;
    //     case 'aug': $month = 8 ; break;
    //     case 'sep': $month = 9 ; break;
    //     case 'oct': $month = 10; break;
    //     case 'nov': $month = 11; break;
    //     case 'dec': $month = 12; break;
    // }

    // if ($month == 'oct') {$month = 10;}


    

    

    
?>

<?php 


if ($user_choose_no != 1 && $user_invalid != 1) {
    $select_sql = "SELECT * FROM `diary` WHERE `year`='".$year."' AND `month`='".$month."' AND `day`='".$day."' AND `no`='".$no."' LIMIT 1";
    $select_st = mysqli_query($conn,$select_sql);
    $select_rc = mysqli_num_rows($select_st);
    
    if ($select_rc == 0) {
        $user_invalid = 'Cannot find any matches';
    } else {
        $post = mysqli_fetch_array($select_st);

        $title = $post['title'];
        $content = $post['content'];
        $postmonth = $monthlist[$month - 1];
        $author = $post['author'];
    }
}

if ($user_invalid == 1) {
    $title = 'Error';
} elseif ($user_choose_no == 1) {
    $title = 'Please choose';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?> - Diary | TinagritProject</title>
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
        <div class="shrinksm shrink-tb">
            <?php if (isset($user_invalid)) { ?>
                <?php echo $select_sql; ?>
            <?php } elseif ($user_choose_no == 1) { ?>
                <h1>Please choose one</h1>
                <h2>There are multiple posts from this day</h2>
                <?php while ($check = mysqli_fetch_array($check_no)) {
                    echo '
                    <a class="daycon daycondown" href="/diary/'.strtolower($monthinitial[$check['month'] - 1]).'/'.$check['day'].'/'.$check['year'].'/'.$check['no'].'">
                        <div class="date">
                            <span class="mon">'. strtoupper($monthinitial[$check['month'] - 1]) .'</span>
                            <span class="day">'.$check['day'].'</span>
                        </div>
                        <span class="title ibm">'.$check['title'].'</span>
                    </a>';
                } ?>
            <?php } else { ?>
                <h1 class="title"><?php echo $title;  ?></h1>
                <p class="subtitle"><?php echo $postmonth.' '.$day.', '.$year ?></p>
                <?php if ($author != 'TINAGRIT') {
                    echo "<div class='alert_author ibm'>This post does not come from Tinagrit, the owner.</div>";
                } ?>
                
                <hr class="undersubtitle">
                <div id="postcontent">
                    <?php echo $content; ?>
                </div>
            <?php } ?>
        </div>    

        <style>
            .title {
                overflow-wrap: break-word;
                word-break: break-word;
            }
            .subtitle {
                font-size: 22px;
                margin-bottom: 10px;
            }
            #postcontent {
                margin-top: 5px;
                box-sizing: border-box;
                overflow: auto;
                overflow-wrap: break-word;
                word-break: break-word;
                font-family: 'IBM Plex Sans','IBM Plex Sans Thai Looped','Lato','Noto Sans Thai',sans-serif;
            }
            #postcontent h1,
            #postcontent h2,
            #postcontent h3,
            #postcontent p,
            #postcontent ul,
            #postcontent ol,
            #postcontent figure,
            #postcontent blockquote {
                margin: 15px 0;
                overflow-wrap: break-word;
                word-break: break-word;
            }

            #postcontent li {
                margin-bottom: 5px;
            }

            #postcontent p,
            #postcontent li {
                font-size: 18px;
            }

            #postcontent ul,
            #postcontent ol {
                margin-left: 20px;
            }

            #postcontent blockquote {
                padding-right: 1.5em;
                padding-left: 1.5em;
                font-style: italic;
                border-left: 5px solid #ccc;
            }

            #postcontent figure {
                width: fit-content;
                display: block;
                margin: 0 auto;
            }

            #postcontent table {
                border-collapse: collapse;
            }

            #postcontent td {
                border: solid black;
                border-width: 1px 0;
            }

            #postcontent th {
                border: solid white;
                border-width: 1px;
            }

            #postcontent td,
            #postcontent th {
                padding: 10px 20px;
            }

            

            #postcontent th {
                background-color: #d3d3d3
            }

            #postcontent tr {
                
            }

            .alert_author {
                padding: 10px 20px;
                margin: 10px 0;
                background-color: #facccc;
                color: #960118;
                border: 1px solid #960118;
                font-weight: bold;
                text-align: center;
                border-radius: 10px;
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
        </style>
        <script>
            
        </script>
    </div>
</body>
</html>