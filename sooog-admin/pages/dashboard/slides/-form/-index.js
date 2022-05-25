import { mapState } from 'vuex'
import AdService from "../-service/-AdService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
import { BIconHandThumbsDown } from 'bootstrap-vue';
export default {
    props: {
        item: {
            required: false
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
          image: ''
        },
        param_id: this.$route.params.id,
        uploaderFolder: 'slides',
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
        this.form = {...this.item}
      },
      async handleUploadFile (e) {
        this.submitted = true
        if (e.target.files.length) {
          // if (this.form.image != '') {
          //   this.deleteFile()
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
        //debugger
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
        AdService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      create () {
        AdService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-slides" }))
      }
    },
  }
