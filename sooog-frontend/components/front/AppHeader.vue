<template>
  <!-- Main Header-->
  <header class="main-header">
    <div class="bef-h">
      <div class="container">
        <create-request-offer-quantity></create-request-offer-quantity>
        <div class="row">
          <div class="offset-md-5 col-md-7">
            <ul class="user-mnu">
              <li>
                <nuxt-link :to="localePath('carts')">
                  <img src="~/assets/website/imgs/home/basket.svg" alt="">
                </nuxt-link>
              </li>
              <client-only>
                <li class="dropdown" v-show="!authUser">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="~/assets/website/imgs/home/user.svg" alt="">
                  </a>
                  <div class="dropdown-menu">
                    <h3>{{ $t('front.make_login') }}</h3>
                    <p class="grey">{{ $t('front.welcome_again') }}</p>
                    <div class="dropdown-items padd-i">
                      <b-form @submit.prevent="loginForm()" class="form">
                        <!-- <VuePhoneNumberInput v-model="loginData.phone"
                          v-validate="{ required: true }"
                          :translations="translations"
                          default-country-code="SA"
                          @update="updatePhoneNumber"
                          name="phone"
                        /> -->
                        <div class="input-group cntry-input">
                          <select :title="$t('front.country_code')" class="selectpicker form-control login-input"
                                  v-model="loginData.country_code">
                            <option v-for="(country, key) in country_codes" :key="`count${key}`"
                                    :data-thumbnail="country.flag" :value="country.code"
                                    :selected="country.code == '966'">
                              {{ country.code }}
                            </option>
                          </select>
                          <input class="form-control login-input" type="text" name="phone"
                                 :placeholder="$t('front.phone')"
                                 v-model="loginData.phone"
                                 v-validate="{ required: true, numeric: true, min: 7, max: 15 }">
                        </div>
                        <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                            {{ errors.first("phone") }}
                          </span>
                        <!-- </div> -->
                        <input class="form-control login-input" type="password" name="password"
                               :placeholder="$t('front.password')"
                               v-model="loginData.password" v-validate="{ required: true, min: 8 }">
                        <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                            {{ errors.first("password") }}
                          </span>
                        <div class="flex-div">
                          <div>
                            <input class="grey" type="checkbox" v-model="loginData.remember" id="remember-check">
                            <label class="grey" for="remember-check">{{ $t('front.remember') }}</label>
                          </div>
                          <div>
                            <nuxt-link class="yellow" :to="localePath('password-forget')">{{
                                $t('front.qs_forget_password')
                              }}
                            </nuxt-link>
                          </div>
                        </div>
                        <button type="submit" class="button btn-gredient full">{{ $t('front.login') }}</button>
                        <div class="inline-d">
                          <p class="grey">{{ $t('front.not_have_account') }}</p>
                          <nuxt-link class="yellow" :to="localePath('register')">
                            {{ $t('front.new_account') }}
                          </nuxt-link>
                        </div>
                      </b-form>
                    </div>
                  </div>

                </li>
                <!--logged user-->
                <li class="dropdown" v-show="authUser">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="~/assets/website/imgs/home/user.svg" alt="">
                  </a>
                  <div class="dropdown-menu">
                    <h3>{{ $t('front.home') }}</h3>
                    <!-- <p class="grey">
                      {{$t('front.logged_in_menu')}}
                    </p> -->
                    <ul class="dropdown-items">
                      <li>
                        <nuxt-link :to="localePath('profile')">
                          {{ $t('front.profile') }}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li>
                      <li>
                        <nuxt-link :to="localePath('orders')">
                          {{ $t('front.myorders') }}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li>
                      <!--<li>-->
                      <!--<nuxt-link :to="localePath('orders-services')">-->
                      <!--{{$t('front.myservices')}}-->
                      <!--<i class="fas fa-angle-left"></i>-->
                      <!--</nuxt-link>-->
                      <!--</li>-->
                      <li>
                        <nuxt-link :to="localePath('addresses')">
                          {{ $t('front.addresses') }}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li>
                      <li>
                        <nuxt-link :to="localePath('favourites')">
                          {{ $t('front.favourites') }}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li>

                      <li>
                        <nuxt-link :to="localePath('profile-wallet')">
                          {{ $t('front.wallet') }}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li>

                      <!-- <li>
                        <nuxt-link :to="localePath('notifications')">
                          {{$t('admin.notifications')}}
                          <i class="fas fa-angle-left"></i>
                        </nuxt-link>
                      </li> -->
                      <button @click="logout" class="no-btn">
                        <img src="~/assets/website/imgs/account/logout.svg" alt="">
                        {{ $t('front.logout') }}
                      </button>

                      <!-- <li>
                        <a href="account.html">
                          التنبيهات
                          <i class="fas fa-angle-left"></i>
                        </a>
                      </li> -->
                    </ul>
                  </div>
                </li>

                <li v-show="authUser" class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="~/assets/website/imgs/home/bell.svg" alt=""><span
                      class="notifi">{{ notificationCount }}</span></a>
                  <div class="dropdown-menu">
                    <div class="dropdown-items" v-if="notifications.length">
                      <div class="notification new" v-for="item in notifications" :key="item.id">

                        <nuxt-link
                            :to="item.data.type == 'order' ? (item.data.type == 'service_order' ? localePath(`/orders/services/${item.data.model_id}`) : localePath(`/orders/${item.data.model_id}`)) : '#'">
                          <div class="row">
                            <div class="col-3 padd-l-0">
                              <!-- <img src="~/assets/website/imgs/account/notification@2x.png" alt=""> -->
                              <img v-if="item.data.type == 'order'" :src="authUser.avatar" alt="">
                              <img v-else-if="currentLocale == 'en'" src="../../assets/website/imgs/home/logo@2x.png"
                                   alt="">
                              <img v-else src="../../assets/website/imgs/home/logo@2x.png" alt="">
                            </div>
                            <div class="col-9">
                              <div class="row">
                                <div class="col-8">
                                  <h6 class="b">{{ item.data.title }}</h6>
                                </div>
                                <div class="col-4 text-right">
                                  <p class="grey">{{ item.created_at }}</p>
                                </div>
                              </div>
                              <p class="grey">{{ item.data.body }}</p>
                            </div>
                          </div>
                        </nuxt-link>
                      </div>
                    </div>

                    <div v-else class="text-center alert-div">
                      {{ $t('front.no_notification') }}
                    </div>

                    <div class="text-center" v-if="notifications.length">
                      <nuxt-link class="grey more" :to="localePath('notifications')">
                        {{ $t('front.show_all_notifications') }}
                      </nuxt-link>
                    </div>
                  </div>
                </li>
                <li v-show="authUser">
                  <nuxt-link :to="localePath('favourites')">
                    <img src="~/assets/website/imgs/home/love.png" alt="">
                  </nuxt-link>
                </li>
              </client-only>

              <li>
                <a @click="switchMyLang('en')">
                  <img v-if="this.$i18n.locale == 'ar'" src="~/assets/website/imgs/home/internet.png" alt="">
                </a>
                <a @click="switchMyLang('ar')">
                  <img v-if="this.$i18n.locale == 'en'" src="~/assets/website/imgs/home/internet.png" alt="">
                </a>
              </li>
            </ul>
            <form @submit.prevent="handleSearch">
              <div class="input-group search-g">
                <input class="form-control" type="text"
                       v-model="publicSearch" :placeholder="$t('front.search_about')">
                <div class="input-group-prepend">
                  <button><img src="~/assets/website/imgs/home/search.svg" alt=""></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuToggle"
                aria-expanded="false"><span class="sr-only">Toggle navigation</span><i class="fas fa-bars"></i></button>
        <nuxt-link :to="localePath('index')" class="navbar-brand">
          <img v-if="this.$i18n.locale == 'en'" src="~/assets/website/imgs/home/logo@2x.png" alt="">
          <img v-else src="~/assets/website/imgs/home/logo@2x.png" alt="">
        </nuxt-link>
        <div class="collapse navbar-collapse" id="menuToggle">
          <ul class="nav navbar-nav ml-auto">
            <li exact>
              <nuxt-link :to="localePath('index')">{{ $t('front.home') }}</nuxt-link>
            </li>

            <li>
              <nuxt-link :to="localePath('stores')">{{ $t('front.stores') }}</nuxt-link>
            </li>
            <!--<li><nuxt-link :to="localePath('centers')">{{$t('front.centers')}}</nuxt-link></li>-->
            <li>
              <nuxt-link :to="localePath('brands')">{{ $t('front.brands') }}</nuxt-link>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown">
                {{ $t('front.request_price') }}<img src="~/assets/website/imgs/home/arrow-d.svg" alt="">
              </a>
              <div class="dropdown-menu drop-store">
                <ul class="dropdown-items">
                  <li>
                    <nuxt-link :to="localePath('request-offer-quantity')">{{ $t('front.my_request_offer') }}</nuxt-link>
                  </li>
                  <li class="cursor-pointer">
                    <a data-toggle="modal" class="cursor-pointer" data-target="#modal-order">{{ $t('front.request_price_create') }}</a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <nuxt-link :to="localePath('offers')">{{ $t('front.offers') }}</nuxt-link>
            </li>
            <li>
              <nuxt-link :to="localePath('about')">{{ $t('front.about_us') }}</nuxt-link>
            </li>
            <li>
              <nuxt-link :to="localePath('contact')">{{ $t('front.contact_us') }}</nuxt-link>
            </li>

            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle='dropdown'>
                {{ $t('front.trades') }}
                <img src="~/assets/website/imgs/home/arrow-d.svg" alt="">
              </a>
              <div class="dropdown-menu drop-store">
                <ul class="dropdown-items">
                  <li>
                    <nuxt-link class="dropdown-item" :to="localePath('stores-auth-register')">
                      {{ $t('front.store_register') }}
                    </nuxt-link>
                  </li>
                </ul>
                <!--<nuxt-link class="dropdown-item" :to="localePath('centers-auth-register')">-->
                <!--{{$t('front.center_register')}}-->
                <!--</nuxt-link>-->
              </div>
            </li>

          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- End Main Header-->
