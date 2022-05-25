<template>
  <div class="col-md-3">
    <!--account-pills-->
    <div class="profile-pills">
      <div class="logo-profile-wrap">
        <img :src="authUser.avatar" alt="">
      </div>
      <h5 class="grey">{{$t('front.home')}}</h5>
      <div class="nav flex-column nav-pills">
        <nuxt-link :class="currentRoute == `profile___${currentLocale}` ? 'active' : ''"
          :to="localePath('profile')">
          {{$t('front.profile')}}
          <i class="fas fa-angle-left"></i>
        </nuxt-link>
        <!-- <a href="account-orders.html">طلباتى<i class="fas fa-angle-left"></i></a> -->
        <!-- <a href="account-services.html">خدماتى<i class="fas fa-angle-left"></i></a> -->
        <nuxt-link :class="currentRoute == `addresses___${currentLocale}` ? 'active' : ''"
          :to="localePath('addresses')">
          {{$t('front.addresses')}}
          <i class="fas fa-angle-left"></i>
        </nuxt-link>

        <nuxt-link :class="currentRoute == `orders___${currentLocale}` ? 'active' : ''"
          :to="localePath('orders')">
          {{$t('front.myorders')}}
          <i class="fas fa-angle-left"></i>
        </nuxt-link>

        <!--<nuxt-link :class="currentRoute == `orders-services___${currentLocale}` ? 'active' : ''"-->
          <!--:to="localePath('orders-services')">-->
          <!--{{$t('front.myservices')}}-->
          <!--<i class="fas fa-angle-left"></i>-->
        <!--</nuxt-link>-->
        <nuxt-link :class="currentRoute == `favourites___${currentLocale}` ? 'active' : ''"
                   :to="localePath('favourites')">{{$t('front.favourites')}}<i class="fas fa-angle-left"></i></nuxt-link>

        <nuxt-link :class="currentRoute == `request-offer-quantity___${currentLocale}` ? 'active' : ''"
          :to="localePath('request-offer-quantity')">{{$t('front.request_offer_quantities')}}<i class="fas fa-angle-left"></i></nuxt-link>

        <nuxt-link :class="currentRoute == `notifications___${currentLocale}` ? 'active' : ''"
          :to="localePath('notifications')">{{$t('admin.notifications')}}<i class="fas fa-angle-left"></i></nuxt-link>
        <!-- <a href="account-notification.html">التنبيهات<i class="fas fa-angle-left"></i></a> -->

        <nuxt-link :class="currentRoute == `profile-wallet___${currentLocale}` ? 'active' : ''"
          :to="localePath('profile-wallet')">{{$t('front.wallet')}}<i class="fas fa-angle-left"></i></nuxt-link>

      </div>
      <div>
        <button @click="logout" class="no-btn"><img src="~/assets/website/imgs/account/logout.svg" alt="">
          {{$t('front.logout')}}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import LoginService from "~/services/auth/LoginService.js"

export default {
  data () {
    return {
      currentRoute: this.$route.name
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      firebaseToken: state => state.localStorage.firebaseToken,
    })
  },
  methods: {
   async logout () {
      this.$nuxt.$loading.start()

    await LoginService.logout({device_token: this.firebaseToken})
      .then((res) => {
        this.$store.commit(
          "localStorage/RESET_DATA"
        )
        this.$router.replace(this.localePath('login'))

        this.$toast.success(this.$t('admin.logged_out_successfully'))
      })
      .catch(() => {})
      this.$nuxt.$loading.finish();
    },
  }
}
</script>
