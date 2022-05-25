import { mapState } from 'vuex'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import PasswordService from "~/services/auth/PasswordService.js"
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
      titlePage: this.$t('front.forget_password'),
      passwordHidden: true,
      phoneData: null,
      translations: {
        countrySelectorLabel: this.$t('front.country_code'),
        // countrySelectorError: 'Choisir un pays',
        phoneNumberLabel: this.$t('front.phone'),
        // example: 'Exemple :'
      },
      stepper: 0,
      form: {
        phone: null,
        country_code: '',
        email: '',
        send_type: 'sms',
      },
      type: 'verify',
      payload: {
        token: null,
        password: null,
        password_confirmation: null
      },
      customEvents: [
        { eventName: 'handle-code-event', callback: this.handleCodeEvent },
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
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
    },
    handlePhoneNumber () {
      if (this.form.phone.startsWith("0") || this.form.phone.startsWith("٠")) {
        this.form.phone = this.form.phone.substring(1)
      }
    },
      nextStep(){
          this.stepper = 1
      },
    handleActivation () {
      debugger
      this.type = 'activate'
      this.stepper = 2
    },
    async submit () {
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
      const validData = await this.$validator.validateAll()

      if (validData) {
        if (this.stepper == 1) {
          this.forgetPassword()
        } else {
          this.resetPassword()
        }
      }
    },
    forgetPassword () {
      PasswordService.forgetPassword(this.form)
        .then((res) => {
            this.stepper = 2
          })
          .catch((err) => {
            if (err.is_active === false) {
              this.handleActivation()
            //   this.$router.replace(this.localePath('login'))
            //   setTimeout(() => {
            //     this.$EventBus.$emit('display-activation-modal', this.form)
            //   }, 100);
            }
          });
        this.$nuxt.$loading.finish();
    },
    handleCodeEvent (data) {
      this.payload.token = data
      this.stepper = 3
    },
    resetPassword () {
      PasswordService.resetPassword({ ...this.form, ...this.payload })
        .then((res) => {
          this.$router.replace(this.localePath({ name: "login" }))
          this.$toast.success(this.$t('front.updated_successfully'))
          })
          .catch(() => {});
        this.$nuxt.$loading.finish();
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
