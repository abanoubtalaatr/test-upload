<template>
  <!-- Main Content-->
  <main class="main-content">
    <client-only>
      <div class="container">
        <div class="row">
          <div class="col-md-12 flex">

            <h3 class="mt-4">{{$t('admin.requests')}} {{$t('admin.'+this.filter.status)}}</h3>
            <!--addresses-->
            <div class="col-md-8 text-right mt-4">
              <div class="row">
                <div class="col-6 col-md-3 padd-r-0">
                  <select class="form-control select-g" v-model="filter.status" @change="changeSelect">
                    <option value="" selected disabled>{{$t('admin.sort_by')}}</option>
                    <option v-for="(status, key) in statuses" :key="key" :value="status.by">
                      {{status.name}}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <section class="acc-orders mt-4">
              <div class="table-responsive" v-if="replies.length">
                <table class="table blue-t table-striped">
                  <tr>
                    <th>{{$t('admin.operation_id')}}</th>
                    <th>{{$t('admin.user_name')}}</th>
                    <th>{{$t('admin.category')}}</th>
                    <th>{{$t('admin.product_name')}}</th>
                    <th>{{$t('admin.details')}}</th>
                    <th> </th>
                  </tr>
                  <tr class="flex" v-for="(reply, key) in replies" :key="key">
                    <td>
                      <p class="text-dark">{{`${reply.id}A`}}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{`${reply.user.name}`}}</p>
                    </td>
                    <td>
                      <p class="text-dark">
                        {{ reply.category.name}}
                      </p>
                    </td>
                    <td>
                      <p class="text-dark">{{reply.request_offer_quantity.product_name}}</p>
                    </td>
                    <td>
                      <p class="text-dark">{{reply.request_offer_quantity.details}}</p>
                    </td>
                    <td>
                      <nuxt-link :to="localePath(`/stores/request-offer-quantity/replies/${reply.id}`)" class="button btn-gredient" >
                        {{$t('admin.details')}}
                      </nuxt-link>
                    </td>
                  </tr>
                </table>
              </div>

              <div v-else class="text-center alert-div">
                {{$t('admin.no_results')}}
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
