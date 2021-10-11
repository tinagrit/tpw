let bsc__ua = navigator.userAgent;

let bsc__firefox = bsc__ua.toLowerCase().indexOf('firefox') > -1;
let bsc__chrome = (bsc__ua.toLowerCase().indexOf('chrome/') > -1) && (window.chrome);
let bsc__safari = bsc__ua.toLowerCase().indexOf('safari/') > -1;
let bsc__ie = bsc__ua.toLowerCase().indexOf('trident/') > -1;


if (bsc__firefox) {
    location.replace('/sorry/firefox.html');
} else if (bsc__ie) {
    location.replace('/sorry/internetexplorer.html');
} else if(!(bsc__chrome || bsc__safari)) {
    location.replace('/sorry/browser.html');
}

function bsc__bsv(){
    var ua= navigator.userAgent;
    var tem; 
    var M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M;
};

if (bsc__safari) {
    if (Number(bsc__bsv()[1]) < 11) {
        location.replace('/sorry/browser.html');
    }
}

if (bsc__chrome) {
    if (Number(bsc__bsv()[1]) < 88) {
        location.replace('/sorry/browser.html');
    }
}
