<template>
  <modal
    v-if="modalProps"
    :adaptive="true"
    :height="modalProps.height"
    :width="modalProps.width"
    :min-height="modalProps.minHeight"
    :scrollable="modalProps.scrollable"
    name="cancelModal"
    :click-to-close="false"
  >
    <div slot="top-right">
      <b-button @click="hideModal">
        x
      </b-button>
    </div>
    <div class="vs-modal">
      <!--Modal Header-->
      <div class="modal-header text-center">
        <h4>{{ $t('front.cancel_order') }}</h4>
      </div>
      <form @submit.prevent="submit"  @reset="hideModal()">
        <!--Modal Body-->
        <div class="modal-body">
          <b-col
            cols="12"
          >
            <div class="form-group">
              <label for="title" class="col-form-label">
                {{$t('front.cancel_reason')}}
              </label>
              <textarea
                v-model="form.reason"
                v-validate="{ required: true }"
                name="comment" class="form-control"
                :placeholder="$t('front.cancel_reason_placeholder')"
                :class="{ 'is-invalid': errors.has('comment') }"
              >
              </textarea>
            </div>
            <span v-show="errors.has('comment')" class="text-danger text-error text-sm">
              {{ errors.first("comment") }}
            </span>
          </b-col>
        </div>

        <!--Modal Footer-->
        <div class="modal-footer text-center">
            <div class="control">
              <button type="submit" class="button btn-gredient full">
                  {{$t('front.save')}}
                </button>
            </div>
            <div class="control">
              <button
                class="btn simple btn-danger"
                type="reset"
                @click="hideModal"
              >
                {{ $t('admin.cancel') }}
              </button>
            </div>
        </div>
      </form>
    </div>
  </modal>
</template>

<script src="./-index.js"></script>
<style src="./-index.css"></style>
