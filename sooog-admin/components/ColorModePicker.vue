<template>
  <ul>
    <li class="switcher">
      <i @click="$colorMode.preference = 'light'" class="fas fa-lightbulb"></i>
      <i @click="$colorMode.preference = 'dark'" class="fas fa-moon"></i>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      colors: ["light", "dark"]
    };
  }
};
</script>

<style>
.switcher {
  font-size: 1.3em !important;
}
.switcher .fa-lightbulb {
  color: #fdb6a8;
}
.switcher i {
  cursor: pointer;
}
</style>
