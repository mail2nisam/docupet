<template>
    <div>

        <Multiselect v-model="value" mode="tags" :close-on-select="false" :searchable="true" :create-option="true"
            :options="breeds" @input="handleSelectedBreeds" />

    </div>
</template>

<script>
import Multiselect from '@vueform/multiselect';
import axios from 'axios';
import { mapGetters } from 'vuex';


export default {
    components: {
        Multiselect
    },
    data() {
        return {
            selectedBreeds: [],
            breeds: []
        };
    },
    created() {
        this.fetchBreeds();
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'token']),
    },
    methods: {
        async fetchBreeds() {

            try {
                const token = localStorage.getItem('token');
                const config = {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                };
                const response = await axios.get('http://localhost:9000/api/breed/2', config); // Adjust the API endpoint URL as per your setup
                this.breeds = response.data.map(breed => ({
                    value: breed.id,
                    label: breed.name
                }));
                console.log(this.breeds)
            } catch (error) {
                console.error('Error fetching breeds:', error);
                return [];
            }

        },
        handleSelectedBreeds(selectedBreeds) {
            this.$emit('breeds-selected', selectedBreeds);
        }
    }
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
