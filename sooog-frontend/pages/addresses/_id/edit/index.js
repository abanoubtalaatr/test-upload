import { mapState } from 'vuex'
import SideBar from '~/components/front/SideBar.vue';
import FormData from "~/pages/addresses/-form/-index.vue"

export default {
  middleware: ['auth'],
  components: {
    SideBar,
    FormData
  },
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item, countries ] = await Promise.all([
      context.$axios.$get(`/profile/user-addresses/${context.params.id}`).catch(() => {}),
      context.$axios.$get(`/location/countries?is_paginated=0`).catch(() => {}),
    ])
    return { item, countries }
  },
  data () {
    return {
      titlePage: this.$t('front.addresses')
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  methods: {

  },
  head () {
    return {
      title: this.titlePage
    }
  }
};
