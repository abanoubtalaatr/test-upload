<template>
    <b-form @submit.prevent="submit">
      <b-row>
        <b-col md="12">
                <b-form-group
                :label="$t('admin.service_wanted_date')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-datepicker 
                  id="example-datepicker" 
                  name="service_wanted_date"
                  v-model="form.service_wanted_date" 
                  class="mb-2"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.service_wanted_date')"
                  :locale="currentLocale"
                  today-button
                  reset-button
                  close-button
                  :label-today-button="$t('admin.select_today')"
                  :label-reset-button="$t('admin.reset')"
                  :label-close-button="$t('admin.close')" 
                  :class="{ 'is-invalid': errors.has('service_wanted_date') }"
                >
                </b-form-datepicker>
                <span v-show="errors.has('service_wanted_date')" class="text-error text-danger text-sm">
                    {{ errors.first("service_wanted_date") }}
                </span>
                </b-form-group>
            </b-col>
      </b-row>
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
                  @input="getServices"
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
        <b-row>
            <b-col md="12" v-if="services.length > 0">
              <b-form-group
                :label="$t('admin.service')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.service_id"
                  :options="services.map(obj => obj.id)"
                  :custom-label="opt => services.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.service')"
                  label="key"
                  :allowEmpty="false"
                  :preselect-first="false"
                  id="key"
                  name="service"
                  v-validate="{ required: true }"
                  @input="getServices"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`service`)" class="text-error text-danger text-sm">
                  {{ errors.first(`service`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" v-if="categories.length > 0">
              <b-form-group
                :label="$t('admin.category')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.category_id"
                  :options="categories.map(obj => obj.id)"
                  :custom-label="opt => categories.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.category')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="category"
                  v-validate="{ required: true }"
                  @input="getSubcategories"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`category`)" class="text-error text-danger text-sm">
                  {{ errors.first(`category`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" v-if="subcategories.length > 0">
              <b-form-group
                :label="$t('admin.subcategory')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.subcategory_id"
                  :options="subcategories.map(obj => obj.id)"
                  :custom-label="opt => subcategories.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.subcategory')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="subcategory"
                  v-validate="{ required: true }"
                  @input="getSubcategories"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`subcategory`)" class="text-error text-danger text-sm">
                  {{ errors.first(`subcategory`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.problem_description')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-textarea
                    v-model="form.problem_description"
                    :placeholder="$t('admin.problem_description')"
                    rows="3"
                    max-rows="6"
                    name='problem_description'
                    v-validate="{ required: true, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('problem_description') }"
                ></b-form-textarea>
                <span v-show="errors.has(`problem_description`)" class="text-error text-danger text-sm">
                  {{ errors.first(`problem_description`) }}
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

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
