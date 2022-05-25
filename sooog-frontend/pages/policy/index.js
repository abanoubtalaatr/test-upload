import {mapState} from 'vuex'

export default {
  components: {},
  async asyncData(context) {
    const policy = await context.$axios.$get('/pages/policy').catch(() => {
    })
    return {policy}
  },
  data() {
    return {
      titlePage: this.$t('front.policy'),
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    }),
  },
  methods: {},

  head() {
    return {
      title: this.titlePage
    }
  }
}
;
