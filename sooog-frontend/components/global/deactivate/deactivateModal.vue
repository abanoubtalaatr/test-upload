<template>
  <modal
    v-if="modalProps"
    :adaptive="true"
    :height="modalProps.height"
    :width="modalProps.width"
    :min-height="modalProps.minHeight"
    :scrollable="modalProps.scrollable"
    name="deactivateModal"
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
        <h4>{{ $t('admin.reason_modal') }}</h4>
      </div>
        <!--Modal Body-->
        <div class="modal-body">
          <!-- <div class="col-md-12 text-center">
            name
          </div>
            <b-row> -->
                <b-col md="12">
                    <b-form-group
                        :label="$t('admin.reason')"
                        label-for="input-horizontal"
                        id="fieldset-horizontal"
                        label-cols-sm="3"
                    >
                    <b-form-textarea
                        v-model="form.reason"
                        :placeholder="$t('admin.reason')"
                        rows="3"
                        max-rows="6"
                        name='reason'
                        v-validate="{ required: true, max: 1000 }"
                        :class="{ 'is-invalid': errors.has('reason') }"
                    ></b-form-textarea>
                    <span v-show="errors.has('reason')" class="text-error text-danger text-sm">
                    {{ errors.first(`reason`) }}
                    </span>
                </b-form-group>
                </b-col>
            </b-row>
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
