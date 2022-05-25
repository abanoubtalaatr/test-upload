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
            <!--form-->
            <section class="profile">
              <h3>{{$t('front.edit_address')}}</h3>
              <p class="grey">{{$t('front.new_address_detail')}}</p>

              <FormData
                :item="item"
                :countries="countries"
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
