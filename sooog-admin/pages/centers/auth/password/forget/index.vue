<template>
  <!-- Login Page -->
  <div class="login-page">
    <div class="overlay">
      <div class="form">
        <h4 class="main-color">{{$t('admin.change_password')}}</h4>
        <!-- Login Form -->
        <b-form @submit.prevent="submit()">
          <b-form-input type="email" name="email" :placeholder="$t('admin.email')"
            v-model="form.email" v-validate="{ required: true, email: true }">
          </b-form-input>
          <span v-show="errors.has('email')" class="text-error text-danger text-sm">
            {{ errors.first("email") }}
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
