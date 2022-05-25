import { mapValues } from "lodash"
import { mapState } from 'vuex'

export default {
    data () {
      return {
        modalId: 'OfferFilterModal',
        titlePage: this.$t('admin.filter'),
        stores: [],
        categories: [],
        form: {
          name: null,
          product_name: '',
          type: '',
          date: null
        },
        options: [
          {
            value: 'percentage',
            text: this.$t('admin.percentage')
          },
          {
            value: 'value',
            text: this.$t('admin.value')
          },
          {
            value: 'free_product',
            text: this.$t('admin.free_product')
          }
        ],
        queryParam: '',
        customEvents: [
          { eventName: 'open-offer-filter-modal', callback: this.showModal },
          { eventName: 'close-offer-filter-modal', callback: this.hideModal }
        ]
      }
    },
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
    methods: {
      showModal () {
        this.handleReset()
        this.$bvModal.show(this.modalId)
      },
      hideModal () {
        this.$bvModal.hide(this.modalId)
      },
      cancelModal () {
        this.hideModal()
      },
      handleReset () {
        this.form = mapValues(this.form, (item) => {
          if (item && (typeof item === 'object' || Array.isArray(item))) {
            return []
          }
          return null
        })
        this.$validator.reset()
      },
      submit () {
        this.$validator.validateAll().then(result => {
          if (!result) {
            return
          }
          this.$EventBus.$emit('offer-filter-event', this.axiosParams)
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
          params.append('date', this.form.date  || '');
          params.append('name', this.form.name || '');
          params.append('product_name', this.form.product_name || '');
          params.append('type', this.form.type || '');
          return params;
      }
    },

  }
