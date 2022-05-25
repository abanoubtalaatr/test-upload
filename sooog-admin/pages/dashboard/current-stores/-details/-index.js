import { mapState } from 'vuex'
export default {
    props: {
      item: {
          required: false
      },
      back_route: {
        required: false,
        default: "dashboard-current-stores"
      }
    },
    data() {
      return {
        param_id: this.$route.params.id
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    methods: {
      back () {
        this.$router.push(this.localePath({ name: this.back_route }))
      }
    },
  }