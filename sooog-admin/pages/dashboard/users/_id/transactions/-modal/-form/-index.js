import UserService from "~/pages/dashboard/users/-service/-UserService";
import { mapValues } from "lodash"

export default {
  data() {
    return {
      payload: {
        ar: {
          reason: null
        },
        en: {
            reason: null
        },
        type: 'pay_in',
        amount: null
      },
      type_options: [
        { text: this.$t('admin.pay_in'), value: 'pay_in' },
        { text: this.$t('admin.pay_out'), value: 'pay_out' }
      ],
      customEvents: [
        { eventName: 'open-transaction-modal', callback: this.showModal }
    ],
    submitted: false,
    param_id: this.$route.params.id,
    titlePage: this.$t('admin.add_transaction'),
    };
  },
  mounted() {
    //this.getData()
    //console.log('currentLocale', this.currentLocale)
  },
  created () {
    this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback)
      }.bind(this))
},
beforeDestroy (){
    this.customEvents.forEach(function (customEvent) {
    // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback)
        }.bind(this))
},
  methods: {
    hideModal () {
      this.handleReset()
      this.$bvModal.hide('form-transaction-modal')
    },
    showModal () {
      this.$bvModal.show('form-transaction-modal')
    },
    async submit () {
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.create()
      }else {
        this.submitted = false
      }
    },
    create() {
      this.$nuxt.$loading.start()
      UserService.createTransaction(this.param_id, this.payload)
        .then(res => {
            this.$toast.success(this.$t('admin.created_successfully'))
            this.submitted = false
            this.$EventBus.$emit('handle-transaction-modal', res)
            this.hideModal()
        })
        .catch(e => {
          this.submitted = false
        });
    },
    handleReset () {
      this.payload = {
        ar: {
          reasons: null
        },
        en: {
            reasons: null
        },
        type: null,
        amount: null
      }
    },
  },
}
