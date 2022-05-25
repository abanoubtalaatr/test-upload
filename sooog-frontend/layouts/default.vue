<template>
  <div>
    <div :lang="this.$i18n.locale"
        class="home-page" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">

      <!-- app header Component-->
      <AppHeader />

      <Nuxt/>
      <AppBenifiets/>
      <!-- app footer Component-->
      <AppFooter/>

    </div>
  </div>
</template>

<script>
  import Vue from "vue";
  import Mixsing from "~/mixins/mixins";

  Vue.mixin(Mixsing);
  import {mapState} from "vuex";
  import AppHeader from '../components/front/AppHeader.vue';
  import AppFooter from '../components/front/AppFooter.vue';
  import AppBenifiets from '../components/front/AppBenifiets.vue';
  // const someSound = require("~/assets/notification.mp3");

  export default {
    components: {AppHeader, AppFooter,AppBenifiets},
    data() {
      return {
        settings: []
      }
    },
    created () {
      this.getSettings()
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
        authUser: state => state.localStorage.authUser,
        setting: state => state.localStorage.settings,
      })
    },
    methods: {
      getSettings () {
        this.$axios.$get(`/settings`)
          .then((response) => {
            response.forEach(element => {
              this.settings[element.key] = element.body
            });
            this.$store.commit("localStorage/SET_SETTINGS", this.settings);
          })
          .catch(() => {})
      }
    },
    head() {
      return {
        // link: [],
        script: [
          {src: 'https://code.jquery.com/jquery-3.5.1.min.js'},
          {src: 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'},
          {src: 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'},
          {src: 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'},
          {src: 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'},
        ]
      }
    }
  };
</script>

<style>
  .page {
    display: flex;
    min-height: 100vh;
  }

  .content-wrap {
    position: relative;
    min-width: calc(100% - 17%); /* 17% ---> sidebarWidth */
    will-change: width;
    min-height: 100%;
  }

  .slide-fade-enter-active {
    transition: all 0.3s ease;
  }

  .slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
  }

  .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */
  {
    transform: translateX(10px);
    opacity: 0;
  }
</style>
