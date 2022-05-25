<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container" v-if="authUser">
        <div class="mr-30">
          <h3>
            {{ authUser.name }}
          </h3>
        </div>
        <div class="row">

          <side-bar/>
          <AcceptRequestOfferQuantity :myId.sync="idReply" :index.sync="idOfReplyIsUpdated"
                                      @accepted-reply="accepted"></AcceptRequestOfferQuantity>

          <preview-image :file.sync="fileSrc" :type.sync="typeOfFile"></preview-image>
          <div class="col-md-8">
            <!--addresses-->
            <section class="profile">

              <h3>{{ $t('front.request_offer_details') }}</h3>

              <div class="row">
                <div class="col-md-8">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>{{ $t('front.category') }}</th>
                        <th>{{ $t('front.product_name') }}</th>
                        <th>{{ $t('front.image') }}</th>
                        <th>{{ $t('front.quantity') }}</th>
                        <th>{{ $t('front.details') }}</th>
                        <th></th>
                      </tr>
                      <tr>
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

                        <td class="w-50 text-break">
                          <p class="text-dark">{{ requestOfferQuantity.details }}</p>
                        </td>

                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <h3>{{ $t('front.request_offer_replies') }}</h3>
              <div class="row" v-if="!replies.length==0">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>{{ $t('front.store_name') }}</th>
                        <th>{{ $t('front.by_day') }}</th>
                        <th>{{ $t('front.offer_price') }}</th>
                        <th>{{ $t('front.status') }}</th>
                        <th>{{ $t('front.invoice') }}</th>
                        <th></th>
                      </tr>
                      <tr v-for="(reply,index) in replies">
                        <td>
                          <p class="text-dark">{{ reply.store.name }}</p>
                        </td>

                        <td>
                          <p class="text-dark">{{ reply.created_at }}</p>
                        </td>

                        <td>
                          <p class="text-dark">{{ reply.offer_price }}</p>
                        </td>

                        <td>
                          <button
                              :class="`acc-btn ${reply.status == 'waiting' ? 'btn-default' : (reply.status == 'replied' ? 'btn-del' : 'btn-confirm')}`">
                            {{ reply.status }}
                          </button>
                        </td>

                        <td>
                          <button class="bg-0 border-0 width-50 bg-transparent"
                                  v-b-modal.modal-preview-image
                                  @click="setPreviewFile(reply.invoice)">
                            <img class="custom-image rounded" :src="reply.invoice">
                          </button>
                        </td>

                        <td v-if="(reply.status !='Rejected')">
                          <div v-if="(reply.status !='Accepted')">
                            <button @click="rejectRequestOffer(reply.id)"
                                    class="acc-btn border-0 orange2 cursor-pointer px-3 py-2">
                              {{ $t('front.reject') }}
                            </button>

                            <button data-toggle="modal" class="acc-btn border-0 btn-confirm cursor-pointer px-3 py-2"
                                    @click="setReplyId(reply.id, index)" data-target="#modal-accept-reply-request-offer">
                              {{ $t('front.accept') }}
                            </button>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <Pagination
                      :pagination="meta"
                      v-if="meta && meta.last_page != 1"
                      @page-changed="onPageChange($event)"
                      @prev-page="prevPage($event)"
                      @next-page="nextPage($event)"
                  />
                </div>
              </div>
              <div v-if="replies.length==0" class="text-center alert-div">
                {{ $t('front.no_results') }}
              </div>
            </section>
          </div>
        </div>
      </div>
    </client-only>
  </main>
  <!-- End Main Content-->
</template>
<style>
.modal-footer, .modal-header{
  display: none;
}
</style>
<script src="./index.js"></script>
