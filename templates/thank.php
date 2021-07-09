<div id="q-app">
  <template>
    <q-layout>
      <q-page-container>
        <q-page class="no-padding">
          <div class="bg-1">
            <div class="row section-padding">
              <div class="col-12 col-md-8 text-white">
                <div class="text-subtitle1">{{ site.site_name }}</div>
                <h1 class="text-h2">{{ $t('thank') }}</h1>
                <div class="q-mb-xl">{{ $t('feedback_soon') }} </div>

                <a href="#" onclick="window.history.go(-2);" class="text-grey-5 text-caption">
                  <q-icon name="west" size="md"></q-icon> 
                  <!-- Back -->
                </a>

              </div>
              <div class="col-12 col-md-4">
                <!-- <q-img class="rounded-borders" :src="c.showImage(site.images)" /> -->
              </div>
            </div>
          </div>

          <div class="">
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
  window.object = {};
  window.site = {}
  window.site = <?= json_encode($site); ?>;
  window.object = <?= json_encode($object); ?>;

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
          product: 'Products',
          detail: 'View detail',
          more: 'View more',
          home: 'Home',
          features: 'Featured Posts',
          articles: 'Articles',

          thank: 'Thank you',
          feedback_soon : 'We will feedaback to you soon',
      },
      vi: {
          phone: 'Điện thoại',
          address: 'Địa chỉ',
          edit_mode: 'Đã kích hoạt chế độ sửa bài',
          normal_mode: 'Đã trở lại bình thường',
          social : 'Mạng xã hội',
          contact: 'Liên hệ',
          news: 'Tin tức hoạt động',
          product: 'Sản phẩm',
          detail: 'Chi tiết',
          more: 'Xem thêm',
          home: 'Trang chủ',
          features: 'Bài viết nổi bật',
          articles: 'Bài viết',

          thank: 'Cảm ơn bạn',
          feedback_soon : 'Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất',
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
        object: {},
        edit: false,

      }
    },
    created() {
      this.init()
      this.track.ping() 

    },
    methods: {
      init() {
        this.site = window.site
        this.object = window.object
      },
      editMode() {
        this.edit = !this.edit
        if (this.edit)
          this.c.toast(this.$t('edit_mode'),'negative')
        else
          this.c.toast(this.$t('normal_mode'),'positive')
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