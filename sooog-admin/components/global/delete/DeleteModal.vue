<template>
  <modal
    v-if="modalProps"
    :adaptive="true"
    :height="modalProps.height"
    :width="modalProps.width"
    :min-height="modalProps.minHeight"
    :scrollable="modalProps.scrollable"
    name="deleteModal"
    :click-to-close="false"
  >
    <div slot="top-right">
      <button @click="cancelModal">
        x
      </button>
    </div>
    <div class="vs-modal">
      <!--Modal Header-->
      <div class="modal-header">
        <h4>{{ $t('admin.delete_modal') }}</h4>
      </div>
        <!--Modal Body-->
        <div class="modal-body">
          <div class="col-md-12 text-center">
            {{$t('admin.delete_message')}}
          </div>
        </div>

        <!--Modal Footer-->
        <div class="modal-footer">
          <div class="control">
            <Button @clickFn="confirmModal" size="sm" bgGreen>{{$t('admin.confirm')}}</Button>
            <Button @clickFn="cancelModal" size="sm" bgRed>{{$t('admin.cancel')}}</Button>
          </div>
        </div>
    </div>
  </modal>
</template>

<script src="./main.js"></script>
<style src="./main.css"></style>
