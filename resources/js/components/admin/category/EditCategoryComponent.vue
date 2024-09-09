<template>
    <div class="categories-create-edit-container">


        <!-- edit GLOBAL -->
        <div class="d-none mt-3" v-if="this.category_count > 1">
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight"> {{ this.translations.Edit_on_all_locations }} ({{ this.category_count }})</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input
                    type="checkbox"
                    checked
                    v-on:change="toggle_weightable($event.target.checked)" />
                <div class="slider round"></div>
                </label>
            </div>
            </div>
        </div>

        <!-- LOCATION -->
        <div>
            <div class="drinks-food-create-edit__input-label">
                <label for="category">{{this.translations.Update_on_locations}}</label>
            </div>

            <Multiselect v-model="selected_locations"
                :options="labelOptions"
                :close-on-select="false"
                :multiple="true"
                :placeholder="this.translations.Choose_locations"
            >
            </Multiselect>

        </div>

        <!-- name -->
        <div class="drinks-food-create-edit__input-label">
            <label for="category">{{this.translations.Name}}</label>
            <input
            v-model="name"
            type="text"
            class="category-create-edit__input"
            :laceholder="this.translations.Enter_category_name"
        />
        </div>
        

        <div class="category-create-edit__dropdown-container">
            <label for="category">{{ this.translations.Type }}</label>
            <select v-model="drink_or_food" name="category" id="category" class="category-create-edit__dropdown">
                <option value="choose">{{this.translations.Food_or_drink}}</option>
                <option value="food">{{this.translations.food}}</option>
                <option value="drink">{{this.translations.drink}}</option>
            </select>

            <svg
                width="14"
                height="8"
                viewBox="0 0 14 8"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="category-create-edit__dropdown-arrow"
                style="top: 2.4rem;"
            >
                <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
            </svg>
        </div>

        <button class="category-create-edit__add-button" v-on:click="update">
            {{this.translations.Save}}
        </button>
    </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>



<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {Multiselect},

    mounted() {
        this.name = this.category.categoryName;
        this.drink_or_food = this.category.drink_or_food;

        console.log(this.category); 
    },

    props: ["category","translations","category_count","locations"],

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

            drink_or_food: '',
            name: "",
            global_edit: true,
        };
    },

    methods: {

        fillLocations(){
            for(var i=0;i<this.locations.length;i++){
                var temp_location = { value: this.locations[i].id, label: this.locations[i].name}
                this.options.push(temp_location);
            }

            console.log(this.options);
        },



        toggle_weightable(value) {
            if (value == false) {
                this.global_edit = false;
            } else {
                this.global_edit = true;
            }
        },

        update(){

            //name
            if(this.name == "" || this.name == null){
                this.$toast.error(this.translations.Enter_category_name);
                return 0;
            } 

            //type
            if(this.drink_or_food == "choose"){
                this.$toast.error(this.translations.Choose_category_type);
                return 0;
            }

            //locations
            if(this.selected_locations.length == 0){
                this.$toast.error(this.translations.Choose_locations);
                return 0;
            }
        
            //removed location
            if(this.selected_locations.length < this.locations.length 
                    &&this.category.name == this.categoryName 
                    && this.category.drink_or_food != this.drink_or_food){
                   this.$toast.error(this.translations.You_cant_change_category_type_just_for_one_category_without_changing_name);
                return 0;
            }

            const filter_url = `/category/update`;
            return new Promise(resolve => {
                window.axios.post(filter_url, {
                    'name': this.name,
                    'drink_or_food':this.drink_or_food,
                    'category_id':this.category.id,
                    'category_count':this.category_count,
                    'global_edit':this.global_edit,

                    'selected_locations':this.selected_location_ids

                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {

                    if(response.data == "success"){
                        this.$toast.success("You sucessfully updated category");
                        setTimeout(() => {
                            window.location.href = "/category/index";
                        }, 1500);
                    }
                    
                }).then(response => {}).catch(error => {})
            });
        },
    }

};
</script>
