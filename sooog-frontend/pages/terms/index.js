import {mapState} from 'vuex'

export default {
  // middleware: ['auth'],
  components: {},
  async asyncData(context) {
    const page = await context.$axios.$get('/pages/terms').catch(() => {
    })
    return {page}
  },
  data() {
    return {
      titlePage: this.$t('front.terms'),
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      // facebook: state => state.localStorage.settings.filter(item=>(item.key=='facebook'))[0].body,
    }),

    title() {
      return this.page.title;
    },
    body() {
      return this.page.body;
    },

  },
  methods: {},

  head() {
    return {
      title: this.titlePage
    }
  }
}
;
