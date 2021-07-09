<div id="q-app">
    <template>
        <q-layout>

            <!-- header
            ==============================  -->
            <q-toolbar class="app-padding">

                <!-- header logo -->
                <div v-if="site.images" class="q-pa-sm">
                    <a href="<?=get_base().'/page'. lang_append()?>" alt="home">
                        <img :src="c.showImage(site.images)" height="60px" loading="lazy" alt="logo" title="Logo"></img>
                    </a>
                </div>

                <div v-else class="orientation-landscape">
                    <div class="text-h5 text-bold"> {{ site.site_name }} {{ site.branch }}</div>
                    <h1 class="text-caption ellipsis-2-lines">{{ site.site_slogan }} </h1>
                </div>

                <q-space></q-space>


                <!-- right  -->
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

                <a class="text-blue-7" :href="site.contact_zalo">
                    <q-btn flat round icon="comment" />
                </a>
                <a class="text-blue-10" :href="site.contact_facebook">
                    <q-btn flat round icon="facebook" />
                </a>
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
            <q-toolbar class="app-padding bg-primary text-white shadow-2 menu">
                <q-tabs inline-label v-model="tab" shrink swipeable>
                    <q-tab v-for="(one, index) in menu" class="cta" @click="c.scrollTo(one._id)" :name="one.menu"
                        :label="one.menu">
                    </q-tab>
                </q-tabs>
                <!-- <q-space></q-space> -->
            </q-toolbar>





            <!-- slider 
            ========================================================================== -->

            <q-carousel id="slider" v-if="slider.length>0" navigation-position="bottom" swipeable navigation autoplay
                infinite animated transition-prev="slide-right" transition-next="slide-left"
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




            <!--  content 
            =========================================================================== -->
            <div v-for="(one,index) in objects" :key="one._id" :name="one._id">

                <!-- layout == Columns -->
                <div :id="one._id" v-if="['Columns','Chia cột','chia-cot'].indexOf(one.layout)!=-1">


                    <!-- image right 
                    =========================================== -->
                    <div v-if="(index%2)==0" class="section-padding">
                        <div class="row q-col-gutter-lg">
                            <div class="col-12 col-md-7">
                                <div class="text-overline">{{ site.site_name }}</div>
                                <h2 class="text-h4 text-primary" v-html="one.title + c.addBranch(site.branch)">
                                </h2>
                                <div class="text-justify" v-html="one.summary"></div>
                                <div class="q-mt-md">
                                    <a :href="'<?=get_base()?>/page/'+one.slug + '<?=lang_append()?>'"
                                        :alt="site.keywords" :title="site.keywords">
                                        <q-btn v-if="one.content" v-ripple outline color="grey" icon="visibility"
                                            :label="$t('more')" class="print-hide">
                                        </q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('page',one._id)">
                                    </q-btn>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <q-img class="rounded-borders" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up" />
                            </div>
                        </div>
                    </div>




                    <!-- image left 
                    =============================================== -->
                    <div v-if="(index%2)!=0" class="bg-grey-1 section-padding">
                        <div class="row q-col-gutter-lg">
                            <div class="col-12 col-md-5 orientation-landscape">
                                <q-img class="rounded-borders" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up" />
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="text-overline">{{ site.site_name }}</div>
                                <h2 class="text-h4 text-primary" v-html="one.title + c.addBranch(site.branch)"></h2>
                                <div class="text-justify" v-html="one.summary"></div>
                                <!-- buttons  -->
                                <div class="q-mt-md">
                                    <a :href="'<?=get_base()?>/page/'+one.slug + '<?=lang_append()?>'"
                                        :alt="site.keywords" :title="site.keywords">
                                        <q-btn v-if="one.content" v-ripple outline color="grey" icon="visibility"
                                            :label="$t('more')" class="print-hide">
                                        </q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('page',one._id)">
                                    </q-btn>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 orientation-portrait">
                                <q-img class="rounded-borders" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up" />
                            </div>
                        </div>
                    </div>

                </div>





                <!-- embed products col-md-3 x 4 
            ========================================================== -->
                <div :id="one._id" class="section-padding"
                    v-else-if="['Product List','san-pham'].indexOf(one.layout)!=-1">

                    <div class="text-center">
                        <div class="text-overline">{{ site.site_name }}</div>
                        <h2 class="text-h4 text-primary" v-html="one.title + c.addBranch(site.branch)"></h2>
                    </div>

                    <div class="row q-col-gutter-md">
                        <div v-for="(one,index) in products" :key="'prod'+index" class="bg-white col-12 col-md-3">
                            <q-card>
                                <q-img :ratio="16/9" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                        :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                </q-img>
                                <q-card-section class="text-caption">
                                    <div class="text-h6 text-bold" v-html="one.title"></div>
                                    <div v-html="one.summary" class="q-mt-md ellipsis"></div>
                                    <div v-if="one.price&&one.price>0" class="q-mt-md">
                                        <span class="text-subtitle1 text-bold text-primary">{{
                                            c.formatCurrency(one.price) }}
                                            <s class="text-grey">{{ c.formatCurrency(one.retail_price) }}</s>
                                    </div>
                                </q-card-section>
                                <div class="q-pa-md">
                                    <a :href="'<?=get_base()?>/product/'+one.slug+'<?=lang_append()?>'"
                                        :alt="site.keywords">
                                        <q-btn v-ripple outline icon="sell" color="primary" class="full-width"
                                            :label="$t('detail')"></q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('product',one._id)">
                                    </q-btn>
                                </div>
                            </q-card>
                        </div>
                    </div>

                </div>



                <!-- carousel 
                ====================================================  -->
                <div :id="one._id" v-else-if="['Gallery','thu-vien-anh'].indexOf(one.layout)!=-1 "
                    class="section-padding text-center text-white bg-1">
                    <div class="text-overline">{{ site.site_name }}</div>
                    <h2 class="text-h4" v-html="one.title"></h2>
                    <div class="q-pb-lg" v-html="one.summary"></div>
                    <q-virtual-scroll :items="loadSlider(one.images)" virtual-scroll-horizontal>
                        <template v-slot="{ item, index }">
                            <div :key="index" style="width:280px; margin-right: 10px;">
                                &nbsp;
                                <q-img :ratio="16/9" :src="item.img" :alt="site.keywords" :title="site.keywords"
                                    transition="jump-up"></q-img>
                            </div>
                        </template>
                    </q-virtual-scroll>

                    <!-- admin icon -->
                    <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one._id)">
                    </q-btn>
                </div>




                <!-- layout == photos // cong nghe su dung, khach hang 
                ================================================================================  -->
                <div :id="one._id" v-else-if="['hinh-anh','Hình ảnh', 'Images', 'Photos'].indexOf(one.layout)!=-1"
                    class="section-padding">
                    <div class="text-center">
                        <div class="text-overline">{{ site.site_name }}</div>
                        <h2 class="text-h4 text-primary" v-html="one.title + c.addBranch(site.branch)"></h2>
                        <div v-html="one.summary" class="q-mt-md"></div>

                        <!-- admin icon -->
                        <q-btn icon="post_add" v-if="edit" dense outline label="Edit" @click="editPost('page',one._id)">
                        </q-btn>

                        <!-- photos from string 
                         =================================== -->
                        <div v-if="c.showPhoto(one).length<=1" class="q-pa-md">
                            <q-img class="rounded-borders" style="width:100%" :src="one.images" :alt="site.keywords"
                                :title="site.keywords" transition="jump-up"></q-img>
                        </div>

                        <div v-else class="row q-col-gutter-sm">
                            <div v-for="(one,index) in photos" :key="'photo-'+index" :name="index"
                                class="col-6 col-md-2">
                                <q-img class="rounded-borders" :src="one" :alt="site.keywords" :title="site.keywords"
                                    transition="jump-up">
                                </q-img>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- layout == contact 
                ==================================================================================== -->
                <div :id="one._id" v-else-if="['Contact','lien-he','Liên hệ'].indexOf(one.layout)!=-1"
                    class="bg-2 section-padding">
                    <div class="text-white text-center">
                        <h2 class="text-h4 text-white" v-html="one.title + c.addBranch(site.branch)"></h2>
                        <div class="text-center" v-html="one.summary"></div>
                        <div class="q-my-lg">
                            <a v-if="site.cta_link1" :href="site.cta_link1" :alt="site.keywords">
                                <q-btn glossy v-ripple class="q-px-md" color="primary" :label="site.cta_text1">
                                </q-btn>
                            </a>
                            <a v-if="site.cta_link2" :href="site.cta_link2" :alt="site.keywords">
                                <q-btn glossy v-ripple outline class="q-px-md" color="primary" icon="schedule"
                                    :label="site.cta_text2">
                                </q-btn>
                            </a>
                            <!-- <a :href="'<?=get_base()?>/page/'+one.slug + '<?=lang_append()?>'" :alt="site.keywords">
                                <q-btn v-if="one.content" outline class="q-px-md" color="white" :label="$t('contact')"
                                    class="print-hide">
                                </q-btn>
                            </a> -->

                            <a :href="'<?=get_base()?>/contact<?=lang_append()?>'" :alt="site.keywords">
                                <q-btn outline class="q-px-md" color="white" :label="$t('contact')" class="print-hide">
                                </q-btn>
                            </a>
                        </div>

                        <!-- admin icon -->
                        <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one._id)">
                        </q-btn>

                    </div>
                </div>



                <!-- Testimonials  -->
                <div :id="one._id" v-else-if="['Testimonial','khach-hang-noi-gi'].indexOf(one.layout)!=-1 "
                    class="section-padding text-center">
                    <div class="text-overline">{{ site.site_name }}</div>
                    <h2 class="text-h4 text-primary" v-html="one.title"></h2>
                    <div class="q-pb-lg" v-html="one.summary"></div>
                    <q-virtual-scroll :items="loadSlider(one.images)" virtual-scroll-horizontal>
                        <template v-slot="{ item, index }">
                            <div :key="index" style="width:350px; margin-right: 10px;">
                                &nbsp;
                                <q-img :ratio="16/9" :src="item.img" :alt="site.keywords" :title="site.keywords"
                                    transition="jump-up"></q-img>
                            </div>
                        </template>
                    </q-virtual-scroll>
                    <!-- admin icon -->
                    <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one._id)">
                    </q-btn>
                </div>


                <!-- embed posts col-md-3 x 4 
            ========================================================== -->
                <div :id="one._id" class="section-padding" v-else-if="['Post List','bai-viet'].indexOf(one.layout)!=-1">

                    <div class="text-center">
                        <div class="text-overline">{{ site.site_name }}</div>
                        <h2 class="text-h4 text-primary" v-html="one.title + c.addBranch(site.branch)"></h2>
                    </div>

                    <div class="row q-col-gutter-md">
                        <div v-for="(one,index) in posts" :key="'post'+index" class="col-12 col-md-3 bg-white ">
                            <q-card>
                                <q-img :ratio="16/9" :src="c.showImage(one.images)" :alt="site.keywords"
                                    :title="site.keywords" transition="jump-up">
                                    <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                        :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                </q-img>
                                <q-card-section class="text-caption">
                                    <div class="text-h6 text-bold" v-html="one.title"></div>
                                    <div v-html="one.summary" class="q-mt-md ellipsis-3-lines"></div>
                                    <!-- <div v-if="one.price&&one.price>0" class="q-mt-md">
                                    <span class="text-subtitle1 text-bold text-primary">{{
                                        c.formatCurrency(one.price) }}
                                        <s class="text-grey">{{ c.formatCurrency(one.retail_price) }}</s>
                                </div> -->
                                </q-card-section>
                                <div class="q-pa-md">
                                    <a :href="'<?=get_base()?>/post/'+one.slug+'<?=lang_append()?>'"
                                        :alt="site.keywords">
                                        <q-btn v-ripple outline icon="article" color="primary" class="full-width"
                                            :label="$t('detail')"></q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('post',one._id)">
                                    </q-btn>
                                </div>
                            </q-card>
                        </div>
                    </div>

                </div>


            </div>
            <!-- end v-for -->
                                    

            <!-- place QPageScroller at end of page -->
            <q-page-scroller expand position="top" :scroll-offset="150" :offset="[0, 0]">
                <!-- menu 
                ====================================================================== -->

                 <q-toolbar class="app-padding bg-primary text-white shadow-2 menu">
                <q-tabs inline-label v-model="tab" shrink swipeable>
                    <q-tab v-for="(one, index) in menu" class="cta" @click="c.scrollTo(one._id)" :name="one.menu"
                        :label="one.menu">
                    </q-tab>
                </q-tabs>
                <!-- <q-space></q-space> -->
            </q-toolbar>


            </q-page-scroller>



            <!-- admin icon -->
            <div class="text-center">
                <q-btn icon="post_add" v-if="edit" dense outline label="Edit Master" @click="editMaster()">
                </q-btn>
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
    window.lang = <?= json_encode($lang); ?>;
    window.langList = <?= json_encode($langList); ?>;
    window.site = <?= json_encode($site); ?>;
    window.pages = <?= json_encode($pages); ?>;
    window.products = <?= json_encode($products); ?>;
    window.posts = <?= json_encode($posts); ?>;
    window.policy = <?= json_encode($policy); ?>;

    // console.log(window.pages ? window.pages : [])

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
            company_owner: "Đại diện pháp luật",
            policy: "Chính sách"
        }
    }

    const i18n = new VueI18n({
        locale: "<?=$lang ? $lang : 'vi'?>",
        messages,
    })

    new Vue({
        el: "#q-app",
        i18n: i18n,
        data() {
            return {
                track: new Track(),
                c: new Common(this.$q),
                lang: "",
                langList: [],
                site: {},
                objects: [],
                selected: {},
                slide: 0, // slider start 
                slider: [],
                gal: 0, // gallery start 
                gallery: [], // khong can dung chung

                tab: '',
                products: [],
                posts: [],
                edit: false,
                policy: []
            }
        },
        computed: {
            menu() {
                let vm = this
                let res = vm.objects.filter(f => {
                    let item = {}
                    if (f.menu && f.menu != '' && f.lang == vm.lang) {
                        item.id = f.id
                        item.menu = f.menu
                    }
                    return item
                })
                return res.filter(f => f.menu)
            },

        },
        mounted() {
            let vm = this
            vm.track.cta()
        },
        created() {
            this.init()
            this.track.ping()
        },
        methods: {
            init() {
                // this.reset() // the form
                this.site = window.site
                this.lang = window.lang
                this.langList = [{ code: 'vi', text: 'Tiếng Việt' }, { code: 'en', text: 'English' }]

                this.objects = window.pages ? window.pages : [] // main objects 

                this.posts = window.posts ? window.posts : []
                this.products = window.products ? window.products : []
                this.policy = window.policy

                this.fetchAll()
                // this.c.log(this.menu)
                this.slider = this.loadSlider(this.site.slider)
                // console.log(this.slider)


                this.products = this.products.slice(0, this.site.embed_product ? this.site.embed_product : 4)
                this.posts = this.posts.slice(0, this.site.embed_blog ? this.site.embed_blog : 4)


            },
            fetchAll() {
                var vm = this
                vm.$q.loadingBar.start()

                if (!vm.site.site_title) {
                    vm.$q.loadingBar.stop()
                    vm.toast("none", "Setting error")
                    return
                }

                if (vm.objects && vm.objects.length > 0) {
                    // sort the posts
                    vm.objects.sort(function (a, b) {
                        return a.doc_order - b.doc_order;
                    });

                }
                vm.$q.loadingBar.stop()
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
            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast(this.$t('edit_mode'), "negative")
                else
                    this.c.toast(this.$t('normal_mode'), 'positive')
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
        text-decoration: none
    }

    a:hover {
        color: #ccc
    }

    hr {
        background-color: #eee;
        border: 0 none;
        color: #eee;
        height: 1px;

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
        padding-top: 15vh;
        padding-bottom: 15vh;
    }

    ul li {
        margin-left: -20px;
    }

    .app-padding {
        padding-left: 8vw;
        padding-right: 8vw;
    }

    #slider {
        height: 80vh;
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

        .app-padding {
            padding-left: 20px;
            padding-right: 20px;
        }

        #slider {
            height: 45vh;
        }
    }
</style>