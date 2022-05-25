<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col md="12" v-if="addresses.length>0">
              <b-form-group
                :label="$t('admin.user_address')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.user_address_id"
                  :options="addresses.map(obj => obj.id)"
                  :custom-label="opt => addresses.find(obj => obj.id == opt).title"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.user_address')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="user_address"
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`user_address`)" class="text-error text-danger text-sm">
                  {{ errors.first(`user_address`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" v-if="stores">
              <b-form-group
                :label="$t('admin.store')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.store_id"
                  :options="stores.map(obj => obj.id)"
                  :custom-label="opt => stores.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.store')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="store"
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`store`)" class="text-error text-danger text-sm">
                  {{ errors.first(`store`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <!-- <b-row>
            <b-col md="6" v-if="payment_methods">
              <b-form-group
                :label="$t('admin.payment_method')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="3"
              >
                <multiselect
                  v-model.lazy="form.payment_method_id"
                  :options="payment_methods.map(obj => obj.id)"
                  :custom-label="opt => payment_methods.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.payment_method')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="payment_method"
                  v-validate="{ required: false }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`payment_method`)" class="text-error text-danger text-sm">
                  {{ errors.first(`payment_method`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row> -->

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.products')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <Button bgGreen @clickFn="openProductsModal">{{$t('admin.select_products')}}</Button>
                </b-form-group>
            </b-col>
        </b-row>
        <order-products :store_id="form.store_id" :warranties="warranties"/>
        
        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
