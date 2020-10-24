<template>
  <div>
    <v-row>
      <h4>Roles</h4>
      <v-spacer></v-spacer>
      <h4>User Management > Roles</h4>
    </v-row>
    <div>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Display Name
              </th>
              <th class="text-left">
                Description
              </th>
              <th class="text-left">
                Created At
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(role,index) in roles"
              :key="index"
              @click="EditRole(index)"
            >
              <td>{{ role.RoleName }}</td>
              <td>{{ role.RoleDescription }}</td>
              <td>{{ role.created_at.substr(0,10) }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row>
        <v-spacer></v-spacer>
        <v-btn @click="AddRoleDialog = true">Add Role</v-btn>
      </v-row>
    </div>
    <v-row justify="center">
    <v-dialog
      v-model="EditRoleDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">Edit Role</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="updateRole">
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    label="Display Name"
                    v-model="edit.RoleName"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    v-model="edit.RoleDescription"
                    label="Description"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
            color="red"
            text
            @click="DeleteRole()"
          >
            Delete
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="EditRoleDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="UpdateRole()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="AddRoleDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">Add Role</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="addRole">
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    label="Display Name"
                    v-model="add.RoleName"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    v-model="add.RoleDescription"
                    label="Description"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="AddRoleDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="AddRole()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
  </div>
</template>

<script>
export default {
  data(){
    return {
      rules:{
        email: [
          v => !!v || "E-mail is required",
          v =>
            /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
            "E-mail must be valid"
        ],
        required: [value => !!value || 'Required.'],
      },
      roles:[],
      edit:{},
      EditRoleDialog:false,
      AddRoleDialog: false,
      add:{}
    }
  },
  created(){
    this.GetRoles();
  },
  methods:{
    DeleteRole(){
      axios.post('api/DeleteRole',this.edit)
      .then(res=>{
        this.GetRoles()
        this.EditRoleDialog = false
      })
    },
    AddRole(){

      this.$refs.addRole.validate()
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/AddRole',this.add)
          .then(res=>{
            this.AddRoleDialog = false
            this.add = {}
            this.GetRoles()
          })
      }
      },300)
    },
    UpdateRole(){
      this.$refs.updateRole.validate()
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/UpdateRole',this.edit)
          .then(res=>{
            this.EditRoleDialog = false
            this.edit = {};
            this.GetRoles();
          })
        }
      },300)
    },
    EditRole(i){
      this.edit = JSON.parse(JSON.stringify(this.roles[i]))
      this.EditRoleDialog = true
    
    },
    GetRoles(){
      axios.get('api/GetRoles')
      .then(res=>{
        this.roles = res.data
      })
    }
  }

}
</script>

<style>

</style>