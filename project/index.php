<?php 

require('../require/init.php');

if (isset($_GET['home'])) {header('location: /');} 

    elseif (isset($_GET['study']))      {$name = 'study';   $realname = 'Study';     $url = 'https://study.tinagrit.com';} 
    elseif (isset($_GET['shoppers']))   {$name = 'shoppers';$realname = 'Shoppers';  $url = 'https://shoppers.tinagrit.com';} 
    elseif (isset($_GET['24solver']))   {$name = '24solver';$realname = '24Solver';  $url = 'https://24solver.tinagrit.com';} 
    elseif (isset($_GET['covid19']))    {$name = 'covid19'; $realname = 'COVID-19';  $url = 'https://covid19.tinagrit.com';} 
    elseif (isset($_GET['math']))       {$name = 'math';    $realname = 'Math';      $url = 'https://math.tinagrit.com';} 
    elseif (isset($_GET['sandbox']))    {$name = 'sandbox'; $realname = 'SANDBOX';   $url = 'https://sandbox.tinagrit.com/tlib';} 
    elseif (isset($_GET['tlib']))       {$name = 'tlib';    $realname = 'TLIB';      $url = 'https://tlib.tinagrit.com/doc';}
    elseif (isset($_GET['popm']))       {$name = 'popm';    $realname = 'POPM';      $url = 'https://popm.tinagrit.com/';}

else {
    header('location: /');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $realname ?> | TinagritProject</title>
    <link rel="stylesheet" href="/require/init.css">
    <link rel="stylesheet" href="/content.css">
    <script src="/require/init.js"></script>
    <script>let redurl = '<?php echo $url ?>'</script>
</head>
<body>
    <div class="template__anno__exclude" style="background-color: #5C7AEA;color:white">
        <div>
            <strong class="ibm">Preview Mode - <wbr><a href="<?php echo $url; ?>" class="udl">Click here to go to <?php echo $realname; ?> website</a></strong>
        </div>
    </div>
    <?php include('../template/navigation.php'); ?>
    <div id="pagecontent">
        <iframe src="<?php echo $url ?>" frameborder="0" onload="iframeloaded()" ></iframe>
        <div class="no3c">
            <div>
                <h1>Sorry for interruption</h1>
                <a href="<?php echo $url ?>" class="btn">Click here to continue</a>
                <p id="desctog">Why do I see this?</p>
                <p id="descred">This project requires cookie to work. The project link is different from where you are, so it needs 3rd party cookie enabled, which is disabled in your browser. It could happen on incognito mode. Continuing will redirect you to the project website.</p>
            </div>
        </div>
    </div>
    <style>
        body {
            overflow: none;
        }
        #pagecontent {
            height: 100vh;
        }
        iframe,.no3c {
            width: 100%;
            height: 100%;
        }
        .btn {
            background-color: white;
            color: #e93333;
            width: 100%;
            display: block;
            box-sizing: border-box;
            text-align: center;
            margin: 15px 0;
            font-size: 20px;
        }
        .no3c {
            background-color: #e93333;
            display: flex;
            align-items: center;
            justify-content: center;
            display: none;
        }
        .no3c p {
            font-size: 20px;
            max-width: 300px;
        }
        .no3c p,.no3c h1 {
            color: white;
        }
        #descred {
            display: none;
        }
    </style>
    <script>
        for (i=0;i<document.querySelectorAll('.template__anno').length;i++) {
            document.querySelectorAll('.template__anno')[i].style.display = 'none';
        }

        let annoall,annosum,navsum;
        if (document.querySelector('.template__anno__exclude')) {
            annoall = [];
            for (i=0;i<document.querySelectorAll('.template__anno__exclude').length;i++) {
                annoall.push(document.querySelectorAll('.template__anno__exclude')[i].offsetHeight);
            }
            annosum = annoall.reduce((a, b) => a + b)
        }

        navsum = document.querySelector('nav').offsetHeight;
        if (annosum) {navsum += annosum};

        document.querySelector('#pagecontent').style.height = 'calc(100vh - ' + navsum + 'px)';

        function iframeloaded() {
            document.title = document.querySelector('iframe').contentDocument.title + ' | TinagritProject';
        }

        function no3partyred() {
            // document.querySelector('iframe').style.display = 'none';
            // document.querySelector('.no3c').style.display = 'flex';
            location.href = '<?php echo $url ?>?sn3p';
        }

        document.querySelector('#desctog').addEventListener('click',whydoIseethis);

        function whydoIseethis() {
            document.querySelector('#descred').style.display = 'block'; 
            document.querySelector('#desctog').style.display = 'none';
        }


        var eventMethod = window.addEventListener
			? "addEventListener"
			: "attachEvent";
        var eventer = window[eventMethod];
        var messageEvent = eventMethod === "attachEvent"
            ? "onmessage"
            : "message";

        eventer(messageEvent, function (e) {
            
            if (e.data === "no3rdparty" || e.message === "no3rdparty") 
                no3partyred();
            
            console.log(e);
        });
    </script>
</body>
</html>