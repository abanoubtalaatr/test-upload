import { mapState } from 'vuex'
import ServiceService from "../-service/-ServiceService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
export default {
    props: {
        item: {
            required: false
        },
        categories: {
          required: true
        },
        stores: {
          required: true
        }
    },
    data() {
      return {
        form: {
          en: {
            name: '',
            description: ''
          },
          ar: {
            name: '',
            description: ''
          },
          is_active: true,
          image: '',
          category_id: null,
          store_id: null,
          preview_fees: null,
          price: null
        },
        param_id: this.$route.params.id,
        uploaderFolder: 'products',
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
          category_id: this.item.category?.id,
          store_id: this.item.store?.id
        }}
        //this.form = {...this.item}
        console.log('itemm: ', this.form)
      },
      async handleUploadFile (e) {
        if (e.target.files.length) {
          var imageExt=['png','jpg','jpeg','svg','gif'];
          var extension = e.target.files[0].name.split('.').pop().toLowerCase();

          if(! imageExt.includes(extension)){
            this.$toast.error(this.$t('admin.unsupported_image_format'));
            this.form.image = '';
            return false;
          }else {
            if (this.form.image != '') {
              this.deleteFile()
            }
            await UploaderService.uploadSingleFile({
              file: e.target.files[0],
              path: this.uploaderFolder
            })
              .then((response) => {
                this.form.image = response.file
                this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
              })
              .catch(() => {
                this.submitted = false
              })
          }
        }
    },
    async deleteFile(){
      console.log('ss', typeof(this.form.image))
      if (this.form.image != '' && typeof(this.form.image) == 'string') {
      await UploaderService.deleteSingleFile({
        file: this.form.image,
        path: this.uploaderFolder
      })
      .then(() => {
        this.form.image = ''
        this.$refs.fileupload.value = ''
        this.$toast.success(this.$t('admin.attachment_deleted_successfully'))
      })
      .catch(() => {
        //this.submitted = false
      })
    }else {
      this.form.image = ''
    }
    },
      submit () {
        this.submitted = true
        const validData = this.$validator.validateAll()
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
      update () {
        ServiceService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      create () {
        ServiceService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-services" }))
      }
    },
  }
