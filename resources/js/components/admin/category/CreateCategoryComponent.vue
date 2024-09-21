<template>
    <div class="categories-create-edit-container">

        <!-- modal -->
        <div class="modal fade warning-popup" id="confirm-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header close -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="p-bold"> {{this.translations.You_have_unsaved_changes_are_you_sure_you_want_to_exit}}</h3>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                            <button class="save-button" type="button" data-bs-dismiss="modal">
                                {{this.translations.No}}
                            </button>

                            <!-- YES -->
                            <a class="w-100" v-on:click="goBack()">
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    {{this.translations.Yes}}
                                </button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- trigger modal button-->
        <button type="button" id="confirm-back" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#confirm-modal">
            Open Modal
        </button>

        <!-- CATEGORY NAME -->
        <input
            v-model="name"
            type="text"
            class="category-create-edit__input"
            :placeholder="translations.Enter_category_name"
        />

        <!-- FOOD OR DRINK -->
        <div class="category-create-edit__dropdown-container">
            <select v-model="drink_or_food" name="category" id="category" class="category-create-edit__dropdown">
                <option value="choose">{{ translations.Food_or_drink }}</option>
                <option value="food">{{ translations.food }}</option>
                <option value="drink">{{ translations.drink }}</option>
            </select>
            <svg
            width="14"
            height="8"
            viewBox="0 0 14 8"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="category-create-edit__dropdown-arrow"
        >
            <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
        </svg>
        </div>

        <textarea class="category-create-edit__input" rows="15" v-model="icon" placeholder="Add SVG code for ICON" style="height:fit-content;">
        </textarea>

        <!-- LOCATION -->
        <div class="mb-5">
            <div class="drinks-food-create-edit__input-label">
                <label for="category">{{ this.translations.Choose_location }}</label>
            </div>

            <Multiselect v-model="selected_locations"
                :options="labelOptions"
                :close-on-select="false"
                :multiple="true"
                :placeholder="this.translations.Choose_location"
            >
            </Multiselect>

            <!-- old locations -->
            <div class="d-none category-create-edit__dropdown-container">
                <select v-model="location_id" name="category" id="category" class="category-create-edit__dropdown">
                    <option value="0">{{ this.translations.All_locations }}</option>
                    <option v-for="location in locations" v-bind:key="location.id" :value="location.id">
                        {{location.name}}
                    </option>
                </select>
                <svg
                    width="14"
                    height="8"
                    viewBox="0 0 14 8"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="category-create-edit__dropdown-arrow"
                >
                    <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
                </svg>
            </div>
        </div>

        <!-- create BUTTON -->
        <button v-on:click="create()" class="category-create-edit__add-button">
            {{ this.translations.Create_category }}
        </button>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import Multiselect from 'vue-multiselect';
export default {
    components: {Multiselect},

    computed: {
        labelOptions() {
            return this.options.map(option => option.label);
        },

        selected_location_ids() {
            return this.selected_locations.map((label) => {
            const matchingOption = this.options.find((option) => option.label === label);
            return matchingOption ? matchingOption.value : null;
            });
        },
    },

    props: ["translations"],

    mounted() {

        this.getLocations();
        this.getCurrentLocationID();

        var goBackButton = document.getElementById("back-button");
        goBackButton.addEventListener('click', this.goBackFunction);
    },

    data() {
        return {
            selected_locations: [],
            options: [],

            drink_or_food: "choose",
            icon:null,
            name: "",
            locations: null,
            location_id: 0,
            loading: null,
            errored: null,
        };
    },

    methods: {

        goBackFunction(){
            if(this.name != "" || this.drink_or_food != "choose"  || this.selected_locations.length != 1){
                let button = document.getElementById('confirm-back');
                button.click();
            } else {
                this.goBack();
            }
        },

        goBack(){
            window.history.back();
        },

        fillLocations(){
            for(var i=0;i<this.locations.length;i++){
                var temp_location = { value: this.locations[i].id, label: this.locations[i].name}
                this.options.push(temp_location);
            }            
        },

        create(){
            if(this.name == "" || this.name == null){
                this.$toast.error(this.translations.Enter_category_name);
                return 0;
            } 

            if(this.drink_or_food == "choose"){
                this.$toast.error(this.translations.Choose_category_type);
                return 0;
            }

            if(this.selected_locations.length == 0){
                this.$toast.error(this.translations.Choose_locations);
                return 0;
            }
            
            this.store();

        },

        store(){
            const filter_url = `/category/store`;
            return new Promise(resolve => {
                window.axios.post(filter_url, {
                    'name': this.name,
                    'drink_or_food':this.drink_or_food,
                    'icon':this.icon,
                    'location_id':this.location_id,

                    'selected_locations':this.selected_location_ids
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {

                    if(response.data == "duplicate"){
                        this.$toast.error(this.translations.You_already_have_category_with_that_name_in_selected_location);
                    }

                    if(response.data == "success"){
                        this.$toast.success(this.translations.You_sucessfully_created_new_category);
                        setTimeout(() => {
                            window.location.href = "/category/index";
                        }, 1500);
                    }
                    
                }).then(response => {}).catch(error => {})
            });
        },


        getLocations(){
            const get_locations_url = '/api/get-locations/';
            axios.get(get_locations_url)
                .then(response => {
                    this.locations = response.data;
                    this.fillLocations();
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
        },

        getCurrentLocationID(){
            const get_location_id_url = '/get-current-location-id/';
            axios.get(get_location_id_url)
                .then(response => {
                    
                    this.location_id = response.data;
            const location = this.options.find(option => option.value === this.location_id);
            if (location) {
                this.selected_locations.push(location.label);
            }
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)
        },
    }

};
</script>
