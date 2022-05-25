import StoreService from "./-service/-StoreService";

export default {
  async asyncData(context) {
    //let response = await StoreService.getAll()
    let response = await context.$axios.$get("/admin/stores/list-temp-store?is_paginated=1").catch((e) => {
      console.log('err: ', e)
    })
    return {
      collection: response.data,
      meta: response.meta,
      links: response.links
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.stores_update_request'),
      orderBy: 'is_featured',
      orderType: 'DESC',
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
          key: "email",
          label: this.$t('admin.email'),
          sortable: true
        },
        {
          key: "phone",
          label: this.$t('admin.phone'),
          sortable: true
        },
        {
          key: "is_featured",
          label: this.$t('admin.is_featured'),
          sortable: true
        },
        {
          key: "is_active",
          label: this.$t('admin.status'),
          sortable: true
        },
        {
          key: "created_at",
          label: this.$t('admin.created_at')
        },
        {
          key: "action",
          label: this.$t('admin.actions')
        }
      ],
      loading: false,
      publicSearch: '',
      queryParam: '',
      form: {
        store_id: '',
        status: '',
      },
      customEvents: [
        {eventName: 'handle-quick-search', callback: this.handleSearch},
        {eventName: 'deactivate-item-event', callback: this.toggleStatus}
      ],
      permissions: this.$cookies.get('permissions')
    }
  },
  mounted() {
    this.$EventBus.$emit('enable-quick-search', true)
  },
  created() {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy() {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  methods: {
    handleSearch(search) {
      this.publicSearch = search
      this.onPageChange(1)
    },
    sortingChanged(ctx) {
      this.orderBy = ctx.sortBy
      this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
      this.loadAsyncData()
      // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
      // ctx.sortDesc ==> true if sorting descending, false otherwise
    },
    /*
    * Load async data
    */
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_paginated=1&status=accepted&type=stores&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

      await StoreService.getAll(this.queryParam)
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
    onPageChange(page) {
      this.meta.current_page = page
      this.loadAsyncData()
    },
    updatedAction(id,status) {
      this.form={
        store_id:id,
        status:status,
      };
      StoreService.storeTempAction(this.form)
        .then((response) => {
          //* update list *//
          this.refresh();
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-stores-updates" }))
    },

    refresh(){
      this.$nuxt.refresh();
    }
  },
  computed: {
    titleStack() {
      return [this.$t('admin.stores')]
    }
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
