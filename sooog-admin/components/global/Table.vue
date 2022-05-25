<template>
  <div>
    <!-- <div class="table_search">
      <b-row>
        <b-col lg="3" class="my-1">
          <Search />
          <b-form-group>
            <b-input-group size="sm">
              <b-form-input
                v-model="search_input"
                type="search"
                 :placeholder ="$t('sreach')"
                @input="$emit('searchFn', $event)"
              ></b-form-input>

              <b-input-group-append>
                <b-button :disabled="!search_input" @click="search_input = ''"
                  >Clear</b-button
                >
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>
    </div> -->

    <b-table striped borderless :items="collection" :fields="records" no-local-sorting  @sort-changed="sortingChanged" show-empty>
      <template #empty="scope">
       <div class="text-center">  {{$t('admin.no_data')}}</div>
      </template>
      <template
        v-for="dataTableSlot in Object.keys($scopedSlots)"
        v-slot:[dataTableSlot]="slotScope"
      >
        <slot :name="dataTableSlot" v-bind="slotScope" />
      </template>
      <!--<div> No Data</div>-->
    </b-table>

    <b-row v-if="pagination">
      <b-col lg="6" class="my-1">
        {{$t('admin.showing_page_number')}}
        {{ collection.length ? current_page : 0 }}
      </b-col>

      <b-col v-if="pagination" lg="6" class="my-1">
        <b-pagination
          v-model="current_page"
          :total-rows="pagination.total"
          :per-page="pagination.per_page"
          :last-page="pagination.last_page"
          pills
          align="right"
          @input="$emit('page-changed', current_page)"
          class="my-3 heavy-rain-gradient"
        />
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  props: {
    collection: {
      type: Array,
      default: null
    },
    records: {
      type: Array,
      default: null
    },
    pagination: {
      type: Object,
      default: () => {}
    }
  },

  data() {
    return {
      total: 1,
      current_page: 1,
      per_page: 10,
      last_page: "",
      search_input: ""
    };
  },
  methods: {
    sortingChanged(ctx) {
      this.$emit('sort-updated', ctx)
      // ctx.sortBy   ==> Field key for sorting by (or null for no sorting)
      // ctx.sortDesc ==> true if sorting descending, false otherwise
    },
  }
};
</script>

<style scoped>
.table {
  font-size: 12px;
}
table {
  border-collapse: separate;
  border-spacing: 0 20px;
}
.table thead th{
  text-align: center !important;
}
table[data-v-4e6ff006] {
  border-collapse: separate;
  border-spacing: 2px;
  border: 2px solid #f1f1f1;
}
</style>
