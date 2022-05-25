<template>
   <div class="step">
        <h3>{{$t('front.activate_phone')}}</h3>
        <div class="inline-d">
            <p class="grey">{{$t('front.activate_hint')}}</p>
            <!-- <a class="blue mr-5">
                {{$t('front.change')}}
            </a> -->
            <div class="form">
            <b-form @submit.prevent="verifyCode()" class="form">
                <div id="confirm-box">
                    <input v-for="(key,idx) in requiredCells"
                    :key="idx"
                    ref="codeRef"
                    v-validate="{ required: true, numeric: true }"
                    type="text"
                    maxlength="1"
                    :value="activationCells[idx]"
                    class="input-code"
                    :name="`code`"
                    @input="inputActivationCode($event.target.value, idx)">
                </div>
                <button type="submit" class="button btn-gredient full">{{ $t('front.confirm') }}</button>
            </b-form>
            <span v-show="errors.has(`code`)" class="text-error text-danger text-sm">
                {{ errors.first(`code`) }}
            </span>
            <div class="resend">
                <img src="~/assets/website/imgs/login/resend.svg" alt="">
                <a class="grey cursor" @click="resendCode">{{$t('front.resend_code')}}</a>
                <!-- <span class="grey">{{$t('front.send_code_within')}} </span> -->
                <!-- <span class="grey" id="timer">00:05</span> -->
            </div>
            </div>
        </div>
    </div>
</template>

<script src="./-index.js"></script>
