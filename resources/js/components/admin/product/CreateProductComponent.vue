<template>
  <div class="drinks-food-edit__container">

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


    <div class="drinks-food-create-edit__form-container">


        <!-- FOOD OR DRINK -->
        <div class="category-create-edit__dropdown-container">
          <select v-model="type" name="category" id="category" class="category-create-edit__dropdown">
              <option value="choose">{{ translations.Choose_type }}</option>
              <option value="food">{{ translations.food }}</option>
              <option value="drink">{{ translations.drink }}</option>
          </select>
          <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="category-create-edit__dropdown-arrow">
            <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
          </svg>
      </div>


       <!-- LOCATION -->
       <div>
        <div class="drinks-food-create-edit__input-label">
          <label for="category">{{ this.translations.Add_product_to_locations }}</label>
        </div>

        <Multiselect v-model="selected_locations"
            :options="labelOptions"
            :close-on-select="false"
            :multiple="true"
            :placeholder="this.translations.Choose_location"
        >
        </Multiselect>
      </div>

      <!-- NAME -->
      <input
        type="text"
        v-model="name"
        class="drinks-food-create-edit__input"
        :placeholder="translations.Enter_product_name" 
        />

        <!-- CODE -->
        <div>
          <div class="drinks-food-create-edit__input-label">
            <label for="category">ŠIFRANT</label>
          </div>
          <input type="text" v-model="code" class="drinks-food-create-edit__input" placeholder="ŠIFRANT" />
        </div>

        <!-- PRICE -->
      <input
      type="number"
      v-model="price"
      class="drinks-food-create-edit__input"
      :placeholder="translations.Enter_product_price" 
      />

      <!-- Description -->
      <textarea
        name="description"
        id="description"
        cols="30"
        rows="10"
        class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
        :placeholder="translations.Enter_product_description+' (not required)'"
        v-model="description"></textarea>


      <!-- STORAGE -->
      <div>
        <div class="drinks-food-create-edit__input-label">
          <label for="category">{{ this.translations.Choose_storage }}</label>
        </div>
        <div class="category-create-edit__dropdown-container">
          <select
            v-model="storage_value"
            class="category-create-edit__dropdown">
            <option value="bar">{{this.translations.Bar}}</option>
            <option value="restaurant">{{this.translations.Restaurant}}</option>
          </select> 
          <svg
            width="14"
            height="8"
            viewBox="0 0 14 8"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="category-create-edit__dropdown-arrow">
            <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
          </svg>
        </div>
      </div>

      <!-- CATEGORY -->
      <div>
        <div class="drinks-food-create-edit__input-label">
          <label for="category">{{ this.translations.Choose_category }}</label>
        </div>
        <div class="drinks-food-create-edit__dropdown-container">
          <select
            name="category"
            id="category"
            class="drinks-food-create-edit__dropdown"
            v-model="category_id">
            <option value="0">{{ this.translations.Choose_category }}</option>
            <option
              v-for="category in categories"
              v-bind:key="category.id"
              :value="category.id">
              {{ category.categoryName }}
            </option>
          </select>

          <svg
            width="14"
            height="8"
            viewBox="0 0 14 8"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="drinks-food-create-edit__dropdown-arrow">
            <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
          </svg>
        </div>
      </div>

      <!-- ENUM -->
      <div>
        <div class="drinks-food-create-edit__input-label">
          <label for="category">{{ this.translations.Choose_enum }}</label><br> 
          <label for="category">{{ this.translations.what_is_enum }}</label>
        </div>
        <div class="category-create-edit__dropdown-container">
          <select
            v-model="enum_type"
            name="enum"
            id="enum"
            class="category-create-edit__dropdown">
            <option value="pcs">{{ this.translations.Piece }}</option>
            <option value="l">{{ this.translations.Liter }}</option>
            <option value="g">{{ this.translations.Gram }}</option>
          </select>
          <svg
            width="14"
            height="8"
            viewBox="0 0 14 8"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="category-create-edit__dropdown-arrow">
            <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
          </svg>
        </div>
      </div>

      <!-- PACKING SIZE -->
      <div
        class="drinks-food-create-edit__volume-container">
        <div class="drinks-food-create-edit__input-with-symbol-container">
          <input
            type="number"
            class="drinks-food-create-edit__input-with-symbol"
            value="0,00"
            v-model="packing_size"
            :placeholder="translations.Enter_packing_size" />

          <div class="drinks-food-create-edit__input-symbol">
            <span v-if="enum_type != 'pcs'" >{{ this.enum_type }}</span>
          </div>
        </div>
      </div>

      <!-- weightable TOGLE -->
      <div class="mt-3">
        <div
          class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
          <label for="weight">{{
            this.translations.Product_is_weightable
          }}</label>
          
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

      <!-- PACKING WEIGHT -->
      <div
        v-if="weightable == true"
        class="drinks-food-create-edit__volume-container">
        <div class="drinks-food-create-edit__input-with-symbol-container">
          <input
            type="number"
            class="drinks-food-create-edit__input-with-symbol"
            value="0,00"
            v-model="packing_weight"
            :placeholder="translations.Enter_packing_weight" />

          <div class="drinks-food-create-edit__input-symbol">g</div>
        </div>
        <div class="d-flex justify-content-end">
          <a href="/calculator" target="_blank" class="btn btn-primary drinks-food-create-edit__calculator-button" style="margin-top:1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
              <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
              <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- BUTTON -->
    <div class="drinks-food-create-edit__bottom-buttons">
      <button
        v-on:click="create()"
        class="drinks-food-create-edit__add-allergens-button mt-5">
        {{ this.translations.Create_Product }}
      </button>
    </div>
    
  </div>

  
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script>
import Multiselect from 'vue-multiselect'

