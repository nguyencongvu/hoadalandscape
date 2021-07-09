<div id="q-app">
    <template>
        <q-layout>
            <!-- toolbar menu 
        ======================= -->
            <q-toolbar class="app-padding">
                <div v-if="site.images" class="q-pa-sm">
                    <!-- header logo -->
                    <a href="<?=get_base()?>/<?=lang_append()?>" alt="home">
                        <img :src="c.showImage(site.images)" height="60px" loading="lazy" alt="logo" title="Logo"></img>
                    </a>
                </div>

                <div v-else class="orientation-landscape">
                    <div class="text-h5 text-bold"> {{ site.site_name }} {{ site.branch }}</div>
                    <div class="text-caption ellipsis-2-lines">{{ site.site_slogan }} </div>
                </div>

                <q-space></q-space>
                <!-- search  -->
                <q-btn flat round icon="search" class="q-ml-sm" @click="showsearch=true">
                    <q-menu>
                        <q-input v-if="showsearch" outlined v-model="text" clearable :placeholder="$t('search')">
                        </q-input>
                    </q-menu>
                </q-btn>
                
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
                    <q-btn flat round icon="comment"></q-btn>
                </a>
                <a class="text-blue-10" :href="site.contact_facebook">
                    <q-btn flat round icon="facebook"></q-btn>
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






            <!-- toolbar = menu 
            ====================================================== -->
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





            <!-- slider 
        ========================================================================== -->
            <q-carousel v-if="1==0" id="slider" v-if="slider&&slider.length>0" navigation-position="bottom" swipeable
                navigation autoplay infinite animated transition-prev="slide-right" transition-next="slide-left"
                @mouseenter="autoplay = false" @mouseleave="autoplay = true" control-type="regular"
                control-color="white" v-model="slide">

                <q-carousel-slide v-for="(one,index) in slider" :key="one.id" :name="one.id" :img-src="one.img">
                    <div v-if="1==0" class="absolute-bottom custom-caption">
                        <h1 v-if="index==0">{{ one.h1 }}</h1>
                        <h2 v-else>{{ one.h1 }}</h2>
                        <!-- <div class="text-subtitle1 q-pt-xs">{{ one.p }}</div> -->
                    </div>
                </q-carousel-slide>
            </q-carousel>


            <!-- bg top
            ==================================== -->
            <div class="bg-1">
                <div class="row section-padding">
                    <div class="col-12 col-md-8 text-white">
                        <div class="text-subtitle1">{{ $t('category') }}</div>
                        <h1 class="text-h3 q-mb-xl">{{ categoryTitle ? categoryTitle : $t(objectType) }}</h1>
                        <a href="#" onclick="window.history.go(-1);" class="text-grey-5 text-caption">
                            <q-icon name="west" size="md"></q-icon>
                            <!-- Trở lại -->
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- <q-img class="rounded-borders" :src="c.showImage(object.images)" /> -->
                    </div>
                </div>
            </div>




            <!-- features 
        ============================================== -->
            <div v-if="text==''" class="section-padding">
                <h2 class="text-h4 text-primary">
                    <q-icon name="auto_graph"></q-icon> {{ $t(objectType) }} {{ $t('features') }}
                </h2>
                <!-- feature_posts  -->
                <div class="row q-col-gutter-md">
                    <div v-for="(one,index) in feature_posts" class="col-6 col-md-3">
                        <q-card class="card">
                            <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                :alt="site.keywords" class="cta">
                                <q-img :ratio="4/3" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <!-- <div class="absolute text-caption" style="bottom: 8px; left:0px">{{
                                        one.category}}
                                    </div> -->
                                </q-img>
                            </a>
                            <q-card-section>
                                <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                    :alt="site.keywords" class="text-primary">
                                    <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>

                                <div v-if="one.price" class="q-mt-md">
                                    <span class="text-red text-bold">{{ one.price ? c.formatCurrency(one.price) :
                                        $t('call') }}</span>
                                    <s class="text-grey text-caption">{{ c.formatCurrency(one.retail_price)
                                        }}</s>
                                </div>
                            </q-card-section>
                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one.id)">
                                </q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>






            <!-- list of posts 
        ====================================================== -->
            <div id="blog_list" class="section-padding orientation-landscape">
                <h2 class="text-h4 text-primary">
                    <q-icon name="sell"></q-icon> {{ $t(objectType) }} {{ categoryTitle }}
                </h2>
                <!-- layout == col -->
                <div class="row q-col-gutter-md">

                    <div v-for="(one,index) in fsearch" class="col-6 col-md-3">
                        <q-card class="card">
                            <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                :alt="site.keywords" class="cta">
                                <q-img :ratio="4/3" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <!-- <div class="absolute text-caption" style="bottom: 8px; left:0px">{{
                                        one.category}}
                                    </div> -->
                                </q-img>
                            </a>
                            <q-card-section>
                                <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                    :alt="site.keywords" class="text-primary">
                                    <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>

                                <div v-if="one.price" class="q-mt-md">
                                    <span class="text-red text-bold">{{ one.price ? c.formatCurrency(one.price) :
                                        $t('call') }}</span>
                                    <s class="text-grey text-caption">{{ c.formatCurrency(one.retail_price)
                                        }}</s>
                                </div>
                            </q-card-section>
                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one.id)">
                                </q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>

            </div>
            <!-- v-for -->






            <!-- portrait responsive -->
            <div class="post section-padding orientation-portrait">
                <div class="row q-col-gutter-md">
                    <div v-for="(one,index) in fsearch" class="col-12 col-md-12">
                        <q-card class="bg-white">
                            <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                :alt="site.keywords">
                                <q-img :ratio="16/9" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up"></q-img>
                            </a>

                            <q-card-section>
                                <a :href="'<?=get_base()?>/view/<?=$object_type?>/'+one.slug + '<?=lang_append()?>'"
                                    :alt="site.keywords" class="text-primary">
                                    <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>

                                <div class="q-mt-md">
                                    <span class="text-red text-bold">{{ one.price ? c.formatCurrency(one.price) :
                                        $t('call') }}</span>
                                    <s class="text-grey text-caption">{{ c.formatCurrency(one.retail_price)
                                        }}</s>
                                </div>
                            </q-card-section>

                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one.id)">
                                </q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>





            <div class="text-center">
                <q-btn icon="post_add" v-if="edit" dense outline label="Edit Master" @click="editPost('master',2)">
                </q-btn>
            </div>

            <?php include "footer.php"; ?>

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



            <?php 
                global $DEFAULT_LANG; 
                $lang = $_SESSION['lang'];


                if ($lang!='vi')
                    include __DIR__."/../footer.php"; 
                else 
                    include __DIR__."/../footer-vi.php"; 
            ?>

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
    window.lang = <?= json_encode($lang); ?>;
    window.defaultLang = <?= json_encode($DEFAULT_LANG); ?>;

    window.langList = <?= json_encode($langList); ?>;
    window.objects = <?= json_encode($objects); ?>;
    window.objectType = <?= json_encode($object_type); ?>;
    window.category = <?= json_encode($category); ?>;
    window.categoryTitle = <?= json_encode($category_title); ?>;
    window.categorySlug = <?= json_encode($category_slug); ?>;
    window.policy = <?= json_encode($policy); ?>;

    // console.log(window.products ? window.products : [])

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
            product: 'Products',
            detail: 'View detail',
            more: 'View more',
            home: 'Home',
            features: 'featured',
            articles: 'Articles',
            search: 'Search',
            all: "All",
            post: "Posts",
            page: "Pages",
            category: "Category",
            call: "Call",
            policy: "Policy",
            company_owner: "Business Owner",

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
            features: 'nổi bật',
            articles: 'Bài viết',
            search: 'Tìm kiếm',
            all: "Tất cả",
            post: "Bài viết blog",
            page: "Bài viết landing page",
            category: "Chuyên mục",
            call: "Liên hệ",
            policy: "Chính sách",
            company_owner: "Đại diện pháp luật",


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
                lang: "",
                langList: [],
                defaultLang : "",
                text: '',
                tab: '',
                post: {},

                slide: 0,
                edit: false,
                objects: [],
                objectType: "",
                categoryTitle: '',
                categorySlug: '',

                products: [],
                pages: [],
                posts: [],
                feature_posts: [],
                cate: '',
                category: [], // load menu 
                category_lang: [], // load menu 
                showsearch: false,

                policy: []

            }
        },
        computed: {
            fsearch() {
                let vm = this;
                let posts = vm.objects

                const search = vm.text ? vm.text.toLowerCase().trim() : '';
                const category = vm.cate ? vm.cate.toLowerCase().trim() : '';

                if (search == "" && category == "") return vm.objects;

                if (search != "")
                    // filter by search 
                    return posts.filter(function (c) {
                        let r = c.title.toString().toLowerCase(); // array also
                        return r.includes(search);
                        // || (c.content.toLowerCase().includes(search))
                    });
                if (category != "")
                    // filter by type     
                    return posts.filter(function (c) {
                        let r = c.category.toString().toLowerCase(); // array also
                        return r.includes(category);
                    });
            },
            slider() { // slider 
                let vm = this
                let sl
                if (vm.site.slider && vm.site.slider.includes(',')) {
                    sl = vm.site.slider.split(',')
                } else {
                    return []
                }

                return sl.map((m, index) => {
                    let res = {}
                    res.id = index
                    res.img = m
                    res.h1 = vm.site.keywords
                    res.p = vm.site.site_slogan

                    if (index == 1) res.h1 = vm.site.site_slogan
                    if (index == 2) res.h1 = vm.site.site_name

                    return res
                })
            },

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
                // this.reset() // the form
                vm.site = window.site
                vm.lang = window.lang
                vm.defaultLang = window.defaultLang  

                vm.langList = [{ code: 'vi', text: 'Tiếng Việt' }, { code: 'en', text: 'English' }]

                vm.objects = window.objects ? window.objects : [] // post, product 
                vm.policy = window.policy 

                vm.posts = vm.objects
                vm.products = vm.objects


                vm.objectType = window.objectType ? window.objectType : ""
                vm.category = window.category ? window.category : []

                vm.categorySlug = window.categorySlug ? window.categorySlug : "" // title to filetr 
                // vm.policy = vm.getByCategory('post', 'chinh-sach', 8)


                // vm.cate = vm.getCategoryTitle(vm.categorySlug) // filter posts 
                vm.cate = vm.categorySlug

                vm.fetchAll()

                vm.menu = vm.loadMenu('main-menu')
                vm.categoryTitle = vm.getCategoryTitle(vm.categorySlug)

                let res = vm.objects.filter(function (f) {
                    return f.featured && f.featured != ''
                });
                vm.feature_posts = res.slice(0, 6)
            },

            fetchAll() {
                var vm = this
                vm.$q.loadingBar.start()

                if (!vm.site.slug) {
                    vm.$q.loadingBar.stop()
                    vm.c.toast("Không tải được setting cho website này!", 'negative')
                    return
                }

                if (vm.objects && vm.objects.length > 0) {
                    // sort the posts by id desc
                    vm.objects.sort(function (a, b) {
                        return b._id - a._id;
                    });

                }

                vm.$q.loadingBar.stop()
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

            getCategoryTitle(slug) {
                let vm = this
                let res = vm.category.filter(f => f.slug == slug)[0]

                return (vm.lang!=vm.defaultLang) ? res['title_'+vm.lang]: res.title
            },

            getByCategory(collection, cate_slug, count) {
                // docs by category 
                let vm = this
                const posts = vm.posts
                const products = vm.products
                const pages = vm.pages

                let res = []
                let c = cate_slug ? cate_slug.trim().toLowerCase() : ''

                if (collection === "post") {
                    res = posts.filter(f => f.category && f.category.includes(c))
                }
                if (collection === "product") {
                    res = products.filter(f => f.category && f.category.includes(c))
                }
                if (collection === "page") {
                    res = pages.filter(f => f.category && f.category.includes(c))
                }
                // console.log(res)
                return res ? res : []

            },

            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast("Đã kích hoạt Nút sửa bài", 'negative')
                else
                    this.c.toast("Trở về trạng thái bình thường", 'positive')
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
        /* border: solid 0.2px #eee; */
    }

    a {
        text-decoration: none;
    }

    a:hover {
        color: #ccc
    }

    .popular .text-h4 {
        letter-spacing: -1px;
        font-family: "Montserrat";
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


    .card {
        min-height: 40vh;
    }

    .card:hover {
        box-shadow: 20px;
    }

    .post .text-h4.right {
        background: white;
        letter-spacing: -1px;
        border-right: solid 5px <?=$site->color_primary ? $site->color_primary: 'blue'?>;
        padding: 10px;
        margin-right: -100px;

    }

    .post .text-h4.left {
        background: white;
        letter-spacing: -1px;
        border-left: solid 5px <?=$site->color_primary ? $site->color_primary: 'blue'?>;
        padding: 10px;
        margin-left: -100px;

    }

    .bg-1 {
        background: url('<?=get_base()?>/images/bg-1.png');
        background-size: cover;
    }

    .bg-2 {
        background: url('<?=get_base()?>/images/bg-2.png');
        background-size: cover;
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

    ul li {
        margin-left: -20px;
    }

    #slider {
        height: 80vh;
    }

    @media (orientation: portrait) {

        .text-h3{
            font-size: 2rem;
        }
        .text-h4{
            font-size: 1.6rem;
        }

        .section-padding {
            padding: 10px !important;
        }

        .app-padding {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card {
            min-height: 35vh;
        }

        #slider {
            height: 45vh;
        }

        .full-width {
            max-width: calc(100% - 3em);
        }


    }
</style>