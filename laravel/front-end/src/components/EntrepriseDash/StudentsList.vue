<template>
    <Navbar/>
    <div class="grid grid-cols-12 gap-4">
    <div class="col-span-3">
      <Sidebar />
    </div>
    <div class="col-span-9 mt-24 mr-24">
      <!-- Ajoutez des boutons pour choisir le type de liste -->
      <div class="flex justify-end mb-4 font-sans text-center">
        <button @click.prevent="filterByStatut('accepté')"
    class="px-6 py-2 rounded text-black text-sm tracking-wider font-medium outline-none border-2 border-green-600 hover:bg-green-300 hover:text-white transition-all duration-300 flex items-center mr-4">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
   Approvées
  </button>
  <button
  @click.prevent="filterByStatut('en attente')"
    class="px-6 py-2 rounded text-black text-sm tracking-wider font-medium outline-none border-2 border-blue-600 hover:bg-blue-300 hover:text-white transition-all duration-300 flex items-center mr-4">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
  on hold
  </button>
  
  <button
  @click.prevent="filterByStatut('rejeté')"
    class="px-6 py-2 rounded text-black text-sm tracking-wider font-medium outline-none border-2 border-red-600 hover:bg-red-300 hover:text-white transition-all duration-300 flex items-center">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    Rejetées
  </button>
</div>
      
          <h2 class="text-2xl font-bold mb-8 mt-8">Liste des demandes des étudiants</h2>
          

      <!-- Liste des demandes d'étudiants -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom et Prénom</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Étudiant</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Offre</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de Stage Demandé</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <!-- Boucle à travers les demandes d'étudiants -->
            <tr v-for="(demande, index) in storedDemandes" :key="index">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ demande.idEtudiant }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ demande.fullname }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ demande.offerId}}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ demande.typeStage }}</td>
              <td class="px-6 py-4 text-sm text-[#333]">
            <button class="text-green-500 hover:text-green-700 mr-4">
            
            </button>
        
            <form @submit.prevent="deleteDemande(demande.demandeId)">
              <button  type="submit" class="text-red-500 hover:text-red-700">Delete</button>
            </form>
         
        </td>

              <!-- Ajoutez d'autres colonnes pour afficher d'autres informations sur les demandes -->
            </tr>  
           
           
          </tbody>
        </table>
      
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
          storedDemandes:[],
          filtredDemandes:[],
          
      };
    },
      components: {
          Navbar,
          Sidebar
      },
      methods: {


        filterByStatut(statut){
          this.storedDemandes = [];
          for(let i=0;i<this.filtredDemandes.length;i++){
            if(this.filtredDemandes[i].statut==statut){
              this.storedDemandes.push(this.filtredDemandes[i]);
            }
          }
        },

      
        async getAllDemandes() {
     
      try {
          const response = await axios.get(
             "http://localhost:8000/api/Demandes"
          );
          if (response.data.check === true) {
            this.demandes = response.data.demandes;
            console.log(this.demandes);
            for(let i=0;i<this.demandes.length;i++){
              const response2 = await axios.get(`http://localhost:8000/api/getStudentDetail/${this.demandes[i].idEtudiant}`);
              let myObject = {
                idEtudiant:response2.data.student.id,
                fullname:response2.data.student.fullname,
                offerId:this.demandes[i].idOffreDeStage,
                typeStage:response2.data.student.typeStage,
                statut:this.demandes[i].statut,
                demandeId:this.demandes[i].id,
              }
              this.filtredDemandes.push(myObject);
            }
             
              console.table(this.filtredDemandes);
              this.storedDemandes=this.filtredDemandes;
              
          } else {
              toast.error("Something went wrong !", {
                  autoClose: 2000,
              });
          }
      } catch (error) {
          console.error("Error:", error);
      }
  },


  async deleteDemande(id){
    console.log(id);
        try {
          const response = await axios.delete(`http://localhost:8000/api/deleteDemande/${id}`);
          if (response.data.delete === true) {
            window.location.reload();
          } else {
            toast.error("Something went wrong !", {
            autoClose: 2000, 
            });
          }
      } catch (error) {
          console.error("Error", error);
      }
        
      }

  
      
  
  },
  
  mounted() {
  this.getAllDemandes();
  },
  }
  </script>
  
  <style>
  /* Styles spécifiques à votre tableau de bord d'entreprise */
  </style>
  