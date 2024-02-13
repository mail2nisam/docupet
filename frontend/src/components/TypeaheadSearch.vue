<template>
    <div class="position-relative">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search breed..." v-model="searchTerm" @input="handleInput">
        </div>
        <ul class="position-absolute start-0 list-group w-100" v-if="showResults">
            <li class="list-group-item cursor-pointer" v-for="(breed, index) in filteredBreeds" :key="index"
                @click="selectBreed(breed)">
                {{ breed.name }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            searchTerm: '',
            breeds: [],
            showResults: false
        };
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'token']),
        filteredBreeds() {
            const filtered = this.breeds.filter(breed => breed.name.toLowerCase().includes(this.searchTerm.toLowerCase()));
            return [{ id: 'cannot_find', name: "Can't find it?" }, ...filtered];
        }
    },
    methods: {
        async handleInput() {
            this.showResults = true;
                const token = localStorage.getItem('token');

            try {
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };
                const response = await axios.get('http://localhost:9000/api/breed/2', config); // Adjust the API endpoint URL as per your setup
                this.breeds = response.data;
            } catch (error) {
                console.error('Error fetching breeds:', error);
            }
        },
        selectBreed(breed) {
            this.searchTerm = breed.name;
            this.$emit('breed-selected', breed);
            this.showResults = false;
        }
    }
};
</script>
