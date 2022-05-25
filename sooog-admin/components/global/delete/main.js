
export default {
  data () {
    return {
      modalName: 'deleteModal',
      modalProps: {
        width: '500px',
        height: 'auto',
        minHeight: 500,
        scrollable: true
      },
      customEvents: [
        { eventName: 'open-delete-modal', callback: this.showModal },
        { eventName: 'close-delete-modal', callback: this.hideModal }
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
    showModal () {
      //* show modal */
      this.$modal.show(this.modalName)
    },
    hideModal () {
      this.$modal.hide(this.modalName)
    },
    cancelModal () {
      this.$emit('cancel')
    },
    confirmModal () {
      this.$emit('confirm')
    }

  }
}
