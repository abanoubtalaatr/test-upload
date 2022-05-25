<template>
  <div class="div modal show" id="modal-order">
    <div class="modal-dialog">
      <div class="modal-content">
        <button class="close" type="button" @click="resetForm()" data-dismiss="modal" id="closeCreateRequest"
                aria-label="Close"><span>&times;</span></button>
        <div class="modal-body">
          <h3>{{ $t('front.request_price') }}</h3>
          <label>{{ $t('front.category') }}</label>
          <select class="form-control login-input" v-model="requestOfferQuantity.category_id" required>
            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
          </select>
          <input class="form-control login-input" required v-model="requestOfferQuantity.product_name" type="text"
                 :placeholder="$t('front.product_name')">
          <div class="custom-file-upload">
            <input type="file" ref="file" @change="handleImage()">
            <img v-show="!showUploadImage" src="" id="createOfferRequestImage"
                 class="w-25 h-25" alt="">
            <img v-show="showUploadImage" src="~/assets/website/imgs/account/upload.svg" class="w-25 h-25" alt="">
            <span>{{ $t('admin.image') }}</span>
          </div>
          <input class="form-control login-input" v-model="requestOfferQuantity.amount" type="number"
                 :placeholder="$t('front.quantity')">

          <textarea class="form-control login-input" rows="5" v-model="requestOfferQuantity.details"
                    :placeholder="$t('front.product_details')"></textarea>
          <div class="text-center">
            <button @click="sendRequestOffer()" class="button btn-gredient big">
              <img class="mx-2" src="~/assets/website/imgs/home/arrow-w.svg" alt="">
              {{ $t('front.send') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  async created() {
    await this.$axios.get('categories?type=stores').then(response => {
      this.categories = response.data;
    });
  },

  data() {
    return {
      categories: {},
      requestOfferQuantity: {
        product_name: '',
        category_id: '',
        amount: '',
        details: '',
        image: '',
      },
      showUploadImage: true
    }
  },
  methods: {
    async sendRequestOffer() {
      let formData = new FormData();
      formData.append('image', this.requestOfferQuantity.image)

      _.each(this.requestOfferQuantity, (value, key) => {
        formData.append(key, value)
      })

      this.$nuxt.$loading.start();
      await this.$axios.post('request-offer-quantity', formData).then(response => {
        this.$toast.success(this.$t('front.added_successfully'));
        this.requestOfferQuantity = {};
        this.requestOfferQuantity.image = '';
        this.showUploadImage = true;
        document.getElementById('createOfferRequestImage').src = '';
        document.getElementById('closeCreateRequest').click();

      }).catch(error => {
      });
      this.$nuxt.$loading.finish();
    },
    handleImage(e) {
      this.showUploadImage = false;
      let file = this.$refs.file.files[0];
      this.requestOfferQuantity.image = file;
      document.getElementById('createOfferRequestImage').src = URL.createObjectURL(file);
    },
    resetForm() {
      this.requestOfferQuantity = {};
      this.showUploadImage = true;
    }
  },
}
</script>

<style scoped>

</style>