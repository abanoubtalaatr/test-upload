import { mapState } from 'vuex'
import _ from 'lodash'
import RegisterService from '@/services/auth/RegisterService'
import ProfileService from "~/services/profile/ProfileService.js"

export default {
  props: {
    type: {
        type: String,
        default: null,
        required: true
    },
      send_type: {
        type: String,
        default: 'sms',
        required: true
    },
    phone: {
        type: String,
        default: null,
        required: false
    },
      email: {
        type: String,
        default: null,
        required: true
    },
    country_code: {
        type: String,
        default: null,
        required: false
    },
  },
  data () {
    return {
        requiredCells: _.range(0, 4),
        activationCells: [],
        form: {
            phone: this.phone,
            email: this.email,
            send_type: this.send_type,
            code: null,
            country_code: this.country_code,
          },
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  methods: {
    inputActivationCode (value, index) {
        this.$set(this.activationCells, index, value)
        //* check on next cell to focus */
        debugger
        if (this.currentLocale == 'en') {
          if (this.$refs.codeRef[index + 1] != null) {
            this.$refs.codeRef[index + 1].focus()
          }
        } else {
          if (this.$refs.codeRef[index - 1] != null) {
            this.$refs.codeRef[index - 1].focus()
          }
        }
        debugger
    },
     formData(){
         if(this.form.send_type=='email'){
           return { email: `${this.form.email}`,
           send_type:`${this.form.send_type}`
           };
         }else{
             return { 
                 country_code: `${this.form.country_code}`,
                 phone: `${this.form.phone}`,
                 send_type:`${this.form.send_type}`
             };
         }
     },
    async resendCode () {
        this.$nuxt.$loading.start()
        await RegisterService.resendCode(this.formData())
        .then((response) => {
            this.$toast.success(response.message)
        })
        .catch(() => {})
        this.$nuxt.$loading.finish()
    },
    async verifyCode () {
        const validData = await this.$validator.validateAll()

        if (validData) {
            let cells = this.cloneItem(this.activationCells)
            // check on arabic language to reverse code, it's added from max index to min
            if (this.currentLocale == 'ar') {
            this.form.code = cells.reverse().join("") // reverse array then convert it to string code
            } else {
            this.form.code = cells.join('') // convert array to string
            }
            this.$nuxt.$loading.start()
            if (this.type === 'verify') {
                await RegisterService.verifyPasswordCode({
                    token: this.form.code,
                    phone: `${this.form.phone}`,
                    country_code: `${this.form.country_code}`,
                    email: `${this.form.email}`,
                    send_type:`${this.form.send_type}`
                })
                .then((response) => {
                    this.$EventBus.$emit('handle-code-event', this.form.code)
                })
                .catch(() => {})
            } else if (this.type === 'activate') {
            // this.$set(this.form, 'code', this.form.token)
                await this.getDeviceToken()
                debugger
                this.$store.commit("localStorage/SET_FIREBASE_TOKEN", this.notifyToken);
        
                await RegisterService.activateRegisterCode({...this.form, ...{device_token: this.notifyToken}})
                    .then((res) => {
                        let token = `${res.token_type} ${res.access_token}`
                        // for client side rendering
                        this.$store.commit("localStorage/SET_ACCESS_TOKEN", token);
                        this.$store.commit("localStorage/SET_ROLE", 'client');
                        this.$store.commit(
                        "localStorage/SET_AUTH_USER",
                        {...(({addresses, ...rest} = res.user) => (rest))()}
                        );
                        // for ssr rendering
                        const options = { path: '/', maxAge: 60 * 60 * 24 * 7 }

                        this.$cookies.setAll([
                            {name: 'accessToken', value: token, opts: options},
                            {name: 'role', value: 'client', opts: options},
                        ])
                        this.$EventBus.$emit('load-notification')
                        this.$router.push(this.localePath('index'))
                    })
                    .catch(() => {})
            } else {
                debugger
                //* update phone from profile */
                await ProfileService.verifyUpdatedPhone(this.form)
                .then((response) => {
                    debugger
                    this.$store.commit(
                        "localStorage/SET_AUTH_USER",
                        {...(({addresses, ...rest} = response) => (rest))()}
                    );
                    this.$EventBus.$emit('handle-update-phone', response.phone)
                    this.$toast.success(this.$t('front.updated_successfully'))
                })
                .catch(() => {})
            }
            this.$nuxt.$loading.finish()
        }
    }
  }
}
