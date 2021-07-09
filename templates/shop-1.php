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
                        <q-tab label="Tất cả" @click="cate='';text='';table=false;c.scrollTo('product_list')"
                            class="cta">
                        </q-tab>

                        <q-tab v-for="(one, index) in menu"
                            @click="cate=one.slug;text='';table=false;c.scrollTo('product_list')" :name="one.title"
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
                    </q-tabs>

                    <q-space></q-space>

                    <!-- search  -->
                    <q-btn flat round icon="search" class="q-ml-sm cta">
                        <q-menu>
                            <q-input outlined v-model="text" clearable :placeholder="$t('search')">
                            </q-input>
                        </q-menu>
                    </q-btn>

                    <q-btn flat round color="white" size="xl" icon="shopping_bag" class="cta"
                        @click="show_checkout=true;">
                        <q-badge color="red" floating>{{ cart.length }}</q-badge>
                    </q-btn>


                </q-toolbar>

            </div>






            <!-- breadcumbs 
            =================================== -->
            <q-breadcrumbs v-if="cate!=''" class="app-padding q-py-sm bg-grey-2 cursor-pointer">
                <q-breadcrumbs-el icon="home" @click="cate='';text=''"></q-breadcrumbs-el>
                <q-breadcrumbs-el :label="$t('category')"></q-breadcrumbs-el>
                <q-breadcrumbs-el :label="cate"></q-breadcrumbs-el>
            </q-breadcrumbs>


            <!-- slider 
            ========================================================================== -->
            <q-carousel id="slider" v-if="cate==''&&text==''&&slider.length>0" navigation-position="bottom" swipeable
                navigation autoplay infinite animated transition-prev="slide-right" transition-next="slide-left"
                @mouseenter="autoplay = false" @mouseleave="autoplay = true" control-type="flat" control-color="white"
                v-model="slide">

                <q-carousel-slide v-for="(one,index) in slider" :key="index" :name="index" :img-src="one.img">
                    <div v-if="1==0" class="absolute-bottom custom-caption">
                        <h1 v-if="index==0">{{ one.h1 }}</h1>
                        <h2 v-else>{{ one.h1 }}</h2>
                        <!-- <div class="text-subtitle1 q-pt-xs">{{ one.p }}</div> -->
                    </div>
                </q-carousel-slide>

            </q-carousel>



            <!-- category with images - Trends
            ================================================= -->
            <div v-if="cate==''&&text==''" class="app-padding text-center q-mt-xl popular cursor-pointer">
                <div class=" text-h4 q-py-lg text-primary text-bold">{{ $t('trend')}}</div>
                <hr style="border-top: dashed 1px #333; width: 33%">

                <!-- trend phai dung item,index  -->
                <div class="q-my-xl">
                    <q-virtual-scroll :items="menu" virtual-scroll-horizontal>
                        <template v-slot="{ item, index }">
                            <div :key="index" style="width:250px; margin-right: 10px;">
                                <q-card flat bordered class="cta" @click="cate=item.title;c.scrollTo('body')">
                                    <q-img :ratio="3/4" :src="c.showImage(item.images)" :alt="item.title"
                                        :title="item.title">
                                        <div class="absolute-bottom text-left" style="bottom:20px;right:70px">
                                            {{ item.title }}
                                        </div>
                                    </q-img>

                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('category',item._id)">
                                    </q-btn>
                                </q-card>
                            </div>
                        </template>
                    </q-virtual-scroll>
                </div>

            </div>



            <!-- banner 1 site.images[1,2,3]
            =========================== -->
            <div v-if="cate==''&&text==''" class="app-padding">
                <q-img :ratio="16/7" :src="c.showImage(site.images,1)"></q-img>
            </div>




            <!-- new and sale off 
            ================================== -->
            <div v-if="cate==''&&text==''" class="app-padding q-mt-xl cursor-pointer">
                <q-tabs v-model="tab" no-caps class="text-primary popular" align="center" :breakpoint="0">
                    <q-tab name="new"><span class="text-h4 q-px-lg cta" clickable @click="getNewArrival();">{{ $t('new')
                            }}</span>
                    </q-tab>
                    <q-tab name="sale"><span class="text-h4 q-px-lg cta" clickable @click="getSaleOff()">{{ $t('sale')
                            }}</span>
                    </q-tab>
                </q-tabs>

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="new">
                        <div class="row q-col-gutter-md">
                            <div class="col-6 col-md-3 q-my-md" v-for="(item,index) in newArrival">
                                <q-card flat class="cta" @click="$router.push('/'+item._id)">
                                    <q-img :src="c.showImage(item.images)" :alt="item.title" :title="item.title">
                                    </q-img>
                                    <q-card-actions align="center">
                                        <div class="text-subtitle1">
                                            {{ item.title }} <br>
                                            <span class="text-red">{{ c.formatCurrency(item.price) }}</span>
                                            <s class="text-grey text-caption">{{ c.formatCurrency(item.retail_price)
                                                }}</s>
                                        </div>
                                        <!-- admin icon -->
                                        <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                            @click="editPost('product',item._id)">
                                        </q-btn>
                                    </q-card-actions>
                                </q-card>
                            </div>
                        </div>
                    </q-tab-panel>

                    <q-tab-panel name="sale">
                        <div class="row q-col-gutter-md">
                            <div class="col-6 col-md-3 q-my-md" v-for="(item,index) in saleOff">
                                <q-card flat class="cta" @click="$router.push('/'+item._id)">
                                    <q-img :src="c.showImage(item.images)" :alt="item.title" :title="item.title">
                                        <div class="absolute-bottom bg-red text-white text-center text-bold"
                                            style="bottom:20px;left:180px">
                                            {{ item.discountPercent }}%
                                        </div>
                                    </q-img>
                                    <q-card-actions align="center">
                                        <div class="text-subtitle1">
                                            {{ item.title }} <br>
                                            <span class="text-red">{{ c.formatCurrency(item.price) }}</span>
                                            <s class="text-grey text-caption">{{ c.formatCurrency(item.retail_price)
                                                }}</s>
                                        </div>

                                        <!-- admin icon -->
                                        <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                            @click="editPost('product',item._id)">
                                        </q-btn>
                                    </q-card-actions>
                                </q-card>
                            </div>
                        </div>

                    </q-tab-panel>
                </q-tab-panels>
            </div>





            <!-- banner 2 
            ======================== -->
            <div v-if="cate==''&&text==''" class="app-padding">
                <q-img :ratio="16/7" :src="c.showImage(site.images,2)"></q-img>
            </div>





            <!-- hot sales  
            ================================-->
            <div v-if="cate==''&&text==''" class="app-padding popular cursor-pointer">
                <div class="text-h4 text-center q-mt-xl text-primary text-bold">{{ $t('hotsales') }}</div>
                <hr style="border-top: dashed 1px #333; width: 33%">

                <div class="row q-col-gutter-md">
                    <div class="col-6 col-md-3 q-my-md" v-for="(item,index) in hotSales">
                        <q-card flat class="cta" @click="$router.push('/'+item._id)">
                            <q-img :ratio="3/4" :src="c.showImage(item.images)"></q-img>
                            <q-card-actions align="center">
                                <div class="text-subtitle1">
                                    {{ item.title }} <br>
                                    <span class="text-red">{{ c.formatCurrency(item.price) }}</span>
                                    <s class="text-grey text-caption">{{ c.formatCurrency(item.retail_price) }}</s>
                                </div>

                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                    @click="editPost('product',item._id)">
                                </q-btn>
                            </q-card-actions>
                        </q-card>
                    </div>
                </div>
            </div>







            <!-- all products / search 
            ================================================================  -->
            <div id="product_list" class="app-padding q-my-xl cursor-pointer">
                <q-toolbar class="popular">
                    <h2 class="text-h4 text-bold text-primary cta" @click="table=false">
                        <q-icon name="list_alt"></q-icon> {{ $t('product_list') }}
                    </h2>
                    <q-space></q-space>
                    <q-btn flat icon-right="list_alt" text-color="primary" class="text-bold cta" label="Bảng giá"
                        @click="table=!table;"></q-btn>
                </q-toolbar>

                <div v-if="!table" class="row q-col-gutter-md cursor-pointer">
                    <div v-for="(item,index) in fsearch" class="col-6 col-md-3">

                        <q-card flat class="cta" @click="$router.push('/'+item._id)">
                            <q-img :ratio="3/4" :src="c.showImage(item.images)"></q-img>
                            <q-card-actions align="center">
                                <div class="text-subtitle1">
                                    {{ item.title }} <br>
                                    <span class="text-red">{{ c.formatCurrency(item.price) }}</span>
                                    <s class="text-grey text-caption">{{ c.formatCurrency(item.retail_price) }}</s>
                                </div>

                                <!-- admin icon -->
                                <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                    @click="editPost('product',item._id)">
                                </q-btn>
                            </q-card-actions>
                        </q-card>

                    </div>
                </div>


                <div v-if="table">
                    <q-table flat bordered title="Bảng giá" :data="products" :columns="columns" row-key="name">
                        <template v-slot:body="props">
                            <q-tr :props="props">
                                <q-td key="sku" :props="props">
                                    {{ props.row.sku }}
                                </q-td>
                                <q-td key="name" :props="props" class="cursor-pointer">
                                    <a class="text-primary" @click="$router.push('/'+props.row._id)"
                                        :alt="site.keywords">
                                        {{ props.row.title }}</a>
                                </q-td>
                                <q-td key="price" :props="props">
                                    {{ c.formatCurrency(props.row.price) }}
                                </q-td>
                                <q-td key="retail_price" :props="props">
                                    {{ c.formatCurrency(props.row.retail_price) }}
                                </q-td>
                            </q-tr>
                        </template>
                    </q-table>
                </div>
            </div>




            <!-- blog 
            ================================ -->
            <div v-if="cate==''&&text==''" class="app-padding popular cursor-pointer">
                <div class="text-h4 text-center q-mt-xl text-primary text-bold">{{ $t('articles') }}</div>
                <hr style="border-top: dashed 1px #333; width: 33%">
                <div class="q-my-lg">
                    <q-virtual-scroll :items="posts" virtual-scroll-horizontal>
                        <template v-slot="{ item, index }">
                            <div :key="index" style="width:250px; margin-right: 10px;">
                                <q-card flat bordered>
                                <a :href="'<?=get_base()?>/view/post/' + item.slug + '<?=lang_append()?>'"
                                                :alt="site.keywords">
                                    <q-img :ratio="16/9" :src="c.showImage(item.images)" :alt="item.title"
                                        :title="item.title">
                                        <!-- <div class="absolute-bottom text-caption text-left" style="bottom:20px;right:70px">
                                    </div> -->
                                    </q-img>
                                            </a>
                                    <q-card-section>
                                        <div class="text-subtitle1 text-bold">{{ item.title }}</div>
                                        <div class="text-body2 ellipsis-2-lines">{{ item.summary }}</div>
                                    </q-card-section>

                                    <!-- admin icon -->
                                    <q-btn icon="post_add" v-if="edit" outline label="Edit"
                                        @click="editPost('product',item._id)">
                                    </q-btn>
                                </q-card>
                            </div>
                        </template>
                    </q-virtual-scroll>
                </div>
            </div>

            <div class="q-mt-xl"></div>




            <!-- view product dialog 
          =================================== -->
            <aside>
                <q-dialog id="view_product" v-model="show_product" persistent :maximized="maximizedToggle"
                    transition-show="slide-up" transition-hide="slide-down">

                    <div class="bg-white">
                        <q-toolbar>
                            <div class="app-padding">
                                <!-- header logo -->
                                <a href="<?=get_base()?>/shop" alt="home">
                                    <img :src="c.showImage(site.images,0)" height="60px" loading="lazy" alt="logo"
                                        title="Logo" />
                                </a>
                            </div>

                            <!-- <q-btn no-caps outline color="primary" icon="west" label="Trở về Shop"
                                @click="$router.push('/')" v-close-popup>
                            </q-btn> -->
                            <q-space></q-space>

                            <q-btn flat round color="primary" size="xl" icon="shopping_bag"
                                @click="show_checkout=true;">
                                <q-badge color="red" floating>{{ cart.length }}</q-badge>
                            </q-btn>

                            <q-btn flat round icon="close" @click="$router.push('/')" v-close-popup>
                                <q-tooltip content-class="bg-white text-primary">Đóng lại</q-tooltip>
                            </q-btn>
                        </q-toolbar>

                        <q-separator></q-separator>

                        <!-- breadcumbs 
                        =================================== -->
                        <q-breadcrumbs class="app-padding q-py-sm bg-grey-2 cursor-pointer">
                            <q-breadcrumbs-el icon="home" @click="cate='';text=''; show_product=false">
                            </q-breadcrumbs-el>
                            <q-breadcrumbs-el :label="$t('product')"></q-breadcrumbs-el>
                            <q-breadcrumbs-el :label="selected_product ? selected_product.title : ''">
                            </q-breadcrumbs-el>
                        </q-breadcrumbs>


                        <div v-if="selected_product" class="row q-col-gutter-md app-padding q-mt-md q-mb-xl">
                            <!-- left pane  -->
                            <div class="col-12 col-md-6">
                                <div>
                                    <q-img :src="c.showImage(selected_product.images)" :ratio="3/5"></q-img>
                                </div>
                                <!-- san pham lien quan  -->

                                <!-- san pham lien quan  -->
                                <div class="row q-gutter-sm q-mt-sm cursor-pointer">

                                    <div v-if="related_images && related_images.length>0"
                                        v-for="(one,index) in related_images" :key="index" class="col">
                                        <q-img class="rounded-borders" :src="c.showImage(one)" :ratio="1" clickable
                                            @click="selectedImage=one;dialogImage=true">
                                        </q-img>
                                    </div>

                                </div>
                            </div>

                            <!-- right pane  -->
                            <div class="col-12 col-md-6">
                                <div>
                                    <div class="text-h5 text-bold text-primary" v-html="selected_product.title"></div>
                                    <div class="text-caption">SKU: {{ selected_product.sku }}</div>
                                    <q-separator></q-separator>
                                    <div class="q-my-sm">
                                        <q-badge transparent align="middle" color="red">
                                            {{
                                            ((selected_product.retail_price-selected_product.price)/selected_product.retail_price*100).toFixed(0)
                                            }}%
                                        </q-badge>
                                        <span class="text-h5  text-bold text-red">{{
                                            c.formatCurrency(selected_product.price)
                                            }}</span>
                                        <s class="text-grey">{{ c.formatCurrency(selected_product.retail_price)}}</s>

                                    </div>
                                    <q-separator></q-separator>
                                    <div class="q-my-md">
                                        <q-icon name="star" class="text-orange" v-for="one in 5"></q-icon>
                                        <q-chip color="green" outline text-color="white" icon="beenhere">
                                            <span class="text-caption">{{ $t('checked')}}</span>
                                        </q-chip>
                                    </div>
                                    <q-toolbar class="no-padding">
                                        <q-input outlined type="number" min="1" v-model.number="quantity"
                                            style="width:60px;">
                                        </q-input>
                                        <q-btn push class="q-ml-sm" color="primary" label="Thêm vào giỏ"
                                            @click="addToCart()"></q-btn>

                                        <q-btn v-if="cart.length>0" push class="q-ml-sm" color="red" label="Mua ngay"
                                            @click="show_checkout=true;"></q-btn>

                                    </q-toolbar>

                                </div>

                                <div class="col-12 col-md-12">
                                    <h2 class="text-subtitle1 text-bold">Mô tả sản phẩm</h2>
                                    <div v-html="selected_product.summary"></div>
                                    <div v-html="selected_product.content"></div>
                                </div>
                            </div>


                        </div>


                    </div>

                </q-dialog>
            </aside>




            <!-- show an image popup  -->
            <q-dialog v-model="dialogImage">
                <div style="width:90vw" class="bg-white q-pa-md">
                    <q-img :src="selectedImage" style="width:100%"></q-img>
                </div>
            </q-dialog>






            <!-- check out form 
          ================================ -->
            <aside>
                <q-dialog id="view_cart" v-model="show_checkout" persistent :maximized="maximizedToggle"
                    transition-show="slide-up" transition-hide="slide-down">
                    <div class="bg-white">
                        <q-toolbar>
                            <div class="app-padding">
                                <!-- header logo -->
                                <a href="<?=get_base()?>/shop" alt="home">
                                    <img :src="c.showImage(site.images,0)" height="60px" loading="lazy" alt="logo"
                                        title="Logo" />
                                </a>
                            </div>
                            <!-- <q-btn outline icon="west" color="primary" label="Tiếp tục mua sắm"
                                @click="$router.push('/')" v-close-popup>
                            </q-btn> -->
                            <q-space></q-space>
                            <q-btn dense flat icon="close" @click="$router.push('/')" v-close-popup>
                                <q-tooltip content-class="bg-white text-primary">{{ $t('close') }} </q-tooltip>
                            </q-btn>
                        </q-toolbar>

                        <q-separator></q-separator>

                        <!-- breadcumbs 
                        =================================== -->
                        <q-breadcrumbs class="app-padding q-py-sm bg-grey-2 cursor-pointer">
                            <q-breadcrumbs-el icon="home"
                                @click="cate='';text=''; show_checkout=false; show_product=false;">
                            </q-breadcrumbs-el>
                            <q-breadcrumbs-el :label="$t('cart')"></q-breadcrumbs-el>
                            <q-breadcrumbs-el :label="$t('checkout')"></q-breadcrumbs-el>
                        </q-breadcrumbs>


                        <div class="row q-col-gutter-md app-padding q-my-md">

                            <!-- right pane form dat hang  -->
                            <div class="col-12 col-md-6" style="border-right:solid 0.2px #eee;">

                                <div v-if="cart&&cart.length>=1" class="q-mr-md">
                                    <div class="text-h5">{{ $t('info')}}</div>
                                    <q-form @submit="make_order()" @reset="reset" class="row q-col-gutter-sm">

                                        <q-input outlined v-model="guest.name" class="col-12 col-md-6"
                                            label="Họ và tên *"></q-input>
                                        <!-- <q-input outlined v-model="guest.position" class="col-12 col-md-6"
                                            label="Chức danh"></q-input> -->
                                        <q-input outlined v-model="guest.phone" class="col-12 col-md-6"
                                            label="Điện thoại *"></q-input>
                                        <q-input outlined v-model="guest.email" class="col-12 col-md-6" label="Email *">
                                        </q-input>
                                        <!-- <q-input outlined v-model="guest.company" class="col-12 col-md-6"
                                            label="Tên Công ty"></q-input> -->
                                        <q-input outlined v-model="guest.province" class="col-12 col-md-6"
                                            label="Tỉnh thành *">
                                        </q-input>
                                        <q-input outlined v-model="guest.address" class="col-12 col-md-12"
                                            label="Địa chỉ"></q-input>
                                        <!-- <q-input filled v-model="guest.industry" class="col-12 col-md-12"
                                            label="Ngành kinh doanh"
                                            placeholder="sản xuất, thương mại, thủy sản, bao bì, may mặc, xây dựng, dược, thép, bán lẻ...">
                                        </q-input> -->
                                        <q-input outlined v-model="guest.first_request" type="textarea" rows="3"
                                            class="col-12 col-md-12" label="Ghi chú đặt hàng"></q-input>

                                        <div class="q-mt-lg">
                                            <q-btn push label="Xác nhận đặt hàng" type="submit" color="primary">
                                            </q-btn>
                                            </q-btn>
                                            <q-btn flat label="Làm lại" type="reset" color="primary" class="q-ml-sm">
                                            </q-btn>
                                        </div>
                                    </q-form>
                                </div>
                            </div>
                            <!-- left pane  -->
                            <div class="col-12 col-md-6">
                                <!-- cart  -->
                                <div class="text-h5">{{ $t('cart') }}</div>
                                <div class="q-py-md" v-if="!cart||cart.length<=0">{{ $t('cart') }} {{
                                    $t('empty') }}
                                </div>
                                <q-separator></q-separator>

                                <div v-if="cart&&cart.length>=1" v-for="(one,index) in cart" :key="index">
                                    <q-banner inline-actions flat class="q-pa-sm">
                                        <template v-slot:avatar>
                                            <q-img :src="c.showImage(one.images)" style="width: 60px">
                                            </q-img>
                                        </template>
                                        <div>{{ one.title }} </div>
                                        <div class="text-caption">{{ one.sku }} x {{ one.quantity }}</div>
                                        <template v-slot:action>
                                            <div class="text-bold">{{ c.formatCurrency(one.price * one.quantity) }}
                                            </div>
                                            <q-btn flat round class="q-ml-md" color="grey" icon="delete" @click="removeItem(one._id)"></q-btn>
                                        </template>
                                    </q-banner>

                                </div>
                                <q-separator></q-separator>

                                <q-banner inline-actions class="q-pa-sm">
                                    {{ $t('grandtotal')}}
                                    <template v-slot:action>
                                        <div class="text-h5 text-bold">
                                            {{ c.formatCurrency(getTotal() ) }}
                                        </div>
                                        <q-btn v-if="cart&&cart.length>0" flat round class="q-ml-md" color="grey" icon="check"></q-btn>

                                    </template>
                                </q-banner>
                                <q-separator></q-separator>

                            </div>


                        </div>
                    </div>
                </q-dialog>
            </aside>




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

