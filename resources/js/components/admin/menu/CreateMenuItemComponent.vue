<template>
    <div class="drinks-food-edit__container">

        <!-- PRODUCT INFO-->
        <div v-if="step == 1" id="step-1" style="height:fit-content;">
            
            <div class="drinks-food-create-edit__form-container">
                <!-- FOOD OR DRINK -->
                <div class="category-create-edit__dropdown-container">
                    <select
                        v-model="localType"
                        name="category"
                        id="category"
                        class="category-create-edit__dropdown"
                    >
                        <option value="choose">Izberi tip izdelka</option>
                        <option value="food">Hrana</option>
                        <option value="drink">Pijača</option>
                        <option value="shisha">Shisha</option>
                    </select>
                    <svg
                        width="14"
                        height="8"
                        viewBox="0 0 14 8"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="category-create-edit__dropdown-arrow"
                    >
                        <path
                            d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z"
                            fill="currentColor"
                        />
                    </svg>
                </div>

                <!-- NAME -->
                <input
                    type="text"
                    class="drinks-food-create-edit__input"
                    placeholder="Ime izdelka"
                    v-model="name"
                />

                <!-- PRICE -->
                <div class="drinks-food-create-edit__input-with-symbol-container">
                    <input
                        type="number"
                        class="drinks-food-create-edit__input-with-symbol"
                        placeholder="Cena"
                        v-model="price"
                    />
                    <div class="drinks-food-create-edit__input-symbol">€</div>
                </div>

                <!-- NIGHT PRICE -->
                <div class="drinks-food-create-edit__input-with-symbol-container">
                    <input
                        type="number"
                        class="drinks-food-create-edit__input-with-symbol"
                        placeholder="Nočna cena"
                        v-model="night_price"
                    />
                    <div class="drinks-food-create-edit__input-symbol">€</div>
                </div>

                <!-- DESCRIPTION -->
                <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="10"
                    class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
                    placeholder="Vnesi opis artikla"
                    v-model="description"
                ></textarea>

                <!-- CATEGORY -->
                <div>
                    <div class="drinks-food-create-edit__input-label">
                        <label for="category">Izberite kategorijo artikla</label>
                    </div>
                    <div class="drinks-food-create-edit__dropdown-container">
                        <select
                            name="category"
                            id="category"
                            class="drinks-food-create-edit__dropdown"
                            v-model="category_id"
                        >
                            <option
                                v-for="category in filteredCategories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.categoryName }}
                            </option>
                        </select>
                        <svg
                            width="14"
                            height="8"
                            viewBox="0 0 14 8"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="drinks-food-create-edit__dropdown-arrow"
                        >
                            <path
                                d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z"
                                fill="currentColor"
                            />
                        </svg>
                    </div>
                </div>

                <!-- PACKING SIZE -->
                <div v-if="showPackingSize" class="drinks-food-create-edit__volume-container">
                    <div class="drinks-food-create-edit__input-with-symbol-container">
                        <input
                            type="number"
                            class="drinks-food-create-edit__input-with-symbol"
                            v-model="packing_size"
                            placeholder="Vpišite velikost embelaže"
                        />
                        <div class="drinks-food-create-edit__input-symbol">l</div>
                    </div>
                </div>
                

                <!-- FILE -->
                <div class="form-group row">
                    <label class="form-label col-3 col-form-label">Product Image</label>
                    <div class="col">
                        <input type="file" id="media" @change="handleFileUpload" accept="image/*, video/*" class="form-control" ref="media">
                    </div>
                </div>

                <!-- Allergens -->
                <div class="drinks-food-create-edit__volume-container mb-5">
                    <div class="drinks-food-create-edit__input-with-symbol-container">
                        <input
                            type="text"
                            class="drinks-food-create-edit__input-with-symbol"
                            v-model="allergens_text"
                            placeholder="Vpišite alergene"
                        />
                    </div>
                </div>
            </div>

            

            <!-- Buttons -->
            <div class="drinks-food-create-edit__bottom-buttons w-100">
                <button v-on:click="create()">Dodaj izdelek</button>
                <button v-on:click="createWithTranslations()"
                    v-if="languages_count>0"
                    class="drinks-food-create-edit__add-allergens-button ">
                    Dodaj izdelek in vpiši prevode
                </button>
            </div>
        </div>

        <!-- ALLERGENS -->
        <div v-if="step == 2" id="step-2">
          <div class="drinks-food-allergens__container">
              <ol class="drinks-food-allergens__list-container">
                  <li v-for="allergen in allergens">
                      <div class="drinks-food-allergens__allergen-container">
                          <div class="drinks-food-allergens__allergen-name">
                              {{ allergen.shortcode }} - {{ allergen.name }}
                          </div>
                          <div class="drinks-food-allergens__allergen-switch">
                              <label class="switch">
                                  <input
                                      type="checkbox"
                                      v-on:change="
                                          switchAllergen(
                                              allergen.id,
                                              $event.target.checked
                                          )
                                      "
                                  />
                                  <div class="slider round" />
                              </label>
                          </div>
                      </div>
                  </li>
              </ol>
              <div class="drinks-food-allergens__bottom-buttons">
                  <button v-on:click="goToStep(1)">Nazaj na podatke</button>
                  <button v-on:click="create()">Dodaj izdelek</button>
              </div>
          </div>
      </div>
    </div>
