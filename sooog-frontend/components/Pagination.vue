<template>
    <ul class="ul-pagination custom-padd">
      <li class="arrow cursor" @click="$emit('prev-page')">
        <a>
          <!--<img src="~/assets/website/imgs/paginations/angle-l.svg" alt="">-->
          <i class="fas fa-angle-right"></i>
        </a>
      </li>
      <li @click="$emit('page-changed', page)" :class="`cursor ${pagination.current_page == page ? 'active' : ''}`"
        v-for="(page, key) in pagination.last_page" :key="key">
        <a>{{page}}</a>
      </li>
      <li class="arrow cursor" @click="$emit('next-page')">
        <a>
          <i class="fas fa-angle-left"></i>
          <!--<img src="~/assets/website/imgs/paginations/angle-r.svg" alt="">-->
        </a>
      </li>
    </ul>
</template>

<script>
export default {
  props: {
    pagination: {
      required: true
    }
  },
  created () {
    console.log('pagina>>>', this.pagination)
  },
};
</script>




