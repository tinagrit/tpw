    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai+Looped:wght@300;400;700&family=IBM+Plex+Sans+Thai:wght@300;400;700&family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet"> -->

    <!-- <div class="template__anno" style="background-color: #950101;color: white;">
        <div>
            <strong>Website in Maintenance <a href="mailto:webmasters@tinagrit.com" class="udl">(Report Bugs Here)</a></strong>
        </div>
    </div> -->

    <div class="template__anno" style="background-color: #996136;color: white;">
        <div>
            <strong>October 11th - Thanksgiving Day</strong>
        </div>
    </div>
    
    

    <nav>
        <div class="nav-content">
        
            <!-- logo -->
            <a href="/" class="logo" style="display: flex; justify-content: center; padding: 10px;">
                <img style="width: 80px" src="/template/tplogo.png">
            </a>
            
            <!-- navigation button -->
            <div class="nav-icon">
                <div class="bar one"></div>
                <div class="bar two"></div>
            </div>
            
            <!-- naviagtion links -->
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/diary">Diary</a>
                <a href="/project/?study">Study</a>
                <a href="/project/?shoppers">Shoppers</a>
                <a href="/project/?covid19">COVID-19</a>
                <a href="/project/?math">Math</a>
                <a href="/project/?sandbox">Sandbox</a>
                <a href="/project/?tlib">TLIB</a>
                <a href="/project/?popm">POPM</a>
            </div>
        </div>
    </nav>

    <script>
        const navIcon = document.querySelector(".nav-icon");
        const nav = document.querySelector("nav");

        let navbarstat = 0;

        navIcon.onclick = function () {
            // nav.classList.toggle('show');
            if (navbarstat == 0) {
                navbarstat = 1;
                nav.classList.add('show');
                
                for (i=0;i<document.querySelectorAll('.template__anno').length;i++) {
                    document.querySelectorAll('.template__anno')[i].style.display = 'none';
                }
            } else if (navbarstat == 1) {
                navbarstat = 0;
                nav.classList.remove('show');

                for (i=0;i<document.querySelectorAll('.template__anno').length;i++) {
                    document.querySelectorAll('.template__anno')[i].style.display = 'block';
                }
            }
        }
    </script>
    <style>
        nav {
            background-color: #202020;
            position: sticky;
            z-index: 2;
            top: 0;
            
        }
        .nav-content {
            max-width: 1024px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-around;
            
        }
        .nav-content a {
            display: block;
            font-size: 14px;
            line-height: 44px;
            text-decoration: none;
            /* transition: all 0.3s; */
            color: #ffffff;
        }
        .nav-content a:hover,
        .nav-icon:hover,
        .search-icon:hover {
            opacity: 0.7;
        }
        .nav-links {
            width: 80%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-top: 3px;
        }
        .nav-icon {
            display: none;
            grid-gap: 5px;
            grid-template-columns: auto;
            padding: 17px 0;
            height: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .bar {
            height: 1px;
            width: 18px;
            background: white;
            transition: 0.5s;
        }
        .show .one {
            transform: rotate(45deg) translateY(5.5px);
        }
        .show .two {
            transform: rotate(-45deg) translateY(-5.5px);
        }
        @media (max-width: 778px) {
            .show {
                background-color: #202020;
            }
            /* .template__anno {
                transition: 1s;
                top: -999px;
            } */
            .nav-content {
                justify-content: space-between;
            }
            .nav-links {
                position: fixed;
                /* top: calc(44px + var(--anno-height)); */
                top: 44px;
                right: 0;
                height: 0;
                width: 100%;
                background: #333333;
                flex-direction: column;
                justify-content: flex-start;
                transition: height 2s cubic-bezier(0.19, 1, 0.22, 1),
                    background-color 0.3s;
            }
            .show .nav-links {
                height: 100%;
                background-color: #202020;
            }
            .nav-links a {
                height: 0;
                width: 0;
                opacity: 0;
                overflow: hidden;
                margin-right: 50px;
                margin-left: 50px;
                transition: opacity 1.5s, height 2s;
            }
            .show .nav-links a {
                opacity: 1;
                width: auto;
                height: auto;
            }
            .nav-icon {
                order: 1;
                display: grid;
            }
            .logo {
                order: 2;
            }
        }

        .template__anno,
        .template__anno__exclude {
            padding: 7px;
            text-align: center;
        }

        .template__anno>div,
        .template__anno__exclude>div {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
    <script>
        if (document.querySelector('.template__anno')) {
            annoall = [];
            for (i=0;i<document.querySelectorAll('.template__anno').length;i++) {
                annoall.push(document.querySelectorAll('.template__anno')[i].offsetHeight);
            }
            annosum = annoall.reduce((a, b) => a + b);
            document.querySelector('.nav-links').style.setProperty('--anno-height', annosum + 'px')
        }
    </script>



    