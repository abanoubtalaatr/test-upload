<template>
  <!-- Login Page -->
  <div class="login-page">
    <div class="overlay">
      <div class="form">
        <h4 class="main-color">{{$t('admin.center_login')}}</h4>
        <!-- Login Form -->
        <b-form @submit.prevent="login()">
          <b-form-input type="email" name="email" :placeholder="$t('admin.email')"
            v-model="form.email" v-validate="{ required: true, email: true }">
          </b-form-input>
          <span v-show="errors.has('email')" class="text-error text-danger text-sm">
            {{ errors.first("email") }}
          </span>
          <b-form-input type="password" name="password" :placeholder="$t('admin.password')"
            v-model="form.password" v-validate="{ required: true, min: 8 }">
          </b-form-input>
          <span v-show="errors.has('password')" class="text-error text-danger text-sm">
            {{ errors.first("password") }}
          </span>

          <div class="mb-4">
            <nuxt-link :to="localePath('centers-auth-password-forget')">
              {{$t('admin.forget_password')}}
            </nuxt-link>
          </div>

          <Button bgRed block type="submit">
            {{$t('admin.login')}}
            <b-spinner small type="grow" v-if="loading"></b-spinner>
          </Button>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script src="./index.js"></script>
<style scoped src="./index.css"></style>
