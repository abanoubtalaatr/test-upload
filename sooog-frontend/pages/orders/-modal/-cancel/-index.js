import { mapState } from 'vuex'
import _ from 'lodash'
import OrderService from "~/services/orders/OrderService.js"

export default {
  data () {
    return {
      modalName: 'cancelModal',
      modalProps: {
        width: '600px',
        height: 'auto',
        minHeight: 500,
        scrollable: true
      },
      form: {
        reason: null,
        status: 'canceled'
      },
      order_id: null,
      customEvents: [
        { eventName: 'open-cancel-modal', callback: this.handleDataModal }
      ]
    }
  },
  created () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  destroyed () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  mounted () {},
  methods: {
    handleDataModal (data) {
      this.order_id = data
      this.showModal()
    },
    showModal () {
      //* show modal */
      this.$modal.show(this.modalName)
    },
    hideModal () {
      this.resetForm()
      this.$modal.hide(this.modalName)
    },
    resetForm () {
      this.$validator.pause();
      this.form = {
        reason: null,
        status: 'canceled'
      }
    },
    async submit () {
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.$nuxt.$loading.start()
        await OrderService.changeStatus(this.form, this.order_id)
          .then((response) => {
            //* fire event to update prop is_rated true */
            this.$EventBus.$emit('cancel-order', response)
            this.$toast.success(this.$t('front.updated_successfully'))
            this.hideModal()
          })
          .catch(() => {})
          this.$nuxt.$loading.finish()
      }
    }
  }
}
