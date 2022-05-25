import {mapState} from 'vuex'
import StoreService from "~/services/stores/StoreService.js"
import StateService from "~/services/location/StateService.js"
import CityService from "~/services/location/CityService.js"
import OrderService from "~/services/orders/OrderService.js"
import UploaderService from '~/services/uploader/UploaderService.js'
import _ from "lodash";

export default {
  components: {},
  props: {
    countries:{
      required: true
    },
      packages:{
      required: true
    }
  },
  data() {
    return {
      uploaderFolder: 'stores',
      titlePage: this.$t('front.register'),
      states: [],
      cities: [],
        stepper: 0,
      form:{
        phone: null,
        username: null,
        email: null,
        state_id: '',
        city_id: '',
        country_id: '',
        ar:{name:''},
        en:{name:''},
        type: this.$route.path == this.localePath('stores-auth-register') ? 'stores' : 'centers',
        latitude: '24.69721690000003',
        longitude: '46.68350619999999',
        commercial_registry_photo:'',
        commercial_registry_no:null,
        bank_name:null,
        iban_no:null,
        swift_code:null,
        bank_account_no:null,
        image: '',
          package_id:'',
          payment_method_id:'',
        // send_type: 'sms',
      },
        online_methods: [],
        online_payment: false,
        image_required: true,
        commerical_required: true,
      uniqueId: this.uniqueID(),
      position: { lat:24.69721690000003, lng:46.68350619999999 },
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    }),
  },
  created () {
      if(this.authUser){
          this.form.username=this.authUser.name;
          this.form.phone=this.authUser.phone;
          this.form.email=this.authUser.email;
          // this.form.image=this.authUser.avatar;
      }
      if(this.form.commercial_registry_photo){
          this.commerical_required=false;
      }
      if(this.form.image){
          this.image_required=false;
      }

    console.log('roue', this.$route, this.localePath('stores-auth-register'));
  },
  methods: {
      changePackage(item){
        if(item.is_free){
            this.online_payment=false;
        }else{
            this.online_payment=true;
        }
      },
    async changeCountry (value) {
      // reset state id
      this.form.state_id = ''
      // get states of selected country
      await StateService.getAll(value)
        .then((response) => {
          this.states = response
        })
        .catch(() => {})
    },
    async changeState (value) {
      // reset city id
      this.form.city_id = ''
      // get states of selected country
      await CityService.getAll(value)
        .then((response) => {
          this.cities = response
        })
        .catch(() => {})
    },
    resetFile(type) {
      if (type == 'profile') {
        this.form.image = ''
        this.$refs.profile.value = null
      } else {
        this.form.commercial_registry_photo = ''
        this.$refs.commercial.value = null
      }
      this.uniqueId = this.uniqueID()
    },
    async handleUploadFile (e, type) {
      if (e.target.files.length) {
        // if (this.form.commercial_registry_photo != '') {
        //   await this.handleDeleteFile(this.form.commercial_registry_photo, this.uploaderFolder)
        // }
        if (!this.supportedImgTypes.includes(e.target.files[0].type)) {
          this.resetFile(type)
          this.$toast.error(this.$t('front.unsupported_file_type'))
          return
        }
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            if (type == 'profile') {
              this.form.image = response.file;
                this.image_required=false;
            } else {
              this.form.commercial_registry_photo = response.file;
              this.commerical_required=false;
            }
            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
          })
          .catch(() => {})
      }
    },
    handleMap (event) {
      let lng = event.latLng.lng();
      let lat = event.latLng.lat();
      this.position = { lat: lat, lng: lng };
      this.form.latitude = lat.toString();
      this.form.longitude = lng.toString()
    },
    async submit () {
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
      const validData = await this.$validator.validateAll()
      if (validData) {
        this.stepper=1;
        // this.register()
      }
    },
      async send(){
          const validData = await this.$validator.validateAll()
          if (validData) {
              if(this.online_payment){
                  this.getOnlineMethods();
                  this.stepper=2;
              }else{
                  this.register();
              }
          }
      },
      async pay(){
          const validData = await this.$validator.validateAll()
          if (validData) {
              this.register();
          }
      },
      prevStep(){
          this.stepper=0;
      },

      async getOnlineMethods () {
          this.$nuxt.$loading.start()
          await OrderService.allOnlineMethods()
              .then((response) => {
                  this.online_methods = response;
              })
              .catch(() => {})
          this.$nuxt.$loading.finish()
      },
    register () {
      StoreService.register(this.form)
        .then((res) => {
            if (res.payment_url) {
                window.location.replace(res.payment_url);
            } else {
                this.$router.push(this.localePath({name: "index"}))
                this.$toast.success(this.$t('front.store_reg_message'))
            }
        })
        .catch(() => {});
      this.$nuxt.$loading.finish();
    },
  },

  head() {
    return {
      title: this.titlePage
    }
  }
}
;
