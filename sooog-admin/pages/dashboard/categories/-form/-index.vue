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
            <b-col md="12" v-if="is_child">
              <b-form-group
                :label="$t('admin.category')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.parent_id"
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
            <b-col md="12">
                <b-form-group
                :label="$t('admin.category_order')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <!-- <b-form-input
                    name="order"
                    v-model="form.order"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.order')"
                    :class="{ 'is-invalid': errors.has('order') }"
                ></b-form-input> -->
                <b-form-select
                    :options="order_range"
                    name="order"
                    v-model="form.order"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.order')"
                    :class="{ 'is-invalid': errors.has('order') }"
                ></b-form-select>
                <span v-show="errors.has('order')" class="text-error text-danger text-sm">
                    {{ errors.first("order") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>

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
                    @change="handleUploadFile"
                    :class="{ 'is-invalid': errors.has('image') }"
                    v-model="form.image"
                    v-validate="'required'"
                    ></b-form-file>
                    <span v-show="errors.has(`image`)" class="text-error text-danger text-sm">
                      {{ errors.first(`image`) }}
                    </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">
                <a v-if="form.image != '' && typeof form.image === 'string'" :href="form.image" target="_blank">
                    <button @click.prevent="deleteFile" style="color:red; float:right">x</button>
                    <b-img
                        :lazy-src="form.image"
                        :src="form.image"
                        max-height="100"
                        max-width="150"
                        class="img-fluid"
                    />
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
