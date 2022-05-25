
export default {
  data () {
    return {
      modalName: 'deactivateModal',
      form: {
        reason: '',
        id: null
      },
      modalProps: {
        width: '500px',
        height: 'auto',
        minHeight: 500,
        scrollable: true
      },
      customEvents: [
        { eventName: 'open-deactivate-modal', callback: this.showModal },
        { eventName: 'close-deactivate-modal', callback: this.hideModal }
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
  mounted () {},
  methods: {
    showModal (id) {
      //* show modal */
      this.form = {
        reason: '',
        id: id
      }
      this.$modal.show(this.modalName)
    },
    hideModal () {
      this.$modal.hide(this.modalName)
    },
    cancelModal () {
      this.hideModal()
    },
    confirmModal () {
      this.$validator.validateAll().then(result => {
        if (!result) {
          return
        }
        this.$EventBus.$emit('deactivate-item-event', this.form)
        this.hideModal()
      });
      
    }

  }
}
