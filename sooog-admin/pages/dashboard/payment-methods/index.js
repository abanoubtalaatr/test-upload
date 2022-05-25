import PaymentMethodService from "./-service/-PaymentMethodService"

export default {
  async asyncData(context) {
    let response = await Promise.all([
      context.$axios.$get("/admin/payment-methods").catch(() => { }),
    ])

    return {
      collection: response[0],
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.payment_method'),
      uniqueId: this.uniqueID(),
      fieldsData: [
        {
          key: "id",
          label: this.$t('admin.ID')
        },
        {
          key: "name",
          label: this.$t('admin.name')
        },{
          key: "is_active",
          label: this.$t('admin.status'),
        },
        // {
        //   key: "total",
        //   label: this.$t('admin.reserved_amount')
        // },
        // {
        //   key: "application_dues_percentage",
        //   label: this.$t('admin.commission_percentage')
        // },
        // {
        //   key: "application_dues",
        //   label: this.$t('admin.commission_value')
        // },
        // {
        //   key: "amount_before_commission",
        //   label: this.$t('admin.amount_before_commission')
        // },
        // {
        //   key: "created_at",
        //   label: this.$t('admin.payment_actual_date')
        // },
        // {
        //   key: "receipt",
        //   label: this.$t('admin.payment_file')
        // },
        {
          key: "action",
          label: this.$t('admin.actions')
        }
      ],
      loading: false,
      permissions: this.$cookies.get('permissions')
    }
  },

  methods: {

    handleToggleStatus (id) {
      PaymentMethodService.toggleStatus(id)
        .then((response) => {
          //* update list *//
          let index = this.collection.findIndex((obj) => obj.id == id)
          if (index >= 0) {
            this.$set(this.collection, index, response)
          }
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {})
    }
  },
  computed: {
    titleStack() {
      return [this.$t('admin.payment_method')]
    },
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
