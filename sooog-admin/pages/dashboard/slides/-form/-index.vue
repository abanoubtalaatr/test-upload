<template>
    <b-form @submit.prevent="submit">

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin[\'en.title\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="en.name"
                    v-model="form.en.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'en.title\']')"
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
                :label="$t('admin[\'ar.title\']')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="ar.name"
                    v-model="form.ar.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin[\'ar.title\']')"
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
                        fluid-grow
                        style="width: 50;"
                        rigth
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
