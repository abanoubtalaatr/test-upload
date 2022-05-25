import moment from 'moment'
import UploaderService from '@/pages/dashboard/uploaders/service/UploaderService'

export default {
    data () {
      return {
        isModalActive: false,
        trashObjectId: null,
        supportedImgTypes: [
          'image/jpeg',
          'image/jpg',
          'image/png'
        ],
        supportedPdfTypes: [
          'application/pdf'
        ]
        // centerPermissions : this.$cookies.get('centerPermissions') || [],
      }
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
    }
  };

