<template>
  <div :dir="this.$i18n.locale == 'en' ? 'ltr' : 'rtl'">
    <Nuxt />
  </div>
</template>

<script>
import Vue from "vue";
import Mixsing from "~/mixins/mixins";
Vue.mixin(Mixsing);

export default {

  mounted() {},
};
</script>

