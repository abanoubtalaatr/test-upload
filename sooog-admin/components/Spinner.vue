<template>
  <div v-if="loading" class="spinner">
    <fulfilling-bouncing-circle-spinner :animation-duration="2000" :size="100" :color="'#ffa42b'" />
  </div>
</template>

<script>
//   To use minified css and js files instead of .vue single file components:
import "epic-spinners/dist/lib/epic-spinners.min.css";
import { FulfillingBouncingCircleSpinner } from "epic-spinners/dist/lib/epic-spinners.min.js";

//   import {AtomSpinner} from 'epic-spinners'
export default {
  components: {
    FulfillingBouncingCircleSpinner ,
  },
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    start() {
      this.loading = true;
    },
    finish() {
      this.loading = false;
    },
  },
};
</script>
<style  scoped>
.spinner {
  position: fixed;
  top: 50%;
  height: 0;
  left: 50%;
  z-index: 9999;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
