<template>
  <div class="upper-search" v-if="isSearch">
    <b-form-group class="search_result">
      <i class="fa fa-search"></i>
      <b-input-group>
        <b-form-input type="search" v-model="searchValue"
            :placeholder="$t('admin.search')"
        @input="debouncedNormalSearch"></b-form-input>
      </b-input-group>
    </b-form-group>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  data () {
    return {
      isSearch: false,
      searchValue: '',
      customEvents: [
        { eventName: 'enable-quick-search', callback: this.enableSearch },
        { eventName: 'reset-quick-search', callback: this.resetSearch }
      ]
    }
  },
  created () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$on(customEvent.eventName, customEvent.callback)
    }.bind(this))
    // eslint-disable-next-line no-undef
    this.debouncedNormalSearch = _.debounce(this.search, 500)
  },
  mounted () {
    this.searchValue = ''
  },
  beforeDestroy () {
    this.customEvents.forEach(function (customEvent) {
      // eslint-disable-next-line no-undef
      this.$EventBus.$off(customEvent.eventName, customEvent.callback)
    }.bind(this))
  },
  methods: {
    enableSearch (flag) {
      this.isSearch = flag
    },
    resetSearch () {
      this.searchValue = ''
    },
    search () {
      this.$EventBus.$emit('handle-quick-search', this.searchValue == "0" ? false : this.searchValue)
    }
  }
}
</script>


<style scoped>
.upper-search {
  display: inline-block;
  margin-left: 1rem;
}
.search_result {
  position: relative;
  width: 185px;
  color: #bdbdbd;
  margin-left: 1rem;
  display: inline-block;
}
.search_result input {
  border-color: #e1e1e1;
  height: 42px;
  padding-right: 2.5rem;
  font-size: 16px;
}
.search_result input::placeholder {
  color: #bdbdbd;
}
.search_result label {
  display: none;
}
.search_result i {
  position: absolute;
  top: 15px;
  right: 15px;
  color: #bdbdbd;
  z-index: 333;
}
button {
  border: 1px solid #e1e1e1;
  color: #bdbdbd !important;
  height: 42px;
  font-size: 16px;
  background: none !important;
  width: 125px;
  text-align: left;
  float: left;
}
button i {
  float: right;
  margin-top: 5px;
}
.upper-search {
  text-align: left;
}
@media(max-width: 578px) {
  .upper-search {
    text-align: right;
  }
}
@media(max-width: 450px) {
  .search_result,
  button {
    width: 100%;
    float: unset;
    text-align: right;
    margin-bottom: 1rem;
  }
  button i {
    margin-left: 0.5rem;
  }
}
</style>
