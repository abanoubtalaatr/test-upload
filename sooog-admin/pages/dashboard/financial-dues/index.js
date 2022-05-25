import FinancialDuesService from "./-service/-FinancialDuesService"
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
import {mapState} from 'vuex'

export default {
  async asyncData(context) {
    let response = await Promise.all([
      context.$axios.$get("/admin/financial-dues?is_paginated=1").catch(() => { }),
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
      titlePage: this.$t('admin.financial_dues'),
      fieldsData: [
        {
          key: "id",
          label: this.$t('admin.order_id')
        },
        {
          key: "store",
          label: this.$t('admin.store')
        },
        {
          key: "total",
          label: this.$t('admin.reserved_amount')
        },
        {
          key: "application_dues_percentage",
          label: this.$t('admin.commission_percentage')
        },
        {
          key: "application_dues",
          label: this.$t('admin.commission_value')
        },
        {
          key: "amount_before_commission",
          label: this.$t('admin.amount_before_commission')
        },
        {
          key: "created_at",
          label: this.$t('admin.payment_date')
        },
        {
          key: "action",
          label: this.$t('admin.actions')
        }
      ],
      uniqueId: this.uniqueID(),
      orderIds: [],
      loading: false,
      select_all: false,
      publicSearch: '',
      queryParam: '',
      filter: {
        order_id: '',
        store_id: ''
      },
      form: {
        receipt: ''
      },
      enableSubmit: true,
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
    changeStore() {
      debugger
      this.orderIds = []
      this.select_all = false
    },
    selectAll(e) {
      if (!e.target.checked) {
        this.orderIds = []
        this.select_all = false
      } else {
        // check on store first
        if (this.filter.store_id == '' && this.collection.length) {
          let sameStores = this.collection.every((item) => item.store.id == this.collection[0].store.id)
          if (!sameStores) {
            this.select_all = false
            this.$toast.error(this.$t('admin.select_store_first'))
            return
          }
          this.orderIds = this.collection.map((item) => {
            return item.id
          })
          return
        }
        this.orderIds = this.collection.filter((obj) =>
          obj.store.id == this.filter.store_id
        ).map((item) => {
          return item.id
        })
      }
    },
    togglePayment(e) {
      debugger
      if (e.target.checked) {
        let item = this.collection.find((item) => item.id == e.target.value)
        if (item) {
          if (this.orderIds.length) {
            if (this.collection.find((obj) => obj.id == this.orderIds[0]).store.id != item.store.id) {
              this.$toast.error(this.$t('admin.select_same_store'))
              this.uniqueId = this.uniqueID()
              debugger
              return
            }
          }
          this.orderIds.push(Number(e.target.value))
        }
      } else {
        this.orderIds = this.orderIds.filter((id) => {
          return id != e.target.value
        })
      }
    },
    exportToExcel(){
      FinancialDuesService.excelExport(this.queryParam)
      .then(response => {
        this.forceFileDownload(response, 'financial-dues.xlsx')
      })
    },
    exportToPdf(){
      debugger
      FinancialDuesService.pdfExport(this.queryParam)
      .then(response => {
        debugger
        this.forceFileDownload(response, 'financial-dues.pdf')
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
    resetFile() {
      this.form.receipt = ''
      this.$refs.fileupload.value = null
      this.uniqueId = this.uniqueID()
    },
    async handleUploadFile(e) {
      this.enableSubmit = false
      if (e.target.files.length) {
        // if (this.form.image != '') {
        //   await this.deleteFile()
        // }
        if (![...this.supportedImgTypes, ...this.supportedPdfTypes].includes(e.target.files[0].type)) {
          this.resetFile()
          this.$toast.error(this.$t('admin.unsupported_file_type'))
          return
        }
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: 'payments'
        })
          .then((response) => {
            this.form.receipt = response.file
            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
            this.enableSubmit = true
          })
          .catch(() => {
            this.enableSubmit = true
          })
      }
    },
    async handlePayment() {
      if (this.form.receipt == '') {
        this.$toast.error(this.$t('admin.choose_file_first'))
        return
      }
      if (!this.orderIds.length) {
        this.$toast.error(this.$t('admin.choose_orders_first'))
        return
      }
      this.$nuxt.$loading.start();

      await FinancialDuesService.payment({...this.form, ...{orders: this.orderIds}})
        .then((response) => {
          this.handleReset()
          this.onPageChange(1)
          this.$toast.success(this.$t('admin.payment_successfully'))
        })
        .catch(() => { })
      this.$nuxt.$loading.finish();
    },
    handleReset() {
      // reset variables
      this.orderIds = []
      this.select_all = false
      this.filter.store_id = ''
      this.form.receipt = ''
      this.filter.order_id = ''
      this.$refs.fileupload.value = null
      this.uniqueId = this.uniqueID()
    },
    resetFilter () {
      this.handleReset()
      this.onPageChange(1)
    },
    /*
    * Load async data
    */
    async loadAsyncData() {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&order_id=${this.filter.order_id}&store=${this.filter.store_id}&public_search=${this.publicSearch}`

      await FinancialDuesService.getAll(this.queryParam)
        .then((response) => {
          // reset variables
          this.orderIds = []
          this.select_all = false

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
      return [this.$t('admin.financial_dues')]
    },
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    totalPayment() {
      return (this.collection.filter((obj) =>
        this.orderIds.includes(obj.id)
      ).reduce((total, item) =>
        Number(item.total) - Number(item.application_dues) + total, 0
      )).toFixed(2)
    }
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
