import OrderService from '@/pages/dashboard/product-orders/-service/-OrderService'
import StoreService from '@/pages/dashboard/current-stores/-service/-StoreService'
import { mapState } from 'vuex'
export default {
  props: {
    type: {
        required: false,
        default: 'stores'
    }
  },
    data () {
      return {
        modalId: 'orderFilterModal',
        titlePage: this.$t('admin.filter'),
        stores: [],
        payment_methods: [],
        statuses: [],
        form: {
          type: 'stores',
          status: null,
          payment_method: null,
          start_date: null,
          end_date: null,
          cost_from: null,
          cost_to: null,
          store: null
        },
        queryParam: '',
        customEvents: [
          { eventName: 'open-order-filter-modal', callback: this.showModal },
          { eventName: 'close-order-filter-modal', callback: this.hideModal }
        ]
      }
    },
    async fetch() {
      const response = await Promise.all([
        await StoreService.getAll(`?status=accepted&type=${this.type}`),
        await OrderService.listPaymentMethods(),
        await OrderService.listStatuses()
      ])
      this.stores = response[0]
      this.payment_methods = response[1]
      this.statuses = response[2]
    },
    fetchOnServer: true,
    created () {
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
    mounted () {
        this.form.type = this.type
    },
    methods: {
      showModal () {
          console.log('showwwh')
          this.form = {
            status: null,
            payment_method: null,
            start_date: null,
            end_date: null,
            cost_from: null,
            cost_to: null,
            type: this.type
          }
        this.$bvModal.show(this.modalId)
      },
      hideModal () {
        this.$bvModal.hide(this.modalId)
      },
      cancelModal () {
        this.hideModal()
      },
      submit () {
        this.$validator.validateAll().then(result => {
          if (!result) {
            return
          }
          this.$EventBus.$emit('order-filter-event', this.axiosParams)
          this.hideModal()
        });
        
      }
  
    },
    computed: {
        titleStack () {
          return ['']
        },
        ...mapState({
          currentLocale: state => state.localStorage.currentLocale,
        }),
        axiosParams() {
          const params = new URLSearchParams();
          params.append('type', this.form.type  || '');
          params.append('start_date', this.form.start_date || '');
          params.append('end_date', this.form.end_date || '');
          params.append('cost_from', this.form.cost_from || '');
          params.append('cost_to', this.form.cost_to || '');
          params.append('payment_method', this.form.payment_method || '');
          params.append('status_id', this.form.status || '');
          params.append('store', this.form.store || '');
          return params;
      }
    },
      
  }
  