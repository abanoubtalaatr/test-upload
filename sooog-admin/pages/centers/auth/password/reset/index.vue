<template>
  <!-- Login Page -->
  <div class="login-page">
    <div class="overlay">
      <div class="form">
        <h4 class="main-color">{{$t('admin.change_password')}}</h4>
        <!-- Login Form -->
        <b-form @submit.prevent="submit()">

          <b-form-input type="text" name="code" :placeholder="$t('admin.verification_code')"
            v-model="form.token" v-validate="{ required: true }">
          </b-form-input>
          <span v-show="errors.has('code')" class="text-error text-danger text-sm">
            {{ errors.first("code") }}
          </span>

          <b-form-input type="password" name="password" :placeholder="$t('admin.password')"
            v-model="form.password" v-validate="{ required: true, min: 8 }">
          </b-form-input>
          <span v-show="errors.has('password')" class="text-error text-danger text-sm">
            {{ errors.first("password") }}
          </span>

          <b-form-input type="password" name="confirm_password" :placeholder="$t('admin.confirm_password')"
            v-model="form.password_confirmation" v-validate="{ required: true, min: 8 }">
          </b-form-input>
          <span v-show="errors.has('confirm_password')" class="text-error text-danger text-sm">
            {{ errors.first("confirm_password") }}
          </span>

          <Button bgBlack block type="submit">
            {{$t('admin.change')}}
            <b-spinner small type="grow" v-if="loading"></b-spinner>
          </Button>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script src="./index.js"></script>
<style scoped src="./index.css"></style>
