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
                  v-validate="{ required: true ,max:100,min:3}"
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
                  v-validate="{ required: true ,max:100,min:3}"
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
                :label="$t('admin.country')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.country_id"
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
                  name="country"
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
                <span v-show="errors.has(`country`)" class="text-error text-danger text-sm">
                  {{ errors.first(`country`) }}
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
