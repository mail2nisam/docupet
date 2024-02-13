<template>
    <div class="container dashboard mt-5  shadow ">
        <div class="row paw-prints mb-3">
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">
                <i class="fa-solid fa-paw fa-rotate-90 top-paw text-green"></i>

            </div>
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">

                <i class="fa-solid fa-paw fa-rotate-90 bottom-paw text-green"></i>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">
                <i class="fa-solid fa-paw fa-rotate-90 top-paw"></i>

            </div>
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">

                <i class="fa-solid fa-paw fa-rotate-90 bottom-paw"></i>
            </div>
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">
                <i class="fa-solid fa-paw fa-rotate-90 top-paw"></i>

            </div>
            <div class="col-md-2 d-flex flex-column align-items-center justify-content-between">

                <i class="fa-solid fa-paw fa-rotate-90 bottom-paw"></i>
            </div>
        </div>
        <h3>Tell us about your dog</h3>

        <form @submit.prevent="registerPet">
            <div class="mb-3">
                <label for="dogName" class="form-label">What is your dog's name?</label>
                <input type="text" class="form-control" id="dogName" placeholder="Enter your dog's name" v-model="petName">
            </div>
            <div class="mb-3 select-breed">
                <label for="dogBreed" class="form-label">What breed are they?</label>
                <TypeaheadSearch @breed-selected="handleBreedSelected" v-model="selectedBreed" />
            </div>
            <div class="mb-3" v-if="selectedBreedKey === 'cannot_find'">
                <label for="dogBreed2" class="form-label">Choose One</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="idontknow" value="idontknow" id="idontknow"
                        v-model="isCRossBreed">
                    <label class="form-check-label" for="idontknow">I don't know</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="idontknow" value="itisamix" id="itisamix"
                        v-model="isCRossBreed">
                    <label class="form-check-label" for="itisamix">It's a mix</label>
                </div>

            </div>
            <div class="mb-3">
                <div class="mb-3" v-if="isCRossBreed === 'itisamix'">
                    <label for="dogBreedMix" class="form-label">Please specify the mix:</label>
                    <BreedSelection @breeds-selected="updateBreed" />
                </div>
            </div>
            <div class="mb-3">
                <div>
                    <label for="dogGender" class="form-label">What is your dog's gender?</label>
                </div>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="gender" id="female" autocomplete="off" value="female"
                        v-model="gender">
                    <label class="btn btn-outline-primary" for="female">Female</label>

                    <input type="radio" class="btn-check" name="gender" id="male" autocomplete="off" value="male"
                        v-model="gender">
                    <label class="btn btn-outline-primary" for="male">Male</label>
                </div>
            </div>
            <div class="mb-3">
                <div>
                    <label for="dogGender" class="form-label">Did you know their date of birth?</label>
                </div>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="know_dob" id="dob_yes" value="yes" autocomplete="off"
                        checked v-model="dobKnown">
                    <label class="btn btn-outline-primary" for="dob_yes">Yes</label>

                    <input type="radio" class="btn-check" name="know_dob" id="dob_no" value="no" autocomplete="off"
                        v-model="dobKnown">
                    <label class="btn btn-outline-primary" for="dob_no">No</label>
                </div>
            </div>

            <div class="mb-3" v-if="dobKnown === 'yes'">
                <label for="dogDob" class="form-label">Select your dog's date of birth:</label>
                <VueDatePicker v-model="dob" auto-apply :enable-time-picker="false"></VueDatePicker>
            </div>

            <div class="mb-3" v-else>
                <label for="dogAge" class="form-label">How old is your dog (in years)?</label>
                <select class="form-select" id="dogAge" v-model="age">
                    <option v-for="year in 10" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Continue</button>
        </form>
    </div>
</template>

<script>
import TypeaheadSearch from '../components/TypeaheadSearch.vue';
import BreedSelection from '../components/BreedSelection.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import axios from 'axios';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    name: 'NewPet',
    components: {
        TypeaheadSearch,
        BreedSelection,
        VueDatePicker
    },
    data() {
        return {
            petName: '',
            petType: 'dog',
            mixBreeds: [],
            dobKnown: 'yes',
            selectedBreed: null,
            isCRossBreed: null,
            dob: null,
            gender: 'female',
            age: null
        };
    },
    computed: {
        selectedBreedKey() {
            return this.selectedBreed ? this.selectedBreed.id : '';
        }
    },
    methods: {
        registerPet() {

            const formData = {
                name: this.petName,
                dbKnown: this.dobKnown,
                is_cross_breed: !(this.isCRossBreed == 'idontknow'),
                dob: this.dob,
                age: this.age,
                gender: this.gender
            }
            formData.breed = this.isCRossBreed ? this.mixBreeds : [this.selectedBreed?.id]
            const token = localStorage.getItem('token');
            const config = {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            };
            axios.post('http://localhost:9000/api/pet', formData, config)
                .then(response => {
                    this.$router.push('/dashboard');
                    console.log('Pet registration successful:', response.data);
                })
                .catch(error => {
                    console.error('Error registering pet:', error.response.data);
                });
        },
        handleBreedSelected(breed) {
            this.selectedBreed = breed
        },
        updateBreed(selectedBreeds) {
            this.mixBreeds = selectedBreeds || [];
        }
    }
};
</script>