<?php 
    $policy = show_policy();
?>

<script>
    // global var from php
    //---------------------------------------------------
    window.site = <?= json_encode($site); ?>;
    // window.lang = <?= json_encode($site); ?>;
    window.product = <?= json_encode($product); ?>;
    window.category = <?= json_encode($category); ?>;
    window.tax = <?= json_encode($tax); ?>;
    window.post = <?= json_encode($post); ?>;

    window.policy = <?= json_encode($policy); ?>;

    console.log(window.policy ? window.policy : [])

    window.aff = getAff("aff");
    console.log(window.site)

    function getAff(name) {
        url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';

        var res = decodeURIComponent(results[2].replace(/\+/g, ' '));
        return res != null ? res : ''
    }

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
<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.15.15/dist/quasar.umd.modern.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.15.15/dist/lang/vi.umd.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue-i18n@8"></script>


<script type="module">

    import Track from './config/track.js'
    import Common from './config/common.js'

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
            features: 'Featured Products',
            articles: 'Articles',
            search: 'Search',
            trend: "Trends",
            new: 'New Arrival',
            sale: 'Sale Off',
            hotsales: 'Hot Sales',
            articles: 'Latest Articles',
            category: 'Category',
            product_list: 'List of products',
            cart: "Your Cart",
            checkout: 'Checkout',
            info: 'Your Information',
            empty: ' is empty',
            subtotal: 'Subtotal',
            grandtotal: "Grand Total",
            close: 'Close',
            checked: "Checked",
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
            features: 'Sản phẩm nổi bật',
            articles: 'Bài viết',
            search: 'Tìm kiếm',
            trend: 'Xu hướng mới',
            new: "Mới về",
            sale: "Giảm giá",
            hotsales: "Bán chạy nhất",
            articles: 'Bài viết mới nhất',
            category: 'Danh mục',
            product_list: 'Danh sách sản phẩm',
            cart: 'Giỏ hàng',
            checkout: 'Thanh toán',
            info: 'Thông tin của bạn',
            empty: ' rỗng ',
            subtotal: 'Tạm tính',
            grandtotal: "Tổng cộng",
            close: 'Đóng lại',
            checked: 'Đã kiểm tra',
            company_owner: "Đại diện pháp luật",
            policy: "Chính sách",
        }
    }

    const i18n = new VueI18n({
        locale: '<?=$lang ? $lang : 'vi'?>',
        messages,
    })

    // vue router 
    //--------------------------------------------------------
    const Foo = { template: "#empty" }; // chi dung de khoi tao 
    const routes = [
        { path: '/:id', component: Foo },
        // { path: '/checkout', component: Foo },
    ];

    const router = new VueRouter({
        // mode: 'history', // never use -> error 
        routes,
    });

    router.beforeEach((to, from, next) => {
        // console.log(from)
        // console.log(to)
        if (from.path != to.path && to.params.id) {
            window.id = to.params.id //
            // console.log(window.id)
        }
        next()
    })

    Quasar.lang.set(Quasar.lang.vi)

    new Vue({
        el: "#q-app",
        router,
        i18n: i18n,
        data() {
            return {
                track: new Track(),
                c: new Common(this.$q),
                site: {},
                lang: "",
                text: '',
                tab: 'new',

                slide: 0,
                slider: [],
                // loading: false,
                dialog: false,
                maximizedToggle: true,

                guest: {}, // visitor
                edit: false,
                emailForm: false,

                currentId: 1,
                product: {}, // selected_product = this post
                products: [],
                hotSales: [],
                newArrival: [],
                saleOff: [],

                posts: [],

                show_product: false,
                show_checkout: false,
                show_order: false,

                quantity: 1,
                cart: [],
                item: {},
                shippingPrice: 0,
                coupon: '',
                subtotal: 0,
                total: 0,
                cog: 0,
                profit: 0,
                aff: "online",

                cate: '',
                category: [],
                menu: [],
                showsearch: false,
                table: false,
                columns: [
                    { name: 'sku', label: 'SKU', field: row => row.sku },
                    {
                        name: 'name',
                        required: true,
                        label: 'Sản phẩm',
                        align: 'left',
                        field: row => row.title,
                        format: val => `${val}`,
                        sortable: true
                    },
                    { name: 'price', label: 'Giá bán', field: row => row.price, sortable: true },
                    { name: 'retail_price', label: 'Giá thị trường', field: row => row.retail_price, sortable: true }
                ],

                policy: [],
                dialogImage: false,
                selectedImage: ""
            }
        },
        watch: {
            // watch moi khi change 
            "$route.params.id": function (value) {
                //Your code here
                if (value) {
                    this.currentId = value
                    this.show_product = true
                    // this.viewPostByParam(value)
                }
            }
        },

        computed: {
            selected_product() {
                let vm = this
                let res = vm.products.find(x => x._id == vm.currentId); // posts is all 
                this.product = res
                return res
            },

            related_images() {
                let vm = this
                let images = vm.selected_product.images
                let imgs = (images && images.includes(',')) ? images.split(',') : []
                return imgs
            },

            items() {
                return this.cart.map(item => {
                    let res = {}
                    res.sku = item.sku
                    res.unit = item.unit
                    res.title = item.title
                    res.price = item.price
                    res.quantity = item.quantity
                    res.images = item.images
                    res.warranty = item.warranty ? item.warranty : 0
                    res.parent_id = null // de san 
                    return res
                })
            },
            fsearch() {
                let vm = this;
                let posts = vm.products

                const search = vm.text ? vm.text.toLowerCase().trim() : '';
                const category = vm.cate ? vm.cate.toLowerCase().trim() : '';

                if (search == "" && category == "") return vm.products;

                if (category != "")
                    // filter by type     
                    return posts.filter(function (c) {
                        let r = c.category ? c.category.toLowerCase() : '';  // array also
                        return r.includes(category);
                    });

                if (search != "")
                    // filter by search 
                    return posts.filter(function (c) {
                        let r = c.title ? c.title.toString().toLowerCase() : ''; // array also
                        return r.includes(search);
                        // || (c.content.toLowerCase().includes(search))
                    });

            },

        },
        mounted() {
            this.track.cta()
            // this.getSubtotal()
            // this.getTotal()
        },
        created() {
            this.init()
            this.track.ping()
        },
        methods: {
            init() {
                // this.reset() // the form
                this.site = window.site
                // this.lang = window.lang
                this.products = window.product
                this.category = window.category
                this.posts = window.post
                this.aff = window.aff

                // this.c.log(this.category)

                this.fetchAll()
                this.menu = this.loadMenu('product')
                this.slider = this.loadSlider(this.site.slider)
                this.newArrival = this.getNewArrival()
                this.saleOff = this.getSaleOff()
                this.hotSales = this.getHotSales()
                this.posts = this.getFeaturedPosts()

                this.policy = window.policy

                if (window.id) {
                    this.currentId = window.id
                    this.show_product = true
                    // window.id = ""
                }
            },
            fetchAll() {
                var vm = this
                vm.$q.loadingBar.start()

                if (!vm.site.site_title) {
                    vm.$q.loadingBar.stop()
                    vm.c.toast("Không tải được setting cho website này!", 'negative')
                    return
                }

                if (vm.products && vm.products.length > 0) {
                    // sort the posts by id desc
                    vm.products.sort(function (a, b) {
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
            getNewArrival() {
                // by ddate_created 
                let vm = this
                const p = vm.products
                let res = p.sort(function (a, b) {
                    let prop = "date_created"
                    var x = b[prop].toLowerCase();
                    var y = a[prop].toLowerCase();
                    if (x < y) { return -1; }
                    if (x > y) { return 1; }
                    return 0;
                })
                return res
            },
            getSaleOff() {
                // by discount 
                let vm = this
                const p = vm.products
                let res = p.map(m => {
                    let r = m
                    r.discount = m.retail_price ? m.retail_price - m.price : 0
                    r.discountPercent = (r.discount / m.retail_price * 100).toFixed(0)
                    return r
                }).sort(function (a, b) {
                    return b.discount - a.discount
                })
                return res
            },
            getHotSales() {
                // by instock 
                let vm = this
                const p = vm.products
                let res = p.map(m => {
                    let r = m
                    return r
                }).sort(function (a, b) {
                    return a.instock - b.instock
                })
                return res
            },
            getFeaturedPosts() {
                let vm = this
                const p = vm.posts
                let res = p.slice(0, 8)
                return res
            },

            reset() {
                this.guest = {}
            },
            valid() {
                return (this.guest.name && this.guest.phone && this.guest.email && this.guest.province)
            },
            editMode() {
                this.edit = !this.edit
                if (this.edit)
                    this.c.toast("Đã kích hoạt Nút sửa sản phẩm", 'negative')
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
            addToCart() {
                this.item = this.selected_product
                this.item.quantity = this.quantity
                // this.c.log(this.cart)
                for (let i = 0; i < this.cart.length; i++) {
                    if (this.cart[i]._id == this.item._id) {
                        this.cart.splice(i, 1)
                    }
                }
                this.cart.push(this.item)

                this.subtotal = this.getSubtotal()
                this.total = this.getTotal() // reduce cart 
                this.c.toast('Bạn vừa thêm vào giỏ hàng', 'positive');
                this.quantity = 1
            },
            removeItem(id) {
                this.cart = this.cart.filter(function (res) {
                    return res._id != id
                })

                this.subtotal = this.getSubtotal() // reduce cart 
                this.total = this.getTotal()

                console.log(this.total)

                this.c.toast("Đã bỏ ra khỏi giỏ hàng")
                this.$forceUpdate() 
            },
            getSubtotal() {
                let vm = this
                if (vm.cart&& vm.cart.length<=0) return 0 
                let amounts = vm.cart.map(m => {
                    return { amount: m.price * m.quantity }
                })
                return this.c.sum(amounts, 'amount')
            },
            getTotal() {
                if (this.cart&& this.cart.length<=0) return 0 
                return (
                    this.subtotal + this.shippingPrice
                )
            },
            getCog() {
                let vm = this
                let cogs = vm.cart.map(m => {
                    return { cog: m.cog }
                })
                return this.c.sum(cogs, 'cog')
            },
            make_order() {
                if (!this.valid()) {
                    this.c.toast("Vui lòng nhập đủ thông tin", 'negative')
                    return false
                }
                let cf = confirm("Bạn xác nhận đặt hàng?")
                if (!cf) return false
                this.save_db();

            },
            async save_db() {

                let vm = this

                // data to post 
                let data = {
                    so: {},
                    contact: {},
                    items: []
                }

                // so and so_items 
                const code = vm.c.genCode('SO')
                let cog = vm.getCog()

                let so = {
                    code: code,
                    slug: code,
                    title: "Đặt hàng online",
                    status: "New",
                    groupname: 'Web',
                    type: 'Online',
                    date_created: vm.c.formatDataDate(new Date()),
                    date_updated: vm.c.formatDataDate(new Date()),
                    date_start: vm.c.formatDataDate(new Date()),
                    total: vm.total,
                    cog: cog,
                    owner: "online",
                }

                // contact 
                let contact = vm.guest
                contact.cookie = localStorage.cookie ? localStorage.cookie : null
                contact.name = vm.guest.name // not null 
                contact.slug = vm.c.genCode('CO')  // not null 
                contact.code = contact.slug
                contact.title = vm.guest.name

                contact.aff = vm.site.aff ? vm.site.aff : 'online';
                contact.source = location.href
                contact.type = "Online"
                contact.date_created = vm.c.formatDataDate(new Date())
                contact.date_updated = vm.c.formatDataDate(new Date())
                contact.owner = "online"

                //postdata 
                data.contact = contact
                data.so = so
                data.items = vm.items // map form cart  
                let endpoint = vm.track.api + '/so_upsert'; /// track.api da co domain 

                // vm.c.log(data);
                // vm.c.log(endpoint);

                // return

                vm.loading = true
                // post de api xu ly het 
                let res = await axios.post(endpoint, data)
                vm.c.toast("Đã gửi đơn đặt hàng", 'positive')

                vm.cart = []
                vm.c.log(res)
                vm.show_checkout = false
                vm.show_product = false
                vm.loading = false
            },


        },

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

    hr {
        background-color: #eee;
        border: 0 none;
        color: #eee;
        height: 1px;

    }

    table {
        border-collapse: collapse;
        width: 100%;

    }

    th,
    td {
        text-align: left;
        padding: 8px;
        font-size: 0.85rem;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .app-padding {
        padding-left: 12vw;
        padding-right: 12vw;
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

    .card {
        min-height: 50vh;
    }

    .card:hover {
        margin-top: -10px;
        box-shadow: 5px;
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

    /* card hover */
    .container {
        position: relative;
    }

    .image {
        opacity: 1;
        display: block;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }

    .container:hover .image {
        opacity: 0.1;
    }

    .container:hover .middle {
        opacity: 1;
    }


    @media (orientation: portrait) {

        .text-h4 {
            font-size: 1.6rem;
        }

        .section-padding {
            padding: 10px !important;
        }

        .app-padding {
            padding-left: 5vw;
            padding-right: 5vw;
        }

        #slider {
            height: 45vh;
        }

        .full-width {
            max-width: calc(100% - 3em);
        }


    }
</style>