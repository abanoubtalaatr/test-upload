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

          <div class="col-md-9">
            <!--addresses-->
            <section class="products">

              <div class="row" v-if="collection.length">
                <div class="col-md-4" v-for="(product, key) in collection" :key="key">
                  <a href="#">
                    <productBlock :product="product" />
                  </a>
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

            </section>

          </div>
        </div>
      </div>
      </client-only>
    </main>
    <!-- End Main Content-->
</template>

<script src="./index.js"></script>
