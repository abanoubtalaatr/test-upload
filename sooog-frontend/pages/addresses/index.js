import { mapState } from 'vuex'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import AddressService from "~/services/profile/AddressService.js"
import SideBar from '~/components/front/SideBar.vue';

export default {
  middleware: ['auth'],
  components: {
    VuePhoneNumberInput,
    SideBar
  },
  async asyncData (context) {
    const collection = await context.$axios.$get('/profile/user-addresses').catch(() => {})

    return { collection }
  },
  data () {
    return {
      titlePage: this.$t('front.addresses'),
      translations: {
        countrySelectorLabel: this.$t('front.country_code'),
        // countrySelectorError: 'Choisir un pays',
        phoneNumberLabel: this.$t('front.phone'),
        // example: 'Exemple :'
      },
      stepper: 0,
      customEvents: [
        { eventName: 'event-delete-address', callback: this.handleDestroy },
      ]
    }
  },
  created () {
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
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  methods: {
    async handleDestroy (id) {
      await AddressService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id
          })
          this.$toast.success(this.$t('admin.deleted_successfully'))
        })
        .catch(() => {})
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
};
