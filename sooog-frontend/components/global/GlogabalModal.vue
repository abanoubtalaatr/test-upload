<template>
  <div>
    <b-modal
      :size="size"
      :centered="centered"
      :id="id"
      header-class="manage_model_header"
      footer-class="manage_model_footer"
      body-class="manage_model_body"
    >
      <slot name="modal"></slot>
    </b-modal>
  </div>
</template>


<script>
export default {
  props: {
    id: String,
    size: String,
    centered: Boolean,
  },
};
</script>




