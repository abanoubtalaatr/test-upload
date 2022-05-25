import { mapState } from 'vuex'
import SideBar from '~/components/front/SideBar.vue';
import FormData from "~/pages/addresses/-form/-index.vue"

export default {
  middleware: ['auth'],
  components: {
    SideBar,
    FormData
  },
  async asyncData (context) {
    const [ countries ] = await Promise.all([
      context.$axios.$get(`/location/countries?is_paginated=0`).catch(() => {}),
    ])
    return { countries }
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
