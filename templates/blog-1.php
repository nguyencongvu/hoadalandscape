<div id="q-app">
    <template>
        <q-layout>
            <!-- toolbar menu 
        ======================= -->
            <q-toolbar class="app-padding">
                <div class="q-pa-sm">
                    <!-- header logo -->
                    <a href="<?=get_base()?>/<?=lang_append()?>" alt="home">
                        <img :src="c.showImage(site.image)" height="60px" loading="lazy" alt="logo" title="Logo"></img>
                    </a>
                </div>
                <div class="orientation-landscape">
                    <div class="text-h5 text-bold"> {{ site.site_name }} {{ site.branch }}</div>
                    <h1 class="text-caption ellipsis-2-lines">{{ site.site_slogan }} </h1>
                </div>
                <q-space></q-space>
                <!-- search  -->
                <q-btn flat round icon="search" class="q-ml-sm">
                    <q-menu>
                        <q-input outlined v-model="text" clearable :placeholder="$t('search')">
                        </q-input>
                    </q-menu>
                </q-btn>
                <!-- phone email va dia chi  -->
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
                <!-- zalo va facebook  -->
                <!-- <a class="text-blue-7" :href="site.contact_zalo">
                    <q-btn flat round icon="comment"></q-btn>
                </a>
                <a class="text-blue-10" :href="site.contact_facebook">
                    <q-btn flat round icon="facebook"></q-btn>
                </a> -->

                <!-- language  -->
                <q-btn flat round icon="language" color="green">
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


            <q-tabs inline-label class="app-padding bg-primary text-white" align="left" v-model="tab" shrink
                mobile-arrows>

                <q-tab label="Tất cả" @click="cate='';text='';table=false;c.scrollTo('blog_list')" class="cta">
                </q-tab>

                <q-tab v-for="(one, index) in menu" clickable
                    @click="cate=one.slug;text='';table=false;c.scrollTo('blog_list')" :name="one.title"
                    :label="one.title">
                    <q-menu class="cursor-pointer">
                        <q-list separator v-if="one.children&&one.children.length>0">
                            <q-item v-for="(item,index) in one.children" class="cta" clickable
                                @click="cate=item.slug;text=''" v-close-popup>
                                {{ item.title }}
                            </q-item>
                        </q-list>
                    </q-menu>
                </q-tab>
                <!-- <q-tab label="Liên hệ"></q-tab> -->
            </q-tabs>




            <!-- slider 
            ========================================================================== -->
            <q-carousel id="slider" v-if="text==''&&cate==''&&slider.length>0" navigation-position="bottom" swipeable
                navigation autoplay infinite animated transition-prev="slide-right" transition-next="slide-left"
                @mouseenter="autoplay = false" @mouseleave="autoplay = true" control-type="flat" control-color="primary"
                v-model="slide" height="55vh">

                <q-carousel-slide v-for="(one,index) in slider" :key="index" :name="index" :img-src="one.img">
                    <div v-if="1==0" class="absolute-bottom custom-caption">
                        <h1 v-if="index==0">{{ one.h1 }}</h1>
                        <h2 v-else>{{ one.h1 }}</h2>
                        <!-- <div class="text-subtitle1 q-pt-xs">{{ one.p }}</div> -->
                    </div>
                </q-carousel-slide>

            </q-carousel>


            <q-separator></q-separator>


            <!-- features  
            ============================================== -->
            <div class="section-padding popular">


                <!-- landscape blog_list -->
                <div class="row q-col-gutter-md">
                    <div class="col-12 col-md-8 orientation-landscape">
                        <h2 class="text-h4 text-primary">
                            <q-icon name="pages"></q-icon> {{ $t('articles') }}
                        </h2>
                        <div v-for="(one,index) in fsearch">
                            <q-card flat bordered class="q-mb-md">
                                <q-card-section horizontal>

                                    <q-card-section class="col-7 no-padding">
                                        <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'"
                                            :alt="site.keywords" class="cta">
                                            <q-img class="full-height" :src="c.showImage(one.images)">
                                                <!-- <div class="absolute-top-left text-center"
                                                    :style="'background:' + site.color_secondary">
                                                    <div class="text-h6 text-bold">1</div>
                                                    <div class="text-caption">Tháng 5</div>
                                                </div> -->
                                            </q-img>
                                        </a>
                                    </q-card-section>

                                    <q-card-section class="col-5">
                                        <!-- <div class="text-caption">{{ one.category}}</div> -->
                                        <h3 class="text-h6 text-bold">{{ one.title}}</h3>
                                        <div class="text-caption">
                                            <q-icon name="today"></q-icon>
                                            {{ c.formatDate(one.date_created) }}
                                        </div>
                                        <div class="text-body2 q-mt-md">{{ one.summary }}</div>
                                        <div class="q-mt-md">
                                            <q-btn dense outline color='primary'
                                                @click="c.goto('/post/' + one.slug) + '<?=lang_append()?>'"
                                                class="q-px-md" :label="$t('more')">
                                            </q-btn>
                                        </div>

                                        <!-- admin icon -->
                                        <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                            @click="editPost('post',one._id)">
                                        </q-btn>

                                    </q-card-section>

                                </q-card-section>
                            </q-card>
                        </div>
                    </div>

                    <!-- right trick first  -->

                    <div class="col-12 col-md-4">
                        <h2 class="text-h4 text-primary">
                            <q-icon name="pages"></q-icon> {{ $t('intro') }}
                        </h2>
                        <div class="full-width">
                            <img class="full-width" :src="c.showImage(null)" />
                        </div>

                        <div class="q-my-lg">
                            <a v-if="site.cta_link1" :href="site.cta_link1" :alt="site.keywords">
                                <q-btn push class="q-px-md full-width" color="primary" :label="site.cta_text1">
                                </q-btn>
                            </a>
                            <a v-if="site.cta_link2" :href="site.cta_link2" :alt="site.keywords">
                                <q-btn push outline class="q-px-md full-width" color="primary" icon="schedule"
                                    :label="site.cta_text2">
                                </q-btn>
                            </a>
                        </div>

                        <!-- features  -->

                        <h2 class="text-h4 text-primary">
                            <q-icon name="featured_play_list"></q-icon> {{ $t('features') }}
                        </h2>

                        <q-list separator>
                            <q-item clickable @click="c.goto('<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>')"
                                v-ripple v-for="(one,index) in feature_posts" class="cta">
                                <q-item-section avatar>
                                    <q-avatar rounded>
                                        <img :src="c.showImage(one.images)" />
                                    </q-avatar>
                                </q-item-section>
                                
                                <q-item-section>
                                    <h3 class="text-h6">{{ one.title }}</h3>
                                    <div class="text-caption ellipsis-2-lines">{{ one.summary }}</div>
                                </q-item-section>


                            </q-item>
                        </q-list>

                        <!-- banners  -->
                        <div class="q-my-md">
                            <img style="width:100%" :src="c.showImage(site.image,1)" loading="lazy" :alt="site.keywords"
                                :title="site.keywords"></img>
                        </div>

                        <div class="q-my-md">
                            <img style="width:100%" :src="c.showImage(site.image,2)" loading="lazy" :alt="site.keywords"
                                :title="site.keywords"></img>
                        </div>



                    </div>

                </div>


                <!-- portrait -->
                <div class="row q-col-gutter-md orientation-portrait">
                    <div v-for="(one,index) in feature_posts" class="col-6 col-md-3">


                        <q-card class="card">
                            <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords"
                                class="cta">
                                <q-img :ratio="4/3" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                        :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                </q-img>
                            </a>


                            <q-card-section>
                                <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords"
                                    class="text-primary">
                                    <h3 class="text-h6 ellipsis-2-lines" v-html="one.title"></h3>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>
                            </q-card-section>


                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one._id)">
                                </q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>




            <!-- list of posts portrail trick 
            ====================================================== -->
            <div id="blog_list" class="popular section-padding orientation-portrait">
                <h2 class="text-h4 text-primary">
                    <q-icon name="article"></q-icon> {{ $t('articles') }}
                </h2>
                <div class="row q-col-gutter-md">
                    <div v-for="(one,index) in fsearch" :key="index" class="col-6 col-md-3">

                        <q-card class="card">
                            <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords"
                                class="cta">
                                <q-img :ratio="4/3" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                        :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                </q-img>
                            </a>
                            <q-card-section>
                                <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords"
                                    class="text-primary">
                                    <h3 class="text-h6 ellipsis-2-lines" v-html="one.title"></h3>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>
                            </q-card-section>
                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one._id)">
                                </q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>
                <!-- v-for -->
            </div>



            <!-- portrait responsive -->
            <div class="post section-padding orientation-portrait">
                <div class="row q-col-gutter-md">
                    <div v-for="(one,index) in fsearch" class="col-12 col-md-12">
                        <q-card class="bg-white">
                            <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords">
                                <q-img :ratio="16/9" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up"></q-img>
                            </a>

                            <q-card-section>
                                <a :href="'<?=get_base()?>/post/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords"
                                    class="text-primary">
                                    <h3 class="text-h6 ellipsis-2-lines" v-html="one.title"></h3>
                                </a>
                                <div class="text-body2 ellipsis-2-lines" v-html="one.summary"></div>
                            </q-card-section>

                            <div class="">
                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                    @click="editPost('post',one._id)"></q-btn>
                            </div>
                        </q-card>
                    </div>
                </div>
            </div>

            <div class="text-center q-my-md">
                <q-btn icon="post_add" v-if="edit" dense outline label="Edit Master" @click="editMaster()">
                </q-btn>
            </div>

            <?php 
                global $DEFAULT_LANG; 
                $lang = $_SESSION["lang"];
                
                if ($lang!='vi')
                    include __DIR__."/footer.php"; 
                else 
                    include "footer-vi.php"; 
            ?>


        </q-layout>
    </template>
