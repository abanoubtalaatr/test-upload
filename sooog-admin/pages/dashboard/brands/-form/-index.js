import { mapState } from 'vuex'
import BrandService from "../-service/-BrandService";
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
          image: ''
        },
        param_id: this.$route.params.id,
        uploaderFolder: 'brands',
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
        this.form = {... this.item}
      },
      async handleUploadFile (e) {
        this.submitted = true
        if (e.target.files.length) {
          // if (this.form.image != '') {
          //   await this.deleteFile()
          // }
          var imageExt=['png','jpg','jpeg','svg','gif'];
          var extension = e.target.files[0].name.split('.').pop().toLowerCase();

          if(! imageExt.includes(extension)){
            this.$toast.error(this.$t('admin.unsupported_image_format'));
            this.form.image = '';
            return false;
          }else {
          await UploaderService.uploadSingleFile({
            file: e.target.files[0],
            path: this.uploaderFolder
          })
            .then((response) => {
              this.form.image = response.file
              this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
              this.submitted = false
            })
            .catch(() => {
              this.submitted = false
            })
          }
        }
    },
    async deleteFile(){
      await UploaderService.deleteSingleFile({
        file: this.form.image,
        path: this.uploaderFolder
      })
      .then(() => {
        this.form.image = ''
        this.$refs.fileupload.value = ''
        this.$toast.success(this.$t('admin.attachment_deleted_successfully'))
      })
      .catch(() => {})
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
        await BrandService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      async create () {
        await BrandService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-brands" }))
      }
    },
  }
