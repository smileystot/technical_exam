<template>
  <div>
        <v-app-bar
        app
        color="white"
        scroll-target="#scrolling-techniques-7"
        fixed
        >
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Expense Manager</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-btn icon @click="Logout()"><v-icon>mdi-logout</v-icon></v-btn>

    </v-app-bar>
    <v-navigation-drawer clipped-left v-model="drawer" app color="teal">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title" align="center" >
            <v-avatar  height="100" width="100">
              <v-img
                lazy-src="https://cdn.vuetifyjs.com/images/john.jpg"
                src="https://cdn.vuetifyjs.com/images/john.jpg"
                alt="John"
              >
              </v-img>
            </v-avatar>
          </v-list-item-title>
          <v-list-item-subtitle align="center">
            {{`${$store.state.user.FirstName} ${$store.state.user.LastName}` }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <!--<v-list
        dense
        nav
      >
         <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list> -->
        <v-list
            dense
            nav
        >
          <v-list-item link to="/dashboard">
        <v-list-item-icon>
          <v-icon>mdi-view-dashboard</v-icon>
        </v-list-item-icon>

        <v-list-item-title>Dashboard</v-list-item-title>
      </v-list-item>
      <v-list-group
        v-for="item in items"
        :key="item.title"
        v-model="item.active"
        :prepend-icon="item.action"
        link
        no-action
        v-show="item.restriction.includes(parseInt($store.state.user.AccessRights))"
      >
        <template v-slot:activator >
          <v-list-item-content >
            <v-list-item-title v-text="item.title "></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item
          v-for="child in item.items"
          :key="child.title"
          link
          :to="child.to"
          v-show="child.restriction.includes(parseInt($store.state.user.AccessRights))"
        >
          <v-list-item-content >
            <v-list-item-title v-text="child.title"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
    
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
    data(){
        return {
            drawer: false,
            items: [
                
            {
            title: 'User Management',
            action: 'mdi-account',
            restriction:[1], 
            items: [
                { 
                    title: 'Roles',
                    to:'/roles',
                    restriction:[1] 
                },
                { 
                    title: 'Users',
                    to:'/users',
                    restriction:[1] 
                }
            ],
            
            },
            {
            action: 'mdi-format-list-bulleted',
            title: 'Expense Management',
            restriction:[1,2,3,4,5,6,7,8,9],
            items: [
                { 
                    title: 'Expense Categories' ,
                    to:'/expense_categories',
                    restriction:[1]
                },
                { 
                    title: 'Expenses' ,
                    to:'/expenses',
                    restriction:[1,2,3,4,5,6,7,8,9]
                },

            ],
            
            },
        ],
            right: null,
        }
    },
    methods:{
      Logout(){
        this.$store.commit('LOGOUT')
        setTimeout(()=>{
          this.$router.push('/login')
        },300)
      }
    }
    
}
</script>

<style>
    .v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child{
        margin-right: 10px
    }
</style>