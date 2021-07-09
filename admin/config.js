let isLocal = location.href.includes('localhost')

const API_LOCAL = 'http://localhost:3000'
// const API_SERVER = 'https://api.webup.top'  // CHANGE-HERE
const API_SERVER = 'https://api.hitime.vn'  // CHANGE-HERE
let API = isLocal ? API_LOCAL : API_SERVER

const WEB_URL = 'https://danhba.top/web/shilenanailsspa' // CHANGE-HERE 
const DOMAIN = 'hoadalandscape' // CHANGE-HERE 
const TOKEN = '123456789' // CHANGE-HERE 
const PLAN = 2

let WEB = isLocal ? 'http://localost:3004' : WEB_URL

const CONFIG = {
    API: API,
    WEB: WEB_URL,
    DOMAIN: DOMAIN,
    TOKEN: TOKEN,
    PLAN: PLAN,
    LANG: "vi",
    UI: { logo: "logo.png", banner: "login.svg", outlined: !0, primary: "#000000", secondary: "#eeeeee", info: "#f8f8f8" }
}