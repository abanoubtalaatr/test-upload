import { mapState } from 'vuex'
import VuePhoneNumberInput from 'vue-phone-number-input'
import 'vue-phone-number-input/dist/vue-phone-number-input.css'
import ProfileService from "~/services/profile/ProfileService.js"
import CountryService from "~/services/location/CountryService.js"
import SideBar from '~/components/front/SideBar.vue';
import UploaderService from '~/services/uploader/UploaderService.js'
import ActivationModal from "~/pages/register/-modal/-activation/-index.vue"
import _ from 'lodash'
import { mapValues } from 'lodash'

export default {
  middleware: ['auth'],
  components: {
    VuePhoneNumberInput,
    SideBar,
    ActivationModal
  },
  data () {
    return {
      titlePage: this.$t('front.profile'),
      uploaderFolder: 'users/avatar',
      uniqueId: this.uniqueID(),
      translations: {
        countrySelectorLabel: this.$t('front.country_code'),
        // countrySelectorError: 'Choisir un pays',
        phoneNumberLabel: this.$t('front.phone'),
        // example: 'Exemple :'
      },
      stepper: 0,
      form: _.pick(this.cloneItem(this.$store.state.localStorage.authUser), [
        'name', 'phone', 'email', 'country_code', 'avatar'
      ]),
      countries: [],
      payload: {
        old_password: null,
        new_password: null,
        new_password_confirmation: null
      },
      customEvents: [
        { eventName: 'handle-update-phone', callback: this.handleUpdatePhone },
      ]
    }
  },
  created () {
    this.getCountries()
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  beforeDestroy () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      authUser: state => state.localStorage.authUser,
    })
  },
  methods: {
    updatePhoneNumber (value) {
      this.phoneData = value
      this.form.country_code = value.countryCallingCode
      this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
    },
    handleForm () {
      this.form = _.pick(this.cloneItem(this.authUser), [
        'name', 'phone', 'email', 'country_code', 'avatar'
      ])
    },
    updateStep(step) {
      this.handleForm()
      this.stepper = step
    },
    getCountries () {
      CountryService.getAll('?is_paginated=0')
      .then((res) => {
        this.countries = res
        })
        .catch(() => {});
    },
    resetStep () {
      this.stepper = 0
      this.handleReset()
    },
    handleUpdatePhone (phone) {
      debugger
      this.stepper = 0
    },
    resetFile() {
      this.form.avatar = this.authUser.avatar
      this.$refs.profile.value = null
      this.uniqueId = this.uniqueID()
    },
    handlePhoneNumber () {
      if (this.form.phone.startsWith("0") || this.form.phone.startsWith("٠")) {
        this.form.phone = this.form.phone.substring(1)
      }
    },
    async handleUploadFile (e) {
      if (e.target.files.length) {
        if (this.form.avatar != '') {
          await this.handleDeleteFile(this.form.avatar, this.uploaderFolder)
        }
        if (!this.supportedImgTypes.includes(e.target.files[0].type)) {
          this.resetFile()
          this.$toast.error(this.$t('front.unsupported_file_type'))
          return
        }
        await UploaderService.uploadSingleFile({
          file: e.target.files[0],
          path: this.uploaderFolder
        })
          .then((response) => {
            this.form.avatar = response.file
            this.$toast.success(this.$t('admin.attachment_uploaded_successfully'))
          })
          .catch(() => {})
      }
    },
    async submit () {
      // this.form.phone = this.form.phone ? this.form.phone.replace(/\s+/g, '') : null
      const validData = await this.$validator.validateAll()

      if (validData) {
        if (this.stepper != 3) {
          if (this.stepper == 2) {
            // check on phone same value
            if (this.form.phone == this.authUser.phone) {
              this.$toast.error(this.$t('front.error_same_phone'))
              return
            }
          }
          this.updateProfile()
        } else if (this.stepper == 3) {
          this.updatePassword()
        }
      }
    },
    updateProfile () {
      ProfileService.updateProfile(this.form)
        .then((res) => {
          if (this.stepper == 1) {
            this.stepper = 0
            this.$store.commit("localStorage/SET_AUTH_USER", res)
            this.$toast.success(this.$t('front.updated_successfully'))
          } else {
            this.stepper = 4 // activation phone
          }
          })
          .catch(() => {});
        this.$nuxt.$loading.finish();
    },
    updatePassword () {
      ProfileService.updatePassword(this.payload)
        .then((res) => {
          this.stepper = 0
          this.handleReset()
          this.$toast.success(this.$t('front.updated_successfully'))
          })
          .catch(() => {});
        this.$nuxt.$loading.finish();
    },
    handleReset() {
      this.payload = mapValues(this.payload, (item) => {
        if (item && (typeof item === 'object' || Array.isArray(item))) {
          return []
        }
        return ''
      })
      this.$validator.reset()
    }
  },
  head () {
    return {
      title: this.titlePage
    }
  }
}
