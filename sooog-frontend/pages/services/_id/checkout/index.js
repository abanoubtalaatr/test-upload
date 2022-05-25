import OrderService from "~/services/orders/OrderService.js"
import CategoryService from "~/services/category/CategoryService.js"
import { mapState } from "vuex"
import UploaderService from '~/services/uploader/UploaderService.js'
import moment from 'moment'

export default {
  middleware: ['auth'],
  scrollToTop: true,
  validate({ params, query, store }) {
    if (params.id) {
      return !isNaN(params.id);
    }
    return true;
  },
  async asyncData (context) {
    const response = await Promise.all([
      context.$axios.$post(`/orders/preview`, {
        service_id: context.params.id,
        type: 'centers',
        use_wallet: 1
      }).catch(() => {}),
      context.$axios.$get(`/profile/user-addresses`).catch(() => {}),
    ])
    return {
      cartData: response.length ? response[0] : null,
      addresses: response.length ? response[1] : []
    }
  },
  data() {
    return {
      titlePage: this.$t('front.request_service'),
      stepper: 1,
      param_id: this.$route.params.id,
      banks: [],
      fileType: '',
      subcategories: [],
      methods: [],
      categories: [],
      enableSubmit: true,
      uploaderFolder: 'bank_transfer',
      selected_payment_type: 'cash_on_delivery',
      online_methods: [],
      uniqueId: this.uniqueID(),
      form: {
        user_address_id: '',
        payment_method_id: '',
        service_wanted_date: '',
        category_id: '',
        subcategory_id: '',
        problem_description: '',
        use_wallet: false,
        online_payment_method_id: '',
        payment_type: 'web',
      },
      bank: {
        bank_account_id: '',
        depositor_name: '',
        deposit_amount: '',
        deposit_receipt: '',
      }
    }
  },
  computed: {
    currentDate () {
      return moment(new Date()).format('yyyy-MM-DD')
    }
  },
  methods: {
    prevStep (step) {
      this.stepper = step
    },
    async nextStep (step) {
      if (step == 2) {
        const validData = await this.$validator.validateAll('firstStep')
        debugger
        if (validData) {
          // check if there is addresses or not
          if (!this.addresses.length) {
            this.$toast.error(this.$t('front.need_add_address'))
          } else {
            this.stepper = step
          }
        }
      } else {
        const validData = await this.$validator.validateAll('secondStep')
        debugger
        if (validData) {
          this.stepper = step
        }
      }
    },
    selectBank (e) {
      this.bank.bank_account_id = e.target.value
    },
    selectedMethod (method) {
      if (method.type == 'bank_transfer') {
        this.getBanks()
      } else if (method.type == 'online') {
        this.getOnlineMethods()
      } else {
        this.form.online_payment_method_id = '' // reset
      }
      this.selected_payment_type = method.type
    },
    useWallet () {
      debugger
      // this.form.payment_method_id = ''
      this.form.use_wallet = true
    },
    async getBanks () {
      this.$nuxt.$loading.start()
      await OrderService.allBanks()
        .then((response) => {
          this.banks = response;
        })
        .catch(() => {})
      this.$nuxt.$loading.finish()
    },
    async changeAddress () {
      // this.$nuxt.$loading.start()
      await CategoryService.getAll(`?type=stores`)
        .then((response) => {
          this.categories = response;
        })
        .catch(() => {})
      // this.$nuxt.$loading.finish()
    },
    async getSubcategories (event) {
      this.$nuxt.$loading.start()
      await CategoryService.getSubcategories(event.target.value)
        .then((response) => {
          this.subcategories = response;
        })
        .catch(() => {})
      this.$nuxt.$loading.finish()
    },
    async getMethods () {
      // this.$nuxt.$loading.start()
      await OrderService.allMethods()
        .then((response) => {
          this.methods = response;
        })
        .catch(() => {})
      // this.$nuxt.$loading.finish()
    },
    async getOnlineMethods () {
      this.$nuxt.$loading.start()
      await OrderService.allOnlineMethods()
        .then((response) => {
          this.online_methods = response;
        })
        .catch(() => {})
      this.$nuxt.$loading.finish()
    },
    async submit () {
      const validData = await this.$validator.validateAll('thirdStep')
      debugger
      if (validData) {
        this.$nuxt.$loading.start()
        let formData = this.cloneItem(this.form)
        if (this.selected_payment_type == 'bank_transfer') {
          formData = { ...formData, ...this.bank }
        }
        debugger
        await OrderService.serviceCheckout({...formData, ...{
          service_id: this.param_id
        }})
          .then((response) => {
            if (response.payment_url) {
              // this.redirect(response.payment_url)
              window.location.replace(response.payment_url);
              this.$nuxt.$loading.finish()
            } else {
              this.$toast.success(response.message)
              this.$router.push(this.localePath('orders-services'))
            }
          })
          .catch(() => {})
        this.$nuxt.$loading.finish()
      }
    },
    resetFile() {
      this.bank.deposit_receipt = ''
      this.$refs.deposit_receipt.value = null
      this.uniqueId = this.uniqueID()
    },
    async handleUploadFile (e) {
      if (e.target.files.length) {
        if (this.bank.deposit_receipt != '') {
          await this.handleDeleteFile(this.bank.deposit_receipt, this.uploaderFolder)
        }
        if (![...this.supportedImgTypes, ...this.supportedPdfTypes].includes(e.target.files[0].type)) {
          this.resetFile()
          this.$toast.error(this.$t('front.unsupported_file_type'))
          return
        }
        this.fileType = e.target.files[0].type

        this.enableSubmit = false
        this.$nuxt.$loading.start()
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            this.enableSubmit = true
            debugger
            this.bank.deposit_receipt = response.file
            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
          })
          .catch(() => {
            this.enableSubmit = true
          })
          this.$nuxt.$loading.finish()
      }
    },
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
