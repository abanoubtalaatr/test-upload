import ContactService from "./-service/-ContactService";

export default {
  async asyncData(context) {
    //let response = await BrandService.getAll()
    let response = await context.$axios.$get("/admin/contact-us").catch((e) => {
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
      titlePage: this.$t('admin.contact'),
      orderBy: 'id',
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
          key: "title",
          label: this.$t('admin.title'),
          sortable: true
        },
        {
          key: "body",
          label: this.$t('admin.content'),
          sortable: false
        },
        {
          key: "created_at",
          label: this.$t('admin.created_at'),
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
        {eventName: 'handle-quick-search', callback: this.handleSearch},
        {eventName: 'event-delete-contact', callback: this.handleDelete}
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
    // dataLocalized(item){
    //   if(this.currentLocale=='en'){
    //     return "data.en"+item
    //   }else{
    //     return "data.ar"+item
    //   }
    // },
    /*
    * Load async data
    */
    sortingChanged(ctx) {
      this.orderBy = ctx.sortBy
      this.orderType = ctx.sortDesc == false ? 'ASC' : 'DESC'
      this.loadAsyncData()
      // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
      // ctx.sortDesc ==> true if sorting descending, false otherwise
    },
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&public_search=${this.publicSearch}&orderBy=${this.orderBy}&orderType=${this.orderType}`

      await ContactService.getAll(this.queryParam)
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
      console.log('page', page)
      this.meta.current_page = page
      this.loadAsyncData()
    },
    async handleDelete(id) {
      await ContactService.destroy(id)
        .then(() => {
          //* remove this row *//
          this.collection = this.collection.filter((obj) => {
            return obj.id !== id
          })
          this.$toast.success(this.$t('admin.deleted_successfully'))
        })
        .catch(() => {
        })
    },
    exportToExcel() {
      ContactService.excelExport(`?public_search=${this.publicSearch}`)
        .then(response => {
          this.forceFileDownload(response)
        })
    },
    forceFileDownload(response){
      const url = window.URL.createObjectURL(new Blob([response]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', 'contacts.xlsx') //or any other extension
      document.body.appendChild(link)
      link.click()
    },
  },
  computed: {
    titleStack() {
      return [this.$t('admin.contact')]
    },
    // ...mapState({
    //   currentLocale: state => state.localStorage.currentLocale
    // }),
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
