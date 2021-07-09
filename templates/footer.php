<!-- footer 
============================================================== -->

<footer class="text-white section-padding h-card cursor-pointer" :style="'background:'+site.color_footer">


    <div class="row q-col-gutter-xl">


        <!-- column 1 -->
        <div class="col-12 col-md-4 q-pr-xl">
            <h3 class="text-subtitle1 text-bold">{{ site.site_name }}</h3>
            <div class="text-caption ellipsis-3-lines" v-html="site.site_description"></div>
        </div>


        <!-- column 2 -->
        <div class="col-12 col-md-4">
            <q-list dense>

                <h3 class="text-h6 text-bold p-name">{{ site.company_name }}
                    {{ c.addBranch(site.branch)}}</h3>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="location_on" />
                    </q-item-section>
                    <q-item-section class="p-street-address" v-html="site.company_address">
                    </q-item-section>
                </q-item>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="phone" />
                    </q-item-section>
                    <q-item-section class="p-tel">
                        {{ site.contact_phone }} - {{
                        site.contact_name }}
                    </q-item-section>
                </q-item>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="email" />
                    </q-item-section>
                    <q-item-section class="p-email">
                        {{ site.contact_email}}
                    </q-item-section>
                </q-item>


            </q-list>
        </div>



        <!-- column 3 -->
        <div class="col-12 col-md-4 text-white">
            <h3 class="text-h6 text-bold">{{ $t('social')}}</h3>
            <q-list dense>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="facebook" />
                    </q-item-section>
                    <q-item-section>
                        <a class="text-white" :href="site.contact_facebook">{{ site.contact_facebook}}</a>
                    </q-item-section>
                </q-item>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="chat" />
                    </q-item-section>
                    <q-item-section>
                        <a class="text-white" :href="site.contact_zalo">{{ site.contact_zalo}}</a>
                    </q-item-section>
                </q-item>

                <q-item>
                    <q-item-section avatar>
                        <q-icon name="copyright" />
                    </q-item-section>
                    <q-item-section>
                        <a class="text-white" href @click.prevent="editMode()">Designed By Hitime.vn</a>
                    </q-item-section>
                </q-item>
            </q-list>
        </div>



    </div>
</footer>




<!-- call to action fab 
====================================================== -->
<aside class="z-top">
    <q-page-sticky position="bottom-left" :offset="[20, 40]">
        <q-fab icon="phone" direction="right" :label="$t('contact')" aria-label="contact-fab" label-position="top"
            external-label hide-label="false" color="accent">
            <q-fab-action type="a" class="cta" external-label label-position="top" aria-label="contact-phone"
                :href="c.phoneUrl(site.contact_phone)" label="Call" color="red" icon="phone">
            </q-fab-action>
            <q-fab-action type="a" class="cta" external-label label-position="top" aria-label="contact-zalo"
                :href="site.contact_zalo" label="Zalo" color="blue-8" icon="comment">
            </q-fab-action>
            <q-fab-action class="cta" external-label label-position="top" aria-label="contact-face"
                :href="site.contact_facebook" label="Facebook" color="blue-10" icon="facebook">
            </q-fab-action>
            <!-- <q-fab-action external-label label-position="top" aria-label="contact-top"
                @click.prevent="emailForm=true;reset()" label="Email" color="white" class="text-grey" icon="email">
            </q-fab-action> -->
        </q-fab>
    </q-page-sticky>
</aside>


<!-- place QPageScroller at end of page -->
<q-page-scroller position="bottom-right" :scroll-offset="150" :offset="[10, 280]">
    <q-btn fab icon="keyboard_arrow_up" color="info" />
</q-page-scroller>
