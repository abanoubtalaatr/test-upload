<!--<template>-->
  <!--<div-->
    <!--class="col-8 d-flex flex-column p-0 justify-content-between p-3 border border-top-0 chatScreen"-->
  <!--&gt;-->
    <!--<div class="d-flex flex-column justify-content-between chat">-->
      <!--<div class="d-flex flex-column m-auto text-center justify-content-center mb-2 header">-->
        <!--<h2 class="fw-bold">{{ currentChannel.name }}</h2>-->
        <!--<p class="text-muted" v-if="channelMessages.length === 0">-->
          <!--This place is so quiet, start chatting...-->
        <!--</p>-->
      <!--</div>-->
      <!--<div class="messages">-->
        <!--<div-->
          <!--v-for="msg in channelMessages"-->
          <!--:key="msg.id"-->
          <!--class="d-flex gap-2 w-75 mb-4 bubble"-->
          <!--:class="{ self: currentUser.id === msg.userId }"-->
        <!--&gt;-->
          <!--<img :src="msg?.avatar || avatar1" width="50" height="50" alt="avatar" />-->
          <!--<div class="text">-->
            <!--<div class="username fw-bold">{{ msg.username }}</div>-->
            <!--<div class="chatfield p-2">-->
              <!--<span v-html="convertToLink(msg.message)"></span>-->
            <!--</div>-->
          <!--</div>-->
        <!--</div>-->
      <!--</div>-->
    <!--</div>-->
    <!--<div class="chatbox-wrapper">-->
      <!--<input-->
        <!--type="text"-->
        <!--class="chatbox px-3 p-2"-->
        <!--placeholder="Send a message..."-->
        <!--@keyup.enter="userSendMsg"-->
      <!--/>-->
    <!--</div>-->
  <!--</div>-->
<!--</template>-->

<!--<script>-->
  <!--import { mapState } from 'vuex';-->
  <!--import ChatService from "~/pages/stores/auth/service/ChatService.js";-->

  <!--export default {-->
    <!--props: {-->
      <!--chat: {-->
        <!--type: Array,-->
        <!--default: () => []-->
      <!--}-->
    <!--},-->
    <!--data() {-->
      <!--return {-->
        <!--titlePage: "",-->
        <!--chats: [],-->
        <!--chatCount: '',-->
        <!--customEvents: [-->
          <!--{ eventName: 'reset-chat-counter', callback: this.resetChatCounter },-->
          <!--{ eventName: 'load-chat', callback: this.callChats },-->
        <!--]-->
      <!--}-->
    <!--},-->
    <!--created () {-->
      <!--if (this.storeData) {-->
        <!--console.log('here');-->
        <!--this.callChats();-->
      <!--}-->
      <!--this.customEvents.forEach(function (customEvent) {-->
        <!--// eslint-disable-next-line no-undef-->
        <!--this.$EventBus.$on(customEvent.eventName, customEvent.callback)-->
      <!--}.bind(this))-->
    <!--},-->
    <!--beforeDestroy () {-->
      <!--this.customEvents.forEach(function (customEvent) {-->
        <!--// eslint-disable-next-line no-undef-->
        <!--this.$EventBus.$off(customEvent.eventName, customEvent.callback)-->
      <!--}.bind(this))-->
    <!--},-->
    <!--fetch(){-->
      <!--this.$colorMode.preference = 'light'-->
    <!--},-->
    <!--computed: {-->
      <!--...mapState({-->
        <!--currentLocale: state => state.localStorage.currentLocale,-->
        <!--storeToken: state => JSON.parse(state.localStorage.storeToken),-->
        <!--storeData: state => JSON.parse(state.localStorage.storeData),-->
        <!--role: state => state.localStorage.role,-->
        <!--firebaseToken: state => state.localStorage.storeFirebaseToken,-->

      <!--}),-->
      <!--currentDate () {-->
        <!--return moment().lang(this.currentLocale).format('D MMM YYYY')-->
      <!--}-->
    <!--},-->
    <!--name: "app-header",-->
    <!--// watch: {-->
    <!--//   $route: function () {-->
    <!--//     this.name();-->
    <!--//   },-->
    <!--// },-->
    <!--methods: {-->
      <!--async logout () {-->
        <!--this.$nuxt.$loading.start()-->

        <!--await AuthService.logout({device_token: this.firebaseToken})-->
          <!--.then((res) => {-->
            <!--this.$store.commit(-->
              <!--"localStorage/RESET_STORE"-->
            <!--)-->
            <!--this.$router.replace(this.localePath('stores-auth-login'))-->

            <!--this.$toast.success(this.$t('admin.logged_out_successfully'))-->
          <!--})-->
          <!--.catch(() => {})-->
        <!--this.$nuxt.$loading.finish();-->
      <!--},-->
      <!--// translate(lang) {-->
      <!--//   this.$i18n.setLocaleCookie(lang);-->
      <!--//   this.$i18n.setLocale(lang);-->
      <!--//   this.$router.go();-->
      <!--// },-->
      <!--resetChatCounter () {-->
        <!--this.chatCount = 0-->
      <!--},-->
      <!--callChats () {-->
        <!--this.messiging()-->
        <!--this.loadChatsData()-->
      <!--},-->
      <!--messiging() {-->
        <!--const messaging = this.$fire.messaging;-->
        <!--debugger-->
        <!--messaging.onMessage((payload) => {-->
          <!--// debugger-->
          <!--// console.log('payload', payload)-->
          <!--// fire event to load data-->
          <!--this.chatCount ++-->
          <!--this.chats.unshift({-->
            <!--data: payload.data,-->
            <!--created_at: this.currentDate-->
          <!--})-->
          <!--// debugger-->
          <!--if (this.chats.length >= 3) {-->
            <!--this.chats.pop()-->
          <!--}-->
          <!--// let beeb = new Audio(require("../assets/chat.mp3"));-->
          <!--// beeb.play();-->
          <!--// console.log('onMessage: ', payload)-->
          <!--// this.loadChatsData();-->
        <!--})-->
      <!--},-->
      <!--async loadChatsData() {-->
        <!--const response = await Promise.all([-->
          <!--ChatService.firstPage().catch(() => {-->
          <!--}),-->
        <!--])-->
        <!--debugger-->
        <!--this.chats = response[0] ? response[0]?.data : [];-->
        <!--// this.chatCount = response[1] ? response[1]?.chats_count : ''-->
      <!--},-->
    <!--},-->

  <!--};-->
