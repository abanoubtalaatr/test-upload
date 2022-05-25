<template>
  <div class="home-page">
    <b-container>
      <div class="level">
        <div :class="$i18n.locale == 'en' ? 'level-left' : 'level-right'">
            <span>{{ $t("admin.welcome") }} </span> <span> {{ mokayiefyData ? mokayiefyData.name : '' }} </span>
        </div>
        <div :class="$i18n.locale == 'en' ? 'level-right' : 'level-left'">
            <span> </span> <span> {{ date }} </span>
        </div>
      </div>
  
      <div class="Statistecs" v-if="statistics" v-show="permissions.includes('statistics.index')">
        <b-row>
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.stores") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['stores'] }}</span>  
                    </p>
                   
                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->

          </b-col>
          <!--<b-col lg="4">-->
            <!--<div class="users">-->
              <!--<b-row>-->
                <!--<b-col lg="8" class="text-center">-->
                  <!--<p> {{ $t("admin.centers") }} </p>-->
                  <!--<img src="../../assets/images/customer.png" alt="" />-->
                <!--</b-col>-->
                <!--<b-col lg="4">-->
                  <!--<div class="users-statistics">-->
                    <!--<p>-->
                      <!--<span>{{ statistics['centers'] }}</span>-->
                    <!--</p>-->
                   <!---->
                  <!--</div>-->
                <!--</b-col>-->
              <!--</b-row>-->
              <!--<div class="add-user">-->
                <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
                  <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
                <!--</nuxt-link> &ndash;&gt;-->
              <!--</div>-->
              <!--<br>-->
            <!--</div>-->
            <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.categories") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['categories'] }}</span>
                    </p>
                   
                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->

          </b-col>
          <!--<b-col lg="4">-->
            <!--<div class="users">-->
              <!--<b-row>-->
                <!--<b-col lg="8" class="text-center">-->
                  <!--<p> {{ $t("admin.services_types") }} </p>-->
                  <!--<img src="../../assets/images/customer.png" alt="" />-->
                <!--</b-col>-->
                <!--<b-col lg="4">-->
                  <!--<div class="users-statistics">-->
                    <!--<p>-->
                      <!--<span>{{ statistics['service_types'] }}</span>-->
                    <!--</p>-->
                   <!---->
                  <!--</div>-->
                <!--</b-col>-->
              <!--</b-row>-->
              <!--<div class="add-user">-->
                <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
                  <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
                <!--</nuxt-link> &ndash;&gt;-->
              <!--</div>-->
              <!--<br>-->
            <!--</div>-->
            <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->
          <!--<b-col lg="4">-->
            <!--<div class="users">-->
              <!--<b-row>-->
                <!--<b-col lg="8" class="text-center">-->
                  <!--<p> {{ $t("admin.warranties") }} </p>-->
                  <!--<img src="../../assets/images/customer.png" alt="" />-->
                <!--</b-col>-->
                <!--<b-col lg="4">-->
                  <!--<div class="users-statistics">-->
                    <!--<p>-->
                      <!--<span>{{ statistics['warranties'] }}</span>-->
                    <!--</p>-->
                   <!---->
                  <!--</div>-->
                <!--</b-col>-->
              <!--</b-row>-->
              <!--<div class="add-user">-->
                <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
                  <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
                <!--</nuxt-link> &ndash;&gt;-->
              <!--</div>-->
              <!--<br>-->
            <!--</div>-->
            <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.active_products") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['products'] }}</span>
                    </p>
                   
                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->
          </b-col>
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.not_active_products") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['not_active_products'] }}</span>
                    </p>

                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->
          </b-col>
          <!--<b-col lg="4">-->
            <!--<div class="users">-->
              <!--<b-row>-->
                <!--<b-col lg="8" class="text-center">-->
                  <!--<p> {{ $t("admin.services") }} </p>-->
                  <!--<img src="../../assets/images/customer.png" alt="" />-->
                <!--</b-col>-->
                <!--<b-col lg="4">-->
                  <!--<div class="users-statistics">-->
                    <!--<p>-->
                      <!--<span>{{ statistics['services'] }}</span>-->
                    <!--</p>-->
                   <!---->
                  <!--</div>-->
                <!--</b-col>-->
              <!--</b-row>-->
              <!--<div class="add-user">-->
                <!--&lt;!&ndash; <nuxt-link :to="localePath('dashboard')">-->
                  <!--<Button bgGreen Noborder> {{ $t("add_user") }}  </Button>-->
                <!--</nuxt-link> &ndash;&gt;-->
              <!--</div>-->
              <!--<br>-->
            <!--</div>-->
            <!--&lt;!&ndash; End users Box &ndash;&gt;-->
          <!--</b-col>-->
          <b-col lg="4">
            <div class="users">
              <b-row>
                <b-col lg="8" class="text-center">
                  <p> {{ $t("admin.users") }} </p>
                  <img src="../../assets/images/customer.png" alt="" />
                </b-col>
                <b-col lg="4">
                  <div class="users-statistics">
                    <p>
                      <span>{{ statistics['users'] }}</span>
                    </p>
                   
                  </div>
                </b-col>
              </b-row>
              <div class="add-user">
                <!-- <nuxt-link :to="localePath('dashboard')">
                  <Button bgGreen Noborder> {{ $t("add_user") }}  </Button>
                </nuxt-link> -->
              </div>
              <br>
            </div>
            <!-- End users Box -->
          </b-col>
          
        </b-row>
      </div>
    </b-container>
  </div>
</template>
<script>
import { mapState } from 'vuex'
import moment from 'moment'
export default {
  data() {
    return {
      date: moment().locale(this.$i18n.locale).format("LL"),
      loading: true,
      Id: "",
      singleBill: "",
      admins: "",
      users: "",
      blockUsers: "",
      activeSubs: "",
      inActiveSubs: "",
      canceledSubsc: "",
      newSubsc: "",
      newSupport: "",
      pendingSupport: "",
      doneSupport: "",
      statistics: [],
      permissions: this.$cookies.get('permissions')
    };
  },
    computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
      mokayiefyData: state => JSON.parse(state.localStorage.mokayiefyData)
    })
  },
  async asyncData (context) {
    const [ statistics ] = await Promise.all([
        context.$axios.$get(`/admin/statistics`).catch(() => {})
    ])
    return { statistics }
  },
  methods: {
  },
};
</script>

<style scoped>
@import "../../assets/css/pages/homePage.css";
</style>
