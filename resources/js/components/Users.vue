<template>
  <div>
    <v-row>
      <h4>Users</h4>
      <v-spacer></v-spacer>
      <h4>User Management > Users</h4>
    </v-row>
    <div>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Email Address
              </th>
              <th class="text-left">
                Role
              </th>
              <th class="text-left">
                Created At
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user,index) in users"
              :key="index"
              @click="EditUser(index)"
            >
              <td>{{ user.FirstName }} {{ user.LastName }}</td>
              <td>{{ user.Email }}</td>
              <td>{{ user.RoleName }}</td>
              <td>{{ user.created_at.substr(0,10) }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row>
        <v-spacer></v-spacer>
        <v-btn @click="AddUserDialog = true">Add User</v-btn>
      </v-row>
    </div>
    <v-row justify="center">
    <v-dialog
      v-model="EditUserDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">Edit User</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="updateUser">
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                  md="6"
                >
                  <v-text-field
                    label="First Name"
                    v-model="edit.FirstName"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                  md="6"
                >
                  <v-text-field
                    label="Last Name"
                    v-model="edit.LastName"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    label="Email"
                    v-model="edit.Email"
                    :rules="rules.required"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-select
                    :items="roles"
                    item-text="RoleName"
                    item-value="id"
                    v-model="edit.AccessRights"
                    :rules="rules.required"
                    label="Role"
                  ></v-select>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
            color="red"
            text
            @click="DeleteUser()"
          >
            Delete
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="EditUserDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="UpdateUser()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
     <v-dialog
      v-model="AddUserDialog"
      persistent
      max-width="600px"
    >
    <v-card>
        <v-card-title>
          <span class="headline">Add User</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="addUser">
            <v-row>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="First Name"
                  v-model="add.FirstName"
                  :rules="rules.required"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="Last Name"
                  v-model="add.LastName"
                  :rules="rules.required"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Email"
                  v-model="add.Email"
                  :rules="rules.email"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-select
                  :items="roles"
                  item-text="RoleName"
                  item-value="id"
                  v-model="add.AccessRights"
                  :rules="rules.required"
                  label="Role"
                ></v-select>
              </v-col>
            </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="AddUserDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="AddUser()"
          >
            Add
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
      users:[],
      EditUserDialog: false,
      AddUserDialog: false,
      roles:[],
      add:{},
      edit:{}
    }
  },
  created(){
    this.GetUsers()
    this.GetRoles()
  },
  methods:{
    AddUser(){
      this.$refs.addUser.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/AddUser',this.add)
          .then(res=>{
            this.GetUsers()
            this.AddUserDialog = false
          })
        }
      },200)
    },
    UpdateUser(){
      this.$refs.updateUser.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/UpdateUser',this.edit)
          .then(res=>{
            this.GetUsers()
            this.EditUserDialog = false
          })
        }
      },200)
      
    },
    DeleteUser(){
      axios.post('api/DeleteUser',this.edit)
      .then(res=>{
        this.GetUsers()
        this.EditUserDialog = false
      })
    },
    EditUser(i){
      if(this.users[i].AccessRights != 1){
        this.edit = JSON.parse(JSON.stringify(this.users[i]))
        this.edit.AccessRights = parseInt(this.users[i].AccessRights)
        this.EditUserDialog = true
      }else{
        alert('Cannot Edit Admin Account!');
      }
    },
    GetRoles(){
      axios.get('api/GetRoles')
      .then(res=>{
        this.roles = res.data
      })
    },
    GetUsers(){
      axios.get('api/GetUsers')
      .then(res=>{
        this.users= res.data
      })
    }
  }
}
</script>

<style>

</style>