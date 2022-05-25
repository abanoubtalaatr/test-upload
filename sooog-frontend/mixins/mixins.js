import moment from 'moment'
import { mapState } from 'vuex'
import UploaderService from '~/services/uploader/UploaderService.js'
import LoginService from "~/services/auth/LoginService.js"

export default {
    data () {
      return {
        isModalActive: false,
        trashObjectId: null,
        notifyToken: null,
        supportedImgTypes: [
          'image/jpeg',
          'image/jpg',
          'image/png'
        ],
        supportedPdfTypes: [
          'application/pdf'
        ]
      }
    },
    computed: {
      ...mapState({
        currentLocale: state => state.localStorage.currentLocale,
      })
    },
    methods: {
      uniqueID () {
        return '_' + Math.random().toString(36).substr(2, 9)
      },
      cloneItem (obj) {
        return JSON.parse(JSON.stringify(obj))
      },
      transMonths() {
        let months = []
        moment.localeData('en').months().forEach((element, index) => {
          months.push({
            key: element,
            en: { name: element },
            ar: { name: moment(index + 1, 'MM').locale('ar').format('MMMM')}
          })
        });
        return months
      },
      transDays () {
        let days = []
        moment.localeData('en').weekdays().forEach((element, index) => {
          days.push({
            key: element,
            en: { name: element },
            ar: { name: moment(index, 'd').locale('ar').format('dddd')}
          })
        });
        return days
      },
      async handleDeleteFile (filePath, folderName) {
        await UploaderService.deleteSingleFile({
          file: filePath.split('/').pop(),
          path: folderName
        })
      },
      switchMyLang(locale) {
        this.$nuxt.$loading.start()
        this.$store.commit(
          "localStorage/SET_CURRENT_LOCALE",
          locale
        );
        // fetch new locale file
        import(`~/locales/${locale}`).then((module) => {
          // this.$i18n.locale = locale
          // set new messages from new locale file
          this.$i18n.setLocaleMessage(locale, module.default);
          // update url to point to new path, without reloading the page
          window.history.replaceState("", "", this.switchLocalePath(locale));

          // setTimeout(() => {
            this.$nuxt.$router.go()
          // }, 1000);
        });
      },
      trashModal (trashObjectId) {
        this.trashObjectId = trashObjectId
        this.isModalActive = true
        this.$EventBus.$emit('open-delete-modal')
      },
      trashConfirm (event) {
        debugger
        // call api to delete
        this.$EventBus.$emit(event, this.trashObjectId)
        this.trashCancel();
        this.isModalActive = false
      },
      trashCancel () {
        this.isModalActive = false
        this.$EventBus.$emit('close-delete-modal')
      },
      deactivateModal (id) {
        this.$EventBus.$emit('open-deactivate-modal', id)
      },
      async login (form) {
        await this.getDeviceToken()
        this.$store.commit("localStorage/SET_FIREBASE_TOKEN", this.notifyToken);
        this.$nuxt.$loading.start()

        await LoginService.login({...form, ...{device_token: this.notifyToken}})
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
              this.$toast.success(this.$t('front.logged_in_successfully'))
              this.$EventBus.$emit('load-notification')
              this.$router.replace(this.localePath('index'))
            })
            .catch((err) => {
              if (err.is_active === false) {
                if (this.$route.name != `login___${this.currentLocale}`) {
                  // when login from modal in header
                  this.$router.replace(this.localePath('login'))
                  setTimeout(() => {
                    this.$EventBus.$emit('display-activation-modal', form)
                  }, 500);
                }
              debugger
                this.$EventBus.$emit('display-activation-modal')
              }
            });
          this.$nuxt.$loading.finish();
      },
      async getDeviceToken() {
        const messaging = this.$fire.messaging;
        await messaging.getToken()
          .then(() => {
            return messaging.getToken()
          })
          .then((currentToken) => {
            if (currentToken) {
              this.notifyToken = currentToken
              return currentToken
            }
          })
          .catch((err) => {
            console.log('Error occured', err)
          })
      },
    },
  };

