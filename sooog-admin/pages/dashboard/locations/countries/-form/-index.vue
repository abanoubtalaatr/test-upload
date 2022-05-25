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
                  v-validate="{ required: true,max:100,min:3 }"
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
                  v-validate="{ required: true,max:100,min:3 }"
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
                :label="$t('admin.code')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="code"
                  v-model="form.code"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.code')"
                  :class="{ 'is-invalid': errors.has('code') }"
                ></b-form-input>
                <span v-show="errors.has('code')" class="text-error text-danger text-sm">
                  {{ errors.first("code") }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
           <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.flag')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    accept="image/*"
                    name="flag"
                    v-model="form.flag"
                    v-validate="'required'"
                    ref="fileupload"
                    @change="handleUploadFile"
                    :class="{ 'is-invalid': errors.has('flag') }"
                    ></b-form-file>
                    <span v-show="errors.has('flag')" class="text-error text-danger text-sm">
                    {{ errors.first("flag") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">
                <a v-if="form.flag != '' && typeof form.flag === 'string'" :href="form.flag" target="_blank">
                    <button @click.prevent="deleteFile" style="color:red; float:right">x</button>
                    <b-img
                        :lazy-src="form.flag"
                        :src="form.flag"
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