</template>

<script>
import {mapState} from 'vuex'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import NotificationService from "~/services/notification/NotificationService.js"
import CountryService from "~/services/location/CountryService.js"
import moment from 'moment'
import LoginService from "~/services/auth/LoginService.js"
import CreateRequestOfferQuantity from "../global/requestOffer/CreateRequestOfferQuantity";

export default {
  props: {},
  components: {
    VuePhoneNumberInput,
    CreateRequestOfferQuantity,
  },
  data() {
    return {
      routeName: this.$route.name, // dashboard-locations-states___en
      loginData: {
        phone: null,
        country_code: '',
        password: null,
        remember: false,
      },
      translations: {
        countrySelectorLabel: this.$t('front.country_code'),
        // countrySelectorError: 'Choisir un pays',
        phoneNumberLabel: this.$t('front.phone'),
        // example: 'Exemple :'
      },
      publicSearch: '',
      notifications: [],
      notificationCount: '',
      country_codes: [],
      customEvents: [
        {eventName: 'reset-notification-counter', callback: this.resetNotificationCounter},
        {eventName: 'load-notification', callback: this.callNotifications},
      ]
    }
  },
  created() {
    this.countryCodes()
    if (this.authUser) {
      this.callNotifications()
    }
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy() {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      firebaseToken: state => state.localStorage.firebaseToken,
    }),
    currentDate() {
      return moment().lang(this.currentLocale).format('D MMM YYYY')
    }
  },
  methods: {
    async logout() {
      this.$nuxt.$loading.start()

      await LoginService.logout({device_token: this.firebaseToken})
          .then((res) => {
            this.$store.commit(
                "localStorage/RESET_DATA"
            )
            this.$router.replace(this.localePath('login'))

            this.$toast.success(this.$t('admin.logged_out_successfully'))
          })
          .catch(() => {
          })
      this.$nuxt.$loading.finish();
    },
    countryCodes() {
      CountryService.getAll('?all=1&is_paginated=0')
          .then((res) => {
            this.country_codes = res
            this.loginData.country_code = res.length ? res[0].code : ''
          })
          .catch(() => {
          });
    },
    resetNotificationCounter() {
      this.notificationCount = 0
    },
    callNotifications() {
      this.messiging()
      this.loadNotificationsData()
    },
    messiging() {
      const messaging = this.$fire.messaging;
      debugger
      messaging.onMessage((payload) => {
        // debugger
        // console.log('payload', JSON.parse(payload.data.notification));
        // fire event to load data
        this.notificationCount++
        this.notifications.unshift({
          data: JSON.parse(payload.data.notification).data,
          created_at: this.currentDate
        })
        // debugger
        if (this.notifications.length >= 3) {
          this.notifications.pop()
        }
        let audio = require("@/assets/notification.mp3").default;
        let beeb = new Audio(audio);
        beeb.play();
        // console.log('onMessage: ', payload)
        // this.loadNotificationsData();
      })
    },
    async loadNotificationsData() {
      const response = await Promise.all([
        NotificationService.firstPage().catch(() => {
        }),
        NotificationService.count().catch(() => {
        }),
      ])
      debugger
      this.notifications = response[0] ? response[0]?.data : [];
      this.notificationCount = response[1] ? response[1]?.notifications_count : ''
    },
    async loginForm() {
      this.loginData.phone = this.loginData.phone ? this.loginData.phone.replace(/\s+/g, '') : null
      const validData = await this.$validator.validateAll()

      if (validData) {
        this.login(this.loginData)
      }
    },
    updatePhoneNumber(value) {
      this.phoneData = value
      this.loginData.country_code = value.countryCallingCode
      this.loginData.phone = this.loginData.phone ? this.loginData.phone.replace(/\s+/g, '') : null
    },
    handleSearch() {
      this.$router.push({path: this.localePath('products'), query: {search: this.publicSearch}})
    },
  }
}
</script>
<style scoped>
.navbar-brand img {
  width: 216px;
  height: 66px;
}
</style>
