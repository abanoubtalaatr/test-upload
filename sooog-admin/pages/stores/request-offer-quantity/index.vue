<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container">
        <div class="row">
          <div class="col-md-12 flex">

            <h3 class="mt-4">{{ $t('admin.request_offer_quantities_new') }}</h3>

            <p class="grey">{{ $t('admin.display_all_new_request_offer_quantities') }}</p>

            <a  v-if="requestOfferQuantities.length > 0" id="download_requests"
               class="btn mb-4 btn orange2 bg-dark text-white cursor-pointer" target="_blank"
               href="http://localhost:8000/api/store/request-offer-quantity/export-to-excel"
               download="proposed_file_name">{{ $t('admin.download_requests') }}</a>
            <div class="col-md-8 text-right mt-4" v-if="requestOfferQuantities.leading>0">
              <div class="row">
                <div class="col-6 col-md-3 padd-r-0">
                  <select class="form-control select-g" v-model="filter.orderType" @change="changeSort">
                    <option value="" selected disabled>{{ $t('admin.sort_by') }}</option>
                    <option v-for="(sort, key) in sorting" :key="key" :value="sort.key">
                      {{ sort.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <!--addresses-->
            <section class="acc-orders">
              <div class="table-responsive" v-if="requestOfferQuantities.length">
                <table class="table blue-t table-striped">
                  <tr>
                    <th>{{ $t('admin.operation_id') }}</th>
                    <th>{{ $t('admin.user_name') }}</th>
                    <th>{{ $t('admin.category') }}</th>
                    <th>{{ $t('admin.product_name') }}</th>
                    <th>{{ $t('admin.status') }}</th>
                    <th></th>
                  </tr>
                  <tr class="flex" v-for="(requestOffer, key) in requestOfferQuantities" :key="key">
                    <td>
                      <p class="text-dark">{{ `${requestOffer.id}A` }}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{ `${requestOffer.user.name}` }}</p>
                    </td>
                    <td>
                      <p class="text-dark">
                        {{ requestOffer.category.name }}
                      </p>
                    </td>
                    <td>
                      <p class="text-dark">{{ requestOffer.product_name }}</p>
                    </td>
                    <td>
                      <button class="border-0 p-2"
                              :class="`${requestOffer.status == 'Pending' ? 'bg-green-300 text-green-300' : (requestOffer.status == 'replied' ? 'text-cyan-400' : 'btn-confirm')}`">
                        {{ requestOffer.status }}
                      </button>
                    </td>
                    <td>
                      <nuxt-link :to="localePath(`/stores/request-offer-quantity/${requestOffer.id}`)" class="button btn-gredient" >
                        {{$t('admin.details')}}
                      </nuxt-link>
                    </td>
                  </tr>
                </table>
              </div>

              <div v-else class="text-center alert-div">
                {{ $t('admin.no_results') }}
              </div>

              <Pagination
                :pagination="meta"
                v-if="meta && meta.last_page != 1"
                @page-changed="onPageChange($event)"
                @prev-page="prevPage($event)"
                @next-page="nextPage($event)"
              />
            </section>

          </div>

        </div>
      </div>
    </client-only>
  </main>
  <!-- End Main Content-->
</template>

<script src="./index.js"></script>
