import AuthService from "~/pages/dashboard/auth/service/AuthService.js";

export default {
  layout: "login",
  data() {
    return {
      loading: false,
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

        AuthService.login(this.form)
        .then((res) => {
            let token = JSON.stringify(`${res.token_type} ${res.access_token}`);
            // for client side rendering
            this.$store.commit("localStorage/SET_MOKAYIEFY_TOKEN", token);
            this.$store.commit("localStorage/SET_ROLE", 'super_admin');
            this.$store.commit("localStorage/SET_MOKAYIEFY_PERMISSIONS",JSON.stringify(res.user.permissions));
            this.$store.commit(
              "localStorage/SET_MOKAYIEFY_DATA",
              JSON.stringify({...(({permissions, ...rest} = res.user) => (rest))()})
            );
            // for ssr rendering
            const options = {
              path: '/',
              maxAge: 60 * 60 * 24 * 7
            }
            this.$cookies.setAll([
              {name: 'mokayiefyToken', value: token, opts: options},
              {name: 'role', value: 'super_admin', opts: options},
              {name: 'permissions', value: JSON.stringify(res.user.permissions), opts: options}
            ])
            this.loading = false
            this.$toast.success(this.$t('admin.logged_in_successfully'))
            this.$router.replace(this.localePath({ name: "dashboard" }))
          })
          .catch(() => {
            this.loading = false;
          });
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
