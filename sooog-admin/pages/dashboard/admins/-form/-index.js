import { mapState } from 'vuex'
import AdminService from "../-service/-AdminService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
export default {
    props: {
      item: {
          required: false
      },
      roles: {
        required: true,
        type: Array
      }
    },
    data() {
      return {
        form: {
          name: '' ,
          email: '' ,
          phone: '' ,
          password: '' ,
          password_confirmation: '' ,
          is_active: true,
          avatar: '',
          roles: []
        },
        param_id: this.$route.params.id,
        uploaderFolder: 'admins',
        isRequired: true,
        submitted: false
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    async fetch() {
      this.form.type = this.itemType
      if (this.param_id) {
        this.reAssignForm()
        this.isRequired = false
      }
    },
    fetchOnServer: true,
    methods: {
      reAssignForm () {
        // this.form = this.cloneItem(this.item)
        // this.form.roles = this.form.roles.map(role => role.id)
        this.form = {...this.item, ...{roles: this.item.roles.map(role => role.id)}}

        console.log('form: ', this.form)
      },
      async handleUploadFile (e) {
        this.submitted = true
        if (e.target.files.length) {
          // if (this.form.avatar != '') {
          //   this.deleteFile()
          // }
        var imageExt=['png','jpg','jpeg','svg','gif'];
        var extension = e.target.files[0].name.split('.').pop().toLowerCase();

        if(! imageExt.includes(extension)){
          this.$toast.error(this.$t('admin.unsupported_image_format'));
          this.form.avatar='';
          return false;
        }else {
          await UploaderService.uploadSingleFile({
            file: e.target.files[0],
            path: this.uploaderFolder
          })
            .then((response) => {
              this.form.avatar = response.file
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
          file: this.form.avatar,
          path: this.uploaderFolder
        })
        .then(() => {
          this.form.avatar = ''
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
        }else {
          this.submitted = false
        }
      },
      async update () {
        await AdminService.update(this.form, this.param_id)
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
        await AdminService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "dashboard-admins" }))
      }
    },
  }
