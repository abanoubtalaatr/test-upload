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
                :label="$t('admin.categories')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.categories"
                  :options="[{group_name: $t('admin.select_all'), group_values: categories}]"
                  group-values="group_values" 
                  group-label="group_name" 
                  :group-select="true"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.categories')"
                  label="name"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="categories"
                  multiple
                  v-validate="{ required: true }"
                  track-by="id" 
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`categories`)" class="text-error text-danger text-sm">
                  {{ errors.first(`categories`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.property_type')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.property_type_id"
                  :options="property_types.map(obj => obj.id)"
                  :custom-label="opt => property_types.find(obj => obj.id == opt).name"
                  value="id"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.property_type')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="property_type"
                  v-validate="{ required: true }"
                  @input="handlePropertyOPtions"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`property_type`)" class="text-error text-danger text-sm">
                  {{ errors.first(`property_type`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.is_required')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-radio-group
                  id="radio-group-1"
                  v-model="form.is_required"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.is_required')"
                  :options="options"
                  name="is_required"
                  :class="{ 'is-invalid': errors.has('is_required') }"
                ></b-form-radio-group>
                <span v-show="errors.has('is_required')" class="text-error text-danger text-sm">
                    {{ errors.first("is_required") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row v-if="form.has_options">
          <card-component :title="$t('admin.options')" icon="ballot-outline">
          <b-col md="12">
              <b-row v-for="(option, key) in form.options" :key="key">
                <b-col md="5">
                  <!-- <b-form-group
                  :label="$t('admin[\'en.name\']')"
                  label-for="input-horizontal"
                  id="fieldset-horizontal"
                  label-cols-sm="3"
                  > -->
                <b-form-input
                    :name="`en.name.${key}`"
                    v-model="option.en.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.name\']')"
                    :class="{ 'is-invalid': errors.has('en.name') }"
                ></b-form-input>
                <span v-show="errors.has(`en.name.${key}`)" class="text-error text-danger text-sm">
                    {{ errors.first(`en.name.${key}`) }}
                </span>
                <!-- </b-form-group> -->
                </b-col>
                <b-col md="5">
                  <!-- <b-form-group
                  :label="$t('admin[\'ar.name\']')"
                  label-for="input-horizontal"
                  id="fieldset-horizontal"
                  label-cols-sm="3"
                  > -->
                <b-form-input
                    :name="`ar.name.${key}`"
                    v-model="option.ar.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.name\']')"
                    :class="{ 'is-invalid': errors.has('ar.name') }"
                ></b-form-input>
                <span v-show="errors.has(`ar.name.${key}`)" class="text-error text-danger text-sm">
                    {{ errors.first(`ar.name.${key}`) }}
                </span>
                <!-- </b-form-group> -->
                </b-col>
                <b-col md="2">
                  <span class="table_icon mr-2" @click="removeOption(key)"
                    ><i class="far fa-trash-alt red"></i>
                  </span>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="12">
                  <span class="table_icon mr-2" @click="addOption" style="align:center;"
                      ><i class="fas fa-plus green"></i> add option
                    </span>
                </b-col>
              </b-row>
          </b-col>
          
          </card-component>
        </b-row>

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
