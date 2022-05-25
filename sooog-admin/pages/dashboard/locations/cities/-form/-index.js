import { mapState } from 'vuex'
import StateService from "~/pages/dashboard/locations/service/StateService.js";
import CityService from "~/pages/dashboard/locations/service/CityService.js";

export default {
  props: {
    item: {
      required: false
    },
    countries: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      form: {
        en: { name: '' },
        ar: { name: '' },
        is_active: true,
        country_id: '',
        state_id: null
      },
      states: [],
      param_id: this.$route.params.id,
      submitted: false
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  async fetch() {
    if (this.param_id) {
      await this.reAssignForm()
    }
  },
  fetchOnServer: true,
  methods: {
    reAssignForm () {
      // get states of selected country and reset state id
      this.changeCountry(this.item.state?.country?.id)
      // reassign form data
      this.form = {...this.item, ...{
          country_id: this.item.state?.country?.id,
          state_id: this.item.state?.id,
        }
      }
    },
    async changeCountry (value) {
      // reset state id
      this.form.state_id = ''
      // get states of selected country
      await StateService.getAll(`?is_paginated=0&all=1&country=${value}`)
      .then((response) => {
        this.states = response
      })
      .catch(() => {})
    },
    async submit () {
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        if (this.param_id) {
          this.update()
        } else {
          this.create()
        }
      }else{
        this.submitted = false
      }
    },
    async update () {
      await CityService.update(this.form, this.param_id)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.updated_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    async create () {
      await CityService.create(this.form)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.created_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-locations-cities" }))
    }
  },
}
