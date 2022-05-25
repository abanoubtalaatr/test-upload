import UserService from "~/pages/dashboard/users/-service/-UserService";
import formData from "~/pages/dashboard/users/_id/transactions/-modal/-form/-index.vue";

export default {
  components: {
    formData
  },
  data() {
    return {
      transactions: [],
      fieldsData: [
        // {
        //   key: "id",
        //   label: this.$t('id')
        // },
        {
          key: "type",
          label: this.$t('admin.transaction_type')
        },
        {
          key: "amount",
          label: this.$t('admin.amount')
        },
        {
          key: "created_at",
          label: this.$t('admin.created_at')
        },
        {
          key: "reason",
          label: this.$t('admin.reason')
        }
      ],
      meta: {},
      publicSearch: '',
      customEvents: [
        { eventName: 'handle-quick-search', callback: this.handleSearch },
        { eventName: 'handle-transaction-modal', callback: this.handleTransactionEvent }
    ],
    param_id: this.$route.params.id,
    };
  },
  async asyncData(context) {
    try {
      const response = await context.$axios.$get(`/admin/users/${context.params.id}/transactions`).catch((e) => {})
      //console.log('resp: ', response.data)
      return {
        transactions: response.data,
        meta: response.meta
      }
    }catch (e) {
      console.log('err: ', e)
    }
  },
//   mounted () {
//     this.$EventBus.$emit('enable-quick-search', true)
// },
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
    createRow(){
      this.$EventBus.$emit('open-transaction-modal')
    },
    handleSearch (search) {
      this.publicSearch = search
      this.onPageChange(1)
  },
  /*
  * Load async data
  */
  async loadAsyncData () {
  this.$nuxt.$loading.start();

  this.queryParam = `?page=${this.meta.current_page}&public_search=${this.publicSearch}`

  await UserService.listTransactions(this.param_id, this.queryParam)
      .then((response) => {
      this.transactions = response.data

      this.meta = response.meta
      this.links = response.links
      })
      .catch(() => {
      this.transactions = []
      })
      this.$nuxt.$loading.finish();
  },
  onPageChange (page) {
    this.meta.current_page = page
    this.loadAsyncData()
    },
    handleTransactionEvent(data){
      console.log('data-event', data)
      this.transactions.push(data)
      //this.transactions[0] = data
    }

  },
  computed: {
    titleStack () {
        return [this.$t('admin.transactions')]
    }
},
};
