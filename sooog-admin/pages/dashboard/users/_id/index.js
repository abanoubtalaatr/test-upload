import { mapState } from 'vuex'

export default {
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData (context) {
    const [ item ] = await Promise.all([
        context.$axios.$get(`/admin/users/${context.params.id}`).catch(() => {})
    ])
    return { item }
  },
  data() {
    return {
      titlePage: this.$t('admin.users'),
      param_id: this.$route.params.id,
      addressesData: [
        // {
        //     key: "id",
        //     label: this.$t('admin.ID')
        // },
        {
            key: "title",
            label: this.$t('admin.title')
        },
        {
            key: "address",
            label: this.$t('admin.address')
        },
        {
          key: "city.state.country.name",
          label: this.$t('admin.country')
        },
        {
          key: "city.state.name",
          label: this.$t('admin.state')
        },
        {
          key: "city.name",
          label: this.$t('admin.city')
        },
        {
            key: "phone",
            label: this.$t('admin.phone')
        },
        {
            key: "nearest_landmarks",
            label: this.$t('admin.nearest_landmarks')
        }
      ],
      permissions: this.$cookies.get('permissions')
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    }),
    titleStack () {
      return [this.titlePage, this.$t('admin.show')]
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  },
  methods: {
    back () {
      this.$router.push(this.localePath({ name: 'dashboard-users' }))
    }
  },
}
