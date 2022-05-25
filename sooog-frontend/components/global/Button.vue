<template>
  <b-button
    @click="$emit('clickFn')"
    class="button__element button"
    :to="to"
    :disabled="disabled"
    :type="type"
    :size="size"
    :class="{
      roundedradius: roundedRadius,
      block: block,
      smallradius: smallRadius,
      transparent: transparent,
      transparent_green: transparent_green,
      transparent_red: transparent_red,
      green: bgGreen,
      blue: bgBlue,
      bg_red: bgRed,
      grey: bgGrey,
      black: bgBlack,
      orange: bgorange
    }"
  >
    <slot></slot>
  </b-button>
</template>

<script>
export default {
  name: "Button",

  props: {
    to: String,
    type: String,
    size: String,
    block: Boolean,
    disabled: Boolean,
    bgGreen: Boolean,
    bgBlue: Boolean,
    bgRed: Boolean,
    bgorange: Boolean,
    bgGrey: Boolean,
    bgBlack: Boolean,
    transparent_green: Boolean,
    transparent_red: Boolean,
    transparent: Boolean,
    smallRadius: Boolean,
    roundedRadius: Boolean
  }
};
</script>

<style scoped>
button {
  background: transparent;
  color: #fff;
  border: none;
}

button:focus {
  outline: none;
  box-shadow: none;
}

.btn {
  padding: 0.5rem 3rem;
  outline: none;
}

a {
  margin: 1rem 0;
}

.block {
  width: 100%;
}
.green {
  background: #5ad07a;
  color: #fff;
}
.blue {
  background: #2680eb;
  border: 1px solid #2680eb;
}
.bg_red {
  background: #eb4b51;
  border: 1px solid #eb4b51;
}
.transparent_green {
  background: transparent;
  border: 1px solid #5ad07a;
  color: #5ad07a;
}

.transparent_red {
  background: transparent;
  border: 1px solid #eb4b51;
  color: #eb4b51;
}

.orange {
  background: transparent linear-gradient(104deg, #2f0a4d 0%, #6a2f94 100%);
  color: #fff;
}
.grey {
  background: #eaeaea;
  color: #350e54 !important;
}
.black {
  color: #fff;
  background-color: #5a6268;
  border-color: #545b62;
}
.transparent {
  background: transparent;
  color: #43cd8e;
  padding: 0;
}

.roundedradius {
  border-radius: 50%;
}

.smallradius {
  border-radius: 3rem;
}
</style>