export default {

  components: {Multiselect},

  mounted() {
    this.getLocations();
    this.getCurrentLocationID();


    var goBackButton = document.getElementById("back-button");
    goBackButton.addEventListener('click', this.goBackFunction);

    this.storage_value = this.storage;
  },

  

  props: ["storage", "translations"],

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

  data() {
    return {

      type:"choose",

      selected_locations: [],
      options: [],

      name: null,
      price:null,
      description: null,
      enum_type: "pcs",
      weightable: true,
      packing_weight: null,
      packing_size: null,
      storage_value: null,
      category_id: 0,
      code:null,

      categories: null,

      //regular data
      location_id: null,
      
      locations: null,
      errored: null,
      loading: null,
    };
  },

  watch: {
    location_id: function (newVal) {
      this.getCategories();
    },

    type: function (newVal) {
      this.getCategories();
    },

    selected_location_ids: function (newVal){
        if(this.type != "choose"){
          this.getCategories();
        } 
    }


  },

  methods: {

    goBackFunction(){

      //name
      if(this.name != null && this.name != ""){
        this.confirmExit();
        return 0;
      }

      //description
      if(this.description != null && this.description != ""){
        this.confirmExit();
        return 0;
      }

      //packing_weight
      if(this.packing_weight != null && this.packing_weight != ""){
        this.confirmExit();
        return 0;
      }

      //packing_size
      if(this.packing_size != null && this.packing_size != ""){
        this.confirmExit();
        return 0;
      }

      //category_id
      if(this.category_id != 0 && this.packing_size != null){
        this.confirmExit();
        return 0;
      }

      this.goBack();
    },

    goBack(){
      window.history.back();
    },

    confirmExit(){
      let button = document.getElementById('confirm-back');
      button.click();
    },

    toggle_weightable(value) {
      if (value == false) {
        this.weightable = false;
      } else {
        this.weightable = true;
      }
      //this.packing_size = null;
      this.packing_weight = null;
    },

    getCategories() {
        const filter_url = `/get-categories`;
        return new Promise((resolve) => {
          window.axios
            .post(
              filter_url,
              {
                'selected_location_ids':this.selected_location_ids,
                'type':this.type
              },
              {
                headers: {
                  "Content-Type": "application/json",
                  Accept: "application/json",
                  "app-token": "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
                },
              }
            )
            .then((response) => {
              this.categories = response.data;
              if(response.data.length == 0){
                this.category_id = 0;
              }
            })
            .then((response) => {})
            .catch((error) => {});
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

    fillLocations(){
          for(var i=0;i<this.locations.length;i++){
              var temp_location = { value: this.locations[i].id, label: this.locations[i].name}
              this.options.push(temp_location);
          }            
    },

    create() {

      //location
      if(this.selected_locations.length == 0){
            this.$toast.error(this.translations.Choose_location);
            return 0;
      }

      //name
      if(this.name == null || this.name == ""){
        this.$toast.error(this.translations.Enter_product_name);
        return 0;
      }

      //category
      if(this.category_id == 0 || this.category_id == null){
        this.$toast.error(this.translations.Choose_category);
        return 0;
      }

      //packing weight
      if(this.weightable == true && this.packing_weight == null){
        this.$toast.error(this.translations.Enter_packing_weight_for_product);
        return 0;
      }
      


      this.store();
    },

    store(){

      /*
      if (this.packing_size != null) {
        var new_packing_size = this.packing_size.replace(",", ".");
      }

      if (this.packing_weight != null) {
        var new_packing_weight = this.packing_weight.replace(",", ".");
      }
      */

      const filter_url = `/product/store`;
      return new Promise((resolve) => {
        window.axios
          .post(
            filter_url,
            {
              'category_id': this.category_id,
              'type': this.type,
              name: this.name,
              price: this.price,
              description: this.description,
              //location_id: this.location_id,
              'selected_locations':this.selected_location_ids,
              storage: this.storage_value,
              enum_type: this.enum_type,
              weightable: this.weightable,
              code: this.code,
              //packing_weight: new_packing_weight,
              //packing_size: new_packing_size,
              packing_weight: this.packing_weight,
              packing_size: this.packing_size,
              
            },
            {
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "app-token": "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
              },
            }
          )
          .then((response) => {

            if(response.data == "success"){
                      this.$toast.success(this.translations.You_successfully_created_new_product);
                      setTimeout(() => {
                        window.location.href = "/product?page="+this.storage_value;
                      }, 1500);
            }

            if(response.data == "duplicate"){
              this.$toast.error(this.translations.You_already_have_product_with_that_name_in_selected_location);
            }

            
          })
          .then((response) => {})
          .catch((error) => {});
      });

    }
  },
};
</script>
