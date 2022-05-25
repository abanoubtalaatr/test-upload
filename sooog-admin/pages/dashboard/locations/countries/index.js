import CountryService from "~/pages/dashboard/locations/service/CountryService.js";

export default {
  async asyncData (context) {

    const response = await context.$axios.$get('/admin/location/countries?is_paginated=1').catch(() => {})

    return {
      collection: response.data,
      meta: response.meta,
      links: response.links
     }
  },
  data() {
    return {
      titlePage: this.$t('admin.countries'),
      fieldsData: [
        {
          key: "id",
          label: this.$t('admin.ID'),
          sortable: true
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
          label: this.$t('admin.actions'),
          sortable: false
        }
      ],
      loading: false,
      publicSearch: '',
      queryParam: '',
      customEvents: [
        { eventName: 'handle-quick-search', callback: this.handleSearch },
        { eventName: 'event-delete-country', callback: this.handleDelete }
      ],
      submitted: false,
      permissions: this.$cookies.get('permissions'),
      orderBy: 'order',
      orderType: 'ASC'
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
      return [this.$t('admin.countries')]
    }
  },
  methods: {
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

      await CountryService.getAll(this.queryParam)
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
      await CountryService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id
          })
          this.$toast.success(this.$t('admin.deleted_successfully'))
        }).catch(() => {})
    },
    handleToggleStatus (id) {
      this.submitted = true
      CountryService.toggleStatus(id)
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