</div>


<?php 
    $policy = show_policy();
?>


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
    window.langList = <?= json_encode($langList); ?>;
    window.posts = <?= json_encode($posts); ?>;
    window.category = <?= json_encode($category); ?>;
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
            search: 'Search',
            all: 'All',
            intro: "Introduction",
            company_owner: "Business Owner",
            policy: "Policy"
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
            search: 'Tìm kiếm',
            all: 'Tất cả',
            intro: "Giới thiệu",
            company_owner: "Đại diện pháp luật",
            policy: "Chính sách"
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
                text: '',
                tab: '',
                objects: [],
                slide: 0,
                slider: [],
                // loading: false,
                edit: false,

                feature_posts: [],
                cate: '',
                category: [],
                showsearch: false,
                menu: [],

                policy : []
            }
        },
        computed: {
            fsearch() {
                let vm = this;
                let posts = vm.objects

                const search = vm.text ? vm.text.toLowerCase().trim() : '';
                const category = vm.cate ? vm.cate.toLowerCase().trim() : '';

                if (search == "" && category == "") return posts;

                if (search != "")
                    // filter by search 
                    return posts.filter(function (c) {
                        let r = c.title ? c.title.toString().toLowerCase() : ''; // array also
                        return r.includes(search);
                        // || (c.content.toLowerCase().includes(search))
                    });

                if (category != "")
                    // filter by type     
                    return posts.filter(function (c) {
                        let r = c.category ? c.category.toString().toLowerCase() : ''; // array also
                        return r.includes(category)
                    });

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
                this.site = window.site
                this.lang = window.lang
                this.langList = [{ code: 'vi', text: 'Tiếng Việt' }, { code: 'en', text: 'English' }]

                this.objects = window.posts
                this.category = window.category
                this.policy = window.policy 
                
                // this.category = window.category
                this.fetchAll()
                // this.fetchUnique('category') // truoc khi posts bi slice 
                this.slider = this.loadSlider(this.site.slider)
                this.menu = this.loadMenu('blog')

                // this.feature_posts = this.posts.slice(0, 4)
                // this.posts = this.posts.slice(4, this.posts.length)
                this.tmpPosts = this.objects
                this.topPosts = this.tmpPosts.slice(0, 5)
                this.feature_posts = this.objects.filter(function (f) {
                    return f.featured && f.featured != ''
                })
            },
            fetchAll() {
                var vm = this
                vm.$q.loadingBar.start()

                if (!vm.site.site_title) {
                    vm.$q.loadingBar.stop()
                    vm.c.toast("Không tải được setting cho website này!", 'negative')
                    return
                }

                if (vm.objects && vm.objects.length > 0) {
                    // sort the posts by id desc
                    vm.objects.sort(function (a, b) {
                        return b.id - a.id;
                    });

                }

                vm.$q.loadingBar.stop()
            },
            fetchUnique(type = '') {
                // khong dung 
                let vm = this
                this.category = this.objects.map(m => m.category)
                    .filter((value, index, self) => self.indexOf(value) === index)
            },
            loadSlider(images) {
                let vm = this
                let imageArray = []

                if (!images) return []
                if (!images.includes(',')) return [{ img: images.trim() }] // one image url only
                else {
                    imageArray = images.split(',')
                }
                return imageArray.map((m, index) => {
                    let res = {}
                    res.id = index
                    res.img = m

                    // main page slider 
                    res.h1 = vm.site.keywords
                    res.p = vm.site.site_slogan
                    if (index == 1) res.h1 = vm.site.site_slogan
                    if (index == 2) res.h1 = vm.site.site_name
                    return res
                })
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

    .card {
        min-height: 50vh;
    }

    .card:hover {
        margin-top: -10px;
        box-shadow: 5px;
    }


    .text-h1,
    .text-h2,
    .text-h3,
    .text-h4,
    .text-h5,
    .text-h6 {
        letter-spacing: -1px;
        font-family: "Krub";
        font-weight: 700;
    }

    .bg-1 {
        background: url('<?=get_base()?>/images/bg-1.jpeg');
        background-size: cover;
    }

    .bg-2 {
        background: url('<?=get_base()?>/images/bg-2.jpeg');
        background-size: cover;
    }

    .app-padding {
        padding-left: 8vw;
        padding-right: 8vw;
    }

    .section-padding {
        padding-left: 8vw;
        padding-right: 8vw;
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

        .text-h4,{
            font-size: 1rem!important;
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