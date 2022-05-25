<template>
  <!-- Main footer-->
  <footer class="main-footer">
    <div class="container">
      <div class="row">
        <!--<div class="col-md-3">-->
          <!--<div class="foot-logo">-->
            <!--&lt;!&ndash; <img src="~/assets/website/imgs/home/logo-foot@2x.png" alt=""> &ndash;&gt;-->
            <!--<img v-if="currentLocale == 'en'" src="../../assets/website/imgs/home/logo-foot@2x.png" alt="">-->
            <!--<img v-else src="~/assets/website/imgs/home/logo-foot@2x.png" alt="">-->
            <!--</div>-->
        <!--</div>-->
        <div class="col-md-6">
          <h4>{{$t('front.important_links')}}</h4>
          <div class="row">
            <div class="col-6">
              <ul>
                <li><nuxt-link :to="localePath('stores')">{{$t('front.stores')}}</nuxt-link></li>
                <!--<li><nuxt-link :to="localePath('centers')">{{$t('front.centers')}}</nuxt-link></li>-->
                <li><nuxt-link :to="localePath('about')">{{$t('front.about_us')}}</nuxt-link></li>
              </ul>
            </div>
            <div class="col-6">
              <ul>
                <li><nuxt-link :to="localePath('refund-policy')">{{$t('front.refund_policy')}}</nuxt-link></li>
                <li><nuxt-link :to="localePath('policy')">{{$t('front.policy')}}</nuxt-link></li>
                <li><nuxt-link :to="localePath('terms')">{{$t('front.terms')}}</nuxt-link></li>
              </ul>
            </div>
          </div>
        </div>
        <client-only>
          <div class="col-6 col-md-3" v-if="settings">
            <h4>{{$t('front.shop_from_apps')}}</h4>
            <ul class="download">
              <li><a target="_blank" :href="settings.google_store"><img src="~/assets/website/imgs/home/google-play.png" alt=""></a></li>
              <li><a target="_blank" :href="settings.apple_store"><img src="~/assets/website/imgs/home/app-store.png" alt=""></a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3 text-center" v-if="settings">
            <h4>{{$t('front.contacts')}}</h4>
            <ul class="social-footer">
              <li><a target="_blank" :href="settings.youtube"><i class="fab fa-youtube"></i></a></li>
              <li><a target="_blank" :href="settings.facebook"><i class="fab fa-facebook-f"></i></a></li>
              <li><a target="_blank" :href="settings.instagram"><i class="fab fa-instagram"></i></a></li>
              <li><a target="_blank" :href="settings.twitter"><i class="fab fa-twitter"></i></a></li>
            </ul>
            <h5>{{settings.email}}</h5>
            <ul class="payment">
              <li><a href="#"><img src="~/assets/website/imgs/home/pay1.svg" alt=""></a></li>
              <li><a href="#"><img src="~/assets/website/imgs/home/pay2.svg" alt=""></a></li>
              <li><a href="#"><img src="~/assets/website/imgs/home/pay3.svg" alt=""></a></li>
              <li><a href="#"><img src="~/assets/website/imgs/home/pay4.svg" alt=""></a></li>
            </ul>
            <!--<p>{{$t('front.all_rights_reserved')}}</p>-->
          </div>
        </client-only>
      </div>
    </div>
    <div class="rights">
      <div class="container">
        <p>{{$t('front.all_rights_reserved')}}</p>
      </div>
    </div>
  </footer>
  <!-- End Main footer-->
</template>

<script>
import { mapState } from 'vuex'

  export default {
    data () {
      return {

      }
    },
    computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      settings: state => state.localStorage.settings,
    })
  },
    methods: {

    }
  }
</script>

