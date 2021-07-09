<div id="q-app">
    <template>
        <q-layout>
            <q-page-container>
                <q-page class="no-padding">

                    <!-- pst header with background  -->
                    <div class="bg-1">
                        <div class="row section-padding">
                            <div class="col-12 col-md-8 text-white">
                                <h2 class="text-subtitle1">{{ site.site_name }}</h2>
                                <h1 class="text-h4 q-mb-xl" v-html="object.title"></h1>

                                <a href="#" onclick="window.history.go(-1);" class="text-grey-5 text-caption">
                                    <q-icon name="west" size="md"></q-icon>
                                    <!-- Trở lại -->
                                </a>
                            </div>
                            <div class="col-12 col-md-4">
                                <q-img class="rounded-borders" :src="c.showImage(object.images)" />
                            </div>
                        </div>
                    </div>


                    <!-- post content -->
                    <div class="post" style="min-height:40vh;">
                        <blockquote v-html="object.summary"></blockquote>
                        <div v-html="object.content"></div>
                    </div>


                    <!-- call to actions  -->
                    <div class="q-my-lg text-center">
                        <a v-if="site.cta_link1" :href="site.cta_link1" :alt="site.keywords">
                            <q-btn glossy v-ripple size="xl" class="q-pa-xs" color="primary" :label="site.cta_text1">
                            </q-btn>
                        </a>
                        <a v-if="site.cta_link2" :href="site.cta_link2" :alt="site.seo.keywords">
                            <q-btn glossy v-ripple size="xl" outline class="q-pa-xs" color="secondary"
                                :label="site.cta_text2">
                            </q-btn>
                        </a>
                        <!-- admin icon -->
                        <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                            @click="editPost('<?=$object_type?>',object._id)">
                        </q-btn>

                    </div>

                    <?php 
                        global $DEFAULT_LANG; 
                        $lang = $_SESSION["lang"];
                        

                        if ($lang!='vi')
                            include __DIR__."/footer.php"; 
                        else {
                            $policy = show_policy();
                            include "footer-vi.php"; 
                        }
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

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f6324125617127c"></script>

<script>
    // global var from php
    //---------------------------------------------------
    window.site = <?= json_encode($site); ?>;
    window.object = <?= json_encode($object); ?>;
    window.objectType = '<?=(string)($object_type)?>';

    // console.log(window.object ? window.object : {})

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
<script src="https://unpkg.com/vue-i18n@8"></script>


<script type="module">
    import Track from './config/track.js'
    import Common from './config/common.js'
    Quasar.lang.set(Quasar.lang.vi)

    const messages = {
        en: {
            phone: 'Phone',
            address: 'Address',
            edit_mode: 'Activate Edit mode',
            normal_mode: 'Back to normal',
            social: 'Socials',
            contact: 'Quick Contact',
            news: 'News',
            product: 'List of Products',
            detail: 'View detail',
            more: 'View more',
            home: 'Home',
            features: 'Featured Products',
            articles: 'Articles',
            search: 'Search',
        },
        vi: {
            phone: 'Điện thoại',
            address: 'Địa chỉ',
            edit_mode: 'Đã kích hoạt chế độ sửa bài',
            normal_mode: 'Đã trở lại bình thường',
            social: 'Mạng xã hội',
            contact: 'Liên hệ',
            news: 'Tin tức hoạt động',
            product: 'Danh sách Sản phẩm',
            detail: 'Chi tiết',
            more: 'Xem thêm',
            home: 'Trang chủ',
            features: 'Sản phẩm nổi bật',
            articles: 'Bài viết',
            search: 'Tìm kiếm',
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
                site: {},
                guest: {}, // visitor
                edit: false,
                object: {},
                objectType: '',
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
                this.site = window.site
                this.object = window.object
                this.objectType = window.object_type
                // console.log(this.object_type)
            },
            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast("Đã kích hoạt Nút sửa bài", 'negative')
                else
                    this.c.toast("green", "Trở về trạng thái bình thường", 'positive')
            },
            editPost(object, id) {
                let link = "/admin/#/" + object + "/" + id
                location.href = link
            },
            editMaster() {
                let link = "/admin/#/site/" + site._id
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

    .text-h1,
    .text-h2,
    .text-h3,
    .text-h4,
    .text-h5 {
        letter-spacing: -1px;
        font-family: "Krub";
        font-weight: 700;
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

        iframe {
            width: 100%;
        }
    }
</style>