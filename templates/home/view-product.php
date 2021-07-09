<div id="q-app">
    <template>
        <q-layout>

            <!-- header logo -->
            <q-toolbar class="app-padding">
                <div v-if="site.images" class="q-pa-sm">
                    <!-- header logo -->
                    <a href="<?=get_base(). lang_append()?>" alt="home">
                        <img :src="c.showImage(site.images)" height="60px" loading="lazy" alt="logo" title="Logo"></img>
                    </a>
                </div>

                <div v-else class="orientation-landscape">
                    <div class="text-h5 text-bold"> {{ site.site_name }} {{ site.branch }}</div>
                    <div class="text-caption ellipsis-2-lines">{{ site.site_slogan }} </div>
                </div>

                <q-space></q-space>

                <q-banner class="orientation-landscape">
                    <template v-slot:avatar>
                        <q-icon name="phone" color="primary" />
                    </template>
                    <div class='text-bold text-uppercase text-grey-10'>{{ $t('phone') }}</div>
                    <div>
                        <a class="text-grey-7 text-caption"
                            :href="c.phoneUrl(site.contact_phone? site.contact_phone:'')">
                            {{ site.contact_phone }}
                        </a>
                    </div>
                </q-banner>

                <q-banner class="orientation-landscape">
                    <template v-slot:avatar>
                        <q-icon name="email" color="primary" />
                    </template>
                    <div class='text-bold text-uppercase text-grey-10'>Email</div>
                    <div>
                        <a class="text-grey-7 text-caption" :href="'mailto:'+site.contact_email">
                            {{ site.contact_email }}
                        </a>
                    </div>
                </q-banner>

                <q-banner class="orientation-landscape">
                    <template v-slot:avatar>
                        <q-icon name="place" color="primary" />
                    </template>
                    <div class='text-bold text-uppercase text-grey-10'>{{ $t('address') }}</div>
                    <div>
                        <a class="text-grey-7 text-caption">
                            {{ site.company_address }}
                        </a>
                    </div>
                </q-banner>

                <!-- <a class="text-blue-7" :href="site.contact_zalo">
                    <q-btn flat round icon="comment" />
                </a>
                <a class="text-blue-10" :href="site.contact_facebook">
                    <q-btn flat round icon="facebook" />
                </a> -->
                
                <!-- language  -->
                <q-btn v-if="1==0" flat round icon="g_translate" color="green">
                    <q-menu>
                        <q-list separator style="min-width:120px;">
                            <q-item v-for="(item,index) in langList" :key="index" clickable
                                @click="c.setLang(item.code)">
                                {{ item.text }}
                                <!-- <q-btn dense flat type="a" :href="'/'+item.lang" :label="item.lang" class="full-width"></q-btn> -->
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-btn>
            </q-toolbar>





            <!-- menu 
                ====================================================================== -->
            <div id="main-menu">

                <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                <q-toolbar class="app-padding bg-primary text-white shadow-2 menu">


                    <q-tabs inline-label v-model="tab" shrink swipeable outside-arrow mobile-arrows>
                        <q-tab icon='home' class="cta" @click="c.goto('/')"></q-tab>
                        <q-tab class="cta" v-for="(item,index) in menu"
                            :label="(lang!=defaultLang) ? item['title_' + lang] : item.title"
                            @click="item.children &&item.children.length>0 ? null : c.goto(item.url + (lang!=defaultLang ? '?lang='+lang : '' ) )">

                            <q-menu fit class="cursor-pointer">
                                <q-list separator v-if="item.children&&item.children.length>0">
                                    <q-item v-for="(one,index) in item.children" class="cta" clickable
                                        @click="c.goto(one.url + (lang!=defaultLang ? '?lang='+lang : '' ))"
                                        v-close-popup>
                                        {{ (lang!=defaultLang) ? one['title_' + lang] : one.title }}
                                    </q-item>
                                </q-list>
                            </q-menu>

                        </q-tab>
                    </q-tabs>

                    <!-- <q-space></q-space> -->
                </q-toolbar>

            </div>


            <!-- an article 
            ==================================== -->

            <div v-if="object" class="row q-col-gutter-md app-padding q-mt-md q-mb-xl q-pb-xl">
                <!-- left pane  -->
                <div class="col-12 col-md-5">
                    <div>
                        <q-img class="rounded-borders" :src="c.showImage(object.images)" :ratio="1"></q-img>
                    </div>
                    <!-- san pham lien quan  -->
                    <div class="row q-gutter-sm q-mt-sm cursor-pointer">

                        <div v-if="related_images && related_images.length>0" v-for="(one,index) in related_images"
                            :key="index" class="col">
                            <q-img class="rounded-borders" :src="c.showImage(one)" :ratio="1" clickable @click="selectedImage=one;dialog=true">
                            </q-img>
                        </div>

                    </div>

                </div>

                <!-- right pane  -->
                <div class="col-12 col-md-7">
                    <div>
                        <div class="text-h5 text-bold text-primary" v-html="object.title"></div>
                        <div class="text-caption">SKU: {{ object.sku }}</div>
                        <q-separator></q-separator>
                        <div class="q-my-sm">
                            <q-badge transparent align="middle" color="red">
                                {{ showDiscount(object.price, object.retail_price) }}
                            </q-badge>
                            <span class="text-h5  text-bold text-red">{{
                                object.price ? c.formatCurrency(object.price) : $t('call')
                                }}</span>
                            <s class="text-grey">{{ c.formatCurrency(object.retail_price)}}</s>

                        </div>
                        <q-separator></q-separator>
                        <div class="q-my-md">
                            <q-icon name="star" class="text-orange" v-for="one in 5"></q-icon>
                            <q-chip color="green" outline text-color="white" icon="beenhere">
                                <span class="text-caption">{{ $t('checked')}}</span>
                            </q-chip>
                        </div>
                        <!-- <q-toolbar class="no-padding">
                            <q-input outlined type="number" min="1" v-model.number="quantity"
                                style="width:60px;">
                            </q-input>
                            <q-btn push class="q-ml-sm" color="primary" label="Thêm vào giỏ"
                                @click="addToCart()"></q-btn>

                            <q-btn v-if="cart.length>0" push class="q-ml-sm" color="red" label="Mua ngay"
                                @click="show_checkout=true;"></q-btn>

                        </q-toolbar> -->

                        <q-btn push class="" color="red" label="Mua ngay"
                                @click="c.goto('/shop#/'+object._id)"></q-btn>

                    </div>

                    <div class="col-12 col-md-12">
                        <h2 class="text-subtitle1 text-bold">Mô tả sản phẩm</h2>
                        <div v-html="object.summary"></div>
                        <div v-html="object.content"></div>
                    </div>
                </div>


            </div>



            <!-- call to action 
            ==================================== -->
            <div class="q-my-lg text-center">
                <a v-if="site.cta_link1" :href="site.cta_link1" :alt="site.keywords">
                    <q-btn push size="xl" class="q-pa-xs" color="primary" :label="site.cta_text1">
                    </q-btn>
                </a>
                <a v-if="site.cta_link2" :href="site.cta_link2" :alt="site.keywords">
                    <q-btn push size="xl" class="q-pa-xs" color="secondary" :label="site.cta_text2">
                    </q-btn>
                </a>
                <!-- admin icon -->
                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                    @click="editPost('<?=$object_type?>',object._id)">
                </q-btn>

            </div>


            <!-- show an image popup  -->
            <q-dialog v-model="dialog">
                <div style="width:90vw" class="bg-white q-pa-md">
                    <q-img :src="selectedImage" style="width:100%"></q-img>
                </div>
            </q-dialog>



            <?php 
                global $DEFAULT_LANG; 
                $lang = $_SESSION['lang'];
                if ($lang!='vi')
                    include __DIR__."/../footer.php"; 
                else 
                    include __DIR__."/../footer-vi.php"; 
            ?>


            <!-- place QPageScroller at end of page -->
            <q-page-scroller expand position="top" :scroll-offset="150" :offset="[0, 0]">
                <!-- menu 
                ====================================================================== -->

                <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                <q-toolbar class="app-padding text-white bg-primary shadow-2 menu">

                    <q-tabs inline-label v-model="tab" shrink swipeable outside-arrow mobile-arrows>
                        <q-tab icon='home' class="cta" @click="c.goto('/')"></q-tab>
                        <q-tab class="cta" v-for="(item,index) in menu" :label="item.title"
                            @click="item.children.length>0 ? null : c.goto(item.url)">

                            <q-menu fit class="cursor-pointer">
                                <q-list separator v-if="item.children&&item.children.length>0">
                                    <q-item v-for="(one,index) in item.children" class="cta" clickable
                                        @click="c.goto(one.url)" v-close-popup>
                                        {{ one.title }}
                                    </q-item>
                                </q-list>
                            </q-menu>

                        </q-tab>
                    </q-tabs>

                    <!-- <q-space></q-space> -->
                </q-toolbar>

            </q-page-scroller>




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
    window.lang  = <?= json_encode($lang); ?>;
    window.defaultLang  = <?= json_encode($DEFAULT_LANG); ?>;

    window.site = <?= json_encode($site); ?>;
    window.category = <?= json_encode($category); ?>;
    window.object = <?= json_encode($object); ?>;
    window.objectType = '<?=(string)($object_type)?>';
    window.policy = <?= json_encode($policy); ?>;

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
            call: "Call",
            policy: "Policy",
            company_owner : "Business Owner",


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
            call: "Liên hệ",
            policy: "Chính sách",
            company_owner : "Đại diện pháp luật",


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
                lang: '',
                langList: [],
                defaultLang : "",

                menu: [],
                menu_lang: [],
                tab: 'home',
                category: [],
                object: {},
                // quantity: 0,
                // cart: [],
                dialog: false,
                selectedImage: "",

                policy: [] 


            }
        },
        mounted() {
            this.track.cta()
        },
        created() {
            this.init()
            this.track.ping()

        },
        computed: {
            related_images() {
                let vm = this
                let imgs = (vm.object.images && vm.object.images.includes(',')) ? vm.object.images.split(',') : []
                return imgs
            },
        },
        methods: {
            init() {
                let vm = this

                this.lang = window.lang
                this.defaultLang  = window.defaultLang 

                this.site = window.site
                this.object = window.object
                this.objectType = window.object_type
                this.category = window.category
                this.policy = window.policy 
                // console.log(this.object_type)


                vm.menu = vm.loadMenu('main-menu')

                console.log(vm.related_images)

                // vm.policy = vm.getByCategory('post', 'chinh-sach', 8)


            },

            loadMenu(slug) {
                // slug = main menu 
                let vm = this
                if (vm.category.length <= 0) return []

                const allCate = vm.category
                const menu = allCate.filter(f => f.parent_slug == slug)

                // sort alphabet asc 
                let res = menu.sort(function (a, b) {
                    if (a.doc_order > b.doc_order) return 1
                    if (a.doc_order < b.doc_order) return -1
                    return 0;
                });

                // menu cap 2 
                res.forEach(main => {
                    // main.slug + main.children 
                    allCate.forEach(sub => { // data chu khong phai menu 
                        if (sub.parent_id == main._id) {
                            if (!main.children) main.children = [] // QUANTRONG
                            main.children.push(sub)
                        }
                    })
                })

                return res

            },

            showDiscount(price, rprice) {
                if (!price || !rprice) return ""
                if (rprice == 0) return ""
                let vm = this
                let res = ((rprice - price) / rprice * 100).toFixed(0)
                return res + "%"
            },

            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast("Đã kích hoạt Nút sửa bài", 'negative')
                else
                    this.c.toast("green", "Trở về trạng thái bình thường", 'positive')
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
        background: url('<?=get_base()?>/images/bg-1.png');
        background-size: cover;
    }

    .bg-2 {
        background: url('<?=get_base()?>/images/bg-2.png');
        background-size: cover;
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

    .app-padding {
        padding-left: 12vw;
        padding-right: 12vw;
    }

    .section-padding {
        padding-left: 12vw;
        padding-right: 12vw;
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

        .text-h3{
            font-size: 2rem;
        }
        .text-h4{
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