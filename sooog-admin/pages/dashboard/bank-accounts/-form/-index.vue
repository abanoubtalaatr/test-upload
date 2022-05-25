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
                :label="$t('admin.account_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="account_number"
                    v-model="form.account_number"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.account_number')"
                    :class="{ 'is-invalid': errors.has('account_number') }"
                ></b-form-input>
                <span v-show="errors.has('account_number')" class="text-error text-danger text-sm">
                    {{ errors.first("account_number") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.iban_number')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="iban_number"
                    v-model="form.iban_number"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.iban_number')"
                    :class="{ 'is-invalid': errors.has('iban_number') }"
                ></b-form-input>
                <span v-show="errors.has('iban_number')" class="text-error text-danger text-sm">
                    {{ errors.first("iban_number") }}
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
                        accept="image/*"
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
