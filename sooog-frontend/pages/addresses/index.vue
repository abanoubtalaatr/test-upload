<template>
    <!-- Main Content-->
    <main class="main-content">
       <DeleteModal
          :is-active="isModalActive"
          @confirm="trashConfirm('event-delete-address')"
          @cancel="trashCancel"
        />
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
            <section class="profile">
              <div class="row">
                <div class="col-6">
                  <h3>{{$t('front.my_addresses')}}</h3>
                  <p class="grey">{{$t('front.show_all_addresses')}}</p>
                </div>
                <div class="col-6 text-right">
                  <nuxt-link class="button btn-yellow" :to="localePath('addresses-create')">
                    {{$t('front.create')}}
                  </nuxt-link>
                  </div>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr class="grey">
                      <th>{{$t('front.address_name')}}</th>
                      <th>{{$t('front.city')}} </th>
                      <th>{{$t('front.phone')}}</th>
                      <th>{{$t('front.address')}}</th>
                      <th>{{$t('front.primary_address')}}</th>
                      <th> </th>
                    </tr>
                    <tbody v-if="collection.length">
                      <tr v-for="(address, key) in collection" :key="key">
                        <td>
                          <p class="b">
                            {{address.title}}
                          </p>
                        </td>
                        <td>
                          <p class="grey">
                            {{address.city.name}}
                          </p>
                        </td>
                        <td>
                          <p class="grey">
                            {{address.phone}}
                          </p>
                        </td>
                        <td>
                          <p class="grey">
                            {{address.address}}
                          </p>
                        </td>
                        <td>
                          <img v-if="address.is_primary" src="~/assets/website/imgs/account/check.svg" alt="">
                        </td>
                        <td class="a-div">
                          <nuxt-link class="green" :to="localePath(`/addresses/${address.id}/edit`)">{{$t('front.edit')}}</nuxt-link>
                          <a class="red cursor" @click="trashModal(address.id)">{{$t('front.delete')}}</a>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="6" class="grey text-center">{{$t('front.no_addresses')}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
