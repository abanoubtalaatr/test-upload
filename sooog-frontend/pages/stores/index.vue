<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--brands-->
      <section class="centers">
        <div class="container">
          <div class="custom-padd">
            <h3>{{$t('front.stores')}}</h3>
          </div>
          <div class="row" v-if="stores.length">
            <div v-for="(store, key) in stores" :key="key" class="col-6 col-md-3 col-lg-2">
              <div class="center">
                  <nuxt-link :to="{ path: localePath('products'), query: { store: store.id } }">
                    <div class="center-img"><img :src="store.image"></div>
                  </nuxt-link>
                  <div class="store-link">
                    <nuxt-link :to="{ path: localePath('products'), query: { store: store.id } }">
                      {{store.name}}
                    </nuxt-link>
                  </div>
                  <div class="special" v-show="store.is_featured">
                    <i class="fas fa-star"></i>
                  </div>
              </div>
            </div>
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

        </div>
      </section>
    </main>
</template>

<script src="./index.js"></script>
