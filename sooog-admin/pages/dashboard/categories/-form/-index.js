import { mapState } from 'vuex'
import CategoryService from "../-service/-CategoryService";
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'
export default {
    props: {
      item: {
          required: false
      },
      itemType: {
        required: true
      },
      is_child: {
        required: false,
        default: false
      },
      categories: {
        required: false,
        type: Array
      }
    },
    data() {
      return {
        form: {
          en: { name: '' },
          ar: { name: '' },
          is_active: true,
          image: '',
          type: 'stores',
          order: 1
        },
        param_id: this.$route.params.id,
        uploaderFolder: 'categories',
        submitted: false,
        order_range: [1,2,3,4,5,6,7,8,9,10]
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
      }
    },
    fetchOnServer: true,
    methods: {
      reAssignForm () {
        this.form = this.cloneItem(this.item)
        //this.form = {...this.item, ...{parent_id: this.item.category?.id}}
        if(this.is_child)
          this.form.parent_id = this.item.category?.id

        console.log('form: ', this.form)
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
        await CategoryService.update(this.form, this.param_id)
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
        await CategoryService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        if(this.itemType == 'centers')
          return this.$router.push(this.localePath({ name: "dashboard-services-types" }))
        if(this.itemType == 'stores' && this.is_child)
          return this.$router.push(this.localePath({ name: "dashboard-subcategories" }))
        this.$router.push(this.localePath({ name: "dashboard-categories" }))
      }
    },
  }
