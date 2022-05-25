import StateService from "~/pages/dashboard/locations/service/StateService.js";
import CityService from "~/pages/dashboard/locations/service/CityService.js";

export default {
  async asyncData (context) {
    const [ response, countries ] = await Promise.all([
      context.$axios.$get('/admin/location/cities?is_paginated=1').catch(() => {}),
      context.$axios.$get('/admin/location/countries?is_paginated=0').catch(() => {}),
      //context.$axios.$get('/admin/location/states?is_paginated=0').catch(() => {}),
    ])
    return {
      collection: response.data,
      meta: response.meta,
      links: response.links,
      countries: countries,
      //states: states
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.cities'),
      fieldsData: [
        {
          key: "id",
          label: this.$t('admin.ID'),
          sortable: true
        },
        {
          key: "country",
          label: this.$t('admin.country')
        },
        {
          key: "state",
          label: this.$t('admin.state')
        },
        {
          key: "name",
          label: this.$t('admin.name'),
          sortable: true
        },
        {
          key: "is_active",
          label: this.$t('admin.status'),
          sortable: true
        },
        {
          key: "action",
          label: this.$t('admin.actions')
        }
      ],
      loading: false,
      publicSearch: '',
      queryParam: '',
      customEvents: [
        { eventName: 'handle-quick-search', callback: this.handleSearch },
        { eventName: 'event-delete-city', callback: this.handleDelete }
      ],
      permissions: this.$cookies.get('permissions'),
      country: null,
      state: null,
      countries: [],
      states: [],
      orderBy: 'id',
      orderType: 'DESC'
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
  mounted() {
    this.$EventBus.$emit('enable-quick-search', true)
  },
  computed: {
    titleStack () {
      return [this.$t('admin.cities')]
    }
  },
  methods: {
    async changeCountry (value) {
      // reset state id
      this.state = ''
      // get states of selected country
      await StateService.getAll(`?is_paginated=0&country=${value}`)
      .then((response) => {
        this.states = response
      })
      .catch(() => {})
    },
    handleSearch (search) {
      this.publicSearch = search
      this.onPageChange(1)
    },
    /*
    * Load async data
    */
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`
      
      if(this.country)
        this.queryParam += `&country=${this.country}`

        if(this.state)
        this.queryParam += `&state=${this.state}`

      await CityService.getAll(this.queryParam)
        .then((response) => {
          this.collection = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.collection = []
        })
        this.$nuxt.$loading.finish();
    },
    /*
    * Handle page-change event
    */
    onPageChange (page) {
      this.meta.current_page = page
      this.loadAsyncData()
    },
    sortingChanged(ctx) {
      console.log('sort', ctx)
      this.orderBy = ctx.sortBy
      this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
      this.loadAsyncData()
      // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
      // ctx.sortDesc ==> true if sorting descending, false otherwise
    },
    async handleDelete (id) {
      await CityService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id
          })
          this.$toast.success(this.$t('admin.deleted_successfully'))
        }).catch(() => {})
    },
    handleToggleStatus (id) {
      CityService.toggleStatus(id)
        .then((response) => {
          //* update list *//
          let index = this.collection.findIndex((obj) => obj.id == id)
          if (index >= 0) {
            this.$set(this.collection, index, response)
          }
          this.$toast.success(this.$t('admin.updated_successfully'))
        }).catch(() => {})
    }

  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
