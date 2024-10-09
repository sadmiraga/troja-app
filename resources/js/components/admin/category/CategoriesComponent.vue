<template>
    <div class="container">
        <div class="categories-index-container">

            <!-- modal -->
            <div class="modal fade warning-popup" id="confirm-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header close -->
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <h3 class="p-bold text-left">{{this.translations.Delete_from_locations}}</h3>
                            <h3 class="p-bold d-none">{{ this.translations.Are_you_sure_you_want_to_delete_this_category }} ({{ this.category_name }})</h3>
                            <p v-if="category_count > 1" class="d-none p-regular text-center mt-3">{{this.translations.This_will_result_deleting}} {{ this.category_count }} {{this.translations.categories_in_different_locations}}</p>

                            <div class="mt-3">
                                <Multiselect v-model="selected_locations"
                                :options="labelOptions"
                                :close-on-select="false"
                                :multiple="true"
                                :placeholder="this.translations.Choose_locations_to_delete_category_from" 
                                >
                                </Multiselect>
                            </div>


                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                                <!-- CONFIRM -->
                                <a class="w-100" v-on:click="confirmDelete()" >
                                    <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                        <!-- {{this.translations.Yes}} -->
                                        {{this.translations.Confirm}}
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- trigger modal button-->
            <button type="button" id="trigger-modal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#confirm-modal">
                Open Modal
            </button>

            <!-- seach container-->
            <div class="search-bar-container">
                <div class="search-bar">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        v-model="query"
                        :placeholder="translations.Search_categories"
                    />
                    <svg
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="search-bar__icon"
                    >
                        <path
                            d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z"
                            fill="currentColor"
                        />
                    </svg>
                </div>
                <div>
                    <a href="/category/create">
                        <button class="search-bar__button">
                            <svg
                                viewBox="0 0 14 15"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M14 6.5H8V0.5H6V6.5H0V8.5H6V14.5H8V8.5H14V6.5Z"
                                    fill="currentColor"
                                />
                            </svg></button
                    ></a>
                </div>
            </div>

            <!-- CATEGORIES list -->
            <div class="categories-list">
                <div v-for="category in categories" class="category">
                    <!-- Ovako izgleda kategorija -->
                    <div class="category__title-container">
                        <!-- <div class="category__icon"></div>--> 
                            
                        <div class="category__title">

                            <div v-html="category.icon"></div> 

                            <!-- Ime kategorije -->
                            {{category.categoryName}}
                        </div>
                    </div>
                    <div>
                        <a v-on:click="openModalViaButton(category)" >
                            <button class="category__edit-button">{{translations.Delete}}</button>
                        </a>
                        <a :href="'/category/edit/'+category.id" >
                            <button class="category__edit-button">{{translations.Edit}}</button>
                        </a>
                        <a :href="'/category/translations/'+category.id" >
                            <button class="category__edit-button">Translations</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import Multiselect from 'vue-multiselect';


export default {

    mounted() {
        console.log("Component mounted.");
        console.log(this.categories)
    },

    components: {Multiselect},
    props: ["categories","translations"],

    computed: {
        labelOptions() {
            this.fillLocations();
            //select all locations
            this.selected_locations = this.options.map(option => option.label);
            return this.options.map(option => option.label);
        },

        selected_location_ids() {
            return this.selected_locations.map((label) => {
            const matchingOption = this.options.find((option) => option.label === label);
            return matchingOption ? matchingOption.value : null;
            });
        },
    },

    data() {
        return {

            selected_locations: [],
            options: [],

            query: null,
            loading: false,

            locations:null,

            category_id: null,
            category_name: null,
            category_count:null
        };
    },

    watch:{
        query: function(newVal){
            this.search();
        }
    },

    methods: {

        confirmDelete(){
            const delete_url = `/category/delete/multiple`;
            return new Promise(resolve => {
                window.axios.post(delete_url, {

                    'category_id':this.category_id,
                    'selected_locations':this.selected_location_ids
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {
                    if(response.data == "success"){
                        this.$toast.warning(this.translations.You_successfully_deleted_category);
                        setTimeout(() => {
                            window.location.href = "/category/index";
                        }, 1500);
                    }
                    
                }).then(response => {}).catch(error => {})
            });
        },

        openModalViaButton(category) {
            //get locations linked to this cateo
            this.getLocations(category.id);

            this.checkCategoryCount(category.id);
            this.category_id = category.id;
            this.category_name = category.categoryName;
            let button = document.getElementById('trigger-modal');
            button.click();
        },

        //get locations linked to this category
        getLocations(category_id)
        {
            const filter_url = `/category/get-locations`;
            return new Promise(resolve => {
                window.axios.post(filter_url, {
                    'category_id': category_id,
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {
                    
                this.locations = response.data;
                this.selected_locations = []; // Clear the selected locations
                this.fillLocations(); 

                }).then(response => {}).catch(error => {})
            });
        },

        fillLocations() {
            this.options = []; // Clear the options before filling
            if (this.locations != null) {
                for (var i = 0; i < this.locations.length; i++) {
                    var temp_location = {
                        value: this.locations[i].id,
                        label: this.locations[i].name,
                    };
                    this.options.push(temp_location);
                }
            }
        },


        checkCategoryCount(category_id){
            const filter_url = `/category/get-count`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'category_id': category_id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.category_count = response.data;
                    }).then(response => {}).catch(error => {})
                });
        },

        search(){
            const filter_url = `/category/search`;
            return new Promise(resolve => {
                window.axios.post(filter_url, {
                    'query': this.query,
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                }).then(response => {}).catch(error => {})
            });
        },
    }
};
</script>
