<div id="q-app">
    <template>
        <q-layout>
            <q-page-container>
                <q-page class="no-padding">
                    <div class="bg-1">
                        <div class="row section-padding">
                            <div class="col-12 col-md-8 text-white">
                                <div class="text-subtitle1">{{ site.site_name }}</div>
                                <h1 class="text-h4 q-mb-xl">{{ $t('we_will_feedback') }}</h1>
                                <a href="<?=get_base()?>" class="text-grey-5 text-caption">
                                    <q-icon name="west" size="md"></q-icon>
                                    <!-- Trở lại -->
                                </a>
                            </div>
                            <div class="col-12 col-md-4">
                                <!-- <q-img class="rounded-borders" :src="showImages(site.images)" /> -->
                            </div>
                        </div>
                    </div>

                    <div class="post" style="min-height:40vh;">

                        <q-form @submit="submit" @reset="reset" class="row q-col-gutter-xs">
                            <q-input filled v-model="guest.name" class="col-12 col-md-6" :label="$t('name')+'*'">
                            </q-input>
                            <q-input filled v-model="guest.position" class="col-12 col-md-6" :label="$t('position')">
                            </q-input>
                            <q-input filled v-model="guest.phone" class="col-12 col-md-6" :label="$t('phone')+'*'">
                            </q-input>
                            <q-input filled v-model="guest.email" class="col-12 col-md-6" :label="'Email*'"></q-input>
                            <!-- <q-input filled v-model="guest.company" class="col-12 col-md-6" :label="$t('company')"></q-input> -->
                            <!-- <q-input filled v-model="guest.address" class="col-12 col-md-6" :label="$t('address')"></q-input> -->
                            <q-input filled v-model="guest.province" class="col-12 col-md-6"
                                :label="$t('province')+'*'"></q-input>
                            <q-input filled v-model="guest.products" class="col-12 col-md-6" :label="$t('request')"
                                placeholder="..."></q-input>
                            <!-- <q-input filled v-model="guest.size" type="number" class="col-12 col-md-3" :label="$t('size')"> -->
                            </q-input>
                            <!-- <q-input filled v-model="guest.industry" class="col-12 col-md-9" :label="$t('industry')"
                placeholder="..."> -->
                            </q-input>
                            <q-input filled v-model="guest.first_request" type="textarea" class="col-12 col-md-12"
                                :label="$t('first_request')"></q-input>

                            <div class="q-mt-lg">
                                <q-btn push :label="$t('send')" type="submit" color="primary"></q-btn>
                                <q-btn :label="$t('reset')" type="reset" color="primary" flat class="q-ml-sm"></q-btn>
                            </div>
                        </q-form>

                    </div>

                    <?php 
                        global $DEFAULT_LANG; 
                        $lang = $_SESSION["lang"];
                        $policy = show_policy();


                        if ($lang!='vi')
                            include __DIR__."/footer.php"; 
                        else 
                            include "footer-vi.php"; 
                    ?>

                </q-page>
            </q-page-container>
        </q-layout>
    </template>
</div>

<!-- schema org LocalBusiness -->
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "LocalBusiness",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?=$site->company_address?>"
    },
    "description": "<?=$site->description?>",
    "name": "<?=$site->company_name?>",
    "telephone": "<?=$site->contact_phone?>"
    }
</script>