<!--</script>-->
<!--<style scoped>-->
  <!--.chatbox {-->
    <!--outline: none;-->
    <!--border: none;-->
    <!--border-radius: 10px;-->
    <!--font-size: 1rem;-->
    <!--background: var(&#45;&#45;white3);-->
    <!--transition: 0.2s;-->
    <!--color: var(&#45;&#45;black2);-->
    <!--width: 100%;-->
  <!--}-->
  <!--.header {-->
    <!--width: 100%;-->
    <!--border-bottom: 2px var(&#45;&#45;gray1) solid;-->
  <!--}-->
  <!--h2 {-->
    <!--color: var(&#45;&#45;purple1);-->
  <!--}-->
  <!--.messages {-->
    <!--position: relative;-->
    <!--height: 70vh;-->
    <!--width: 100%;-->
    <!--padding-right: 2em;-->
    <!--overflow: auto;-->
  <!--}-->
  <!--.messages::-webkit-scrollbar {-->
    <!--background: #d8d6d6;-->
    <!--width: 8px;-->
    <!--border-radius: 5px;-->
  <!--}-->
  <!--.messages::-webkit-scrollbar-thumb {-->
    <!--border-radius: 5px;-->
    <!--background: var(&#45;&#45;purple1hover);-->
  <!--}-->
  <!--.chatfield {-->
    <!--background: var(&#45;&#45;purple1);-->
    <!--color: var(&#45;&#45;white2);-->
    <!--border-radius: 10px;-->
    <!--border-top-left-radius: 0;-->
  <!--}-->
  <!--.chatbox:focus,-->
  <!--.self .chatfield {-->
    <!--background: var(&#45;&#45;purple2);-->
    <!--color: var(&#45;&#45;black1);-->
  <!--}-->
  <!--.self .chatfield {-->
    <!--border-top-right-radius: 0;-->
    <!--border-top-left-radius: 10px;-->
  <!--}-->
  <!--.chatfield {-->
    <!--font-size: 1rem;-->
    <!--width: fit-content;-->
  <!--}-->
  <!--.bubble {-->
    <!--flex-flow: row;-->
  <!--}-->
  <!--.bubble.self {-->
    <!--flex-flow: row-reverse;-->
  <!--}-->
  <!--.self .chatfield {-->
    <!--float: right;-->
  <!--}-->
  <!--.self {-->
    <!--text-align: right;-->
    <!--float: right;-->
    <!--flex-flow: row-reverse;-->
  <!--}-->
  <!--img {-->
    <!-- -webkit-user-drag: none;-->
  <!--}-->
  <!--@media screen and (max-width: 968px) {-->
    <!--.chatScreen {-->
      <!--position: fixed;-->
      <!--width: 100%;-->
      <!--height: calc(100% - 60px);-->
    <!--}-->
    <!--.chatbox-wrapper {-->
      <!--position: absolute;-->
      <!--background: var(&#45;&#45;white1);-->
      <!--width: 93%;-->
      <!--display: flex;-->
      <!--justify-content: center;-->
      <!--bottom: 0;-->
      <!--align-items: center;-->
      <!--left: 0;-->
    <!--}-->
    <!--.chatbox {-->
      <!--width: 100%;-->
      <!--margin: 1em;-->
    <!--}-->
  <!--}-->
<!--</style>-->
