<template>
    <b-form @submit.prevent="submit">
      <!--<b-row>-->
        <!--<b-col md="12">-->
          <!--<b-form-group-->
            <!--:label="$t('admin.is_free')"-->
            <!--label-for="input-horizontal"-->
            <!--id="fieldset-horizontal1"-->
            <!--label-cols-sm="2"-->
          <!--&gt;-->
            <!--<b-form-radio-group-->
              <!--id="radio-group-1"-->
              <!--v-model="form.is_free"-->
              <!--v-validate="{ required: true }"-->
              <!--:placeholder="$t('admin.is_free')"-->
              <!--:options="options"-->
              <!--name="is_free"-->
              <!--:class="{ 'is-invalid': errors.has('is_free') }"-->
            <!--&gt;</b-form-radio-group>-->
            <!--<span v-show="errors.has('is_free')" class="text-error text-danger text-sm">-->
                    <!--{{ errors.first("is_free") }}-->
                <!--</span>-->
          <!--</b-form-group>-->
        <!--</b-col>-->
      <!--</b-row>-->
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
            <b-col md="12" v-if="!form.is_free">
                <b-form-group
                :label="$t('admin.price')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="price"
                    v-model="form.price"
                    v-validate="{ required: true,  decimal: 3, min_value: 1 }"
                    :placeholder="$t('admin.price')"
                    :class="{ 'is-invalid': errors.has('price') }"
                ></b-form-input>
                <span v-show="errors.has('price')" class="text-error text-danger text-sm">
                    {{ errors.first("price") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.months')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="months"
                    v-model="form.months"
                    type="number"
                    v-validate="{ required: true, min_value:1 }"
                    :placeholder="$t('admin.months')"
                    :class="{ 'is-invalid': errors.has('months') }"
                ></b-form-input>
                <span v-show="errors.has('months')" class="text-error text-danger text-sm">
                    {{ errors.first("months") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.product_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="product_number"
                    type="number"
                    v-model="form.product_number"
                    v-validate="{ required: true, min_value:1 }"
                    :placeholder="$t('admin.product_number')"
                    :class="{ 'is-invalid': errors.has('product_number') }"
                ></b-form-input>
                <span v-show="errors.has('product_number')" class="text-error text-danger text-sm">
                    {{ errors.first("product_number") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.order_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="order_number"
                    type="number"
                    v-model="form.order_number"
                    v-validate="{ required: true, min_value:1 }"
                    :placeholder="$t('admin.order_number')"
                    :class="{ 'is-invalid': errors.has('order_number') }"
                ></b-form-input>
                <span v-show="errors.has('order_number')" class="text-error text-danger text-sm">
                    {{ errors.first("order_number") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
      <b-row>
        <b-col md="12">
          <b-form-group
            :label="$t('admin.has_chat')"
            label-for="input-horizontal"
            id="fieldset-horizontal2"
            label-cols-sm="2"
          >
            <b-form-radio-group
              id="radio-group-2"
              v-model="form.has_chat"
              v-validate="{ required: true }"
              :placeholder="$t('admin.has_chat')"
              :options="options"
              name="has_chat"
              :class="{ 'is-invalid': errors.has('has_chat') }"
            ></b-form-radio-group>
            <span v-show="errors.has('has_chat')" class="text-error text-danger text-sm">
                    {{ errors.first("has_chat") }}
                </span>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="12">
          <b-form-group
            :label="$t('admin.is_rfq')"
            label-for="input-horizontal"
            id="fieldset-horizontal3"
            label-cols-sm="2"
          >
            <b-form-radio-group
              id="radio-group-3"
              v-model="form.is_rfq"
              v-validate="{ required: true }"
              :placeholder="$t('admin.is_rfq')"
              :options="options"
              name="is_rfq"
              :class="{ 'is-invalid': errors.has('is_rfq') }"
            ></b-form-radio-group>
            <span v-show="errors.has('is_rfq')" class="text-error text-danger text-sm">
                    {{ errors.first("is_rfq") }}
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
                    v-model="form.image"
                    v-validate="'required'"
                    ref="fileupload"
                    @change="handleUploadFile"
                    :class="{ 'is-invalid': errors.has('image') }"
                    ></b-form-file>
                    <span v-show="errors.has('image')" class="text-error text-danger text-sm">
                    {{ errors.first("image") }}
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
