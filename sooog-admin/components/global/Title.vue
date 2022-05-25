<template>
  <div id="title">
    <h4
      class="title__element"
      :class="{
        title__big: big,
        title__medium: medium,
        title__small: small,
        title__extra__small: extra_small,
        title__bold: bold,
        title__white: white,
        title__red: red,
        title__gray: gray,
        title__dark_blue: darkBlue,
        title__shadow: shadow,
        title__center: center
      }"
    >
      <slot>{{ title }}</slot>
    </h4>
  </div>
</template>

<script>
export default {
  name: "Title",
  props: {
    title: String,
    big: Boolean,
    medium: Boolean,
    bold: Boolean,
    small: Boolean,
    extra_small: Boolean,
    white: Boolean,
    red: Boolean,
    gray: Boolean,
    darkBlue: Boolean,
    shadow: Boolean,
    center: Boolean
  }
};
</script>

<style scoped>
.title__big {
  font-size: 3em;
  font-weight: bold;
}

.title__medium {
  font-size: 1.7em;
}

.title__small {
  font-size: 1em;
}

.title__extra__small {
  font-size: 0.9em;
}

.title__white {
  color: #fff;
}

.title__red {
  color: #e23428;
}

.title__gray {
  color: #aaaaaa;
}

.title__dark_blue {
  color: var(--color-primary);
}

.title__bold {
  font-weight: bold;
}

.title__shadow {
  text-shadow: 0px 4px 8px rgba(0, 0, 0, 0.25);
}

.title__center {
  text-align: center;
}

@media (min-width: 992px) and (max-width: 1183px),
  screen and (min-width: 768px) and (max-width: 991px),
  screen and (min-width: 320px) and (max-width: 767px) {
  .title__big {
    font-size: 2.2em;
  }
  .title__small {
    font-size: 1em;
  }
}
</style>