</template>


<script>
export default {
  mounted() {
    console.log("Component mounted.");

    if (this.type == "food") {
      this.categories = this.food_categories;
    } else if (this.type == "drink") {
      this.categories = this.drink_categories;
    }

    //create selected_allergens array
    this.allergens.forEach((allergen) => {
      this.selected_allergens.push({ id: allergen.id, selected: false });
    });

    //allergens here.
  },

  props: ["food_categories", "drink_categories", "allergens", "type","languages_count"],

  data() {
    return {
      selected_allergens: [],
      name: null,
      price: null,
      night_price: null,
      description: null,
      category_id: null,
      packing_size: null,
      allergens_text:null,
      step: 1,
      localType: this.type, // Local copy of `type`
      mediaFile: null,
      translationsRedirect:false,
    };
  },

  watch: {
    // Watch the prop `type` and update `localType`
    type(newVal) {
      this.localType = newVal;
    },
  },

  computed: {
    filteredCategories() {
      if (this.localType === "food") {
        return this.food_categories;
      } else if (this.localType === "drink") {
        return this.drink_categories;
      } else {
        return [];
      }
    },

    showPackingSize() {
      return this.localType === "drink"; // Dynamically show/hide packing size based on localType
    }
  },

  methods: {
    handleFileUpload(event) {
      this.mediaFile = event.target.files[0]; // store the file
    },

    goToStep(step){
      this.step = step;
    },

    switchAllergen(allergen_id, value) {
      let allergen = this.selected_allergens.find(
          (allergen) => allergen.id === allergen_id
      );

      // Update its selected value
      if (allergen) {
          allergen.selected = value;
      }
    },

    createWithTranslations(){
      this.translationsRedirect = true;
      this.create();
    },

    create() {
      const formData = new FormData();

      console.log(this.selected_allergens);

      // Append other form data
      formData.append("name", this.name);
      formData.append("translations_redirect", this.translationsRedirect);
      formData.append("type", this.type);
      formData.append("price", this.price.replace(",", "."));
      formData.append("night_price",this.night_price ? this.night_price.replace(",", ".") : null);
      formData.append("description", this.description);
      formData.append("category_id", this.category_id);
      formData.append("allergens_text", this.allergens_text);
      formData.append("packing_size",this.packing_size);
      formData.append("selected_allergens", JSON.stringify(this.selected_allergens));


      // Append file (mediaFile should be set in handleFileUpload)
      if (this.mediaFile) {
        formData.append("media", this.mediaFile);
      }

      const filter_url = `/menu_items/store`;
      return new Promise((resolve) => {
        window.axios
          .post(filter_url, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
              Accept: "application/json",
              "app-token": "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
            },
          })
          .then((response) => {
            
            if(response.data == "success"){
              this.$toast.success("You successfully added new product on the Menu.");
              setTimeout(() => {
                window.location.href = "/menu_items";
              }, 1500);
            } else{
              
              this.$toast.success("You successfully added new product on the Menu.");
              setTimeout(() => {
                window.location.href = "/menu_items/translations/"+response.data;
              }, 1500);
              
            }

            
          })
          .catch((error) => {
            console.error("There was an error!", error);
          });
      });
    },
  },
};
</script>
