class Common {
    constructor(q) {
        this.q = q
    }
    isDev() {
        return location.href.includes("localhost")
    }
    isMobile() {
        // is mobile or landscape 
        if (this.q.platform.is.mobile) return true
        if (this.q.screen.height > this.q.screen.width) return true
        return false
    }
    log(text) {
        if (this.isDev()) {
            console.log("%c" + ("Check"), "color:blue; font-size:16px; font-weight:bold");
            console.log("%O", text);
        }
    }
    toast(text, color = 'dark') {
        this.q.notify({ progress: true, timeout: 1500, message: text, color: color, })
    }
    scrollTo(id) {
        var el = document.getElementById(id)
        el.scrollIntoView({ behavior: "smooth" });
    }

    isPortrait() {
        let orentiation = window.screen.orientation
        // console.log(orentiation)
        return (orentiation.type == "portrait-secondary" || orentiation.type === "portrait-primary") ? true : false
    }

    goto(link, lang = null) {
        if (!link) return '#'
        let res = link
        if (lang) {
            res = link + "?lang=" + lang
        }
        location.href = res
    }

    genId(max) {
        // Math.random should be unique because of its seeding algorithm.
        // Convert it to base 36 (numbers + letters), and grab the first MAX characters
        // after the decimal.
        let uuid = Math.random().toString(36).substr(2, max);
        return uuid
    }
    genCode(module) {
        let c = module + '-'
        let fstr = "%Y%m%d"; // format string
        c += this.formatDataDate(new Date(), fstr)
        c += '-' + this.genId(2)

        return c;
    }
    addBranch(branch) {
        let at = [" tại ", " ở ", " khu vực ", " ở khu vực ", " ở địa bàn ", " trên địa bàn ", " địa bàn "]
        let i = Math.floor(Math.random() * at.length);
        if (branch && branch != "") {
            return at[i] + branch
        } else {
            return ""
        }
    }
    parse_domain(data) {
        if (!data.includes('http')) return data;
        const { hostname } = new URL(data);
        return hostname;
    }

    firstChar(text) {
        let vm = this
        if (!text) return "";
        let split = text.split(" ");
        let res = split[0];
        return res
            .charAt(0)
            .trim()
            .toUpperCase();
    }

    switchLink(lang) {
        // not use!!
        let cur = location.href
        let res
        if (cur.includes('/vi')) {
            res = cur.replace('/vi', '/' + lang.toLowerCase() + '')
            location.href = res
        }
        if (cur.includes('/en')) {
            res = cur.replace('/en', '/' + lang.toLowerCase() + '')
            location.href = res
        }
        // more lang ... 
    }
    setLang(code) {
        let hr = location.href.replace('?lang=vi', '').replace('?lang=en', '')
        // replace more in langList
        let res = hr + (hr.includes('?') ? '&' : '?') + "lang=" + code;
        location.href = res.replace('?lang=vi', '').replace('?lang=vi', '') // bo lang=vi di
    }

    showImage(image, index = null) {
        if (image && image != '') {
            if (image.includes(",")) {
                let res = image.split(",")
                let arrayImages = res.map(m => m.trim())
                if (index) return arrayImages[index]
                else return arrayImages[0]
            } else
                return image.trim()
        }
        else {
            return './images/shop.svg' // sample 
            // return 'images/kimhungphu-' + (i < 2 ? 2 : i) + '.jpg'
            // return 'https://file.hstatic.net/200000272081/file/dam_maxi_cfc2844468f54ab593ee1c55bc636228.jpg'
        }
    }

    sum(array, prop) {
        let vm = this
        let total = 0
        total = array.filter(f => f[prop]).map(m => m[prop]).reduce(function (a, b) {
            return a + b
        }, 0)

        return total;
    }
    count(array, prop) {
        let vm = this
        let count = 0
        count = array.filter(f => f[prop]).length
        return count;
    }



