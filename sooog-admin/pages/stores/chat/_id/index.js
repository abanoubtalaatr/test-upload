import {mapState} from 'vuex';
import AuthService from "~/pages/stores/auth/service/AuthService.js";
import ChatService from "~/pages/stores/auth/service/ChatService.js";
import UploaderService from '@/pages/stores/uploaders/service/UploaderService'
import {mapValues} from 'lodash';

export default {
  layout: 'store',
  validate ({ params }) {
    if (params.id) {
      return !isNaN(params.id)
    }
    return true
  },
  async asyncData(context) {
    const response = await Promise.all([
      context.$axios.$get(`/store/chats/${context.params.id}`).catch(() => {}),
      context.$axios.$get(`/store/chats`).catch(() => {}),
    ])
    return { chat:response[0],
      chats:response[1],
      msgs:response[0].messages,
    }
  },

  data() {
    return {
      titlePage: this.$t('admin.chat'),
      uploaderFolder: 'chat',
      storeUploaderFolder: 'stores',
      store_id: '',
      form: {
        message: '',
        message_type: 'text',
        chat_id: '',
      },
      submitted: false,
    }
  },
  created() {
    if(this.chat){
      this.chat_id=this.chat.id;
    }
    if (this.storeData) {
      // this.messiging();
      this.form.sender_id =this.storeData.id;
      this.store_id=this.storeData.id;
    }
  },
  fetchOnServer: true,
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      storeData: state => JSON.parse(state.localStorage.storeData),
      firebaseToken: state => state.localStorage.storeFirebaseToken,
    }),
    titleStack() {
      return [this.$t('admin.chat')]
    }
  },
  methods: {
    // messiging() {
    //   const messaging = this.$fire.messaging;
    //   debugger
    //   messaging.onMessage((payload) => {
    //     // debugger
    //     console.log('payload', JSON.parse(payload.data.notification));
    //     // fire event to load data
    //     this.msgs.unshift({
    //       data: JSON.parse(payload.data.notification).message,
    //       // created_at: this.currentDate
    //     })
    //     // debugger
    //     // if (this.chats.length >= 3) {
    //     //   this.chats.pop()
    //     // }
    //     let audio=require("@/assets/notification.mp3").default;
    //     let beeb = new Audio(audio);
    //     beeb.play();
    //   })
    // },
    async handleUploadFile(e, name) {
      this.submitted = true
      if (e.target.files.length) {
        var imageExt = ['png', 'jpg', 'jpeg', 'svg', 'gif'];
        var extension = e.target.files[0].name.split('.').pop().toLowerCase();

        if (!imageExt.includes(extension)) {
          this.$toast.error(this.$t('admin.unsupported_image_format'));
          if (name == 'avatar')
            this.user.avatar = '';
          else
            this.user.image = '';
          this.submitted = false;
          return false;
        } else {
          if (this.user.avatar != '' && name == 'avatar') {
            await this.handleDeleteFile(this.user.avatar, this.uploaderFolder)
          }

          // if (this.user.image != '' && name == 'image') {
          //   await this.handleDeleteFile(this.user.image, this.storeUploaderFolder)
          // }

          let path = this.uploaderFolder
          if (name == 'image')
            path = this.storeUploaderFolder
          await UploaderService.uploadSingleFile({
            file: e.target.files[0],
            path: path
          })
            .then((response) => {
              if (name == 'avatar')
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
    async handleDeleteFile(filePath, folderName) {
      await UploaderService.deleteSingleFile({
        file: filePath.split('/').pop(),
        path: folderName
      })
    },
    sendMessage()
    {
      if(this.form.message){

      }
    }
  },
}