<script>
    // global var from php
    //---------------------------------------------------
    window.site = <?= json_encode($site); ?>;
    console.log(window.site ? window.site : {})

    // optional
    window.quasarConfig = {
        brand: { // this will NOT work on IE 11
            primary: window.site.color_primary ? window.site.color_primary : "blue", //red , #808080
            secondary: window.site.color_secondary ? window.site.color_secondary : "green",
            // ... or all other brand colors
        },
        notify: {},
        loading: {},
        loadingBar: {
            color: window.site.color_secondary ? window.site.color_secondary : "green",
            'skip-hijack': true
        },
        scroll: {}, // must have 
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.min.js"></script>
<!-- <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quasar@1.15.15/dist/quasar.umd.modern.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.15.15/dist/lang/vi.umd.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-i18n@8"></script>

<script type="module">
    import Track from './config/track.js'
    import Common from './config/common.js'

    Quasar.lang.set(Quasar.lang.vi)
    // thiet lap da ngon ngu 
    const messages = {
        en: {
            phone: 'Phone',
            address: 'Address',
            edit_mode: 'Activate Edit mode',
            normal_mode: 'Back to normal',
            social: 'Socials',
            contact: 'Quick Contact',
            news: 'News',
            product: 'Products',
            detail: 'View detail',
            more: 'View more',
            home: 'Home',
            features: 'Featured Posts',
            articles: 'Articles',

            input_invalid: "Input Invalid",
            we_will_feedback: 'Leave a message, we will contact you soon',
            name: 'Full name',
            position: 'Position',
            company: 'Company name',
            province: 'Province',
            industry: 'Industry',
            request: 'Products in mind',
            size: 'Number of employees',
            notes: 'Notes',
            first_request: 'First request',
            send: 'Send',
            reset: 'Reset',

        },
        vi: {
            phone: 'Điện thoại',
            address: 'Địa chỉ',
            edit_mode: 'Đã kích hoạt chế độ sửa bài',
            normal_mode: 'Đã trở lại bình thường',
            social: 'Mạng xã hội',
            contact: 'Liên hệ',
            news: 'Tin tức hoạt động',
            product: 'Sản phẩm',
            detail: 'Chi tiết',
            more: 'Xem thêm',
            home: 'Trang chủ',
            features: 'Bài viết nổi bật',
            articles: 'Bài viết',

            we_will_feedback: 'Hãy để lại thông tin, chúng tôi sẽ liên hệ',
            input_invalid: 'Vui lòng nhập đúng và đủ thông tin',

            name: 'Tên đầy đủ',
            position: 'Chức vụ',
            company: 'Tên công ty',
            province: 'Tỉnh thành',
            industry: 'Ngành nghề',
            request: 'Sản phẩm quan tâm',
            size: 'Số nhân viên',
            notes: 'Ghi chú',
            first_request: 'Yêu cầu ban đầu',
            send: 'Gửi đi',
            reset: 'Làm lại',
        }
    }
    const i18n = new VueI18n({
        locale: '<?=$lang ? $lang : 'vi'?>',
        messages,
    })

    new Vue({
        el: "#q-app",
        i18n: i18n,
        data() {
            return {
                track: new Track(),
                c: new Common(this.$q),
                // api: null,
                collection: "contact",
                site: {},
                guest: {}, // visitor
                edit: false,
                object: {},
            }
        },
        mounted() {
            this.track.cta()
        },
        created() {
            this.init()
            this.track.ping()
        },
        methods: {
            init() {
                let vm = this

                this.reset() // the form
                this.site = window.site
                // this.object = window.object
            },
            addBranch(branch) {
                let at = [" tại ", " ở ", " khu vực ", " ở khu vực ", " ở địa bàn ", " trên địa bàn ", " địa bàn "]
                let i = Math.floor(Math.random() * at.length);
                if (branch && branch != "") {
                    return at[i] + branch
                } else {
                    return ""
                }
            },
            reset() {
                this.guest = {}
            },
            valid() {
                return (this.guest.name && this.guest.phone && this.guest.email && this.guest.province)
            },
            async submit() {
                // save contact to contact 
                // alert("save")
                let vm = this

                if (!vm.valid()) {
                    vm.c.toast(this.$t('input_invalid'), 'negative')
                    return false
                }

                // vm.guest in form and ...
                vm.guest.cookie = localStorage.cookie ? localStorage.cookie : null
                vm.guest.name = vm.guest.name // not null 
                vm.guest.phone = vm.guest.phone

                vm.guest.slug = vm.c.genCode("CO")  // not null 
                vm.guest.code = vm.guest.slug
                vm.guest.title = vm.guest.name
                vm.guest.aff = "<?=$site->embed_aff?>";
                vm.guest.source = location.href
                vm.guest.type = "Online"
                vm.guest.owner = vm.guest.aff ? vm.guest.aff : 'online'

                vm.guest.date_created = vm.track.formatDataDate(new Date())
                vm.guest.date_updated = vm.track.formatDataDate(new Date())
                vm.guest.date_start = vm.track.formatDataDate(new Date())

                let postdata = JSON.stringify(vm.guest)
                vm.c.log(postdata)

                vm.loading = true
                let endpoint = vm.track.api + "/contact"
                let res = await axios.post(endpoint, vm.guest) // call api 

                vm.c.log(res)
                vm.loading = false

                vm.c.goto('/thank<?=lang_append()?>')

            },
            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast(this.$t('edit_mode'), 'negative')
                else
                    this.c.toast(this.$t('normal_mode'), 'positive')
            },
            editPost(object, id) {
                let link = "./admin/#/" + object + "/" + id
                location.href = link
            },
            editMaster() {
                let link = "./admin/#/master" + site.slug
                location.href = link
            },
        },
        // ...etc
    })
</script>

<style scoped>
    * {
        font-size: 16px;
        border: solid 0px #eee;
    }

    a {
        text-decoration: none
    }

    a:hover {
        color: #ccc
    }

    .bg-1 {
        background: url('<?=get_base()?>/images/bg-1.jpeg');
        background-size: cover;
    }

    .bg-2 {
        background: url('<?=get_base()?>/images/bg-2.jpeg');
        background-size: cover;
    }

    .section-padding {
        padding-left: 8vw;
        padding-right: 8vw;
        padding-top: 10vh;
        padding-bottom: 10vh;
    }

    .post {
        padding-left: 20vw;
        padding-right: 20vw;
        padding-top: 10vh;
        padding-bottom: 10vh;
    }

    .post blockquote {
        margin: 0;
        margin-bottom: 2rem;
        padding: 2rem;
        background-color: #f8f8f8;
        border-left: solid 5px <?=$site->color_secondary?>;
    }


    ul li {
        margin-left: -20px;
    }

    @media (orientation: portrait) {

        .text-h4,
        .text-h4,
            {
            font-size: 1.6rem;
        }

        .section-padding {
            padding: 20px !important;
        }

        .post {
            padding: 20px !important;
        }
    }
</style>