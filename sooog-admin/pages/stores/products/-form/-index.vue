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
        <!--<b-row>-->
            <!--<b-col md="12">-->
                <!--<b-form-group-->
                <!--:label="$t('admin.quantity')"-->
                <!--label-for="input-horizontal"-->
                <!--id="fieldset-horizontal"-->
                <!--label-cols-sm="2"-->
                <!--&gt;-->
                <!--<b-form-input-->
                    <!--name="quantity"-->
                    <!--v-model="form.quantity"-->
                    <!--v-validate="{ required: true, numeric: true }"-->
                    <!--:placeholder="$t('admin.quantity')"-->
                    <!--:class="{ 'is-invalid': errors.has('quantity') }"-->
                <!--&gt;</b-form-input>-->
                <!--<span v-show="errors.has('quantity')" class="text-error text-danger text-sm">-->
                    <!--{{ errors.first("quantity") }}-->
                <!--</span>-->
                <!--</b-form-group>-->
            <!--</b-col>-->
        <!--</b-row>-->
        <!--<b-row>-->
            <!--<b-col md="12">-->
                <!--<b-form-group-->
                <!--:label="$t('admin.price')"-->
                <!--label-for="input-horizontal"-->
                <!--id="fieldset-horizontal"-->
                <!--label-cols-sm="2"-->
                <!--&gt;-->
                <!--<b-form-input-->
                    <!--name="price"-->
                    <!--v-model="form.price"-->
                    <!--v-validate="{ required: true, decimal: 3, min_value: 0 }"-->
                    <!--:placeholder="$t('admin.price')"-->
                    <!--:class="{ 'is-invalid': errors.has('price') }"-->
                <!--&gt;</b-form-input>-->
                <!--<span v-show="errors.has('price')" class="text-error text-danger text-sm">-->
                    <!--{{ errors.first("price") }}-->
                <!--</span>-->
                <!--</b-form-group>-->
            <!--</b-col>-->
        <!--</b-row>-->
        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'en.description\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-textarea
                    v-model="form.en.description"
                    :placeholder="$t('admin[\'en.description\']')"
                    rows="3"
                    max-rows="6"
                    name='en.description'
                    v-validate="{ required: true, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('en.description') }"
                ></b-form-textarea>
                <span v-show="errors.has(`en.description`)" class="text-error text-danger text-sm">
                  {{ errors.first(`en.description`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'ar.description\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-textarea
                    v-model="form.ar.description"
                    :placeholder="$t('admin[\'ar.description\']')"
                    rows="3"
                    max-rows="6"
                    name='ar.description'
                    v-validate="{ required: true, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('ar.description') }"
                ></b-form-textarea>
                <span v-show="errors.has(`ar.description`)" class="text-error text-danger text-sm">
                  {{ errors.first(`ar.description`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'en.tags\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-tags input-id="tags-basic"
                    v-model="form.en.tags"
                    :placeholder="$t('admin[\'en.tags\']')"
                    rows="3"
                    max-rows="6"
                    name='en.tags'
                    v-validate="{ required: false, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('en.tags') }"
                ></b-form-tags>
                <span v-show="errors.has(`en.tags`)" class="text-error text-danger text-sm">
                  {{ errors.first(`en.tags`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>


        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin[\'ar.tags\']')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                <b-form-tags input-id="tags-basic"
                    v-model="form.ar.tags"
                    :placeholder="$t('admin[\'ar.tags\']')"
                    rows="3"
                    max-rows="6"
                    name='ar.tags'
                    v-validate="{ required: false, max: 1000 }"
                    :class="{ 'is-invalid': errors.has('ar.tags') }"
                ></b-form-tags>
                <span v-show="errors.has(`ar.tags`)" class="text-error text-danger text-sm">
                  {{ errors.first(`ar.tags`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
         <b-row>
            <b-col md="12" v-if="brands">
              <b-form-group
                :label="$t('admin.brand')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.brand_id"
                  :options="brands.map(obj => obj.id)"
                  :custom-label="opt => brands.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.brand')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="brand"
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`brand`)" class="text-error text-danger text-sm">
                  {{ errors.first(`brand`) }}
                </span>
              </b-form-group>
            </b-col>
         </b-row>
         <!--<b-row>-->
            <!--<b-col md="12" v-if="stores">-->
              <!--<b-form-group-->
                <!--:label="$t('admin.store')"-->
                <!--label-for="input-horizontal"-->
                <!--id="fieldset-horizontal"-->
                <!--label-cols-sm="2"-->
              <!--&gt;-->
                <!--<multiselect-->
                  <!--v-model="form.store_id"-->
                  <!--:options="stores.map(obj => obj.id)"-->
                  <!--:custom-label="opt => stores.find(obj => obj.id == opt).name"-->
                  <!--value="key"-->
                  <!--:close-on-select="true"-->
                  <!--:clear-on-select="false"-->
                  <!--:hide-selected="false"-->
                  <!--:preserve-search="true"-->
                  <!--:placeholder="$t('admin.store')"-->
                  <!--label="key"-->
                  <!--:allowEmpty="true"-->
                  <!--:preselect-first="false"-->
                  <!--id="key"-->
                  <!--name="store"-->
                  <!--v-validate="{ required: true }"-->
                <!--&gt;-->
                  <!--<span slot="noOptions">-->
                    <!--{{$t('admin.empty_list')}}-->
                  <!--</span>-->
                  <!--<span slot="noResult">-->
                    <!--{{$t('admin.no_results')}}-->
                  <!--</span>-->
                <!--</multiselect>-->
                <!--<span v-show="errors.has(`store`)" class="text-error text-danger text-sm">-->
                  <!--{{ errors.first(`store`) }}-->
                <!--</span>-->
              <!--</b-form-group>-->
            <!--</b-col>-->

        <!--</b-row>-->

        <b-row>
            <b-col md="12" v-if="categories">
              <b-form-group
                :label="$t('admin.mainCategory')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.mainCategory_id"
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
                  name="mainCategory"
                  v-validate="{ required: true }"
                  @input="handleCategoryRelations"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`mainCategory`)" class="text-error text-danger text-sm">
                  {{ errors.first(`mainCategory`) }}
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
                  v-model="form.category_id"
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
            <b-col md="12" v-if="countries">
              <b-form-group
                :label="$t('admin.made_in')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.made_in"
                  :options="countries.map(obj => obj.id)"
                  :custom-label="opt => countries.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.made_in')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="made_in"
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`made_in`)" class="text-error text-danger text-sm">
                  {{ errors.first(`made_in`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.barcode')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="barcode"
                    v-model="form.barcode"
                    v-validate="{ required: false }"
                    :placeholder="$t('admin.barcode')"
                    :class="{ 'is-invalid': errors.has('barcode') }"
                ></b-form-input>
                <span v-show="errors.has('barcode')" class="text-error text-danger text-sm">
                    {{ errors.first("barcode") }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>

        <b-row>
          <b-col md="12">
                <b-form-group
                :label="$t('admin.max_purchase_quantity')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="max_purchase_quantity"
                    v-model="form.max_purchase_quantity"
                    v-validate="{ required: true, numeric: true }"
                    :placeholder="$t('admin.max_purchase_quantity')"
                    :class="{ 'is-invalid': errors.has('max_purchase_quantity') }"
                ></b-form-input>
                <span v-show="errors.has('max_purchase_quantity')" class="text-error text-danger text-sm">
                    {{ errors.first("max_purchase_quantity") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
          <b-row v-if="properties">
            <b-col md="12" v-for="(property, index) in properties" :key="`prop_${index}`">
                <b-form-group
                :label="property.name"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input v-if="property.property_type.key == 'text'"
                    :name="property.name"
                    v-model="property.value"
                    v-validate="{ required: property.is_required }"
                    :placeholder="property.name"
                    :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                ></b-form-input>
                <b-form-input v-if="property.property_type.key == 'number'"
                    :name="property.name"
                    v-model="property.value"
                    v-validate="{ required: property.is_required, numeric: true, min_value:0, max_value:100000 }"
                    :placeholder="property.name"
                    :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                ></b-form-input>
                <b-form-input v-if="property.property_type.key == 'decimal'"
                    :name="property.name"
                    v-model="property.value"
                    v-validate="{ required: property.is_required, decimal: 3, min_value: 0, max_value: 100000 }"
                    :placeholder="property.name"
                    :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                ></b-form-input>
                <b-form-radio-group v-if="property.property_type.key == 'radio'"
                  id="radio-group-1"
                  v-model="property.body"
                  v-validate="{ required: property.is_required }"
                  :placeholder="property.name"
                  :options="property.options.map((obj) => {return {text: obj.name , value: obj.id}})"
                  :name="property.name"
                  :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                ></b-form-radio-group>
                <b-form-checkbox-group v-if="property.property_type.key == 'checkbox'"
                  id="`checkbox-group-1`"
                  v-model="property.value"
                  :options="property.options.map((obj) => {return {text: obj.name , value: obj.id}})"
                  v-validate="{ required: property.is_required }"
                  :name="property.name"
                  :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                ></b-form-checkbox-group>
                <multiselect v-if="['select', 'multible_select'].includes(property.property_type.key)"
                  v-model="property.value"
                  :options="property.options.map(obj => obj.id)"
                  :custom-label="opt => property.options.find(obj => obj.id == opt).name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('property.name')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  :name="property.name"
                  :multiple="property.property_type.key == 'multible_select'"
                  v-validate="{ required: property.is_required }"
                  :class="{ 'is-invalid': errors.has(`${property.name}`) }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`${property.name}`)" class="text-error text-danger text-sm">
                    {{ errors.first(`${property.name}`) }}
                </span>
                </b-form-group>
            </b-col>
          </b-row>
      <!--units-->
      <card-component :title="$t('admin.units')" icon="fas fa-clipboard-list 5x" class="mb-2">
        <b-row v-for="(unit, key) in form.units" :key="key">
          <b-col md="5">
            <b-form-group
              :label="$t('admin[\'en.name\']')"
              label-for="input-horizontal"
              id="fieldset-horizontal"
              label-cols-sm="3">
              <b-form-input
                class="form-control"
                v-model="unit.en.name"
                v-validate="{ required: true }"
                :name="`unit.${key}.en.name`"
                :placeholder="$t('admin[\'en.name\']')"
                :class="{ 'is-invalid': errors.has(`unit.${key}.en.name`) }">
              </b-form-input>
              <span v-show="errors.has(`unit.${key}.en.name`)" class="text-error text-danger text-sm">
                      {{ errors.first(`unit.${key}.en.name`) }}
                    </span>
            </b-form-group>
          </b-col>
          <b-col md="5">
            <b-form-group
              :label="$t('admin[\'ar.name\']')"
              label-for="input-horizontal"
              id="fieldset-horizontal"
              label-cols-sm="3"
            >
              <b-form-input
                class="form-control"
                v-model="unit.ar.name"
                v-validate="{ required: true }"
                :name="`unit.${key}.ar.name`"
                :placeholder="$t('admin[\'ar.name\']')"
                :class="{ 'is-invalid': errors.has(`unit.${key}.ar.name`) }">
              </b-form-input>
              <span v-show="errors.has(`unit.${key}.ar.name`)" class="text-error text-danger text-sm">
                      {{ errors.first(`unit.${key}.ar.name`) }}
                    </span>
            </b-form-group>
          </b-col>

          <b-col md="5">
            <b-form-group
              :label="$t('admin.price')"
              label-for="input-horizontal"
              id="fieldset-horizontal"
              label-cols-sm="3"
            >
              <b-form-input
                :name="`unit.${key}.price`"
                v-model="unit.price"
                v-validate="{  required: true, decimal: 3, min_value: 0  }"
                :placeholder="$t('admin.price')"
                :class="{ 'is-invalid': errors.has(`unit.${key}.price`) }"
              ></b-form-input>
              <span v-show="errors.has(`unit.${key}.price`)" class="text-error text-danger text-sm">
                      {{ errors.first(`unit.${key}.price`) }}
                    </span>
            </b-form-group>
          </b-col>
          <b-col md="5">
            <b-form-group
              :label="$t('admin.quantity')"
              label-for="input-horizontal"
              id="fieldset-horizontal"
              label-cols-sm="3"
            >
              <b-form-input
                :name="`unit.${key}.quantity`"
                v-model="unit.quantity"
                v-validate="{ required: true, numeric: true  }"
                :placeholder="$t('admin.quantity')"
                :class="{ 'is-invalid': errors.has(`unit.${key}.quantity`) }"
              ></b-form-input>
              <span v-show="errors.has(`unit.${key}.quantity`)" class="text-error text-danger text-sm">
                      {{ errors.first(`unit.${key}.quantity`) }}
                    </span>
            </b-form-group>
          </b-col>
          <!--<b-col md="12">-->
          <!--<hr>-->
          <!--</b-col>-->
          <b-col md="12">
            <div class="text-center">
              <i class="fa fa-trash-alt text-danger" @click="removeUnit(key)"></i>
            </div>
          </b-col>
          <b-col md="12">
            <hr>
          </b-col>
        </b-row>

        <div class="text-center">
          <i class="fa fa-plus-circle text-success" @click="addUnit"></i>
        </div>

      </card-component>
          <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.image')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    accept="image/*"
                    name="image"
                    ref="fileupload"
                    v-validate="{ required: true }"
                    v-model="form.image"
                    @change="handleUploadFile"
                    :class="{ 'is-invalid': errors.has('image') }"
                    ></b-form-file>
                    <span v-show="errors.has('image')" class="text-error text-danger text-sm">
                        {{ errors.first("image") }}
                    </span>
                    <span v-if="image_hint" class="text-info text-sm">* {{image_hint}}</span>
                    <span v-if="uploading_msg" class="text-error text-info text-sm">{{uploading_msg}}</span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">
                <a v-if="form.image" :href="form.image" target="_blank">
                  <button @click.prevent="deleteFile('attachment')" style="color:red; float:right">x</button>
                    <b-img
                        :src="form.image"
                        max-height="100"
                        max-width="150"
                        class="img-fluid"
                    />
                </a>
            </b-col>
          </b-row>

          <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.catalog')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    name="catalog"
                    ref="fileupload"
                    v-validate="{ required: false }"
                    v-model="form.catalog"
                    @change="handleUploadFile($event, 'pdf')"
                    :class="{ 'is-invalid': errors.has('catalog') }"
                    ></b-form-file>
                    <span v-show="errors.has('catalog')" class="text-error text-danger text-sm">
                        {{ errors.first("catalog") }}
                    </span>
                    <span v-if="uploading_file_msg" class="text-error text-info text-sm">{{uploading_file_msg}}</span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">
                <a target="_blank" v-if="form.catalog" :href="form.catalog">
                  <object width="120" height="50" type="application/pdf"
                  :data="form.catalog" class="img-thumbnail" />
                </a>
            </b-col>
          </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.attachments')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    name="attachments"
                    ref="fileuploads"
                    multiple
                    @change="handleUploadFile"
                    v-validate="{ required: false}"
                    :class="{ 'is-invalid': errors.has('attachments') }"
                    accept="image/*"
                    ></b-form-file>
                    <span v-show="errors.has('attachments')" class="text-error text-danger text-sm">
                      {{ errors.first("attachments") }}
                  </span>
                  <span v-if="image_hint" class="text-info text-sm">* {{image_hint}}</span>
                  <span v-if="uploading_files_msg" class="text-error text-info text-sm">{{uploading_files_msg}}</span>
                </b-form-group>
            </b-col>
        </b-row>
          <b-row>
            <b-col md="3" v-for="(attachment, idx) in form.attachments" :key="`attachment_${idx}`" class="img-wrap">
                <a :href="attachment.file" target="_blank">
                    <button @click.prevent="deleteFile('attachments', idx)" style="color:red; float:right">x</button>
                    <b-img v-if="attachment.type != 'video'"
                        :lazy-src="attachment.file"
                        :src="attachment.file"
                        max-height="100"
                        max-width="150"
                        class="img-fluid"
                    />
                    <video width="400" controls v-else>
                      <source :src="attachment.file" type="video/mp4">
                    </video>
                </a>
            </b-col>
          </b-row>

        <div class="text-center mt-3 mb-2">
        <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
        <Button @clickFn="back()" size="sm" bgRed>{{$t('admin.back')}}</Button>
        </div>

    </b-form>

</template>

<script src="./-index.js"></script>
