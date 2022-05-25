import { mapState } from 'vuex'
import AuthService from "~/pages/dashboard/auth/service/AuthService.js";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
import { mapValues } from 'lodash';

export default {
  data() {
    return {
      titlePage: this.$t('admin.profile'),
      uploaderFolder: 'admins',
      user: {
        name: '',
        email: '',
        phone: '',
        avatar: ''
      },
      form: {
        old_password: '',
        password: '',
        password_confirmation: ''
      },
      submitted: false
    }
  },
  created () {
    if (this.mokayiefyData) {
      this.user = {
        name: this.mokayiefyData.name,
        email: this.mokayiefyData.email,
        phone: this.mokayiefyData.phone,
        avatar: this.mokayiefyData.avatar
      }
    }
  },
  fetchOnServer: true,
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      mokayiefyData: state => JSON.parse(state.localStorage.mokayiefyData),
    }),
    titleStack () {
      return [this.$t('admin.profile')]
    }
  },
  methods: {
    async updateProfile(){
      console.log('updateProfile')
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        AuthService.updateProfile(this.user)
        .then((res) => {
          console.log('res', res)
          this.$toast.success(this.$t('admin.updated_successfully'))
          this.$store.commit(
            "localStorage/SET_MOKAYIEFY_DATA",
            JSON.stringify({...(({permissions, ...rest} = res) => (rest))()})
          )
          this.submitted = false
        })
        .catch(() => {
          this.submitted = false
        })
      }else{
        this.submitted = false
      }
    },
    async updatePassword(){
      this.submitted = true
      const validData = await this.$validator.validateAll('password')
      if (validData) {
        AuthService.updatePassword(this.form)
        .then(() => {
          this.$toast.success(this.$t('admin.updated_successfully'))
          this.handleReset()
          this.submitted = false
        })
        .catch(() => {
          this.submitted = false
        })
      }else{
        this.submitted = false
      }
    },
    handleReset () {
      this.form = mapValues(this.form, (item) => {
        if (item && (typeof item === 'object' || Array.isArray(item))) {
          return []
        }
        return null
      })
      this.$validator.reset()
    },
    async handleUploadFile (e) {
      console.log('file', e.target.files[0])
      this.submitted = true
      if (e.target.files.length) {
        var imageExt=['png','jpg','jpeg','svg','gif'];
        var extension = e.target.files[0].name.split('.').pop().toLowerCase();

        if(! imageExt.includes(extension)){
          this.$toast.error(this.$t('admin.unsupported_image_format'));
          this.user.avatar='';
          return false;
        }else {
          if (this.user.avatar != '' && typeof(this.user.avatar) == 'string') {
            await this.handleDeleteFile(this.user.avatar, this.uploaderFolder)
          }

          await UploaderService.uploadSingleFile({
            file: e.target.files[0],
            path: this.uploaderFolder
          })
            .then((response) => {
              this.user.avatar = response.file
              this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
              this.submitted = false
            })
            .catch(() => {
              this.submitted = false
              this.user.avatar = ''
            })
        }
      }
  },
  },
}
