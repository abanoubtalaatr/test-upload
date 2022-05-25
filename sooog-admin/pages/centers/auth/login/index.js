import AuthService from "~/pages/centers/auth/service/AuthService.js";
import StoreAuthService from "~/pages/stores/auth/service/AuthService.js";

export default {
  layout: "login",
  data() {
    return {
      loading: false,
      titlePage: this.$t('admin.login'),
      form: {
        email: "",
        password: ''
      },
    };
  },
  methods: {
    async login() {
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.loading = true

        AuthService.login(this.form)
        .then((res) => {
            // empty cookie space if store logged in in same browser
            //this.logoutStore()

            let token = JSON.stringify(`${res.token_type} ${res.access_token}`);
            // for client side rendering
            this.$store.commit("localStorage/SET_CENTER_TOKEN", token);
            // this.$store.commit("localStorage/SET_ROLE", 'super_admin');
            this.$store.commit("localStorage/SET_CENTER_PERMISSIONS",JSON.stringify(res.user.permissions));
            this.$store.commit(
              "localStorage/SET_CENTER_DATA",
              JSON.stringify({...(({permissions, ...rest} = res.user) => (rest))()})
            );
            // for ssr rendering
            const options = {
              path: '/',
              maxAge: 60 * 60 * 24 * 7
            }
            this.$cookies.setAll([
              {name: 'centerToken', value: token, opts: options},
              // {name: 'role', value: 'super_admin', opts: options},
              {name: 'centerPermissions', value: JSON.stringify(res.user.permissions), opts: options}
            ])
            this.loading = false
            this.$toast.success(this.$t('admin.logged_in_successfully'))
            this.$router.replace(this.localePath({ name: "centers" }))
          })
          .catch(() => {
            this.loading = false;
          });
        this.$nuxt.$loading.finish();
      }
    },
    async logoutStore () {
      if (this.$store.state.localStorage.storeToken) {
        await StoreAuthService.logout()
        .then((res) => {
          this.$store.commit(
            "localStorage/RESET_STORE"
          )
        })
        .catch(() => {})
      }
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
