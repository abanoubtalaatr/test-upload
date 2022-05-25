<template>
  <div class="page" :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <!-- sidebar Component-->
    <Sidebar />

    <!-- Pages Content -->
    <div class="content-wrap">
      <Upperbar />
      <transition name="slide-fade">
        <Nuxt />
      </transition>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Mixsing from "~/mixins/mixins";
Vue.mixin(Mixsing);
import {mapState} from "vuex";

export default {
  middleware: ['auth', 'admin'],
  mounted() {},
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale
    }),
  },
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
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
