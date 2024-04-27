<template>
    <div>
      <Navbar />
      <div class="grid grid-cols-12 gap-4">
        <div class="col-span-3">
          <Sidebar />
        </div>
        <div class="col-span-9 mt-24 mr-24">
          <h2 class="text-2xl font-bold mb-8">Liste des demandes traitées</h2>
          <div class="overflow-x-auto">
      <ul class="divide-y divide-gray-200">
        <li v-for="(demande, index) in demandes" :key="index" class="py-6 flex justify-between items-center">
          <div class="flex items-center">
            <div class="mr-4 flex-shrink-0">
              <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">Demande {{ index+1 }}</p>
              <p class="text-sm text-gray-500">{{ demande.statut}}</p>
            </div>
          </div>
          <div class="flex items-center">
            <router-link :to="'/detailDemande/' + demande.id"><button class="text-blue-500 hover:text-blue-700 mr-4">Détails</button></router-link>
          </div>
        </li>
      </ul>
    </div>
  </div>
      </div>
    </div>
          



  </template>
  

  <script>
  import { toast } from "vue3-toastify";
  import "vue3-toastify/dist/index.css";
  import axios from "axios";
  import Navbar from './Navbar.vue';
  import Sidebar from './SideBar.vue';
  export default {
    data() {
      return {
          demandes:[],
      };
    },
      components: {
          Navbar,
          Sidebar
      },
      methods: {
  
  
        async getAllDemandes() {
      try {
          const response = await axios.get(
              "http://localhost:8000/api/Demandes"
          );
          if (response.data.check === true) {
            for(let i=0;i<response.data.demandes.length;i++){
              if(response.data.demandes[i].statut=="en attente"){
                this.demandes.push(response.data.demandes[i]);
              }
            }
              console.log(this.demandes);
          } else {
              toast.error("Something went wrong !", {
                  autoClose: 2000,
              });
          }
      } catch (error) {
          console.error("Error:", error);
      }
  },
  
      
  
  },
  
  mounted() {
  this.getAllDemandes();
  },
  }
  </script>
  
  <style>
  /* Ajoutez vos styles de tableau de bord spécifiques ici */
  </style>
  