<?php 
    require('../require/init.php');
    require('../require/db.php');

    if (!isset($_SESSION['admin'])) {
        header('location: .');
    }

    if (!isset($_GET['diary']) && !isset($_GET['delete'])) {
        header('location: list.php');
    } else {
        if (isset($_GET['diary'])) {
            $search = $_GET['diary'];
        }
        if (isset($_GET['delete'])) {
            $search = $_GET['delete'];
        }
         
    }

    if ($_SESSION['admin'] == 'true') {
        $author = 'TINAGRIT';
    }

    if (isset($_GET['delete'])) {
        if ( mysqli_query($conn,"DELETE FROM `diary` WHERE `id` = '$search'") ) {
            $_SESSION['deletesuccess'] = true;
            header('location: list.php');
        } else {
            $err = 'Failed to delete a diary to database';
        }
    }

    $select_id = mysqli_query($conn, "SELECT * from `diary` WHERE `id` = '".$search."' LIMIT 1");
    $select_query = mysqli_fetch_assoc($select_id);
    
    $year = $select_query['year'];
    $month = sprintf("%02d", $select_query['month']);
    $day = sprintf("%02d", $select_query['day']);

    $returndateraw = $year.'-'.$month.'-'.$day;
    $returntitle = $select_query['title'];
    $returncontent = $select_query['content'];

    if (isset($_POST['diarysubmit'])) {
        $title = $_POST['title'];
        $dateraw = $_POST['date'];
        $content = $_POST['html'];

        if (empty($title)) {
            $err = 'Title cannot be empty or null';
            $returndateraw = $dateraw;
            $returncontent = $content;
        } else {

            if ( mysqli_query($conn,"UPDATE `diary` SET `title`='$title',`content`='$content' WHERE `id`='$search'") ) {
                $_SESSION['updatesuccess'] = true;
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
    <title>Update - Diary | TinagritProject</title>
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
                    <h1>Update Diary</h1>
                    <a href="?delete=<?php echo $search ?>" class="btn delete secbtn" style="font-size: 13.3333px">Delete</a>
                    <input type="submit" name="diarysubmit" class="btn ibm" value="Update Now">
                </div>
                <hr style="margin-bottom: 10px;">

                <?php if (isset($err)) {echo '<p class="error">'.$err.'</p>';} ?>

                <p class="yawf">This diary is for</p><div class="datehidden"><input type="date" name="date" pattern="\d{4}-\d{2}-\d{2}" <?php if (isset($returndateraw)) {echo 'value="'.$returndateraw.'"';} ?>><div class="btn save ibm">Save</div></div><span id="datechose"></span>

                <input type="text" name="title" class="title" autocomplete="off" placeholder="Title" <?php if (isset($returntitle)) {echo 'value="'.$returntitle.'"';} ?>>
                <textarea placeholder="Content" id="editor" name="html"><?php if (isset($returncontent)) {echo $returncontent;} ?>
                </textarea>
                <input type="hidden" name="id" value="<?php echo $search ?>">
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
            .delete {
                background-color: white;
                color: black;
                outline: 1px solid black;
                box-sizing: border-box;
            }
            @media only screen and (max-width: 768px) {
                .delete {
                    right: 0;
                }
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
            
            formatDateNow();

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