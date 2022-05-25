import { mapState } from 'vuex'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import ActivationModal from "~/pages/register/-modal/-activation/-index.vue"

export default {
  components: {
    VuePhoneNumberInput,
    ActivationModal
  },
  async asyncData(context) {
    const countries = await context.$axios.$get('/location/countries?all=1').catch(() => {
    })
    return {countries}
  },
  data () {
    return {
      titlePage: this.$t('front.login'),
      phoneData: null,
      stepper: 1,
      translations: {
        countrySelectorLabel: this.$t('front.country_code'),
        // countrySelectorError: 'Choisir un pays',
        phoneNumberLabel: this.$t('front.phone'),
        // example: 'Exemple :'
      },
      form: {
        phone: null,
        country_code: '',
        password: null,
        remember: false,
        // device_id: null
      },
      customEvents: [
        { eventName: 'display-activation-modal', callback: this.handleActivation },
      ]
    }
  },
  created () {
    this.form.country_code = this.countries.length ? this.countries[0].code : ''
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale
    })
  },
  methods: {
    updatePhoneNumber (value) {
      this.phoneData = value
      this.form.country_code = value.countryCallingCode
      value.phoneNumber = value.phoneNumber ? value.phoneNumber.replace(/\s+/g, '') : ''
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
    },
    handleActivation (data) {
      debugger
      if (data) {
        this.form = data
      }
      this.stepper = 2
      debugger
    },
    handlePhoneNumber () {
      if (this.form.phone.startsWith("0") || this.form.phone.startsWith("٠")) {
        this.form.phone = this.form.phone.substring(1)
      }
    },
    async submit () {
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
      const validData = await this.$validator.validateAll()

      if (validData) {
        this.login(this.form)
      }
    },
    // login () {
    //   debugger
    //   LoginService.login(this.form)
    //     .then((res) => {
    //         let token = `${res.token_type} ${res.access_token}`
    //         // for client side rendering
    //         this.$store.commit("localStorage/SET_ACCESS_TOKEN", token);
    //         this.$store.commit("localStorage/SET_ROLE", 'client');
    //         this.$store.commit(
    //           "localStorage/SET_AUTH_USER",
    //           {...(({addresses, ...rest} = res.user) => (rest))()}
    //         );
    //         // for ssr rendering
    //         const options = { path: '/', maxAge: 60 * 60 * 24 * 7 }

    //         this.$cookies.setAll([
    //           {name: 'accessToken', value: token, opts: options},
    //           {name: 'role', value: 'client', opts: options},
    //         ])
    //         this.$toast.success(this.$t('front.logged_in_successfully'))
    //         this.$router.replace(this.localePath({ name: "index" }))
    //       })
    //       .catch(() => {});
    //     this.$nuxt.$loading.finish();
    // },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
