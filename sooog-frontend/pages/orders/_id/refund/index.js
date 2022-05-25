import { mapState } from 'vuex'
import OrderService from "~/services/orders/OrderService.js"
import SideBar from '~/components/front/SideBar.vue'

export default {
  middleware: ['auth'],
  validate({ params, query, store }) {
    if (params.id) {
      return !isNaN(params.id);
    }
    return true;
  },
  components: {
    SideBar
  },
  async asyncData (context) {
    const [order, reasons, policy] = await Promise.all([
      context.$axios.$get(`/orders/${context.params.id}`).catch(() => {}),
      context.$axios.$get(`/refund-reasons`).catch(() => {}),
      context.$axios.$get(`/pages/refund-policy`).catch((err) => console.log(err))
    ])
    if (order) {
      order.items = order.items.map((item) => {
        item.refund = {
          order_item_id: item.id,
          type: 'quantity',
          quantity: item.quantity,
          // note: '',
          isChecked: true
        }
        return item
      })
    }
    return { order, reasons, policy }
  },
  data () {
    return {
      titlePage: this.$t('front.order_details'),
      selected_reason_type: '',
      checkAll: true,
      refund: {
        refund_reason_id: '',
        refund_type: 'items',
        note: '',
        items: [],
        accept: false
      }
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  methods: {
    selectReason (event) {
      const reason = this.reasons.find((reason) => reason.id == event.target.value)
      this.selected_reason_type = reason?.type
    },
    toggleSelectAll (event) {
      debugger
      if (event.target.checked) {
        this.order.items = this.order.items.map((item) => {
          item.refund.isChecked = true
          return item
        })
      } else {
        this.order.items = this.order.items.map((item) => {
          item.refund.isChecked = false
          return item
        })
      }
      debugger
    },
    toggleSelect () {
      this.checkAll = this.order.items.every((item) => {
        return item.refund.isChecked == true
      })
    },
    increaseQty (key) {
      if (this.order.items[key].quantity > this.order.items[key].refund.quantity) {
        this.order.items[key].refund.quantity ++
      }
    },
    decreaseQty (key) {
      if (this.order.items[key].refund.quantity > 1) {
        this.order.items[key].refund.quantity --
      }
    },
    async submit () {
      const validData = await this.$validator.validateAll()
      debugger
      if (validData) {
        if (this.checkAll) {
          //* refund as order */
          this.refund.refund_type = 'order'
        } else {
          //* refund specific items */
          this.refund.items = []
          this.refund.refund_type = 'items'
          this.order.items.forEach((item) => {
            if (item.refund.isChecked) {
              this.refund.items.push(item.refund)
            }
          })
        }
        this.$nuxt.$loading.start()
        await OrderService.refundOrder(this.order.id, this.refund)
          .then((res) => {
            this.$toast.success(res.message)
            this.$router.replace(this.localePath('orders'))
          })
          .catch((err) => console.log(err))
          this.$nuxt.$loading.finish()

      }
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
};
