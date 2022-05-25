import { mapState } from 'vuex'
import StoreService from "../-service/-StoreService";

export default {
  async asyncData (context) {
    const [ stores ] = await Promise.all([
        context.$axios.$get(`/admin/stores?type=stores&is_paginated=0`).catch(() => {})
    ])
    return { stores }
  },
  data() {
    return {
      titlePage: this.$t('admin.current_stores'),
      form: {
        stores: [],
        type: 'stores'
      },
      selectAll: false,
    }
  },
  computed: {
    titleStack () {
      return [this.titlePage, this.$t('admin.set_featured_stores')]
    }
  },
  async fetch() {
    this.stores.forEach(element => {
      if(element.is_featured)
        this.form.stores.push(element.id)
    })
  },
  fetchOnServer: true,
  methods: {
    selectAllStores () {
      if (this.form.stores.length) {
        this.form.stores = []
        this.selectAll = false
      } else {
        this.selectAll = true
        // this.stores.forEach(element => {
        //   this.form.stores = [...this.form.stores, ...
        //     (element.map((obj) => obj.id))
        //   ]
        // })
        this.form.stores = [...this.stores.map((obj) => obj.id)]
      }
    },
    submit () {
      const validData = this.$validator.validateAll()
      if (validData) {
        StoreService.setFeaturedStores(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.saved_successfully'))
        })
        .catch(() => {})
      }
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-current-stores" }))
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
