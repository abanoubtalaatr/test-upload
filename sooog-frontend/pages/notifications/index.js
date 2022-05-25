import {mapState} from 'vuex';
import SideBar from '~/components/front/SideBar.vue';
import NotificationService from "~/services/notification/NotificationService.js"

export default {
  middleware: ['auth'],
  components: {
    SideBar
  },
  async asyncData(context) {
    const response = await context.$axios.$get('/user-notifications?is_read=1').catch(() => {
    })
    return {
      collection: response?.data || [], 
      meta: response?.meta,
      links: response?.links
    }
  },
  data() {
    return {
      titlePage: this.$t('admin.notifications'),
      queryParam: ''
    }
  },
  created() {
    this.$EventBus.$emit('reset-notification-counter')
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
      // facebook: state => state.localStorage.settings.filter(item=>(item.key=='facebook'))[0].body,
    }),
  },
  methods: {
    async loadAsyncData () {
      this.$nuxt.$loading.start();

      this.queryParam = `?page=${this.meta.current_page}&is_read=1`

      await NotificationService.getAll(this.queryParam)
        .then((response) => {
          this.collection = response.data

          this.meta = response.meta
          this.links = response.links
        })
        .catch(() => {
          this.collection = []
        })
      this.$nuxt.$loading.finish();
    },
    /*
    * Handle page-change event
    */
    onPageChange (page) {
      this.meta.current_page = page
      this.loadAsyncData()
    },
    prevPage() {
      if (this.links.prev_page_url) {
        this.onPageChange(this.meta.current_page - 1)
      }
    },
    nextPage() {
      if (this.links.next_page_url) {
        this.onPageChange(this.meta.current_page + 1)
      }
    },
  },
  head() {
    return {
      title: this.titlePage
    }
  }
}
;
