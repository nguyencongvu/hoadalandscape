
const API_LOCAL = "http://localhost:3001/v1/api"
const API_SERVER = 'https://api.webup.top/v1/api' // CHANGE-HERE 
// const API_SERVER = 'https://api.hitime.vn' // CHANGE-HERE 
let API = (location.href.includes('localhost')) ? API_LOCAL : API_SERVER
const DOMAIN = "shilenanailsspa"

class Track {
    constructor(name) {
        this.server = name
        this.domain = DOMAIN // customer db 
        this.api = `${API}/${DOMAIN}`
    }
    getOS() {
        var sBrowser, sUsrAg = navigator.userAgent;
        // The order matters here, and this may report false positives for unlisted browsers.
        if (sUsrAg.indexOf("Firefox") > -1) {
            sBrowser = "Mozilla Firefox";
            // "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0"
        } else if (sUsrAg.indexOf("SamsungBrowser") > -1) {
            sBrowser = "Samsung Internet";
            // "Mozilla/5.0 (Linux; Android 9; SAMSUNG SM-G955F Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/9.4 Chrome/67.0.3396.87 Mobile Safari/537.36
        } else if (sUsrAg.indexOf("Opera") > -1 || sUsrAg.indexOf("OPR") > -1) {
            sBrowser = "Opera";
            // "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 OPR/57.0.3098.106"
        } else if (sUsrAg.indexOf("Trident") > -1) {
            sBrowser = "Microsoft Internet Explorer";
            // "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; Zoom 3.6.0; wbx 1.0.0; rv:11.0) like Gecko"
        } else if (sUsrAg.indexOf("Edge") > -1) {
            sBrowser = "Microsoft Edge";
            // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299"
        } else if (sUsrAg.indexOf("Chrome") > -1) {
            sBrowser = "Google Chrome or Chromium";
            // "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/66.0.3359.181 Chrome/66.0.3359.181 Safari/537.36"
        } else if (sUsrAg.indexOf("Safari") > -1) {
            sBrowser = "Apple Safari";
            // "Mozilla/5.0 (iPhone; CPU iPhone OS 11_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1 980x1306"
        } else {
            sBrowser = "unknown";
        }
        return sBrowser;
    }
    pad(number, length) {
        var str = '' + number;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    }
    formatDataDate(dt) { // to save 
        var res = dt.getFullYear()
            + '-' + this.pad(dt.getMonth() + 1, 2)
            + '-' + this.pad(dt.getDate(), 2)
            + ' ' + this.pad(dt.getHours(), 2)
            + ':' + this.pad(dt.getMinutes(), 2)
            + ':' + this.pad(dt.getSeconds(), 2);

        return res
    }
    os_support() {
        // check browser support 
        if (typeof (Storage) !== "undefined") {
            return true
        } else {
            return false
        }
    }
    genId(num = null) {
        const max = num ? num : 6
        let uniqid = Math.round((Math.pow(36, max + 1) - Math.random() * Math.pow(36, max))).toString(36).slice(1);
        return uniqid
    }
    async ping() {
        let vm = this
        let data = {
            date_created: vm.formatDataDate(new Date()),
            cookie: localStorage.cookie ? localStorage.cookie : vm.genId(), // a token with len  
            url: location.href,
            referrer: document.referrer,
            os: vm.getOS(),
        }
        console.log(data)
        localStorage.cookie = data.cookie // save cookie localstorage 

        let endpoint = vm.api + "/ping" // do admin insert 
        let res = await fetch(endpoint, {
            method: "POST",
            body: JSON.stringify(data)
        })
        console.log(res)
        return res;
    }
    async cta(type = null) {
        let vm = this
        let targets = document.querySelectorAll('.cta') || document.querySelectorAll('button') || document.querySelectorAll('a')
        // console.log(targets)
        targets.forEach(f => {
            f.addEventListener("mouseup", e => {
                // let txt = `${f.innerText} x: ${e.clientX} | y: ${e.clientY}`; // very good!!
                // console.log(txt);
                let data = {}
                data.date_created = vm.formatDataDate(new Date())
                data.cookie = localStorage.cookie ? localStorage.cookie : vm.genId() // get id 6 chars 
                data.url = location.href // url 
                data.cta = type ? type : "click"; // click, buy
                data.x = e.clientX //heat map 
                data.y = e.clientY // heat map

                vm.saveCTA(data)

            })
        })

    }
    async saveCTA(data) {
        // console.log(data)
        let endpoint = this.api + "/cta" // do admin insert 
        let res = await fetch(endpoint, {
            method: "POST",
            body: JSON.stringify(data)
        })
        return res
    }
}

export default Track