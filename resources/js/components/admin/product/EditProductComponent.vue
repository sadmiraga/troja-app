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


       <!-- FOOD OR DRINK -->
       <div class="category-create-edit__dropdown-container">
        <label for="category">{{this.translations.Choose_type}}</label>
        <select v-model="type" name="category" id="category" class="category-create-edit__dropdown">
            <option value="food">{{ translations.food }}</option>
            <option value="drink">{{ translations.drink }}</option>
        </select>
        <svg style="margin-top:1.5rem;" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="category-create-edit__dropdown-arrow">
          <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
        </svg>
    </div>
      
      <!-- LOCATION -->
      <div class="mb-3 mt-3">
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

      <!-- input fields -->
      <div class="drinks-food-create-edit__form-container">
  
        <!-- NAME -->
        <div>
          <div class="drinks-food-create-edit__input-label">
            <label for="category">{{this.translations.Name}}</label>
          </div>
          <input type="text" v-model="name" class="drinks-food-create-edit__input" :placeholder="translations.Enter_product_name" />
        </div>

        <!-- PRICE -->
        <div>
          <div class="drinks-food-create-edit__input-label">
            <label for="category">{{this.translations.Price}}</label>
          </div>
          <input type="text" v-model="price" class="drinks-food-create-edit__input" :placeholder="translations.Product_product_price" />
        </div>

        <!-- Description -->
        <div>
          <div class="drinks-food-create-edit__input-label">
            <label for="category">{{this.translations.Description}}</label>
          </div>
          <textarea name="description" id="description" cols="30" rows="10" class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
            :placeholder="translations.Enter_product_description"
            v-model="description">
          </textarea>
        </div>
  
        <!-- STORAGE -->
        <div>
          <div class="drinks-food-create-edit__input-label">
            <label for="category">{{ this.translations.Choose_storage }}</label>
          </div>
          <div class="category-create-edit__dropdown-container">
            <select
              v-model="storage_value"
              name="enum"
              id="enum"
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
            <label for="category">{{ this.translations.Choose_enum }}</label>
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
                  id="product-weightable"
                  v-on:change="toggle_weightable($event.target.checked)" />
                   />
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
        </div>
      </div>
  
      <!-- BUTTON -->
      <div class="drinks-food-create-edit__bottom-buttons">
        <button
          v-on:click="edit()"
          class="drinks-food-create-edit__add-allergens-button mt-5">
          {{ this.translations.Save }}
        </button>
      </div>

  </div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
import Multiselect from 'vue-multiselect';
  export default {
    components: {Multiselect},

    props: ["product", "translations","product_count","locations","category"],

    beforeMount(){
      this.type = this.product.food_or_drink;
    },

    mounted() {
      this.name = this.product.name;
      this.price = this.product.price;
      this.description = this.product.description;
      this.storage_value = this.product.storage;
      this.category_id = this.product.category_id;
      this.enum_type = this.product.enum;
      this.packing_size = this.product.packing_size;
      this.packing_weight = this.product.packing_weight;
      this.weightable = this.product.weightable;
      

      console.log("WEIGHTABLEEEEE");
      console.log(this.weightable);

      var weightable_toggle = document.getElementById("product-weightable");
      
      if(this.weightable == true){
          weightable_toggle.checked = true;
      } else {
          weightable_toggle.checked = false;
      }
      

      var goBackButton = document.getElementById("back-button");
      goBackButton.addEventListener('click', this.goBackFunction);
    },


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

        type:null,

        //locations 
        selected_locations: [],
        options: [],

        global_edit: true,

        name: null,
        price: null,
        description: null,
        enum_type: "pcs",
        weightable: true,
        packing_weight: null,
        packing_size: null,
        storage_value: null,
        category_id: 0,

        categories: null,

        //regular data
        errored: null,
        loading: null,
        };
    },

    watch: {
      selected_location_ids: function (newVal){
        this.getCategories();
        //this.category_id = 0;
      },

      type: function (newVal) {
        this.getCategories();
      },
    },

    methods: {

        goBackFunction(){

            let button = document.getElementById('confirm-back');

            //name changed.
            if(this.product.name != this.name){
              button.click();
              return 0;
            }


            //description changed.
            if(this.product.description != this.description){
              button.click();
              return 0;
            }

            //storage changed.
            if(this.product.storage != this.storage_value){
              button.click();
              return 0;
            }

            //enum changed.
            if(this.product.enum != this.enum_type){
              button.click();
              return 0;
            }

            //packing_size changed.
            if(this.product.packing_size != this.packing_size){
              button.click();
              return 0;
            }

            //packing_size changed.
            if(this.product.packing_weight != this.packing_weight){
              button.click();
              return 0;
            } 

            this.goBack();
        },

        goBack(){
            window.history.back();
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

        fillLocations(){
          for(var i=0;i<this.locations.length;i++){
              var temp_location = { value: this.locations[i].id, label: this.locations[i].name}
              this.options.push(temp_location);
          }
        },

        setOldCategory() {
            const matchingCategory = this.categories.find(cat => cat.categoryName === this.category.categoryName);
            if (matchingCategory) {
                this.category_id = matchingCategory.id;
            } else {
                console.log('No matching category found');
            }

            console.log(this.categories);
            console.log(this.category);
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
                //console.log(response.data);
                this.categories = response.data;
                this.setOldCategory();
                //alert("response");
              })
              .then((response) => {})
              .catch((error) => {});
          });
        },

        edit(){
          
          //removed locations.
          if(this.selected_locations.length < this.locations.length && this.product.name == this.name){  
            
            //enum
            if(this.enum_type != this.product.enum){
              this.$toast.error(this.translations.You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed);
            }

            //weightable
            if(this.weightable != this.product.weightable){
              this.$toast.error(this.translations.You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed);
            }

            //packing_size
            if(this.packing_size != this.product.packing_size){
              this.$toast.error(this.translations.You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed);
            }
            //storage_value
            if(this.storage_value != this.product.storage){
              this.$toast.error(this.translations.You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed);
            }
            
            //packing_weight
            if(this.packing_weight != this.product.packing_weight){
              this.$toast.error(this.translations.You_unlinked_products_from_locations_and_left_the_same_nameThis_is_not_allowed);
            }
            return 0;
          }


          //weightable = true BUT no packing_weight value. 
          if(this.weightable == true && this.packing_weight == null){
            this.$toast.error(this.translations.If_product_is_weightable_you_must_enter_product_packing_weight);
            return 0;
          }


          this.update();
          
        },

        update() {
          /*
          if (this.packing_size != null) {
              console.log(this.packing_size);
              var new_packing_size = this.packing_size.replace(",", ".");
              
          } */

          /*
          if (this.packing_weight != null) {
              var new_packing_weight = this.packing_weight.replace(",", ".");
          }
          */
          const filter_url = `/product/update`;
          return new Promise((resolve) => {
          window.axios
              .post(
              filter_url,
              {
                  'selected_locations':this.selected_location_ids,
                  product_id: this.product.id,
                  name: this.name,
                  price: this.price,
                  description: this.description,
                  storage: this.storage_value,
                  category_id: this.category_id,
                  enum_type: this.enum_type,
                  weightable: this.weightable,
                  packing_weight: this.packing_weight,
                  packing_size: this.packing_size,
                  type:this.type

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
                    this.$toast.success(this.translations.You_successfully_updated_products);
                    setTimeout(() => {
                        window.location.href = "/product?page="+this.storage;
                    }, 1500);
                }  
              })
              .then((response) => {})
              .catch((error) => {});
          });
        },
        
    }

      
  }
</script>
