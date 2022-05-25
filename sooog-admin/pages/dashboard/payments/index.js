import PaymentService from "./-service/-PaymentService"

export default {
  async asyncData(context) {
    let response = await Promise.all([
      context.$axios.$get("/admin/payments?is_paginated=1").catch(() => { }),
      context.$axios.$get('/admin/stores?type=stores&is_paginated=0').catch(() => { }),
    ])

    return {
      collection: response[0].data,
      meta: response[0].meta,
      links: response[0].links,
      stores: response[1]
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.payments'),
      uniqueId: this.uniqueID(),
      fieldsData: [
        {
          key: "id",
          label: this.$t('admin.payment_no')
        },
        {
          key: "store",
          label: this.$t('admin.store')
        },
        {
          key: "total",
          label: this.$t('admin.reserved_amount')
        },
        // {
        //   key: "application_dues_percentage",
        //   label: this.$t('admin.commission_percentage')
        // },
        // {
        //   key: "application_dues",
        //   label: this.$t('admin.commission_value')
        // },
        {
          key: "amount_before_commission",
          label: this.$t('admin.amount_before_commission')
        },
        {
          key: "created_at",
          label: this.$t('admin.payment_actual_date')
        },
        {
          key: "receipt",
          label: this.$t('admin.payment_file')
        },
        {
          key: "action",
          label: this.$t('admin.actions')
        }
      ],
      loading: false,
      publicSearch: '',
      queryParam: '',
      filter: {
        order_id: '',
        store: ''
      },
      customEvents: [
        { eventName: 'handle-quick-search', callback: this.handleSearch },
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
    handleReset() {
      // reset variables
      this.filter.store = ''
      this.filter.order_id = ''
    },
    resetFilter () {
      this.handleReset()
      this.onPageChange(1)
    },
    exportToExcel(){
      PaymentService.excelExport(this.queryParam)
      .then(response => {
        this.forceFileDownload(response, 'payments.xlsx')
      })
    },
    exportToPdf(){
      PaymentService.pdfExport(this.queryParam)
      .then(response => {
        this.forceFileDownload(response, 'payments.pdf')
      })
    },
    forceFileDownload(response, fileName){
      const url = window.URL.createObjectURL(new Blob([response]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', fileName) //or any other extension
      document.body.appendChild(link)
      link.click()
    },
    /*
    * Load async data
    */
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&payment_id=${this.filter.order_id}&store=${this.filter.store}&public_search=${this.publicSearch}`

      await PaymentService.getAll(this.queryParam)
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
      debugger
      this.meta.current_page = page
      this.loadAsyncData()
    },
  },
  computed: {
    titleStack() {
      return [this.$t('admin.payments')]
    },
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
