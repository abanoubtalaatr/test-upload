import { mapState } from 'vuex'
import ProductService from "../-service/-ProductService";
import UploaderService from '@/pages/stores/uploaders/service/UploaderService'
import { times } from 'lodash';
export default {
  layout: 'store',
    props: {
        item: {
            required: false
        },
        categories: {
          required: true
        },
        brands: {
          required: true
        },
        countries: {
          required: true
        },
        settings: {
          required: true
        }
    },
    data() {
      return {
        form: {
          en: { 
            name: '', 
            description: '',
            tags: []
          },
          ar: { 
            name: '',
            description: '',
            tags: []  
          },
          is_active: true,
          image: '',
          mainCategory_id: null,
          category_id: null,
         // store_id: null,
          brand_id: null,
          made_in: null,
          max_purchase_quantity: null,
          price: null,
          quantity: null,
          barcode: null,
          image: null,
          catalog: null,
          attachments: [],
          properties: [],
          units: [
            {
              en: {name: ''},
              ar: {name: ''},
              price: '',
              id: '',
            }
          ],
        },
        subcategories: [],
        properties: [],
        param_id: this.$route.params.id,
        uploaderFolder: 'products',
        submitted: false,
        uploading_msg: null,
        uploading_files_msg: null,
        image_hint: null
      }
    },
  created() {
    //this.
    // if (this.storeData) {
    //   this.form.store_id=this.storeData.id;
    // }
    this.image_hint = this.settings ? this.settings.find((setting) => setting.key == `product_photos_notes_${this.currentLocale}`)?.body : null

    if (this.param_id) {
      this.reAssignForm()
    }
  },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
        storeData: state => JSON.parse(state.localStorage.storeData),
      })
    },
    // async fetch() {
    //   if (this.param_id) {
    //     this.reAssignForm()
    //   }
    // },

    //fetchOnServer: false,
    methods: {
      reAssignForm () {
        let Reunits=[
          {
            en: {name: ''},
            ar: {name: ''},
            price: '',
            id: '',
          }
        ];
        if(this.item.units.length){
          Reunits=this.item.units;
        }
        this.form = {
          en: { 
            name: this.item.name, 
            description: this.item.description,
            tags: this.item.tags
          },
          ar: { 
            name: this.item.ar.name,
            description: this.item.ar.description,
            tags: this.item.ar.tags 
          },
          is_active: true,
          mainCategory_id: this.item.category?.id || null,
          category_id: this.item.subcategory?.id ||null,
          //store_id: this.item.store?.id || null,
          made_in: this.item.made_in?.id || null,
          brand_id: this.item.brand?.id || null,
          max_purchase_quantity: this.item.max_purchase_quantity,
          price: this.item.price,
          quantity: this.item.quantity,
          barcode: this.item.barcode,
          image: this.item.image,
          catalog: this.item.catalog,
          attachments: this.item.attachments,
          properties: [],
          units: Reunits,
        }
        console.log('itemm: ', this.form)
        this.handleCategoryRelations(this.form.mainCategory_id)
        
      },
      removeUnit(key) {
        if (this.form.units.length > 1) {
          if (this.form.units[key].id) {
            this.handleDelete(this.form.units[key].id)
          }
          this.form.units.splice(key, 1)
        } else {
          this.$toast.error(this.$t('admin.alert_min_unit'))
        }
      },
      addUnit() {
        this.form.units.push({
          en: {name: ''},
          ar: {name: ''},
          price: '',
        })
      },

      async handleCategoryRelations(id){
        console.log('idcccc', id)
        let response = await Promise.all([
          ProductService.getSubCategories(id),
          ProductService.listCategoryProperties(id)
        ])
        console.log('resss', response[1])
          this.subcategories = response[0]
          this.properties = response[1].map((obj) => {
            obj.property_id = obj.id
            obj.value = ''
            //* check on edit mode or not */
            if (this.param_id) {
              //* get value from form properties if exist or check on has options type to set default value */
              let property_value = this.item.properties.find(prop => prop.property.id === obj.id)
              if (property_value)
                obj.value = typeof property_value.value == 'object' ? property_value.value?.id : property_value.value
            }
            return obj
          })
          if (this.param_id)
            this.form.category_id = this.item.subcategory?.id || null

          console.log('form', this.form)
      },
      async handleUploadFile (e, type='image') {
        this.submitted = true
        if (e.target.files.length) {
          if(type == 'image'){
            if (e.target.multiple) {
              this.uploading_files_msg = this.$t('admin.uploadingFiles')
              await UploaderService.uploadMultipleFiles({
                files: e.target.files,
                path: this.uploaderFolder
              })
                .then((response) => {
                  //* append new files in attachments */
                  this.form.attachments = response
                  this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
                  this.submitted = false
                  this.uploading_files_msg = null
                })
                .catch(() => {
                  this.submitted = false
                  this.uploading_files_msg = null
                })
            } else {
              var imageExt=['png','jpg','jpeg','svg','gif'];
            var extension = e.target.files[0].name.split('.').pop().toLowerCase();

            if(! imageExt.includes(extension)){
              this.$toast.error(this.$t('admin.unsupported_image_format'));
              this.form.image = '';
              return false;
            }else {
              this.uploading_msg = this.$t('admin.uploadingFile')
              if (this.form.image != '') {
                await UploaderService.deleteSingleFile({
                    file: this.form.image, 
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
                  this.submitted = false
                  this.uploading_msg = null
                })
                .catch(() => {
                  this.submitted = false
                  this.uploading_msg = null
                })
              }
            }
          } else {
            var imageExt=['pdf'];
          var extension = e.target.files[0].name.split('.').pop().toLowerCase();

          if(! imageExt.includes(extension)){
            this.$toast.error(this.$t('admin.unsupported_file_type'));
            this.form.catalog = '';
            return false;
          }else {
            this.uploading_file_msg = this.$t('admin.uploadingFile')
            if (this.form.catalog != '') {
              await UploaderService.deleteSingleFile({
                  file: this.form.catalog, 
                  path: this.uploaderFolder
              }).catch(() => {})
            }
            await UploaderService.uploadSingleFile({
              file: e.target.files[0],
              path: this.uploaderFolder
            })
              .then((response) => {
                this.form.catalog = response.file
                this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
                this.submitted = false
                this.uploading_file_msg = null
              })
              .catch(() => {
                this.submitted = false
                this.uploading_file_msg = null
              })
            }
          }
        }
    },
    async deleteFile(type, index=0){
      console.log('index', index)
      console.log('attachments', this.form.attachments)
      let file = type == 'attachment' ? this.form.image : this.form.attachments[index]
      await UploaderService.deleteSingleFile({
        file: file,
        path: this.uploaderFolder
      })
      .then(() => {
        if(type == 'attachment'){
          this.form.image = ''
          this.$refs.fileupload.value = ''
        } else {
          this.form.attachments = this.form.attachments.filter((obj, idx) => {
            return idx !== index
        })
        this.$refs.fileuploads.files = this.$refs.fileuploads.files.filter((obj, idx) => {
          return idx !== index
      })
        //this.$refs.fileuploads.files[index].name = ''
          console.log('bbb',this.$refs.fileuploads.files[index])
        }
        this.$toast.success(this.$t('admin.attachment_deleted_successfully'))
      })
      .catch(() => {})
    },
      submit () {
        this.submitted = true
        //const validData = this.$validator.validateAll()
       // console.log('validdata1', validData)
        this.$validator.validateAll().then(result => {
          if (!result) {
            console.log('validdata', result)
            this.submitted = false
            return
          }
          this.form.properties = this.properties.map((obj) => {
            return {
              property_id: obj.id,
              value: obj.value
            }
          })
          if (this.param_id) {
            this.update()
          } else {
            this.create()
          }
        });
        // if (validData) {
        //   this.form.properties = this.properties.map((obj) => {
        //     return {
        //       property_id: obj.id,
        //       value: obj.value
        //     }
        //   })
        //   if (this.param_id) {
        //     this.update()
        //   } else {
        //     this.create()
        //   }
        // }else{
        //   this.submitted = false
        // }
      },
      update () {
        ProductService.update(this.form, this.param_id)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.updated_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      create () {
        ProductService.create(this.form)
        .then(() => {
          this.back()
          this.$toast.success(this.$t('admin.created_successfully'))
        })
        .catch(() => {
          this.submitted = false
        })
      },
      back () {
        this.$router.push(this.localePath({ name: "stores-products" }))
      }
    },
  }
