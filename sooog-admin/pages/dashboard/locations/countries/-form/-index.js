import { mapState } from 'vuex'
import CountryService from "~/pages/dashboard/locations/service/CountryService.js";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService';

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
        code: '',
        flag: ''
      },
      flag: '',
      param_id: this.$route.params.id,
      submitted: false,
      uploaderFolder: 'countries',
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
    async submit () {
      console.log('ff', this.form)
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
      await CountryService.update(this.form, this.param_id)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.updated_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    async create () {
      console.log('form', this.form)
      await CountryService.create(this.form)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.created_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    async handleUploadFile (e) {
      this.submitted = true
      if (e.target.files.length) {
        console.log('file', e.target.files[0])
        // if (this.form.flag != '') {
        //   await this.deleteFile()
        // }
        var imageExt=['png','jpg','jpeg','svg','gif'];
          var extension = e.target.files[0].name.split('.').pop().toLowerCase();

          if(! imageExt.includes(extension)){
            this.$toast.error(this.$t('admin.unsupported_image_format'));
            this.form.flag = '';
            return false;
          }else {
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            this.form.flag = response.file
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
        file: this.form.flag,
        path: this.uploaderFolder
      })
      .then(() => {
        this.form.flag = ''
        this.$refs.fileupload.value = ''
        this.$toast.success(this.$t('admin.attachment_deleted_successfully'))
      })
      .catch(() => {})
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-locations-countries" }))
    }
  },
}
