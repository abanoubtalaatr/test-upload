<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container" v-if="authUser">
        <div class="mr-30">
          <h3>
            {{authUser.name}}
          </h3>
        </div>
        <div class="row">

          <side-bar />
          <div class="col-md-8">

            <h3>{{$t('front.my_request_offer')}}</h3>

            <p class="grey">{{$t('front.display_all_my_request_offer')}}</p>
            <div class="col-md-8 text-right">
              <div class="row">
                <div class="col-6 col-md-3 padd-r-0">
                  <select class="form-control select-g" v-model="filter.orderType" @change="changeSort">
                    <option value="" selected disabled>{{$t('front.sort_by')}}</option>
                    <option v-for="(sort, key) in sorting" :key="key" :value="sort.key">
                      {{sort.name}}
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
                    <th>{{$t('front.operation_id')}}</th>
                    <th>{{$t('front.category')}}</th>
                    <th>{{$t('front.product_name')}}</th>
                    <th>{{$t('front.quantity')}}</th>
                    <th>{{$t('front.details')}}</th>
                    <th>{{$t('front.status')}}</th>
                    <th> </th>
                  </tr>
                  <tr v-for="(requestOffer, key) in requestOfferQuantities" :key="key">
                    <td>
                      <p class="text-dark">{{`${requestOffer.id}A`}}</p>
                    </td>
                    <td>
                      <p class="text-dark">
                        {{ requestOffer.category.name}}
                      </p>
                    </td>
                    <td>
                      <p class="text-dark">{{requestOffer.product_name}}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{requestOffer.amount}}</p>
                    </td>
                    <p class="w-75 text-break">{{requestOffer.details}}</p>
                    <td>
                      <button :class="`acc-btn ${requestOffer.status == 'waiting' ? 'btn-default' : (requestOffer.status == 'replied' ? 'btn-del' : 'btn-confirm')}`">
                        {{requestOffer.status}}
                      </button>
                    </td>
                    <td>
                      <nuxt-link :to="localePath(`/request-offer-quantity/${requestOffer.id}`)" class="orange2" >
                      {{$t('front.details')}}
                    </nuxt-link></td>
                  </tr>
                </table>
              </div>

              <div v-else class="text-center alert-div">
                {{$t('front.no_results')}}
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
