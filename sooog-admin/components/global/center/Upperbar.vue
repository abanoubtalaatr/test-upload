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
        <b-col sm class="text-center text-sm-left">
          <b-dropdown>
            <template v-slot:button-content>{{ centerData ? centerData.name : '' }}</template>
            <b-dropdown-item :to="localePath('centers-profile')">{{$t('admin.profile')}}</b-dropdown-item>
            <b-dropdown-item @click="logout()">{{$t('admin.logout')}}</b-dropdown-item>
          </b-dropdown>

          <!-- <nuxt-link class="notifi_btn" to="/dashboard/notifications">
            <i class="far fa-bell"></i>
          </nuxt-link> -->
          <b-dropdown class="mr-4">
            <template v-slot:button-content>{{$i18n.locale == 'en' ? $t('admin.english') : $t('admin.arabic')}}</template>
            <b-dropdown-item @click="switchMyLang('ar')">العربية</b-dropdown-item>
            <b-dropdown-item @click="switchMyLang('en')">English</b-dropdown-item>
          </b-dropdown>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import AuthService from "~/pages/centers/auth/service/AuthService.js";

export default {
  data() {
    return {
      titlePage: "",
    }
  },
  fetch(){
    this.$colorMode.preference = 'light'
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      storeToken: state => JSON.parse(state.localStorage.storeToken),
      centerData: state => JSON.parse(state.localStorage.centerData),
      role: state => state.localStorage.role
    })
  },
  name: "app-header",
  // watch: {
  //   $route: function () {
  //     this.name();
  //   },
  // },
  methods: {
    async logout () {
      let loggedInRole = this.role
      this.$nuxt.$loading.start()

      await AuthService.logout()
      .then((res) => {
        this.$store.commit(
          "localStorage/RESET_CENTER"
        )
        // this.$cookies.removeAll()
        this.$router.replace(this.localePath('centers-auth-login'))
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
