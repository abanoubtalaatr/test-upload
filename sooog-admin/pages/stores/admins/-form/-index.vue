<template>
    <b-form @submit.prevent="submit">

        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.name')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="name"
                    v-model="form.name"
                    v-validate="{ required: true }"
                    :placeholder="$t('admin.name')"
                    :class="{ 'is-invalid': errors.has('name') }"
                ></b-form-input>
                <span v-show="errors.has('name')" class="text-error text-danger text-sm">
                    {{ errors.first("name") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.phone')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="phone"
                    v-model="form.phone"
                    v-validate="{ required: true, numeric:true, min:7, max:13 }"
                    :placeholder="$t('admin.phone')"
                    :class="{ 'is-invalid': errors.has('phone') }"
                ></b-form-input>
                <span v-show="errors.has('phone')" class="text-error text-danger text-sm">
                    {{ errors.first("phone") }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.email')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    name="email"
                    v-model="form.email"
                    v-validate="{ required: true, email: true }"
                    :placeholder="$t('admin.email')"
                    :class="{ 'is-invalid': errors.has('email') }"
                ></b-form-input>
                <span v-show="errors.has('email')" class="text-error text-danger text-sm">
                    {{ errors.first("email") }}
                </span>
                </b-form-group>
            </b-col>

        </b-row>
        <b-row>
            <b-col md="12">
                <b-form-group
                :label="$t('admin.password')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    type="password"
                    name="password"
                    v-model="form.password"
                    v-validate="{ required: isRequired }"
                    :placeholder="$t('admin.password')"
                    :class="{ 'is-invalid': errors.has('password') }"
                ></b-form-input>
                <span v-show="errors.has('password')" class="text-error text-danger text-sm">
                    {{ errors.first("password") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row v-if="isRequired">
            <b-col md="12">
                <b-form-group
                :label="$t('admin.password_confirmation')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
                >
                <b-form-input
                    type="password"
                    name="password_confirmation"
                    v-model="form.password_confirmation"
                    v-validate="{ required: isRequired}"
                    :placeholder="$t('admin.password_confirmation')"
                    :class="{ 'is-invalid': errors.has('password_confirmation') }"
                ></b-form-input>
                <span v-show="errors.has('password_confirmation')" class="text-error text-danger text-sm">
                    {{ errors.first("password_confirmation") }}
                </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.roles')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <multiselect
                  v-model="form.roles"
                  :options="roles.map(obj => obj.id)"
                  :custom-label="opt => roles.find(obj => obj.id == opt).display_name"
                  value="key"
                  :close-on-select="true"
                  :clear-on-select="false"
                  :hide-selected="false"
                  :preserve-search="true"
                  :placeholder="$t('admin.roles')"
                  label="key"
                  :allowEmpty="true"
                  :preselect-first="false"
                  id="key"
                  name="roles"
                  multiple
                  v-validate="{ required: true }"
                >
                  <span slot="noOptions">
                    {{$t('admin.empty_list')}}
                  </span>
                  <span slot="noResult">
                    {{$t('admin.no_results')}}
                  </span>
                </multiselect>
                <span v-show="errors.has(`roles`)" class="text-error text-danger text-sm">
                  {{ errors.first(`roles`) }}
                </span>
              </b-form-group>
            </b-col>
        </b-row>

        <b-row>
            <b-col md="12">
                <b-form-group
                    :label="$t('admin.avatar')"
                    label-for="input-horizontal"
                    id="fieldset-horizontal"
                    label-cols-sm="2"
                >
                    <b-form-file
                    :placeholder="$t('admin.choose_file')"
                    :browse-text="$t('admin.browse_file')"
                    accept="image/*"
                    name="avatar"
                    ref="fileupload"
                    @change="handleUploadFile"
                    :class="{ 'is-invalid': errors.has('avatar') }"
                    v-model="form.avatar"
                    v-validate="'required'"
                    ></b-form-file>
                    <span v-show="errors.has(`avatar`)" class="text-error text-danger text-sm">
                      {{ errors.first(`avatar`) }}
                    </span>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6"></b-col>
            <b-col md="6">

                <a v-if="form.avatar != '' && typeof form.avatar === 'string'" :href="form.avatar" target="_blank">
                    <button @click.prevent="deleteFile" style="color:red; float:right">x</button>
                    <b-img
                        :lazy-src="form.avatar"
                        :src="form.avatar"
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
