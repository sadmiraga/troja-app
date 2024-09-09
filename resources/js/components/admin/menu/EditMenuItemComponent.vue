<template>
  <div class="drinks-food-edit__container">
    <!-- PRODUCT INFO-->
    <div v-if="step == 1" id="step-1" style="height: fit-content">


      <!-- product data -->
      <div class="drinks-food-create-edit__form-container">

        <img :src="banner_image" class="edit-product-banner-image">

        <!-- FILE -->
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label">Media File</label>
            <div class="col">
                <input
                type="file"
                id="media"
                @change="handleFileUpload"
                accept="image/*, video/*"
                class="form-control"
                ref="media" />
            </div>
        </div>

        <!-- FOOD OR DRINK -->
        <div class="category-create-edit__dropdown-container">
          <select
            v-model="localType"
            @change="changeType"
            name="category"
            id="category"
            class="category-create-edit__dropdown">
            <option value="choose">Izberi tip izdelka</option>
            <option value="food">Hrana</option>
            <option value="drink">Pijača</option>
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

        <!-- NAME -->
        <input
          type="text"
          class="drinks-food-create-edit__input"
          placeholder="Ime izdelka"
          v-model="name" />

        <!-- PRICE -->
        <div class="drinks-food-create-edit__input-with-symbol-container">
          <input
            type="number"
            class="drinks-food-create-edit__input-with-symbol"
            placeholder="Cena"
            v-model="price" />
          <div class="drinks-food-create-edit__input-symbol">€</div>
        </div>

        <!-- NIGHT PRICE -->
        <div class="drinks-food-create-edit__input-with-symbol-container">
          <input
            type="number"
            class="drinks-food-create-edit__input-with-symbol"
            placeholder="Nočna cena"
            v-model="night_price" />
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
          v-model="description"></textarea>

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
              v-model="category_id">
              <option
                v-for="category in filteredCategories"
                :key="category.id"
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

        <!-- PACKING SIZE -->
        <div
          v-if="showPackingSize"
          class="drinks-food-create-edit__volume-container">
          <div class="drinks-food-create-edit__input-with-symbol-container">
            <input
              type="number"
              class="drinks-food-create-edit__input-with-symbol"
              v-model="packing_size"
              placeholder="Vpišite velikost embelaže" />
            <div class="drinks-food-create-edit__input-symbol">l</div>
          </div>
        </div>

      </div>

      <!-- Buttons -->
      <div class="drinks-food-create-edit__bottom-buttons mt-5">
        <button v-on:click="update()">Shrani spremembe</button>
        <button
            v-on:click="goToAllergens"
            class="drinks-food-create-edit__add-allergens-button"
        >
            Uredi alergene
        </button>
    </div>

    </div>
  </div>
</template>

<script>
export default {


  mounted() {
    
    this.banner_image = window.location.origin +'/images_dynamic/menu_items/'+this.menu_item.image; 
    this.name = this.menu_item.name;
    this.localType = this.menu_item.drink_or_food;
    this.price = this.menu_item.price;
    this.night_price = this.menu_item.night_price;
    this.description = this.menu_item.description;
    this.packing_size = this.menu_item.packing_size;
    this.category_id = this.menu_item.category_id;
    
  },

  props: ["menu_item","food_categories","drink_categories","allergens"],

  data() {
    return {
      name: null,
      price: null,
      night_price: null,
      description: null,
      category_id: null,
      packing_size: null,
      step: 1,
      localType: this.type, // Local copy of `type`
      mediaFile: null,
      banner_image:null,
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
    },

    
  },

  methods: {

    handleFileUpload(event) {

        this.mediaFile = event.target.files[0];
        // Get the uploaded file
        const new_file = event.target.files[0];

        if (new_file) {
            // Log the file for debugging
            console.log("File selected:", new_file);

            // Create a URL for the uploaded file
            const fileUrl = URL.createObjectURL(new_file);

            // Release the previously created object URL if exists (to avoid memory leaks)
            if (this.banner_image && this.banner_image.startsWith("blob:")) {
                URL.revokeObjectURL(this.banner_image);
            }

            // Update the banner_image with the new file URL
            this.banner_image = fileUrl;
        }
    },

    update() {
    
      const formData = new FormData();

      

      // Append other form data
      formData.append("item_id", this.menu_item.id);
      formData.append("name", this.name);
      formData.append("type", this.localType);
      formData.append("price", this.price);
      formData.append("night_price",this.night_price);
      formData.append("description", this.description);
      formData.append("category_id", this.category_id);
      formData.append("packing_size",this.packing_size);

      // Append file (mediaFile should be set in handleFileUpload)
      if (this.mediaFile) {
        formData.append("media", this.mediaFile);
      }      

      const filter_url = `/menu_items/update`;
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
            window.location.href = "/menu_items";
            //alert("success update.");
          })
          .catch((error) => {
            console.error("There was an error!", error);
          });
      });
    },
}


};
</script>
