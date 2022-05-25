import { mapState } from 'vuex'
import _ from 'lodash'
import RatingService from "~/services/products/RatingService.js"

export default {
  data () {
    return {
      modalName: 'addRatingModal',
      modalProps: {
        width: '600px',
        height: 'auto',
        minHeight: 500,
        scrollable: true
      },
      form: {
        product_id: null,
        rate: 0,
        comment: null
      },
      customEvents: [
        { eventName: 'open-rating-modal', callback: this.handleDataModal }
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
      this.form.product_id = data
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
        product_id: null,
        rate: 0,
        comment: null
      }
    },
    async submitRating () {
      const validData = await this.$validator.validateAll()
      if (validData) {
        if (!this.form.rate) {
          this.$toast.error(this.$t('front.rate_required'))
        } else {
          await RatingService.create(this.form)
            .then((response) => {
              //* fire event to update prop is_rated true */
              this.$EventBus.$emit('rate-product', this.form.product_id)
              this.$toast.success(this.$t('front.added_rate_successfully'))
              this.hideModal()
            })
            .catch(() => {})
        }
      }
    }
  }
}
