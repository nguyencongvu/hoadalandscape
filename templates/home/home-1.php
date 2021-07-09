<div id="q-app">
    <template>
        <q-layout>

            <!-- show by layout  -->
            <div id="main" v-for="(block, index) in layout" :key="index">


                <!-- header 
                ======================================================================  -->
                <div id="header" v-if="block.type=='header'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                    <!-- header logo -->
                    <q-toolbar class="app-padding"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">
                        <div v-if="site.images" class="q-pa-sm">
                            <!-- header logo -->
                            <a href="<?=get_base(). lang_append()?>" alt="home">
                                <img :src="c.showImage(site.images)" height="60px" loading="lazy" alt="logo"
                                    title="Logo"></img>
                            </a>
                        </div>

                        <div class="orientation-landscape">
                            <div class="text-h5 krub-font text-bold"> {{ block.subtitle }} {{ site.branch }}</div>
                            <h1 class="text-subtitle1 krub-font ellipsis-2-lines">{{ site.site_slogan }} </h1>
                        </div>

                        <q-space></q-space>

                        <q-banner class="orientation-landscape bg-transparent">
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

                        <q-banner class="orientation-landscape  bg-transparent">
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

                        <q-banner class="orientation-landscape  bg-transparent">
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
                            <q-btn round>
                                <q-avatar size="28px">
                                    <img src="/images/zalo-icon.png" />
                                </q-avatar>
                            </q-btn>
                        </a>
                        <a class="text-blue-10 q-ml-sm" :href="site.contact_facebook">
                            <q-btn round>
                                <q-avatar size="28px">
                                    <img src="/images/facebook-icon.png" />
                                </q-avatar>
                            </q-btn>
                        </a> -->

                        <!-- language  -->
                        <q-btn v-if="1==1" flat round icon="language" color="green">
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
                </div>



                <!-- menu 
                ====================================================================== -->
                <div id="main-menu" v-else-if="block.type=='menu'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                    <q-toolbar v-if="menu.length>0" class="app-padding bg-primary text-white shadow-2 menu">

                        <q-tabs inline-label v-model="tab" shrink swipeable outside-arrow mobile-arrows>
                            <q-tab icon='home' class="cta" @click="c.goto('/')"></q-tab>
                            <q-tab class="cta" v-for="(item,index) in menu"
                                :label="lang!=defaultLang ? item['title_'+lang] : item['title']"
                                @click="item.children && item.children.length>0 ? null : c.goto(item.url + (lang!=defaultLang ? '?lang='+lang : '' ) )">

                                <q-menu fit class="cursor-pointer">
                                    <q-list separator v-if="item.children&&item.children.length>0">
                                        <q-item v-for="(one,index) in item.children" class="cta" clickable
                                            @click="c.goto(one.url + (lang!=defaultLang ? '?lang='+lang : '' ) )"
                                            v-close-popup>
                                            {{ (lang!=defaultLang) ? one['title_'+lang] : one.title }}
                                        </q-item>
                                    </q-list>
                                </q-menu>

                            </q-tab>
                        </q-tabs>

                        <!-- <q-space></q-space> -->
                    </q-toolbar>

                </div>



                <!-- slider 
                ====================================================================== -->
                <div v-else-if="block.type=='slider'">
                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                    <q-carousel :height="!c.isMobile() ? block.height : '30vh'" v-if="slider&&slider.length>0"
                        navigation-position="bottom" swipeable navigation autoplay infinite animated
                        transition-prev="slide-right" transition-next="slide-left" @mouseenter="autoplay = true"
                        @mouseleave="autoplay = true" control-type="regular" control-color="white" v-model="slide">

                        <q-carousel-slide v-for="one in slider" :key="one.id" :name="one.id" :img-src="one.img">
                        </q-carousel-slide>

                    </q-carousel>

                </div>


                <!-- banner  
                ======================================================================  -->
                <div v-else-if="block.type=='image'">
                    <div class="banner">
                        <!-- {{ block.doc_order}}
                        {{ block.type}}
                        {{ block.index }}
                        {{ block.link }}
                        {{ block.ratio }} -->
                        <a :href="block.link">
                            <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(site.images,block.index)"></q-img>
                        </a>
                    </div>
                </div>



                <!-- page 
                ======================================================================  -->
                <div id="page" v-else-if="block.type=='page'||block.type=='post'||block.type=='product'"
                    :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} /{{ block.slug }} -->


                    <!-- image left 
                  ----------------------------------------------------------- -->
                    <div v-if="block.align=='left'" class="section-padding">
                        <div class="row q-col-gutter-lg">

                            <div class="col-12 col-md-5">
                                <q-img style="width:100%" :src="c.showImage(getOne(block.type,block.slug).images)"
                                    :alt="site.keywords" :title="site.keywords" transition="jump-up" />
                            </div>

                            <div class="col-12 col-md-7">

                                <div class="text-overline">{{ block.subtitle }}</div>
                                <h2 class="text-h4 text-primary" v-html="getOne(block.type,block.slug).title">
                                </h2>
                                <div class="text-justify" v-html="getOne(block.type,block.slug).summary"></div>


                                <!-- buttons  -->
                                <div class="q-mt-md">
                                    <a :href="'<?=get_base()?>/view/'+block.type+'/'+block.slug + '<?=lang_append()?>'"
                                        :alt="site.keywords" :title="site.keywords">
                                        <q-btn v-if="getOne(block.type,block.slug).content" v-ripple outline
                                            color="grey" icon="visibility" :label="$t('more')" class="print-hide">
                                        </q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost(block.type,getOne(block.type,block.slug).id)">
                                    </q-btn>
                                </div>
                            </div>



                        </div>
                    </div>

                    <!-- image right 
                    ----------------------------------------------------------- -->
                    <div v-if="block.align=='right'" class="section-padding">
                        <div class="row q-col-gutter-lg">

                            <div class="col-12 col-md-7">

                                <div class="text-overline">{{ block.subtitle }}</div>
                                <h2 class="text-h4 text-primary" v-html="getOne(block.type,block.slug).title">
                                </h2>
                                <div class="text-justify" v-html="getOne(block.type,block.slug).summary"></div>

                                <!-- buttons  -->
                                <div class="q-mt-md">
                                    <a :href="'<?=get_base()?>/view/'+block.type+'/'+getOne(block.type,block.slug).slug + '<?=lang_append()?>'"
                                        :alt="site.keywords" :title="site.keywords">
                                        <q-btn v-if="getOne(block.type,block.slug).content" v-ripple outline
                                            color="grey" icon="visibility" :label="$t('more')" class="print-hide">
                                        </q-btn>
                                    </a>
                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost(block.type,getOne(block.type,block.slug).id)">
                                    </q-btn>
                                </div>
                            </div>


                            <div class="col-12 col-md-5">
                                <q-img style="width:100%" :src="c.showImage(getOne(block.type,block.slug).images)"
                                    :alt="site.keywords" :title="site.keywords" transition="jump-up" />
                            </div>

                        </div>
                    </div>


                </div>


                <!-- product category 
                ======================================================================  -->
                <div v-else-if="block.type=='category'">
                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->
                    <div class="text-center section-padding cursor-pointer"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">
                        <div class="text-overline">{{ block.subtitle }}</div>
                        <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                        <div class="q-pb-lg" v-html="block.summary"></div>

                        <q-virtual-scroll :items="productCategory.slice(0,block.count)" virtual-scroll-horizontal>
                            <template v-slot="{ item, index }">
                                <div :key="index" style="width:220px; margin-right: 10px;">
                                    <q-card flat bordered class="cta" @click="c.goto('/product/category/'+item.slug )">
                                        <q-img :ratio="getRatio(block.ratio)" :src="item.images" :alt="item.title"
                                            :title="item.title">
                                            <div class="absolute-bottom text-left" style="bottom:20px;right:70px">
                                                {{ (lang!=defaultLang) ? item['title_'+lang] : item['title'] }}
                                            </div>
                                        </q-img>
                                    </q-card>
                                </div>
                            </template>
                        </q-virtual-scroll>
                    </div>
                </div>


                <!-- features images icon 
                ======================================================================  -->
                <div id="features" v-else-if="block.type=='features'">
                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->
                    <!-- fetch category {{ block.slug }} 3 cols -->
                    <div class="text-center section-padding"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <h3 class="text-h4 text-primary">{{ block.title }}</h3>
                        <div>{{ block.summary}}</div>

                        <div class="row q-col-gutter-md q-mt-md text-center">
                            <q-card v-for="(one,index) in features" :key="index" flat
                                :class="block.count==3 ? 'col-12 col-md-4 bg-transparent' : 'col-12 col-md-3 bg-transparent' ">

                                <q-icon v-if="!one.avatar" size="68px" color="primary" :name="one.icon"></q-icon>
                                <q-img v-else :ratio="getRatio('1')" width="68px" :src="c.showImage(one.avatar)"
                                    :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                </q-img>

                                <q-card-section>
                                    <div class="text-h6 text-bold">{{ one.title }}</div>
                                    <div class="q-mt-md">{{ one.summary}}</div>
                                </q-card-section>


                            </q-card>
                        </div>
                    </div>

                </div>


                <!-- lists of products 
                ======================================================================   -->
                <div id="products" v-else-if="block.type=='products'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->


                    <div class="text-center section-padding"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">
                        <div :class="block.dark ? ' text-white ' : ' text-primary ' ">
                            <h3 class="text-h4" v-html="block.title"></h3>
                            <div class="q-pb-lg" v-html="block.summary"></div>
                            <!-- admin icon -->
                            <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                @click="editPost('page',objects[1].id)">
                            </q-btn> -->
                        </div>
                        <!-- embed products col-md-3 x 4 
                    ========================================================== -->
                        <div class="row q-col-gutter-md">
                            <div v-for="(one,index) in products" :key="index" class="col-6 col-md-3">
                                <q-card class="bg-white">

                                    <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                        :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                        <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                            :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                    </q-img>

                                    <q-card-section class="text-caption">
                                        <div class="text-h6 text-bold" v-html="one.title"></div>
                                        <div class="q-my-md ellipsis-2-lines">{{ one.summary}}</div>
                                        <div v-if="one.price&&one.price>0" class="text-body2 text-primary">{{
                                            c.formatCurrency(one.price) }}
                                            <s class="text-grey">{{ c.formatCurrency(one.retail_price) }}</s>
                                        </div>
                                    </q-card-section>

                                    <div class="q-pa-md">
                                        <a :href="'<?=get_base()?>/view/product/'+one.slug+'<?=lang_append()?>'"
                                            :alt="site.keywords">
                                            <q-btn v-ripple outline icon="sell" color="primary" class="full-width"
                                                :label="$t('detail')"></q-btn>
                                        </a>
                                        <!-- admin icon -->
                                        <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                            @click="editPost('product',one.id)">
                                        </q-btn>
                                    </div>
                                </q-card>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- contact 
                ======================================================================  -->

                <div id="contact" v-else-if="block.type=='contact'">

                    <!-- {{ block.doc_order}} {{block.type}} /{{ block.slug}} -->

                    <div class="text-center section-padding"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">
                        <div :class="block.dark ? ' text-white ' : ' text-primary ' ">

                            <h2 class="text-h4" v-html="block.title"></h2>
                            <div class="text-center" v-html="block.summary"></div>


                            <div class="q-my-lg">
                                <a v-if="site.cta_link1" :href="site.cta_link1" :alt="site.keywords">
                                    <q-btn push size="lg" class="q-px-md" color="primary" :label="site.cta_text1">
                                    </q-btn>
                                </a>
                                <a v-if="site.cta_link2" :href="site.cta_link2" :alt="site.keywords">
                                    <q-btn push size="lg" class="q-px-md" color="primary" icon="schedule"
                                        :label="site.cta_text2">
                                    </q-btn>
                                </a>


                                <a :href="'<?=get_base()?>/contact<?=lang_append()?>'" :alt="site.keywords">
                                    <q-btn push size="lg" class="q-px-md" color="white" text-color="primary"
                                        :label="$t('contact')" class="print-hide">
                                    </q-btn>
                                </a>
                            </div>

                            <!-- admin icon -->
                            <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one.id)">
                            </q-btn> -->

                        </div>
                    </div>
                </div>


                <!-- lists of posts  
                ======================================================================  -->
                <div id="posts" v-else-if="block.type=='posts'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->

                    <div class="section-padding"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <div class="text-center">
                            <div class="text-overline">{{ block.subtitle }}</div>
                            <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                            <div class="text-center q-pb-lg" v-html="block.summary"></div>

                            <!-- admin icon -->
                            <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one.id)">
                            </q-btn> -->
                        </div>

                        <!-- embed posts 
                    ====================================================== -->
                        <div class="row q-col-gutter-sm">
                            <div v-for="(one,index) in posts.slice(0,block.count)" :key="'blog-'+index"
                                class="col-6 col-md-3">
                                <q-card>
                                    <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                        :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                        <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                            :name="one.icon" color="white" style="bottom: 8px; right: 8px"></q-icon>
                                    </q-img>
                                    <q-card-section>
                                        <div class="text-bold" v-html="one.title"></div>
                                        <div v-html="one.summary" class="q-mt-md text-body2 ellipsis-3-lines"></div>
                                    </q-card-section>
                                    <div class="q-pa-md">
                                        <a :href="'<?=get_base()?>/view/post/' + one.slug + '<?=lang_append()?>'"
                                            :alt="site.keywords">
                                            <q-btn outline icon="visibility" color="grey" class="full-width"
                                                :label="$t('more')">
                                            </q-btn>
                                        </a>
                                        <!-- admin icon -->
                                        <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                            @click="editPost('post',one.id)">
                                        </q-btn>
                                    </div>
                                </q-card>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- gallery of images  
                ======================================================================  -->
                <div id="gallery" v-else-if="block.type=='gallery'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->


                    <div class="section-padding cursor-pointer"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <div class="text-center">
                            <div class="text-overline">{{ block.subtitle }}</div>
                            <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                            <div class="q-pb-lg" v-html="block.summary"></div>

                            <!-- admin icon -->
                            <!-- <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                @click="editPost('page',one.id)">
                            </q-btn> -->

                            <q-virtual-scroll :items="loadImages(block.slug).slice(0,block.count)"
                                virtual-scroll-horizontal>
                                <template v-slot="{ item, index }">
                                    <div :key="index" style="width:250px; margin-right: 10px;">
                                        <div ref="gallery" :key="index" style="width:250px; margin-right: 10px;">
                                            <q-card flat bordered class="cta" @click="selectedImage=item;dialog=true">
                                                <q-img :ratio="getRatio(block.ratio)" :src="item" :alt="item"
                                                    :title="item">
                                                    <!-- <div class="absolute-bottom text-left" style="bottom:20px;right:70px">
                                                    {{ item }}
                                                </div> -->
                                                </q-img>
                                            </q-card>
                                        </div>
                                </template>
                            </q-virtual-scroll>


                        </div>
                    </div>
                </div>




                <!-- testimonials 
                ======================================================================  -->
                <div id="testimonials" ref="testimonials" v-else-if="block.type=='testimonial'">


                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.slug }} -->


                    <div class="section-padding text-center cursor-pointer"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <div class="text-overline">{{ block.subtitle }}</div>
                        <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                        <div class="q-pb-lg" v-html="block.summary"></div>

                        <q-virtual-scroll :items="loadImages(block.slug).slice(0,block.count)"
                            virtual-scroll-horizontal>
                            <template v-slot="{ item, index }">
                                <div :key="index" style="width:450px; margin-right: 10px;">
                                    <q-card flat bordered class="cta" @click="selectedImage=item;dialog=true">
                                        <q-img :ratio="getRatio(block.ratio)" :src="item" :alt="item" :title="item">
                                            <!-- <div class="absolute-bottom text-left" style="bottom:20px;right:70px">
                                                {{ item }}
                                            </div> -->
                                        </q-img>
                                    </q-card>
                                </div>
                            </template>
                        </q-virtual-scroll>

                        <!-- admin icon -->
                        <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one.id)">
                        </q-btn> -->
                    </div>
                </div>




                <!-- post tabs  
                ======================================================================  -->
                <div id="post_tabs" ref="post_tabs" v-else-if="block.type=='post_tabs'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.objects }} -->


                    <div class="section-padding cursor-pointer"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <div class="text-overline q-mb-lg">{{ block.subtitle }}</div>
                        <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                        <div class="q-pb-lg" v-html="block.summary"></div>


                        <q-tabs v-model="tab" no-caps dense class="text-primary no-padding" align="center"
                            :breakpoint="0">
                            <q-tab name="one">
                                <span class="text-h5 q-px-md cta">
                                    {{ block.objects[0].title }}</span>
                            </q-tab>
                            <q-tab name="two">
                                <span class="text-h5 q-px-md cta">
                                    {{ block.objects[1].title }}</span>
                            </q-tab>
                        </q-tabs>



                        <q-tab-panels v-model="tab" animated>


                            <q-tab-panel name="one" class="row q-col-gutter-sm">
                                
                            
                                    <div v-for="(one,index) in getByCategory('post',block.objects[0].slug,block.objects[0].count)"
                                    :key="'one1-'+index" class="col-6 col-md-3">

                                    <q-card>

                                        <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                            :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                            <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                                :name="one.icon" color="white" style="bottom: 8px; right: 8px">
                                            </q-icon>
                                        </q-img>

                                        <q-card-section>
                                            <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                            <div v-html="one.summary" class="q-mt-md text-body2 ellipsis-3-lines">
                                            </div>
                                        </q-card-section>

                                        <div class="q-pa-sm">
                                            <a :href="'<?=get_base()?>/view/post/' + one.slug + '<?=lang_append()?>'"
                                                :alt="site.keywords">
                                                <q-btn outline icon="visibility" color="grey" class="full-width"
                                                    :label="$t('more')">
                                                </q-btn>
                                            </a>
                                            <!-- admin icon -->
                                            <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                                @click="editPost('post',one._id)">
                                            </q-btn>
                                        </div>
                                    </q-card>
                                </div>
                            </q-tab-panel>


                            <q-tab-panel name="two" class="row q-col-gutter-sm">
                                <div v-for="(one,index) in getByCategory('post',block.objects[1].slug,block.objects[1].count)"
                                    :key="'one2-'+index" class="col-6 col-md-3">

                                    <q-card>

                                        <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                            :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                            <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                                :name="one.icon" color="white" style="bottom: 8px; right: 8px">
                                            </q-icon>
                                        </q-img>

                                        <q-card-section>
                                            <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                            <div v-html="one.summary" class="q-mt-md text-body2 ellipsis-3-lines">
                                            </div>
                                        </q-card-section>

                                        <div class="q-pa-sm">
                                            <a :href="'<?=get_base()?>/view/post/' + one.slug + '<?=lang_append()?>'"
                                                :alt="site.keywords">
                                                <q-btn outline icon="visibility" color="grey" class="full-width"
                                                    :label="$t('more')">
                                                </q-btn>
                                            </a>
                                            <!-- admin icon -->
                                            <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                                @click="editPost('post',one._id)">
                                            </q-btn>
                                        </div>
                                    </q-card>
                                </div>
                            </q-tab-panel>

                        </q-tab-panels>

                        <!-- admin icon -->
                        <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one.id)">
                        </q-btn> -->
                    </div>
                </div>





                <!-- product  tabs  
                ======================================================================  -->
                <div id="product_tabs" ref="product_tabs" v-else-if="block.type=='product_tabs'">

                    <!-- {{ block.doc_order}} {{block.type}} {{ block.count }} {{ block.objects }} -->


                    <div class="section-padding text-center cursor-pointer"
                        :style="(block.color && block.color!='') ? ' background:'+block.color +' ' : ' background:url('+block.bg+');background-size:cover;' ">

                        <div class="text-overline q-mb-lg">{{ block.subtitle }}</div>
                        <h2 class="text-h4 text-primary" v-html="block.title"></h2>
                        <div class="q-pb-lg" v-html="block.summary"></div>


                        <q-tabs v-model="tab2" no-caps class="text-primary popular" align="center" :breakpoint="0">
                            <q-tab name="one">
                                <span class="text-h5 q-px-md cta">
                                    {{ block.objects[0].title }}</span>
                            </q-tab>
                            <q-tab name="two">
                                <span class="text-h5 q-px-md cta">
                                    {{ block.objects[1].title }}</span>
                            </q-tab>
                        </q-tabs>
                        <q-tab-panels v-model="tab2" animated>


                            <q-tab-panel name="one" class="row q-col-gutter-sm">
                                <div v-for="(one,index) in getByCategory('product',block.objects[0].slug,block.objects[0].count)"
                                    :key="'prod1-'+index" class="col-6 col-md-3">
                                    

                                    <q-card>
                                        <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                            :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                            <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                                :name="one.icon" color="white" style="bottom: 8px; right: 8px">
                                            </q-icon>
                                        </q-img>
                                        <q-card-section>
                                            <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                            <div v-html="one.summary" class="q-mt-md text-body2 ellipsis-3-lines">
                                            </div>

                                            <div class="q-mt-md">
                                                <span class="text-red text-bold">{{ one.price ?
                                                    c.formatCurrency(one.price) : $t('call') }}</span>
                                                <s class="text-grey text-caption">{{ c.formatCurrency(one.retail_price)
                                                    }}</s>
                                            </div>

                                        </q-card-section>

                                        <div class="q-pa-sm">
                                            <a :href="'<?=get_base()?>/view/product/' + one.slug + '<?=lang_append()?>'"
                                                :alt="site.keywords">
                                                <q-btn outline icon="visibility" color="grey" class="full-width"
                                                    :label="$t('more')">
                                                </q-btn>
                                            </a>


                                            <!-- admin icon -->
                                            <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                                @click="editPost('product',one.id)">
                                            </q-btn>
                                        </div>
                                    </q-card>
                                </div>
                            </q-tab-panel>



                            <q-tab-panel name="two" class="row q-col-gutter-sm">
                                <div v-for="(one,index) in getByCategory('product',block.objects[1].slug,block.objects[1].count)"
                                    :key="'prod2-'+index" class="col-6 col-md-3">
                                    
                                    <q-card>
                                        <q-img :ratio="getRatio(block.ratio)" :src="c.showImage(one.images)"
                                            :alt="site.keywords" :title="site.keywords" transition="jump-up">
                                            <q-icon v-if="one.icon" class="absolute all-pointer-events" size="32px"
                                                :name="one.icon" color="white" style="bottom: 8px; right: 8px">
                                            </q-icon>
                                        </q-img>
                                        <q-card-section>
                                            <div class="text-bold ellipsis-2-lines" v-html="one.title"></div>
                                            <div v-html="one.summary" class="q-mt-md text-body2 ellipsis-3-lines">
                                            </div>
                                            <div class="q-mt-md">
                                                <span class="text-red text-bold">{{ one.price ?
                                                    c.formatCurrency(one.price) : $t('call') }}</span>
                                                <s class="text-grey text-caption">{{ c.formatCurrency(one.retail_price)
                                                    }}</s>
                                            </div>
                                        </q-card-section>

                                        <div class="q-pa-sm">
                                            <a :href="'<?=get_base()?>/view/product/' + one.slug + '<?=lang_append()?>'"
                                                :alt="site.keywords">
                                                <q-btn outline icon="visibility" color="grey" class="full-width"
                                                    :label="$t('more')">
                                                </q-btn>
                                            </a>
                                            <!-- admin icon -->
                                            <q-btn icon="post_add" v-if="edit" dense outline label="Edit"
                                                @click="editPost('product',one.id)">
                                            </q-btn>
                                        </div>
                                    </q-card>
                                </div>
                            </q-tab-panel>

                        </q-tab-panels>

                        <!-- admin icon -->
                        <!-- <q-btn icon="post_add" v-if="edit" outline label="Edit" @click="editPost('page',one.id)">
                        </q-btn> -->
                    </div>
                </div>


            </div>


            <!-- show an image popup  -->
            <q-dialog v-model="dialog">
                <div style="width:90vw" class="bg-white q-pa-md">
                    <q-img :src="selectedImage" style="width:100%"></q-img>
                </div>
            </q-dialog>

            <div class="text-center q-my-md">
                <q-btn icon="post_add" v-if="edit" dense outline label="Edit Master" @click="editMaster()">
                </q-btn>
            </div>


            <?php 
                global $DEFAULT_LANG; 
                $lang = $_SESSION["lang"];
                
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

                <q-toolbar v-if="menu.length>0" class="app-padding bg-primary text-white shadow-2 menu">

                    <q-tabs inline-label v-model="tab" shrink swipeable outside-arrow mobile-arrows>
                        <q-tab icon='home' class="cta" @click="c.goto('/')"></q-tab>
                        <q-tab class="cta" v-for="(item,index) in menu"
                            :label="lang!=defaultLang ? item['title_'+lang] : item['title']"
                            @click="item.children && item.children.length>0 ? null : c.goto(item.url + (lang!=defaultLang ? '?lang='+lang : '' ) )">

                            <q-menu fit class="cursor-pointer">
                                <q-list separator v-if="item.children&&item.children.length>0">
                                    <q-item v-for="(one,index) in item.children" class="cta" clickable
                                        @click="c.goto(one.url + (lang!=defaultLang ? '&lang='+lang : '' ) )"
                                        v-close-popup>
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


