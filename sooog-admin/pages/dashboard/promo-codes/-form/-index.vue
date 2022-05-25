<template>
    <b-form @submit.prevent="submit">
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.name"
                    v-model="form.en.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.name\']')"
                    :class="{ 'is-invalid': errors.has('en.name') }"
                ></b-form-input>
                <span v-show="errors.has('en.name')" class="text-error text-danger text-sm">
                    {{ errors.first("en.name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'ar.name\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.name"
                    v-model="form.ar.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.name\']')"
                    :class="{ 'is-invalid': errors.has('ar.name') }"
                ></b-form-input>
                <span v-show="errors.has('ar.name')" class="text-error text-danger text-sm">
                    {{ errors.first("ar.name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.promoCode')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="promoCode"
                    v-model="form.code"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.promoCode')"
                    :class="{ 'is-invalid': errors.has('promoCode') }"
                ></b-form-input>
                <span v-show="errors.has('promoCode')" class="text-error text-danger text-sm">
                    {{ errors.first("promoCode") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.max_use_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="max_use_number"
                    v-model="form.max_use_number"
                    v-validate="{ required: true, numeric: true, min_value: 1 }"
                    :placeholder="$t('admin.max_use_number')"
                    :class="{ 'is-invalid': errors.has('max_use_number') }"
                ></b-form-input>
                <span v-show="errors.has('max_use_number')" class="text-error text-danger text-sm">
                    {{ errors.first("max_use_number") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.order_min_cost')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="order_min_cost"
                    v-model="form.order_min_cost"
                    v-validate="{ required: true, decimal: 3, min_value: 0 }"
                    :placeholder="$t('admin.order_min_cost')"
                    :class="{ 'is-invalid': errors.has('order_min_cost') }"
                ></b-form-input>
                <span v-show="errors.has('order_min_cost')" class="text-error text-danger text-sm">
                    {{ errors.first("order_min_cost") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.start_date')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-datepicker 
                  id="start_date-datepicker" 
                  name="start_date"
                  v-model="form.start_date" 
                  class="mb-2"
                  ref="start_date"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.start_date')"
                  :locale="currentLocale"
                  today-button
                  reset-button
                  close-button
                  :label-today-button="$t('admin.select_today')"
                  :label-reset-button="$t('admin.reset')"
                  :label-close-button="$t('admin.close')" 
                  :class="{ 'is-invalid': errors.has('start_date') }"
                >
                </b-form-datepicker>
                <span v-show="errors.has('start_date')" class="text-error text-danger text-sm">
                    {{ errors.first("start_date") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.end_date')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-datepicker 
                  id="end_date-datepicker" 
                  name="end_date"
                  v-model="form.end_date" 
                  class="mb-2"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.end_date')"
                  :locale="currentLocale"
                  today-button
                  reset-button
                  close-button
                  :label-today-button="$t('admin.select_today')"
                  :label-reset-button="$t('admin.reset')"
                  :label-close-button="$t('admin.close')" 
                  :class="{ 'is-invalid': errors.has('end_date') }"
                >
                </b-form-datepicker>
                <span v-show="errors.has('end_date')" class="text-error text-danger text-sm">
                    {{ errors.first("end_date") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.offer_type')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-radio-group
                  id="radio-group-1"
                  v-model="form.type"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.offer_type')"
                  :options="options"
                  name="offer_type"
                  :class="{ 'is-invalid': errors.has('offer_type') }"
                ></b-form-radio-group>
                <span v-show="errors.has('offer_type')" class="text-error text-danger text-sm">
                    {{ errors.first("offer_type") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12" v-if="form.type == 'value'">
                <b-form-group
                :label="$t('admin.value')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="value"
                    v-model="form.value"
                    v-validate="{ required: true,  decimal: 3, min_value: 0 }"
                    :placeholder="$t('admin.value')"
                    :class="{ 'is-invalid': errors.has('value') }"
                ></b-form-input>
                <span v-show="errors.has('value')" class="text-error text-danger text-sm">
                    {{ errors.first("value") }}
                </span>
                </b-form-group>
            </b-col>
            <b-col md="12" v-else-if="form.type == 'percentage'">
                <b-form-group
                :label="$t('admin.value')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="value"
                    v-model="form.value"
                    v-validate="{ required: true,  decimal: 3, max_value: 100, min_value: 0 }"
                    :placeholder="$t('admin.value')"
                    :class="{ 'is-invalid': errors.has('value') }"
                ></b-form-input>
                <span v-show="errors.has('value')" class="text-error text-danger text-sm">
                    {{ errors.first("value") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.applied_to')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-radio-group
                  id="radio-group-2"
                  v-model="form.applied_to"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.applied_to')"
                  :options="appliedToOptions"
                  name="applied_to"
                  :class="{ 'is-invalid': errors.has('applied_to') }"
                ></b-form-radio-group>
                <span v-show="errors.has('applied_to')" class="text-error text-danger text-sm">
                    {{ errors.first("applied_to") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

        <b-row v-if="form.applied_to == 'specific_user'">
            <b-col md="12" v-if="users">
              <b-form-group
                :label="$t('admin.user')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.user_id"
                  :options="users.map(obj => obj.id)"
                  :custom-label="opt => users.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.user')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="user"
                  v-validate="{ required: form.applied_to == 'specific_user' }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`user`)" class="text-error text-danger text-sm">
                  {{ errors.first(`user`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12" v-if="stores">
              <b-form-group
                :label="$t('admin.stores')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model.lazy="form.stores"
                  :options="[{group_name: $t('admin.select_all'), group_values: stores}]"
                  group-values="group_values" 
                  group-label="group_name" 
                  :group-select="true" 
                   value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.stores')"
                  label="name"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="stores"
                  v-validate="{ required: true }"
                  multiple
                  track-by="id" 
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`stores`)" class="text-error text-danger text-sm">
                  {{ errors.first(`stores`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        
        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
