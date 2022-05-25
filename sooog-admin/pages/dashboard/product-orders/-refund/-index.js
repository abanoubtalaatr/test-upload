import { mapState } from 'vuex'
import OrderService from '~/pages/dashboard/product-orders/-service/-OrderService'
export default {
    props: {
      item: {
          required: true
      },
      refund_reasons: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          refund_reason_id: null,
          refund_type: 'order',
          note: null,
          items: []
        },
        other_reason: false,
        param_id: this.$route.params.id,
        options: [
          {
            value: 'order',
            text: this.$t('admin.order')
          },
          {
            value: 'items',
            text: this.$t('admin.items')
          }
        ],
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    methods: {
      updateReason(e){
        console.log('eee', e)
        let reason_type = this.refund_reasons.find(obj => obj.id == e).type
        this.other_reason = false
        if(reason_type && reason_type == 'other')
          this.other_reason = true
        console.log('reason',reason_type)
      },
      reAssignForm () {
        this.form = {...this.item, ...{
          products: this.item.products.map(product => product.id)
        }}
        console.log('form: ', this.form)
      },
      updateItems(item){
        if (!this.item.items.find(obj => obj.id == item.id).product.id) 
          this.item.items = this.item.items.filter((obj) => obj.id != item.id)
        
        console.log('items', this.item.items)
      },
      updateQuantity(){
        console.log('items', this.item.items)
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          if(this.form.refund_type == 'items'){
            this.form.items = this.item.items.map((item) => {
                return {
                  order_item_id: item.id,
                  quantity: item.quantity,
                }
              })
            }else {
              this.form.items = []
            }
          await OrderService.refund(this.form, this.param_id)
          .then(() => {
            this.back()
            this.$toast.success(this.$t('admin.created_successfully'))
            this.submitted = false
          })
          .catch(() => {
            this.submitted = false
          })
        }else{
          this.submitted = false
        }
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-product-orders" }))
      }
    },
  }