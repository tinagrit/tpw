<?php 
    require('../require/init.php');
    require('../require/db.php');

    if (!isset($_SESSION['admin'])) {
        header('location: .');
    }

    if ($_SESSION['admin'] == 'true') {
        $author = 'TINAGRIT';
    }

    if (isset($_POST['diarysubmit'])) {
        $title = $_POST['title'];
        $dateraw = $_POST['date'];
        $content = $_POST['html'];

        $content = str_replace("'","\'",$content);

        if (empty($title)) {
            $err = 'Title cannot be empty or null';
            $returndateraw = $dateraw;
            $returncontent = $content;
        } elseif (empty($dateraw)) {
            $err = 'Invalid date';
            $returntitle = $title;
            $returncontent = $content;
        } else {
            $date_arr = explode('-',$dateraw);
            $year = $date_arr[0];
            $month = $date_arr[1];
            $day = $date_arr[2];   
            
            $findnum_sql = mysqli_query($conn, "SELECT `no` from `diary` WHERE `day` = '".$day."' AND `month` = '".$month."' AND `year` = '".$year."' ORDER BY `no` DESC LIMIT 1");
            $findnum_query = mysqli_fetch_assoc($findnum_sql);
            $latestno = $findnum_query['no'];
            if ($latestno == null) {
                $no = 1;
            } else {
                $no = (int)$latestno + 1;
            }

            if ( mysqli_query($conn,"INSERT INTO `diary` (`id`, `title`, `content`, `no`, `day`, `month`, `year`, `author`) VALUES (NULL, '".$title."', '".$content."', '".$no."', '".$day."', '".$month."', '".$year."', '".$author."');") ) {
                $_SESSION['addsuccess'] = true;
                header('location: list.php');
            } else {
                $err = 'Failed to add a diary to database';
            }


        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create - Diary | TinagritProject</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    <script src="/require/init.js"></script>
</head>
<body>
    <?php include('../template/navigation.php') ?>
    <div id="pagecontent">
        <div class="shrinklg shrink-tb">
            <form action="" method="post">

                <div class="template headerbtn header">
                    <h1>Create a New Diary</h1>
                    <input type="submit" name="diarysubmit" class="btn ibm" value="Publish Now">
                </div>
                <hr style="margin-bottom: 10px;">

                <?php if (isset($err)) {echo '<p class="error">'.$err.'</p>';} ?>

                <p class="yawf">You are writing for</p><div class="datehidden"><input type="date" name="date" pattern="\d{4}-\d{2}-\d{2}" <?php if (isset($returndateraw)) {echo 'value="'.$returndateraw.'"';} ?>><div class="btn save ibm">Save</div></div><span id="datechose"></span>

                <input type="text" name="title" class="title" autocomplete="off" placeholder="Title" <?php if (isset($returntitle)) {echo 'value="'.$returntitle.'"';} ?>>
                <textarea placeholder="Content" id="editor" name="html"><?php if (isset($returncontent)) {echo $returncontent;} ?>
                </textarea>

            </form>

        </div>
        <style>
            form input.title {
                width: 100%;
                outline: none;
                border: none;
                background-color: #e9e9e9;
                color: black;
                padding: 10px;
                padding-bottom: 5px;
                box-sizing: border-box;
                font-size: 25px;
                font-family: 'IBM Plex Sans Thai',sans-serif;
                font-weight: bold;
                margin-bottom: 5px;
                margin-top: 10px;
            }
            .ck-editor__editable_inline {
                min-height: 400px;
            }
            .ck-editor__editable_inline ul,
            .ck-editor__editable_inline ol {
                margin-left: 20px;
            }
            .yawf {
                display: inline;
                font-size: 20px;
                margin-right: 10px;
            }
            input[type=submit] {
            }
            .datehidden {
                display: none;
            }
            #datechose {
                font-weight: bold;
                font-size: 20px;
            }
            div.save {
                padding: 4px 15px;
                margin-left: 5px;
            }
            p.error {
                font-size: 20px;
                color:red;
                font-weight: bold;
                margin-bottom: 10px;
            }
        </style>
        <script>
            // import ImageResizeEditing from '@ckeditor/ckeditor5-image/src/imageresize/imageresizeediting';
            // import ImageResizeHandles from '@ckeditor/ckeditor5-image/src/imageresize/imageresizehandles';

            ClassicEditor.create( document.querySelector( '#editor' ), {
                ckfinder: {
                    uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
                }
                // ,plugins: [ Image, ImageResizeEditing, ImageResizeHandles ]
            } );

            Date.prototype.toDateInputValue = (function() {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0,10);
            });

            let date = new Date();
            let monthlist = ['January','Febuary','March','April','May','June','July','August','September','October','November','December'];

            let day = date.getDate();
            let monthnum = date.getMonth() + 1;
            let month = monthlist[date.getMonth()];
            let year = date.getFullYear();

            let formatteddate = month + ' ' + day + ', ' + year;

            <?php if (!isset($returndateraw)) {echo "
                document.querySelector('#datechose').innerHTML = formatteddate;

                let formattedsmalldate = date.toDateInputValue();
                document.querySelector('input[type=date]').value = formattedsmalldate;
                ";} else {echo "
                formatDateNow();
                ";} ?>
            


            document.querySelector('#datechose').addEventListener('click',()=> {
                document.querySelector('#datechose').style.display = 'none';
                document.querySelector('.datehidden').style.display = 'inline';
                document.querySelector('input[type=date]').focus();
            })

            document.querySelector('div.save').addEventListener('click',()=> {
                formatDateNow();

                document.querySelector('#datechose').style.display = 'inline';
                document.querySelector('.datehidden').style.display = 'none';
            })

            function formatDateNow() {
                date = new Date(document.querySelector('input[type=date]').value);
                date.setTime( date.getTime() + date.getTimezoneOffset()*60*1000 );

                day = date.getDate();
                month = monthlist[date.getMonth()];
                year = date.getFullYear();
                formatteddate = month + ' ' + day + ', ' + year;

                if (month == undefined || day == NaN) {
                    formatteddate = '<strong style="color:red;">Invalid date, please update</strong>'
                    document.querySelector('input[type=submit]').disabled = true;
                } else {
                    document.querySelector('input[type=submit]').disabled = false;
                }

                document.querySelector('#datechose').innerHTML = formatteddate;
            }

        </script>
    </div>
</body>
</html>