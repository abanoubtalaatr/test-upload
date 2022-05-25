<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form data-vv-scope="profile" @submit.prevent="updateProfile">
          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.bank_type')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="user.bank_type"
                  :options="bank_types"
                  :close-on-select="true"
                  :show-labels="false"
                  name="bank_type"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.bank_type')"
                >

                </multiselect>
                <span v-show="errors.has(`bank_type`,'profile')" class="text-error text-danger text-sm">
                  {{ errors.first(`bank_type`,'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row v-if="user.bank_type=='global'">
            <b-col md="12">
              <b-form-group
                :label="$t('admin.country')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="user.bank_country_id"
                  :options="countries.map(obj => obj.id)"
                  :custom-label="opt => countries.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.country')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="bank_country_id"
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                  <!-- <template slot="option" slot-scope="props">
                        {{ props.option[currentLocale].name }}
                  </template> -->
                </multiselect>
                <span v-show="errors.has(`bank_country_id`, 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first(`bank_country_id`, 'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.bank_name')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="bank_name"
                  v-model="user.bank_name"
                  v-validate="{ required: false }"
                  :placeholder="$t('admin.bank_name')"
                  :class="{ 'is-invalid': errors.has('bank_name', 'profile') }"
                ></b-form-input>
                <span v-show="errors.has('bank_name', 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first("bank_name", 'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row v-if="user.bank_type=='local'">
            <b-col md="12">
              <b-form-group
                :label="$t('admin.bank_account_no')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="bank_account_no"
                  v-model="user.bank_account_no"
                  v-validate="{ required: false }"
                  :placeholder="$t('admin.bank_account_no')"
                  :class="{ 'is-invalid': errors.has('bank_account_no','profile') }"
                ></b-form-input>
                <span v-show="errors.has('bank_account_no','profile')" class="text-error text-danger text-sm">
                  {{ errors.first("bank_account_no",'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.bank_user_name')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="bank_account_no"
                  v-model="user.bank_user_name"
                  v-validate="{ required: false }"
                  :placeholder="$t('admin.bank_user_name')"
                  :class="{ 'is-invalid': errors.has('bank_user_name','profile') }"
                ></b-form-input>
                <span v-show="errors.has('bank_user_name','profile')" class="text-error text-danger text-sm">
                  {{ errors.first("bank_user_name",'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row v-if="user.bank_type=='local'">
            <b-col md="12">
              <b-form-group
                :label="$t('admin.iban_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="iban_no"
                  v-model="user.iban_no"
                  v-validate="{ required: false }"
                  :placeholder="$t('admin.iban_number')"
                  :class="{ 'is-invalid': errors.has('iban_no','profile') }"
                ></b-form-input>
                <span v-show="errors.has('iban_no','profile')" class="text-error text-danger text-sm">
                  {{ errors.first('iban_no','profile') }}
                </span>
              </b-form-group>
            </b-col>

          </b-row>
          <b-row v-if="user.bank_type=='global'">
            <b-col md="12">
              <b-form-group
                :label="$t('admin.swift_code')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="swift_code"
                  v-model="user.swift_code"
                  v-validate="{ required: false }"
                  :placeholder="$t('admin.swift_code')"
                  :class="{ 'is-invalid': errors.has('swift_code', 'profile') }"
                ></b-form-input>
                <span v-show="errors.has('swift_code', 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first("swift_code", 'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
            <!-- <Button @clickFn="close()" size="sm" bgRed>{{$t('admin.cancel')}}</Button> -->
          </div>

        </b-form>
      </card-component>

    </section>
 </div>
</template>

<script src="./index.js"></script>

