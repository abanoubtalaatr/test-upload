import AuthService from "~/pages/stores/auth/service/AuthService.js";

export default {
  layout: "login",
  data() {
    return {
      loading: false,
      titlePage: this.$t('admin.change_password'),
      form: {
        email: ""
      },
    };
  },
  methods: {
    async submit () {
      const validData = await this.$validator.validateAll()
      if (validData) {
        AuthService.forgetPassword(this.form)
        .then((res) => {
            this.$toast.success(this.$t('admin.code_sent_successfully'))
            this.$store.commit("localStorage/SET_FORGET_MAIL", this.form.email)
            this.$router.replace(this.localePath({ name: "stores-auth-password-reset" }))
            // this.$router.push(this.localePath({ name: "dashboard-auth-password-reset",
            //   params: {
            //     email: this.form.email
            //   }
            // }))
            // this.$router.push(
            //   {
            //     path: `/${this.$i18n.locale}/dashboard/auth/password/reset`,
            //     props: {
            //       email: this.form.email
            //     },
            //   }
            // )
            // this.$router.push(
            //   {
            //     name: `dashboard-auth-password-reset___${this.$i18n.locale}`,
            //     props: {
            //       email: this.form.email
            //     },
            //     // props: true
            //   }
            // )
          })
          .catch(() => {});
        this.$nuxt.$loading.finish();
      }
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
