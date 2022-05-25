import OrderService from "~/services/orders/OrderService.js"
import { mapState } from "vuex"
import UploaderService from '~/services/uploader/UploaderService.js'

export default {
  middleware: ['auth'],
  scrollToTop: true,
  async asyncData (context) {
    const response = await Promise.all([
      context.$axios.$post(`/orders/preview`, {
        type: 'stores',
        use_wallet: 1
      }).catch(() => {}),
      context.$axios.$get(`/profile/user-addresses`).catch(() => {}),
      // context.$axios.$get(`/payment-methods`).catch(() => {}),
      // context.$axios.$get(`/bank-accounts`).catch(() => {}),
    ])
    if (!response[0]) { // empty cart
      context.redirect(context.app.localePath('carts'))
      return {}
    }
    return {
      cartData: response[0],
      addresses: response[1],
      // methods: response[2],
      // banks: response[3]
    }
  },
  data() {
    return {
      titlePage: this.$t('front.checkout'),
      stepper: 1,
      methods: [],
      online_methods: [],
      banks: [],
      fileType: '',
      enableSubmit: true,
      uploaderFolder: 'bank_transfer',
      selected_payment_type: 'cash_on_delivery',
      uniqueId: this.uniqueID(),
      form: {
        user_address_id: '',
        payment_method_id: '',
        online_payment_method_id: '',
        payment_type: 'web',
        use_wallet: false,
        promo_code: null,
        notes: null,
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
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
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
      }
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
    selectBank (e) {
      this.bank.bank_account_id = e.target.value
    },
    useWallet () {
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
    async previewOrder (event) {
      // if (event.keyCode === 13 && this.form.promo_code) {
        debugger
      if (this.form.promo_code) {
        this.$nuxt.$loading.start()
        await OrderService.previewOrder({
          type: 'stores',
          use_wallet: 1,
          promo_code: this.form.promo_code
        })
          .then((response) => {
            this.cartData = response;
          })
          .catch(() => {})
        this.$nuxt.$loading.finish()
      }
    },
    async submit () {
      const validData = await this.$validator.validateAll('lastStep')
      debugger
      if (validData) {
        this.$nuxt.$loading.start()
        let formData = this.cloneItem(this.form)
        if (this.selected_payment_type == 'bank_transfer') {
          formData = { ...formData, ...this.bank }
        }
        debugger
        await OrderService.checkout(formData)
          .then((response) => {
            if (response.payment_url) {
              // this.redirect(response.payment_url)
              window.location.replace(response.payment_url);
              this.$nuxt.$loading.finish()
            } else {
              this.$toast.success(response.message)
              this.$router.push(this.localePath('orders'))
            }
          })
          .catch(() => {
            this.$nuxt.$loading.finish()
          })
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
        this.enableSubmit = false
        this.fileType = e.target.files[0].type
        this.$nuxt.$loading.start()
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            debugger
            this.enableSubmit = true
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
