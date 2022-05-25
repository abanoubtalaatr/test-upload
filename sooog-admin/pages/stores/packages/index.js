import PackageService from "./-service/-PackageService";
import {mapState} from 'vuex';

export default {
  layout: 'store',
  // middleware({ redirect, app }) {
  // If the user is not authorized
  // if (!app.$cookies.get("storePermissions").includes('packages.index')) {
  //   return redirect(app.localePath('stores-403'))
  // }
  // },
  async asyncData(context) {
    try {
      let response = await context.$axios.$get("/store/packages/").catch((e) => {
        console.log(e)
      })
      console.log(response);
      return {
        collection: response,
        // meta: response.meta,
        // links: response.links
      }
    } catch (e) {
      console.log(e)
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.packages'),
      online_methods: [],
      stepper: 1,
      form: {
        package_id: '',
        store_id: '',
        payment_method_id: '',
      },
      submitted: false,
      permissions: this.$cookies.get('storePermissions') || []
    }
  },
  methods: {
    async getOnlineMethods() {
      // this.$nuxt.$loading.start()
      await PackageService.allOnlineMethods()
        .then((response) => {
          this.online_methods = response;
        })
        .catch(() => {
        })
      // this.$nuxt.$loading.finish()
    },
    subscribe(item) {
      this.submitted = true;
      this.form.package_id = item.id;
      if (item.is_free) {
        this.pay();

      } else {
        this.getOnlineMethods();
        this.stepper = 2
      }
      this.submitted = false;
    },
    pay() {
      console.log('hh');
      this.submitted = true;
      PackageService.subscribe(this.form)
        .then((response) => {
          if (response.payment_url) {
            window.location.replace(response.payment_url);
          } else {
            this.$toast.success(this.$t('admin.subscribed_successfully'))
            this.refresh();
          }
        })
        .catch(() => {
        })
      this.submitted = false;
    },
    refresh() {
      this.$nuxt.refresh();
    }
  },
  created() {
    if (this.storeData) {
      this.form.store_id = this.storeData.store_id;
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      storeData: state => JSON.parse(state.localStorage.storeData),
    }),
    titleStack() {
      return [this.$t('admin.packages')]
    }
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
