import { mapState } from 'vuex'
import WarrantyService from "../-service/-WarrantyService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
export default {
    props: {
        item: {
            required: false
        }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          is_active: true,
          price: null
        },
        param_id: this.$route.params.id,
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
        this.form = this.cloneItem(this.item)
      },
      async handleUploadFile (e) {
        if (e.target.files.length) {
            console.log('nn', e.target.files[0])
          if (this.form.image != '') {
            await UploaderService.deleteSingleFile({
                file: this.item.image, 
                path: this.uploaderFolder
            }).catch(() => {})
          }
          await UploaderService.uploadSingleFile({
            file: e.target.files[0],
            path: this.uploaderFolder
          })
            .then((response) => {
              this.form.image = response.file
              this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
            })
            .catch(() => {})
        }
    },
      async submit () {
        this.submitted = true
        const validData = await this.$validator.validateAll()
        if (validData) {
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
        await WarrantyService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        await WarrantyService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-warranties" }))
      }
    },
  }