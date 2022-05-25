<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container">
        <div class="row">
          <div class="col-md-12 flex">
            <h3 class="mt-4">{{ $t('admin.details_reply') }}</h3>
            <EditReplyRequestOfferQuantity :id_reply.sync="idReplyRequestOfferQuantity" :invoice.sync="reply.invoice"
                                           :offer_price.sync="reply.offer_price"></EditReplyRequestOfferQuantity>

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
                    <th>{{ $t('admin.status') }}</th>
                    <th>{{ $t('admin.offer_price') }}</th>
                    <th>{{ $t('admin.invoice') }}</th>
                    <th></th>
                  </tr>
                  <tr class="flex">
                    <td>
                      <p class="text-dark">{{ reply.category.name }}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{ reply.request_offer_quantity.product_name }}</p>
                    </td>
                    <td>
                      <button class="bg-0 border-0 width-50 bg-transparent"
                                v-b-modal.modal-preview-image
                                @click="setPreviewFile(reply.request_offer_quantity.image)">
                        <img class="custom-image rounded" :src="reply.request_offer_quantity.image">
                      </button>
                    </td>

                    <td>
                      <p class="text-dark">{{ reply.request_offer_quantity.amount }}</p>
                    </td>

                    <td>
                      <p class="text-dark">{{ reply.request_offer_quantity.details }}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{ reply.status }}</p>
                    </td>
                    <td>
                      <p>{{ reply.offer_price }}</p>
                    </td>
                    <td>
                      <button class="bg-0 border-0 width-50 bg-transparent"
                              v-b-modal.modal-preview-image
                              @click="setPreviewFile(reply.invoice)">
                        <img class="custom-image rounded"
                             :src="reply.invoice">
                      </button>
                    </td>
                    <td>
                      <button v-if="reply.can_edit_reply" class="button btn-gredient"
                                v-b-modal.modal-edit-reply-request-offer-quantity
                                @click="setIdReplyRequestOfferQuantity(reply.id)">
                        {{ $t('admin.edit_reply_request_offer_quantity') }}
                      </button>
                      <button v-if="reply.can_delivery" class="bg-success"
                              @click="deliveryReplyRequestOfferQuantity(reply.request_offer_quantity.id)">
                        {{ $t('admin.delivery_reply_request_offer_quantity') }}
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
.custom-image {
  height: 70px;
  width: 70px;
}
</style>
