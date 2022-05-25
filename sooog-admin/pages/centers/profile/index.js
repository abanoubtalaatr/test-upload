import { mapState } from 'vuex'
import AuthService from "~/pages/centers/auth/service/AuthService.js";
import UploaderService from '@/pages/centers/uploaders/service/UploaderService'
import { mapValues } from 'lodash';

export default {
  layout: 'center',
  data() {
    return {
      titlePage: this.$t('admin.profile'),
      uploaderFolder: 'admins',
      storeUploaderFolder: 'stores',
      user: {
        name: '',
        email: '',
        phone: '',
        avatar: '',
        image: '',
        en: { name: '' },
        ar: { name: '' }
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
    if (this.centerData) {
      console.log('this.centerData.image', this.centerData.image)
      this.user = {
        name: this.centerData.name,
        email: this.centerData.email,
        phone: this.centerData.phone,
        avatar: this.centerData.avatar,
        image: this.centerData.image,
        en: this.centerData.en,
        ar: this.centerData.ar
      }
    }
  },
  fetchOnServer: true,
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      centerData: state => JSON.parse(state.localStorage.centerData),
    }),
    titleStack () {
      return [this.$t('admin.profile')]
    }
  },
  methods: {
    async updateProfile(){
      this.submitted = true
      const validData = await this.$validator.validateAll('profile')
      if (validData) {
        AuthService.updateProfile(this.user)
        .then((res) => {
          this.$toast.success(this.$t('admin.updated_successfully'))
          this.$store.commit(
            "localStorage/SET_CENTER_DATA",
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
    async handleUploadFile (e, name) {
      this.submitted = true
      if (e.target.files.length) {
        var imageExt=['png','jpg','jpeg','svg','gif'];
        var extension = e.target.files[0].name.split('.').pop().toLowerCase();

        if(! imageExt.includes(extension)){
          this.$toast.error(this.$t('admin.unsupported_image_format'));
          if(name == 'avatar')
            this.user.avatar='';
          else
            this.user.image='';

          return false;
        }else {
        if (this.user.avatar != '' && name == 'avatar') {
          await this.handleDeleteFile(this.user.avatar, this.uploaderFolder)
        }

        // if (this.user.image != '' && name == 'image') {
        //   await this.handleDeleteFile(this.user.image, this.storeUploaderFolder)
        // }

        let path = this.uploaderFolder
        if(name == 'image')
          path = this.storeUploaderFolder
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: path
        })
          .then((response) => {
            if(name == 'avatar')
              this.user.avatar = response.file
            else
              this.user.image = response.file

            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
            this.submitted = false
          })
          .catch(() => {
            this.submitted = false
          })
        }
      }
  },
    async handleDeleteFile (filePath, folderName) {
      await UploaderService.deleteSingleFile({
        file: filePath.split('/').pop(),
        path: folderName
      })
    },
  },
}