<?php 
    // read layout 
    // global $DEFAULT_LANG; // at footer 
    // $lang = $_SESSION["lang"];

    $layout_file = "./config/layout-".$lang.".json"; 
    $string = file_get_contents($layout_file);
    $layout = json_decode($string,true);

    // var_dump($layout);
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
    window.layout = <?= json_encode($layout['objects']); ?>;

    window.lang = <?= json_encode($lang); ?>;
    window.defaultLang = <?= json_encode($DEFAULT_LANG); ?>;

    window.langList = <?= json_encode($langList); ?>;
    window.site = <?= json_encode($site); ?>;
    window.category = <?= json_encode($category); ?>;
    window.pages = <?= json_encode($pages); ?>;
    window.products = <?= json_encode($products); ?>;
    window.posts = <?= json_encode($posts); ?>;
    window.images = <?= json_encode(show_upload()); ?>; // not call api, call this web 


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
            contact: 'Leave a message',
            news: 'News',
            product: 'Products',
            detail: 'View detail',
            more: 'View more',
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
            contact: 'Để lại thông tin',
            news: 'Tin tức hoạt động',
            product: 'Sản phẩm',
            detail: 'Chi tiết',
            more: 'Xem thêm',
            call: 'Liên hệ',
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
                lang: "",
                defaultLang: "",
                langList: [],

                site: {},
                layout: {}, // 
                pages: [],
                menu: [],
                menu_lang: [],

                objects: [], // khong dung 
                selected: {},
                slide: 0,
                slider: [],
                tab: 'one',
                tab2: 'one',
                products: [],
                features: [],
                productCategory: [],
                category_lang: [],
                posts: [],
                projects: [],
                images: [],
                gallery: [],
                testimonials: [],

                post_one: [],
                post_two: [],

                edit: false,
                dialog: false, //show image 
                selectedImage: "", // url
                selectedBlock: {},

                policy: [], // footer show  

            }
        },
        computed: {


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
                let vm = this
                // vm.reset() // the form
                vm.site = window.site
                vm.lang = window.lang
                vm.defaultLang = window.defaultLang
                vm.langList = [{ code: 'vi', text: 'Tiếng Việt' }, { code: 'en', text: 'English' }]

                vm.layout = window.layout ? window.layout : []
                vm.category = window.category ? window.category : []

                vm.pages = window.pages ? window.pages : []
                vm.posts = window.posts ? window.posts : []
                vm.products = window.products ? window.products : []
                vm.images = window.images ? window.images : []

                // slide san tren layout block.count 

                vm.policy = vm.getByCategory('post', 'chinh-sach', 8)

                vm.slider = vm.loadSlider(vm.site.slider)
                vm.fetchLayout() // fetch layout

                // let slug_lang = vm.lang ? 'main-menu' + vm.lang : 'main-menu'

                vm.menu = vm.loadMenu('main-menu')
                vm.features = vm.loadMenu('features')
                vm.productCategory = vm.loadMenu('product')

                // vm.gallery = vm.loadImages('hinh-anh')
                // vm.testimonials = vm.loadImages('khach-hang')



            },


            fetchLayout() {
                let vm = this
                vm.$q.loadingBar.start()

                if (!vm.site.slug) {
                    vm.$q.loadingBar.stop()
                    vm.toast("none", "Setting error")
                    return
                }

                if (vm.layout && vm.layout.length > 0) {
                    // sort the posts
                    vm.layout = vm.layout.filter(f => f.doc_order > 0)
                        .sort(function (a, b) {
                            return a.doc_order - b.doc_order;
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

                // menu cap 2 - sort 
                res.forEach(main => {
                    // main.slug + main.children 
                    allCate.forEach(sub => { // data chu khong phai menu 
                        if (sub.parent_id == main._id) {
                            if (!main.children) main.children = [] // QUANTRONG
                            main.children.unshift(sub)

                            // sort alphabet asc 
                            main.children.sort(function (a, b) {
                                if (a.doc_order > b.doc_order) return 1
                                if (a.doc_order < b.doc_order) return -1
                                return 0;
                            });


                        }
                    })


                   

                })

                return res

            },

            loadSlider(images) {
                let vm = this

                let imageArray = []

                if (!images) return []
                if (!images.includes(',')) return [{ id: 0, img: images }] // one image url only
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


            loadImages(name) {
                let vm = this
                const images = window.images
                let res = []

                res = images.filter(f => f.includes(name))
                return res ? res : []

            },

            getRatio(str) {
                // string: 16/9 
                if (!str) return eval(16 / 9)
                return eval(str)

            },

            getOne(collection, slug) {
                let vm = this
                let one = {}
                if (collection === 'page') {
                    one = vm.pages.find(f => f.slug && f.slug == slug)
                }
                if (collection === 'post') {
                    one = vm.posts.find(f => f.slug && f.slug == slug)
                }
                if (collection === 'product') {
                    one = vm.products.find(f => f.slug && f.slug == slug)
                }

                return one ? one : {};
            },

            getByCategory(collection, cate_slug, count) {
                // docs by category 
                let vm = this
                const posts = window.posts
                const products = window.products
                const pages = window.pages

                let res = []
                let c = cate_slug ? cate_slug.trim().toLowerCase() : ''

                if (collection == "post") {
                    res = posts.filter(f => f.category && f.category.includes(c))
                }
                if (collection == "product") {
                    res = products.filter(f => f.category && f.category.includes(c))
                }
                if (collection == "page") {
                    res = pages.filter(f => f.category && f.category.includes(c))
                }

                // console.log(res)
                return res ? res.slice(0,count) : []

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
    /* 
    #main * {
        font-size: 16px;
        border: solid 1px #eee;
    }

    #main div {
        height: 5vh;
        background-color: #eee;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    */

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

    .app-padding {
        padding-left: 12vw;
        padding-right: 12vw;
    }

    .bg-1 {
        background: url('<?=get_base()?>/images/bg-1.png');
        background-size: cover;
    }

    .bg-2 {
        background: url('<?=get_base()?>/images/bg-2.png');
        background-size: cover;
    }

    .section-padding {
        padding-left: 12vw;
        padding-right: 12vw;
        padding-top: 15vh;
        padding-bottom: 15vh;
    }

    ul li {
        margin-left: -20px;
    }

    #slider {
        height: 68vh;
    }

    @media (orientation: portrait) {

        .text-h3 {
            font-size: 2rem;
        }

        .text-h4 {
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