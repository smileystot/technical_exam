<template>
  <div>
    <v-row>
      <h4>Expenses</h4>
      <v-spacer></v-spacer>
      <h4>Expense Management > Expenses</h4>
    </v-row>
    <div>
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Expense Category
              </th>
              <th class="text-left">
                Amount
              </th>
              <th class="text-left">
                Entry Date
              </th>
              <th class="text-left">
                Created At
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(ex,index) in expenses"
              :key="index"
              @click="Edit(index)"
            >
              <td>{{ ex.CategoryName }}</td>
              <td>$ {{ WithCommas(ex.ExpenseAmount) }}</td>
              <td>{{ ex.updated_at === undefined ? null : ex.updated_at.substr(0,10) }}</td>
              <td>{{ ex.created_at === undefined ? null : ex.created_at.substr(0,10) }}</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
      <v-row>
        <v-spacer></v-spacer>
        <v-btn @click="AddDialog = true">Add Expense</v-btn>
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
          <span class="headline">Edit Expense</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="updateExpense">
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                  <v-select
                  :items="categories"
                  item-text="CategoryName"
                  item-value="id"
                  v-model="edit.ExpenseCategory"
                  :rules="rules.required"
                  label="Expense Category"                
                  ></v-select>
                </v-col>
                <v-col
                cols="12"
                sm="12"
                md="12"
                >
                  <v-text-field
                    label="Amount"
                    v-model="edit.ExpenseAmount"
                    :rules="rules.required"
                    onkeydown="return ( event.ctrlKey || event.altKey 
                      || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                      || (95<event.keyCode && event.keyCode<106)
                      || (event.keyCode==8) || (event.keyCode==9) 
                      || (event.keyCode>34 && event.keyCode<40) 
                      || (event.keyCode==46) )"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="12"
                >
                <v-dialog
                    ref="dialog"
                    v-model="DatepickerDialog"
                    :return-value.sync="edit.updated_at"
                    width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="edit.date"
                        label="Entry Date"
                        readonly
                        :rules="rules.required"
                        append-icon="mdi-calendar"
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="edit.date"
                    >
                      <v-spacer></v-spacer>
                      <v-btn
                        text
                        color="primary"
                        @click="DatepickerDialog = false"
                      >
                        Cancel
                      </v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.dialog.save(edit.date)"
                      >
                        OK
                      </v-btn>
                    </v-date-picker>
                  </v-dialog>
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
          <span class="headline">Add Expense</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="addExpense">
            <v-row>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-select
                :items="categories"
                item-text="CategoryName"
                item-value="id"
                v-model="add.ExpenseCategory"
                :rules="rules.required"
                label="Expense Category"                
                ></v-select>
              </v-col>
              
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
                <v-text-field
                  label="Amount"
                  v-model="add.Amount"
                  :rules="rules.required"
                  onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46) )"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="12"
                md="12"
              >
              <v-dialog
                  ref="dialog"
                  v-model="DatepickerDialog"
                  :return-value.sync="add.date"
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="add.date"
                      label="Entry Date"
                      readonly
                      :rules="rules.required"
                      append-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="add.date"
                  >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="DatepickerDialog = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialog.save(add.date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-dialog>
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
      expenses:[],
      EditDialog: false,
      AddDialog: false,
      DatepickerDialog: false,
      add:{},
      edit:{}
    }
  },
  created(){
    this.Get()
    this.GetCategory()
  },
  methods:{
    WithCommas(x) {
        return x != null ? x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 0;
    },
    GetCategory(){
        axios.get('api/GetCategories')
        .then(res=>{
            this.categories= res.data
        })
    },
    Add(){
      this.$refs.addExpense.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/AddExpense',this.add)
          .then(res=>{
            this.Get()
            this.AddDialog = false
          })
        }
      },200)
    },
    Update(){
      this.$refs.updateExpense.validate();
      setTimeout(()=>{
        if($('.error--text').length == 0){
          axios.post('api/UpdateExpense',this.edit)
          .then(res=>{
            this.Get()
            this.EditDialog = false
          })
        }
      },200)
      
    },
    Delete(){
      axios.post('api/DeleteExpense',this.edit)
      .then(res=>{
        this.Get()
        this.EditDialog = false
      })
    },
    Edit(i){
        this.edit = JSON.parse(JSON.stringify(this.expenses[i]))
        this.edit.ExpenseCategory = parseInt(this.edit.ExpenseCategory)
        this.EditDialog = true
    },
    Get(){
      axios.get('api/GetExpense')
      .then(res=>{
        this.expenses= res.data
      })
    }
  }
}
</script>

<style>

</style>