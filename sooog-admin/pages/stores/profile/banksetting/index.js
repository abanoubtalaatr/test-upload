import {mapState} from 'vuex'
import AuthService from "~/pages/stores/auth/service/AuthService.js";
import {mapValues} from 'lodash';

export default {
  layout: 'store',
  async asyncData(context) {
    const [countries] = await Promise.all([
      context.$axios.$get('/store/location/countries?is_paginated=0').catch(() => {
      }),
    ])
    return {countries}
  },
  data() {
    return {
      titlePage: this.$t('admin.profile'),
      user: {
        iban_no: '',
        swift_code: '',
        bank_name: '',
        bank_user_name: '',
        bank_account_no: '',
        bank_country_id: '',
        bank_type: '',
      },
      updateData:{},
      submitted: false,
      bank_types: ['local', 'global']
    }
  },
  created() {
    if (this.storeData) {
      AuthService.getProfile(this.storeData.store_id)
        .then((response) => {
          this.user = {
            iban_no: response.iban,
            swift_code: response.swift_code,
            bank_name: response.bank_name,
            bank_account_no: response.bank_account_no,
            bank_user_name: response.bank_user_name,
            bank_country_id: response.bank_country_id ? response.bank_country_id : '',
            bank_type: response.bank_type ? response.bank_type : 'local',
          }
        })
        .catch(() => {
        })

    }
  },
  fetchOnServer: true,
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      storeData: state => JSON.parse(state.localStorage.storeData),
    }),
    titleStack() {
      return [this.$t('admin.profile')]
    }
  },
  methods: {
    async updateProfile() {
      this.submitted = true
      const validData = await this.$validator.validateAll('profile')
      if (validData) {
        if (this.user.bank_type == 'local') {
           this.updateData = {
            iban_no: this.user.iban_no,
            bank_name: this.user.bank_name,
            bank_user_name: this.user.bank_user_name,
            bank_account_no: this.user.bank_account_no,
            bank_type: this.user.bank_type,
          }
        } else {
           this.updateData = {
            swift_code: this.user.swift_code,
            bank_name: this.user.bank_name,
            bank_user_name: this.user.bank_user_name,
            bank_country_id: this.user.bank_country_id,
            bank_type: this.user.bank_type,
          }
        }

        AuthService.updateBankData(this.updateData)
          .then((res) => {
            this.$toast.success(this.$t('admin.updated_successfully'))
            this.submitted = false
          })
          .catch(() => {
            this.submitted = false
          })
      } else {
        this.submitted = false
      }
    }
    ,
    handleReset() {
      this.form = mapValues(this.form, (item) => {
        if (item && (typeof item === 'object' || Array.isArray(item))) {
          return []
        }
        return null
      })
      this.$validator.reset()
    }
    ,
  },
}
