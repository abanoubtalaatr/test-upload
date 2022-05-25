<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container">
        <div class="row">
          <div class="col-md-12 flex">
            <CreateReplyRequestOfferQuantity
              :request_offer_id.sync="idRequestOfferQuantity"></CreateReplyRequestOfferQuantity>
            <h3 class="mt-4">{{ $t('admin.request_offer_quantity_details') }}</h3>
            <preview-image :file.sync="fileSrc" :type.sync="typeOfFile"></preview-image>
            <!--addresses-->
            <section class="acc-orders mt-4">
              <div class="table-responsive">
                <table class="table blue-t table-striped">
                  <tr>
                    <th>{{ $t('admin.category') }}</th>
                    <th>{{ $t('admin.product_name') }}</th>
                    <th>{{ $t('admin.image') }}</th>
                    <th>{{ $t('admin.quantity') }}</th>
                    <th>{{ $t('admin.details') }}</th>
                    <th></th>
                  </tr>
                  <tr class="flex">
                    <td>
                      <p class="text-dark">{{ requestOfferQuantity.category.name }}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{ requestOfferQuantity.product_name }}</p>
                    </td>
                    <td>
                      <button class="bg-0 border-0 width-50 bg-transparent"
                              v-b-modal.modal-preview-image
                              @click="setPreviewFile(requestOfferQuantity.image)">
                        <img class="custom-image rounded" :src="requestOfferQuantity.image">
                      </button>
                    </td>
                    <td>
                      <p class="text-dark">{{ requestOfferQuantity.amount }}</p>
                    </td>
                    <td>
                      <p>{{ requestOfferQuantity.details }}</p>
                    </td>
                    <td>
                      <button v-if="!requestOfferQuantity.auth_user_replied_before" class="button btn-gredient" v-b-modal.modal-1
                                @click="setIdRequestOfferQuantity(requestOfferQuantity.id)">{{
                          $t('admin.offer_price')
                        }}
                      </button>
                    </td>
                  </tr>
                </table>
              </div>
            </section>
          </div>
        </div>
      </div>
    </client-only>
  </main>
  <!-- End Main Content-->
</template>

<script src="./index.js"></script>
<style>
.width-50 {
  height: 50px;
  width: 50px;
}
</style>
