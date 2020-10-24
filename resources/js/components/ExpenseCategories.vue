<template>
  <div>
    <v-row>
      <h4>Expense Categories</h4>
      <v-spacer></v-spacer>
      <h4>Expense Management > Expense Categories</h4>
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
              v-for="(cat,index) in categories"
              :key="index"
              @click="Edit(index)"
            >
              <td>{{ cat.CategoryName }}</td>
              <td>{{ cat.CategoryDescription }}</td>
              <td>{{ cat.created_at.substr(0,10) }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row>
        <v-spacer></v-spacer>
        <v-btn @click="AddDialog = true">Add Category</v-btn>
      </v-row>
    </div>
    <v-row justify="center">
    <v-dialog
      v-model="EditDialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">Edit Category</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="updateCategory">
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    label="Display Name"
                    :rules="rules.required"
                    v-model="edit.CategoryName"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-text-field
                    label="Description"
                    :rules="rules.required"
                    v-model="edit.CategoryDescription"
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
            @click="Delete()"
          >
            Delete
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="EditDialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="Update()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
     <v-dialog
      v-model="AddDialog"
      persistent
      max-width="600px"
    >
    <v-card>
        <v-card-title>
          <span class="headline">Add Category</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="addCategory">
            <v-row>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Display Name"
                  v-model="add.CategoryName"
                  :rules="rules.required"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Description"
                  v-model="add.CategoryDescription"
                  :rules="rules.required"
                ></v-text-field>
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
            @click="Add()"
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
      categories:[],
      EditDialog: false,
      AddDialog: false,
      add:{},
      edit:{}
    }
  },
  created(){
    this.Get()
  },
  methods:{
    Add(){
      this.$refs.addCategory.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/AddCategory',this.add)
          .then(res=>{
            this.Get()
            this.AddDialog = false
          })
        }
      },200)
    },
    Update(){
      this.$refs.updateCategory.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/UpdateCategory',this.edit)
          .then(res=>{
            this.Get()
            this.EditDialog = false
          })
        }
      },200)
      
    },
    Delete(){
      axios.post('api/DeleteCategory',this.edit)
      .then(res=>{
        this.Get()
        this.EditDialog = false
      })
    },
    Edit(i){
        this.edit = JSON.parse(JSON.stringify(this.categories[i]))
        this.EditDialog = true
    },
    Get(){
      axios.get('api/GetCategories')
      .then(res=>{
        this.categories= res.data
      })
    }
  }
}
</script>

<style>

</style>