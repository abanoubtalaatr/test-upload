import { mapState } from 'vuex'
import OrderService from '~/pages/dashboard/product-orders/-service/-OrderService'
import OrderProducts from '~/pages/dashboard/product-orders/-form/-OrderProducts/-index.vue'
import StoreService from '~/pages/dashboard/current-stores/-service/-StoreService'
import UserService from '~/pages/dashboard/users/-service/-UserService'
export default {
  components: {
    OrderProducts
  },
    props: {
      item: {
          required: true
      },
      payment_methods: {
        required: true,
        type: Array
      },
      stores: {
        required: true,
        type: Array
      },
      warranties: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          store_id: null,
          admin_notes: null,
          payment_method_id: null,
          user_address_id: null,
          promo_code: null,
          depositor_name: null,
          deposit_amount: null,
          deposit_receipt: null,
          items: []
        },
        addresses: [],
        param_id: this.$route.params.id,
        customEvents: [
          { eventName: 'selected-order-items-event', callback: this.handleItems }
        ],
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    // async fetch() {
    //   if (this.param_id) {
    //    // this.loadData()
    //    // this.reAssignForm()
    //   }
    // },
    //fetchOnServer: true,
    created () {
      if (this.item) {
         this.loadData()
         this.reAssignForm()
       }
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$on(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    destroyed () {
      this.customEvents.forEach(function (customEvent) {
        // eslint-disable-next-line no-undef
        this.$EventBus.$off(customEvent.eventName, customEvent.callback)
      }.bind(this))
    },
    methods: {
       loadData(){
         UserService.listAddresses(this.item.user.id)
          .then((response) => {
            console.log('addresses>>>', response)
          this.addresses = response
          
          })
          .catch(() => {
          this.addresses = []
          })
      },
      openProductsModal(){
        this.$EventBus.$emit('open-order-products-modal', this.form.items)
      },
      reAssignForm () {
        console.log('item', this.item)
      this.form = {
        store_id: this.item.store?.id,
        admin_notes: this.item.admin_notes,
        payment_method_id: this.item.payment_method?.id,
        user_address_id: this.item.user_address?.id,
        promo_code: null,
        // depositor_name: this.item.bank_transfer?.depositor_name,
        // deposit_amount: this.item.bank_transfer?.deposit_amount,
        // deposit_receipt: this.item.bank_transfer?.deposit_receipt,
        items: this.item.items.map((element) => {
          return {
            product_id: element.product?.id,
            quantity: element.quantity,
            warranty_id: element.warranty?.id
          }
        })
      }
        console.log('form: ', this.form)
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          this.update()
        }else{
          this.submitted = false
        }
      },
      async update () {
        await OrderService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      // async create () {
      //   await OrderService.create(this.form)
      //   .then(() => {
      //     this.back()
      //     this.$toast.success(this.$t('admin.created_successfully'))
      //   })
      //   .catch(() => {})
      // },
      handleItems(data){
        console.log('prod-event', data)
        this.form.items = data
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-product-orders" }))
      }
    },
  }