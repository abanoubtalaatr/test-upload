import { mapState } from 'vuex'
export default {
    props: {
      item: {
          required: true
      },
      type: {
        required: false,
        default: 'stores'
      },
      backRoute: {
        required: false,
        default: 'dashboard-refunds'
      }
    },
    data() {
      return {
        param_id: this.$route.params.id,
        itemsData: [
          // {
          //     key: "id",
          //     label: this.$t('admin.ID')
          // },
          {
              key: "product.name",
              label: this.$t('admin.product_name')
          },
          {
              key: "quantity",
              label: this.$t('admin.quantity')
          },
          {
            key: "product_price",
            label: this.$t('admin.product_price')
          },
          {
            key: "warranty_price",
            label: this.$t('admin.warranty_price')
          },
          {
            key: "offer_discount",
            label: this.$t('admin.offer_discount')
          },
          {
            key: "total",
            label: this.$t('admin.total')
          }
        ],
        statusesData: [
          // {
          //     key: "id",
          //     label: this.$t('admin.ID')
          // },
          {
              key: "status.name",
              label: this.$t('admin.order_status')
          },
          {
              key: "created_at",
              label: this.$t('admin.created_at')
          }
        ]
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    methods: {
      back () {
        this.$router.push(this.localePath({ name: this.backRoute }))
      }
    },
  }