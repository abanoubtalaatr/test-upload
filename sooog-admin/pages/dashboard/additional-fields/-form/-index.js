import { mapState } from 'vuex'
import PropertyService from "../-service/-PropertyService";
export default {
    props: {
      item: {
          required: false
      },
      categories: {
        required: true,
        type: Array
      },
      property_types: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          is_active: true,
          is_required: true,
          property_type_id: null,
          categories: [],
          has_options: false,
          options: []
        },
        param_id: this.$route.params.id,
        options: [
          {
            value: true,
            text: this.$t('admin.yes')
          },
          {
            value: false,
            text: this.$t('admin.no')
          }
        ],
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    async fetch() {
      if (this.param_id) {
        this.reAssignForm()
      }
    },
    fetchOnServer: true,
    methods: {
      reAssignForm () {
        this.form = {...this.item, ...{
          property_type_id: this.item.property_type?.id,
          //categories: this.item.categories.map(category => category.id)
        }}
        console.log('form: ', this.form)
      },
      addOption () {
        this.form.options.push({
          en: {
            name: ''
          },
          ar: {
            name: ''
          }
        })
      },
      removeOption (key) {
        this.form.options.splice(key, 1)
      },
      handlePropertyOPtions(property_type_id){
        let property_type = this.property_types.find(property_type => property_type.id === property_type_id)
        //* check if selected property type has options */
        if (property_type && property_type.has_options) {
          this.addOption()
          this.form.has_options = true
        } else {
          //* reset values of options */
          this.form.options = []
          this.form.has_options = false
        }
      },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
          this.form.categories = this.form.categories.map(category => category.id)
          if (this.param_id) {
            this.update()
          } else {
            this.create()
          }
        }else{
          this.submitted = false
        }
      },
      async update () {
        await PropertyService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        console.log('thform', this.form)
        await PropertyService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-additional-fields" }))
      }
    },
  }