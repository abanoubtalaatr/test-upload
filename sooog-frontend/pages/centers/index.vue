<template>
  <!-- Main Content-->
    <main class="main-content">
      <!--brands-->
      <section class="centers">
        <div class="container">
          <div class="custom-padd">
            <h3>{{$t('front.centers')}}</h3>
          </div>
          <div class="row" v-if="centers.length">
            <div v-for="(center, key) in centers" :key="key" class="col-6 col-md-3 col-lg-2">
              <div class="center">
                  <nuxt-link :to="{ path: localePath('services'), query: { store: center.id } }">
                    <div class="center-img"><img :src="center.image"></div>
                  </nuxt-link>
                  <div class="store-link">
                    <nuxt-link :to="{ path: localePath('services'), query: { store: center.id } }">
                    {{center.name}}
                    </nuxt-link>
                  </div>
                  <div class="special" v-show="center.is_featured">
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
