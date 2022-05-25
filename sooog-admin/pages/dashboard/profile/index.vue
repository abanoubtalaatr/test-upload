<template>
 <div>
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-form data-vv-scope="profile" @submit.prevent="updateProfile">

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
                  v-model="user.name"
                  v-validate="{ required: true }"
                  :placeholder="$t('admin.name')"
                  :class="{ 'is-invalid': errors.has('name', 'profile') }"
                ></b-form-input>
                <span v-show="errors.has('name', 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first("name", 'profile') }}
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
                  v-model="user.email"
                  v-validate="{ required: true, email: true }"
                  :placeholder="$t('admin.email')"
                  :class="{ 'is-invalid': errors.has('email', 'profile') }"
                ></b-form-input>
                <span v-show="errors.has('email', 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first("email", 'profile') }}
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
                  v-model="user.phone"
                  v-validate="{ required: true, numeric: true, max: 15 }"
                  :placeholder="$t('admin.phone')"
                  :class="{ 'is-invalid': errors.has('phone', 'profile') }"
                ></b-form-input>
                <span v-show="errors.has('phone', 'profile')" class="text-error text-danger text-sm">
                  {{ errors.first("phone", 'profile') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>

          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.personal_image')"
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
                  v-model="user.avatar"
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
              <a v-if="typeof(user.avatar) == 'string'" :href="user.avatar" target="_blank">
              <b-img
                :src="user.avatar"
                max-height="100"
                max-width="150"
                class="img-fluid"
              />
            </a>
            </b-col>
          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
            <!-- <Button @clickFn="close()" size="sm" bgRed>{{$t('admin.cancel')}}</Button> -->
          </div>

        </b-form>
      </card-component>

      <card-component :title="$t('admin.change_password')" icon="fas fa-clipboard-list 5x">
        <b-form data-vv-scope="password" @submit.prevent="updatePassword">

          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.old_password')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="old_password"
                  type="password"
                  v-model="form.old_password"
                  v-validate="{ required: true, min: 8 }"
                  :placeholder="$t('admin.old_password')"
                  :class="{ 'is-invalid': errors.has('old_password', 'password') }"
                ></b-form-input>
                <span v-show="errors.has('old_password', 'password')" class="text-error text-danger text-sm">
                  {{ errors.first("old_password", 'password') }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.new_password')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="new_password"
                  type="password"
                  v-model="form.password"
                  v-validate="{ required: true, min: 8 }"
                  :placeholder="$t('admin.new_password')"
                  :class="{ 'is-invalid': errors.has('new_password', 'password') }"
                ></b-form-input>
                <span v-show="errors.has('new_password', 'password')" class="text-error text-danger text-sm">
                  {{ errors.first("new_password", 'password') }}
                </span>
              </b-form-group>
            </b-col>

          </b-row>

          <b-row>
            <b-col md="12">
              <b-form-group
                :label="$t('admin.confirm_password')"
                label-for="input-horizontal"
                id="fieldset-horizontal"
                label-cols-sm="2"
              >
                <b-form-input
                  name="password_confirmation"
                  type="password"
                  v-model="form.password_confirmation"
                  v-validate="{ required: true, min: 8 }"
                  :placeholder="$t('admin.confirm_password')"
                  :class="{ 'is-invalid': errors.has('password_confirmation', 'password') }"
                ></b-form-input>
                <span v-show="errors.has('password_confirmation', 'password')" class="text-error text-danger text-sm">
                  {{ errors.first("password_confirmation", 'password') }}
                </span>
              </b-form-group>
            </b-col>

          </b-row>

          <div class="text-center mt-3 mb-2">
            <Button type="submit" size="sm" bgGreen :disabled="submitted">{{$t('admin.save')}}</Button>
          </div>

        </b-form>
      </card-component>
    </section>
 </div>
</template>

<script src="./index.js"></script>

