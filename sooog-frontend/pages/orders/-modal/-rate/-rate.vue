<template>
  <modal
    v-if="modalProps"
    :adaptive="true"
    :height="modalProps.height"
    :width="modalProps.width"
    :min-height="modalProps.minHeight"
    :scrollable="modalProps.scrollable"
    name="addRatingModal"
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
        <h4>{{ $t('front.add_rate') }}</h4>
      </div>
      <form @submit.prevent="submitRating"  @reset="hideModal()">
        <!--Modal Body-->
        <div class="modal-body">
          <div class="col-md-12 text-center">
            <StarsRatings
              v-bind:increment="1"
              v-bind:max-rating="5"
              inactive-color="#D3E6FB"
              active-color="#f9ae00"
              v-bind:star-size="20"
              v-model="form.rate"
              name="rate"
              v-validate="'required'"
            >
            </StarsRatings>
            <span v-show="errors.has('rate')" class="text-error text-sm">
              {{ errors.first("rate") }}
            </span>
          </div>
          <b-col
            cols="12"
          >
            <div class="form-group">
              <label for="title" class="col-form-label">
                {{$t('front.comment')}}
              </label>
              <textarea
                v-model="form.comment"
                v-validate="{ required: true }"
                name="comment" class="form-control"
                :placeholder="$t('front.comment_placeholder')"
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
                  {{$t('front.send_rate')}}
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

<script src="./-rate.js"></script>
<style src="./-rate.css"></style>
