<template>
  <v-app>
    <v-main >
      <Navbar v-if="$store.state.isLoggedIn" app></Navbar>
      <v-sheet 
        app
        id="scrolling-techniques-7"
        :class="$store.state.isLoggedIn ? 'overflow-y-auto' : 'overflow-y-hidden'"
        
      >
        <v-container>
            <router-view/>
        </v-container>
      </v-sheet> 
      
    </v-main>
  </v-app>
</template>

<script>
import Navbar from './Navbar';
  export default {
    data: () => ({
      
    }),
    components:{
      Navbar,app
    },
    props: {
      source: String
    }
  }
</script>