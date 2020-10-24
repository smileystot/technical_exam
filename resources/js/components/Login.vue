<template>
  <v-app>
    <v-main>
      <v-container fluid fill-height height="95vh">
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="teal">
                <v-toolbar-title>Login</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <span style="color:red" v-if="errorMsg != ''">{{errorMsg}}</span>
                <v-form ref="LoginForm">
                  <v-text-field prepend-icon="email"   v-model="credentials.Email" :rules="rules.email" @keyup.enter="FocusPasswordField()" name="login" label="Email" type="text"></v-text-field>
                  <v-text-field id="password" prepend-icon="lock"   ref="Password" :rules="rules.required" v-model="credentials.Password" @keyup.enter="CheckFields()" name="password" label="Password" type="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="teal" @click="CheckFields()">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      errorMsg: '',
      drawer: null,
      credentials: {},
      rules:{
        email: [
          v => !!v || "E-mail is required",
          v =>
            /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
            "E-mail must be valid"
        ],
        required: [value => !!value || 'Required.'],
      }
    }),
    props: {
      source: String
    },
    methods:{
      FocusPasswordField(){
        this.$refs.Password.focus();
      },
      CheckFields(){
        this.$refs.LoginForm.validate();
        setTimeout(()=>{
          if($('.error--text').length == 0){
            this.Login()
          }
        },200)
        
      },
      Login(){
        axios.post('api/Login',this.credentials)
        .then(res=>{
          this.errorMsg = '';
          this.$store.commit('SET_USER_DATA',res.data)

        }).catch(err=>{
          this.errorMsg = err.response.data

        })
      },
    }
  }
</script>