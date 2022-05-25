import AuthService from "~/pages/stores/auth/service/AuthService.js";
import CenterAuthService from "~/pages/centers/auth/service/AuthService.js";

export default {
  layout: "login",
  data() {
    return {
      loading: false,
      notifyToken: null,
      titlePage: this.$t('admin.login'),
      form: {
        email: "",
        password: '',
        remember_me:'',
      },
    };
  },
  methods: {
    async login() {
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.loading = true
        await this.getDeviceToken();
        this.$store.commit("localStorage/SET_STORE_FIREBASE_TOKEN", this.notifyToken);
        AuthService.login({...this.form, ...{device_token: this.notifyToken}})
        .then((res) => {
            // empty cookie space if center logged in in same browser
            this.logoutCenter()

            let token = JSON.stringify(`${res.token_type} ${res.access_token}`);
            // for client side rendering
            this.$store.commit("localStorage/SET_STORE_TOKEN", token);
            // this.$store.commit("localStorage/SET_ROLE", 'store');
            this.$store.commit("localStorage/SET_STORE_PERMISSIONS",JSON.stringify(res.user.permissions));
            this.$store.commit(
              "localStorage/SET_STORE_DATA",
              JSON.stringify({...(({permissions, ...rest} = res.user) => (rest))()})
            );
            // for ssr rendering
            const options = {
              path: '/',
              maxAge: 60 * 60 * 24 * 7
            }
            this.$cookies.setAll([
              {name: 'storeToken', value: token, opts: options},
              // {name: 'role', value: 'super_admin', opts: options},
              {name: 'storePermissions', value: JSON.stringify(res.user.permissions), opts: options}
            ])
            this.loading = false
            this.$toast.success(this.$t('admin.logged_in_successfully'))
            this.$router.replace(this.localePath({ name: "stores" }))
          })
          .catch(() => {
            this.loading = false;
          });
        this.$nuxt.$loading.finish();
      }
    },

    async getDeviceToken() {
      const messaging = this.$fire.messaging;
      await messaging.getToken()
        .then(() => {
          return messaging.getToken()
        })
        .then((currentToken) => {
          if (currentToken) {
            this.notifyToken = currentToken
            return currentToken
          }
        })
        .catch((err) => {
          console.log('Error occured', err)
        })
    },

    async logoutCenter () {
      if (this.$store.state.localStorage.centerToken) {
        await CenterAuthService.logout()
        .then((res) => {
          this.$store.commit(
            "localStorage/RESET_CENTER"
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
