import { mapState } from 'vuex'
import AddressService from "~/services/profile/AddressService.js"
import StateService from "~/services/location/StateService.js"
import CityService from "~/services/location/CityService.js"

export default {
  props: {
    item: {
      required: false,
      type: Object
    },
    countries: {
      required: true,
      type: Array
    },
  },
  components: {},
  data () {
    return {
      titlePage: this.$t('front.addresses'),
      states: [],
      cities: [],
      param_id: this.$route.params.id,
      form: {
        address: null,
        country_id: '',
        state_id: '',
        city_id: '',
        latitude: '24.69721690000003',
        longitude: '46.68350619999999',
        title: null,
        phone: null,
        nearest_landmarks: null,
        is_primary: false,
      },
      position: { lat:24.69721690000003, lng:46.68350619999999 },
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  created() {
    if (this.param_id) {
      this.reAssignForm()
    }
  },
  methods: {
    handleMap (event) {
      let lng = event.latLng.lng();
      let lat = event.latLng.lat();
      this.position = { lat: lat, lng: lng };
      this.form.latitude = lat.toString();
      this.form.longitude = lng.toString()
    },
    reAssignForm () {
      debugger
      // get states of selected country and reset state id
      this.changeCountry(this.item.city.state.country.id)
      this.changeState(this.item.city.state.id)
      // reassign form data
      this.form = {...this.item, ...{
          country_id: this.item.city.state.country.id,
          state_id: this.item.city.state.id,
          city_id: this.item.city.id,
        }
      }
      this.form = {...(({city, ...rest} = this.form) => (rest))()}
      debugger
    },
    async changeCountry (value) {
      // reset state id
      this.form.state_id = ''
      // get states of selected country
      await StateService.getAll(value)
      .then((response) => {
        this.states = response
      })
      .catch(() => {})
    },
    async changeState (value) {
      // reset city id
      this.form.city_id = ''
      // get states of selected country
      await CityService.getAll(value)
      .then((response) => {
        this.cities = response
      })
      .catch(() => {})
    },
    async submit () {
      const validData = await this.$validator.validateAll()
      if (validData) {
        if (this.param_id) {
          this.update()
        } else {
          this.create()
        }
      }
    },
    async update () {
      await AddressService.update(this.form, this.param_id)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.updated_successfully'))
      })
      .catch(() => {})
    },
    async create () {
      await AddressService.create(this.form)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.created_successfully'))
      })
      .catch(() => {})
    },
    back () {
      // this.$router.push(this.localePath({ name: "addresses" }))
      this.$router.back()
    }
  }
};
