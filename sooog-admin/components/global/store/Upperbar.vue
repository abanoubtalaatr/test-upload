<template>
  <section class="dash-upper-bar">
    <b-container>
      <b-row>
        <b-col sm class="text-center text-sm-right">
          <h4>{{ titlePage }}</h4>
        </b-col>
        <!-- <b-col sm class="text-center text-sm-center">
          <ColorModePicker />
        </b-col> -->

          <b-dropdown class="ml-2">
            <template v-slot:button-content>{{ $t('admin.request_offer_quantities') }}</template>

            <a class="dropdown-item" href="/stores/request-offer-quantity">
              {{$t('admin.requests')}}
            </a>

            <a class="dropdown-item" href="/stores/request-offer-quantity/replies?filter=accepted">
              {{$t('admin.reply_request_offer_quantities_accepted')}}
            </a>

            <a class="dropdown-item" href="/stores/request-offer-quantity/replies?filter=pending">
              {{$t('admin.reply_request_offer_quantities_sending')}}
            </a>
            <a class="dropdown-item" href="/stores/request-offer-quantity/replies?filter=finished">
              {{$t('admin.reply_request_offer_quantities_finished')}}
            </a>
            <a class="dropdown-item" href="/stores/request-offer-quantity/replies?filter=rejected">
              {{$t('admin.reply_request_offer_quantities_rejected')}}
            </a>
          </b-dropdown>

          <b-dropdown>
            <template v-slot:button-content>{{ storeData ? storeData.name : '' }}</template>
            <b-dropdown-item :to="localePath('stores-profile')">{{$t('admin.profile')}}</b-dropdown-item>
            <b-dropdown-item @click="logout()">{{$t('admin.logout')}}</b-dropdown-item>
          </b-dropdown>
          <!-- <nuxt-link class="notifi_btn" to="/dashboard/notifications">
            <i class="far fa-bell"></i>
          </nuxt-link> -->
          <b-dropdown class="mr-2">
            <template v-slot:button-content>{{$i18n.locale == 'en' ? $t('admin.english') : $t('admin.arabic')}}</template>
            <b-dropdown-item @click="switchMyLang('ar')">العربية</b-dropdown-item>
            <b-dropdown-item @click="switchMyLang('en')">English</b-dropdown-item>
          </b-dropdown>
          <b-dropdown class="mr-2">
            <template v-slot:button-content>{{$t('admin.chat')}}</template>
            <span v-if="chats.length > 0">
            <b-dropdown-item  v-for="(chat,key) in chats" :key="key">
              <nuxt-link :to="localePath(`/stores/chat/${chat.id}`)">
              <h4 >{{chat.user.name}}</h4>
                <p class="green">{{chat.messages[0].message}}</p>
              <p class="font-small">{{chat.messages[0].created_at}}</p>
                </nuxt-link>
              <hr>
            </b-dropdown-item>
              </span>
            <span v-else>
            <b-dropdown-item >{{$t('admin.no_results')}}</b-dropdown-item>
              </span>
          </b-dropdown>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import AuthService from "~/pages/stores/auth/service/AuthService.js";
import ChatService from "~/pages/stores/auth/service/ChatService.js";
import moment from 'moment';

export default {
  data() {
    return {
      titlePage: "",
      chats: [],
      chatCount: '',
      customEvents: [
        // { eventName: 'reset-chat-counter', callback: this.resetChatCounter },
        // { eventName: 'load-chat', callback: this.callChats },
      ]
    }
  },
  created () {
    if (this.storeData) {
      this.callChats();
    }
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  fetch(){
    this.$colorMode.preference = 'light'
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      storeToken: state => JSON.parse(state.localStorage.storeToken),
      storeData: state => JSON.parse(state.localStorage.storeData),
      role: state => state.localStorage.role,
      firebaseToken: state => state.localStorage.storeFirebaseToken,

    }),
    currentDate () {
      return moment().lang(this.currentLocale).format('D MMM YYYY')
    }
  },
  name: "app-header",
  // watch: {
  //   $route: function () {
  //     this.name();
  //   },
  // },
  methods: {
    async logout () {
      this.$nuxt.$loading.start()

      await AuthService.logout({device_token: this.firebaseToken})
      .then((res) => {
        this.$store.commit(
          "localStorage/RESET_STORE"
        )
        this.$router.replace(this.localePath('stores-auth-login'))

        this.$toast.success(this.$t('admin.logged_out_successfully'))
      })
      .catch(() => {})
      this.$nuxt.$loading.finish();
    },
    // translate(lang) {
    //   this.$i18n.setLocaleCookie(lang);
    //   this.$i18n.setLocale(lang);
    //   this.$router.go();
    // },
    resetChatCounter () {
      this.chatCount = 0
    },
    callChats () {
      this.messiging();
      this.loadChatsData()
    },
    messiging() {
      const messaging = this.$fire.messaging;
      debugger
      messaging.onMessage((payload) => {
        console.log('here');
        // debugger
        console.log('payload2', payload);
        // fire event to load data

        //if chat is found add the new message label else prepare the object and add to chats
        this.chatCount ++

        // this.chats.unshift({
        //   data: JSON.parse(payload.data.notification).data,
        //   created_at: this.currentDate
        // })
        // debugger
        if (this.chats.length >= 3) {
          this.chats.pop()
        }
        let audio=require("@/assets/notification.mp3").default;
        let beeb = new Audio(audio);
        beeb.play();
      })
    },
    async loadChatsData() {
      const response = await Promise.all([
        ChatService.firstPage().catch(() => {
        }),
      ])
      debugger
      this.chats = response[0] ? response[0]?.data : [];
      // this.chatCount = response[1] ? response[1]?.chats_count : ''
    },
  },

};
</script>

<style scoped>
.dash-upper-bar {
  color: #222222;
  padding: 1em 0;
  background-color: #95a5ba33;
}
.dash-upper-bar h4 {
  color: var(--color);
}
.font-small{
  font-size: x-small;
}
.notifi_btn {
  border: none;
  color: var(--color-secondary);
  background: none;
  border-radius: 3px;
  width: 40px;
  height: 40px;
  font-size: 20px;
  position: relative;
  top: 4px;
}
.notifi_alert {
  position: absolute;
  background-color: #e02020;
  width: 10px;
  height: 10px;
  display: block;
  top: 0;
  right: 0;
  border-radius: 50%;
}

@media (max-width: 1200px) {
  .dash-upper-bar {
    background-color: #95a5ba33;
  }
}
</style>