    formatCurrency(amount) {
        if (!amount) return ""
        if (amount && amount == 0) return ""
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    formatDate(dateString) { // to save 
        if (!dateString) return ""
        return dateString.toLocaleString('vi-VN', { style: 'date' });
    }


    formatPercent(amount) {
        return amount.toFixed(0)
    }

    formatDataDate(date, str = null) {
        let fstr = "%Y-%m-%d %H:%M:%S"; // fixed for sqlite 
        // fstr = "%Y-%m-%d %H:%M"; // fixed for sqlite 
        if (str) fstr = str;

        let utc = false // fixed 
        utc = utc ? 'getUTC' : 'get';
        return fstr.replace(/%[YmdHMS]/g, function (m) {
            switch (m) {
                case '%Y': return date[utc + 'FullYear'](); // no leading zeros required
                case '%m': m = 1 + date[utc + 'Month'](); break;
                case '%d': m = date[utc + 'Date'](); break;
                case '%H': m = date[utc + 'Hours'](); break;
                case '%M': m = date[utc + 'Minutes'](); break;
                case '%S': m = date[utc + 'Seconds'](); break;
                default: return m.slice(1); // unknown code, remove %
            }
            // add leading zero if required
            return ('0' + m).slice(-2);
        });
    }
    dateDiff(date1, date2) {
        let i = Math.floor((date1 - date2) / (1000 * 60 * 60 * 24)) + 1
        return i
    }
    showPhoto(selected) {
        // array of photos 
        var vm = this
        let photos = []
        photos = vm.getImagesFromString(selected.content)
        return photos
    }
    getImagesFromString(string) {
        // get <img> from content 
        // let str = string.replace(/["']/g, "\"")
        // const imgRex = /<img[^>]+src='?([^"\s]+)'?\s*\/>/g;
        const imgRex = /<img.*?src="(.*?)"[^>]+>/g;
        const images = [];
        let img;
        while (img = imgRex.exec(string)) {
            console.log(img)
            images.push(img[1]);
        }
        return images;
    }

    phoneUrl(phone) {
        if (!phone) return ""
        var res = phone.substring(1, phone.length)
        return "tel:+84" + res
    }

    // mail 
    reset() {
        this.guest = {}
    }
    valid() {
        return (this.guest.firstname && this.guest.phone && this.guest.email && this.guest.province)
    }
    send() {
        var vm = this
        if (!vm.valid()) {
            vm.toast("black", "Bạn vui lòng cung cấp đủ thông tin để chúng tôi liên hệ lại")
            return
        }

        // vm.item bind v-model, add more  
        vm.guest.firstdate = new Date().toLocaleString()
        vm.guest.doctype = "lead"
        vm.guest.source = window.location.hostname // chu y luon co source 
        // console.log(vm.guest)

        let subject = "Yêu cầu từ " + vm.guest.firstname + " (" + vm.guest.phone + ") - " + vm.guest.province
        let body = "Tôi là: " + vm.guest.firstname
        body += "%0d%0a Số phone: " + vm.guest.phone
        body += "%0d%0a Email: " + vm.guest.email
        body += "%0d%0a Nội dung yêu cầu: "
        body += "%0d%0a " + vm.guest.firstrequest

        let link = "mailto:" + vm.site.contact.email + "?subject=" + subject + "&body=" + body
        vm.gotoLink(link)

        setTimeout(function () {
            location.href = "<?=get_base_lang()?>/thank";
        }, 2000)

    }
    editorToolbar() {
        let str = ""
        str = [
            ['bold', 'italic', 'underline', 'removeFormat'],
            ['unordered', 'ordered', 'undo', 'redo'],
            [{
                label: ' ', // tricks en 
                icon: 'format_size',
                list: 'no-icons',
                options: ['p', 'h5', 'h6', 'code']
            }],
            ['fullscreen', 'viewsource']
        ]
        return str
    }

    printDiv(divid, title) {
        var contents = document.getElementById(divid).innerHTML;
        var frame1 = document.createElement('iframe');
        frame1.name = "frame1";
        frame1.style.position = "absolute";
        frame1.style.top = "-1000000px";
        document.body.appendChild(frame1);
        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
        frameDoc.document.open();
        frameDoc.document.write(`<html><head><title>${title}</title>`);
        frameDoc.document.write('</head><body>');
        // add styles 
        frameDoc.document.write('</head><body>');
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            document.body.removeChild(frame1);
        }, 500);
        return false;
    }

    fetchFilter(prop) {
        let res = []
        res = this.posts.map(m => m[prop])

        var result = [];
        res.forEach(function (item) {
            if (item && result.indexOf(item) < 0) {
                result.push(item);
            }
        });
        return result;
    }

    loginByPassCode() {
        // by passcode
        let passcode = "<?=get_base()?>" + "@@@"; // no change 
        let passcode_stored = localStorage.getItem("passcode") ? localStorage.getItem("passcode") : null;

        if (!passcode_stored) {
            let pr = prompt("Đăng nhập vào admin:")
            if (pr != passcode) {
                location.href = "<?=get_base()?>"
                return false
            } else {
                // success 
                localStorage.setItem("passcode", passcode.trim());
            }
        }

    }

    setProfile(userData) {
        if (userData) {
            localStorage.setItem('username', userData.username)
            localStorage.setItem('password', userData.password)
            localStorage.setItem('roles', userData.roles)
            localStorage.setItem('name', userData.name)
        } else {
            localStorage.removeItem('username')
            localStorage.removeItem('password')
            localStorage.removeItem('roles')
            localStorage.removeItem('name ')
        }
    }

    getProfile() {
        let lastLogin = {}
        lastLogin.username = localStorage.getItem('username')
        lastLogin.password = localStorage.getItem('password')
        lastLogin.roles = localStorage.getItem('roles')
        lastLogin.name = localStorage.getItem('name')
        return lastLogin
    }

    dofetch(endpoint, method, data = null) {
        // https://jsonplaceholder.typicode.com/posts // for test
        let vm = this
        let options = {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }
        let res
        if (method == 'GET') {
            res = fetch(endpoint)
                .then((res) => res.json())
                .then((data) => {
                    vm.log(data)
                    return data;
                }).catch((err) => err)
        }
        if (method == 'POST') {
            res = fetch(endpoint, options)
                // .then((res) => res.text()) // TEST result 
                .then((res) => res.json())
                .then((data) => {
                    vm.log(data)
                    return data;
                })
                .catch((err) => err)
        }
        if (method == 'PUT') {
            res = fetch(endpoint, options)
                .then((res) => res.text()) // TEST result 
                // .then((res) => res.json())
                .then((data) => {
                    vm.log(data)
                    return data;
                })
                .catch((err) => err)
        }
        if (method == 'DELETE') {
            res = fetch(endpoint, { method: 'DELETE' }) // endpoint co id khong dung options 
                // .then((res) => res.text()) // TEST result 
                .then((res) => res.json())
                .then((data) => {
                    vm.log(data)
                    return data;
                }).catch((err) => err)
        }

        return res
    }

}

export default Common