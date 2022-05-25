import { mapState } from 'vuex'
import RoleService from "~/pages/dashboard/roles/service/RoleService.js";

export default {
  props: {
    item: {
      required: false
    },
    groups: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      form: {
        en: { display_name: '' },
        ar: { display_name: '' },
        is_active: true,
        permissions: []
      },
      selectAll: false,
      param_id: this.$route.params.id,
      submitted: false
    }
  },
  computed: {
    ...mapState({
      currentLocale: state => state.localStorage.currentLocale,
    })
  },
  async fetch() {
    if (this.param_id) {
      this.reAssignForm()
    }
  },
  fetchOnServer: true,
  methods: {
    reAssignForm () {
      this.form = {
        ...(({permissions, ...rest} = this.item) => (rest))(),
        ...{permissions: this.item.permissions.map((obj) => obj.id)}
      }
      let all_permissions = []
      this.groups.forEach((element) => {
        all_permissions = all_permissions.concat(element.permissions)
      })
      this.$nextTick(() => {
        if(this.form.permissions.length == all_permissions.length){
          console.log('hhhhhhhhhhhhhere')
          this.selectAll = true
          console.log('hhhhhhhhh', this.selectAll)
        }
      })
      
      console.log('usr_perm', this.form.permissions.length)
      console.log('allll', all_permissions.length)
    },
    selectAllPers () {
      if (this.form.permissions.length) {
        this.form.permissions = []
        this.selectAll = false
      } else {
        this.selectAll = true
        this.groups.forEach(element => {
          this.form.permissions = [...this.form.permissions, ...
            (element.permissions.map((obj) => obj.id))
          ]
        })
      }
    },
    async submit () {
      this.submitted = true
      const validData = await this.$validator.validateAll()
      if (validData) {
        if (this.param_id) {
          this.update()
        } else {
          this.create()
        }
      }else{
        this.submitted = false
      }
    },
    async update () {
      await RoleService.update(this.form, this.param_id)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.updated_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    async create () {
      await RoleService.create(this.form)
      .then(() => {
        this.back()
        this.$toast.success(this.$t('admin.created_successfully'))
      })
      .catch(() => {
        this.submitted = false
      })
    },
    back () {
      this.$router.push(this.localePath({ name: "dashboard-roles" }))
    }
  },
  watch: {
    'form.permissions': function (newVal, oldVal) {
      let allPermissions = []
      this.groups.forEach(element => {
        allPermissions = [...allPermissions, ...
          (element.permissions.map((obj) => obj.id))
        ]
      })
      debugger
      if (newVal.length == allPermissions.length) {
        debugger
        this.selectAll = true
      } else {
        this.selectAll = false
      }
    }
  }
}
