<template>
  <div class="container mt-5">
    <h2>Your Pets</h2>
     <router-link to="/new" class="btn btn-primary mb-3">Create New Pet</router-link>
    <div class="row">
      <div class="col-md-3" v-for="pet in pets" :key="pet.id">
        <div class="card">
          <div class="icon-container" v-if="isDangerous(pet)">
            <i class="fa-solid fa-triangle-exclamation cursor-pointer" title="This Dog is Dangerous"></i>
          </div>
          <div class="placeholder-pet">
            <i class="fa-solid fa-paw"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ pet.name }}</h5>
            <p class="card-text">DOB: {{ pet.dob }}</p>
            <p class="card-text">Gender: {{ pet.gender }}</p>
            <p class="card-text">Cross Breed: {{ pet.cross_breed ? 'Yes' : 'No' }}</p>
            <p class="card-text">
              <span v-if="isDangerous(pet)">Dangerous</span>
              <span v-else>Not Dangerous</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'DashboardPage',

  data() {
    return {
      pets: []
    };
  },
  mounted() {
    this.fetchPets();
  },
  methods: {
    async fetchPets() {
      try {
        const token = localStorage.getItem('token');
        const config = {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        };
        const response = await axios.get('http://localhost:9000/api/pet', config);
        this.pets = response.data;
      } catch (error) {
        console.error('Error fetching pets:', error);
      }
    },
    getBreedImage() {
      // Return the URL of the placeholder image based on the breed
      // Modify this function according to your requirements
      return 'placeholder-image-url';
    },
    isDangerous(pet) {
      // Check if any breed in the pet is dangerous
      return pet.breeds.some(breed => breed.is_dangerous);
    }
  }
};
</script>

<style scoped>
.card {
  margin-bottom: 20px;
}
</style>
