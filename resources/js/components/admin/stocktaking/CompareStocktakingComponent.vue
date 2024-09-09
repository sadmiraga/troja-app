<template>
  <div class="drinks-food-edit__container">

    <!-- FORM -->
    <div class="drinks-food-create-edit__form-container">

      <!-- Cash register -->
      <div class="category-create-edit__dropdown-container">
        <label for="category">{{ this.translations.Cash_register }}</label>
        <select
          name="register"
          id="category"
          class="category-create-edit__dropdown">
          <option value="choose" selected>Micro gram</option>
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

      <!-- FILE -->
      <input
        type="file"
        id="file" 
        ref="file"
        @change="handleFileUpload($event)"
        class="drinks-food-create-edit__input"
        style="padding-bottom: 2.5rem; padding-top: 1rem" />
    </div>

    <!-- BUTTON -->
    <div class="drinks-food-create-edit__bottom-buttons">
      <button
        v-on:click="compare()"
        class="drinks-food-create-edit__add-allergens-button mt-5">
        {{this.translations.Compare}}
      </button>
    </div>

    <div class="categories-index-container w-100">
        <!-- item list -->
      <div class="categories-list" v-if="comparassions != null" style="margin-top:6rem;">
          <!-- header -->
          <div class="list-header mt-3 w-100 stocktaking-heading">
              <span class="p-info info-name">{{translations.Product}}</span>
              <span class="p-info">{{translations.Application_Stock}}</span>
              <span class="p-info">{{translations.Cash_Register_Stock}}</span>
              <span class="p-info">{{translations.Difference}}</span>
          </div>

          <!-- items -->
          <div v-for="comparassion in comparassions" :key="comparassion.id" class="category stocktaking-row" >

              <!-- stocktakin data-->
              <div class="category__title-container">
                  
                  <!-- location -->
                  <div class="stocktaking-col col-name">
                      <span>{{comparassion.name}}</span>
                  </div>

                  <!-- pieces -->
                  <div class="stocktaking-col">
                      <span class="p-info" style="margin-left:-20px;">{{comparassion.stocktaking_value+" "+comparassion.enum}}</span>
                  </div>
                  <!-- pieces -->
                  <div class="stocktaking-col">
                      <span class="p-info" style="margin-left:-20px;">{{comparassion.register_value+" "+comparassion.enum}}</span>
                  </div>
                  <!-- pieces -->
                  <div class="stocktaking-col">
                      <span class="p-info" style="margin-left:-20px;">
                        {{ getDifference(comparassion) }} {{ comparassion.enum }}
                      </span>
                  </div>


              </div>
          </div>

      </div>
    </div>
    
    



  </div>
</template>

<script>
export default {

  props: ["stocktaking_id","translations"],

  mounted() {
    console.log("Component mounted.");
  },

  data() {
    return {
      file: "",
      comparassions:null,
    };
  },

  methods: {

    getDifference(comparassion){
        var stocktaking_number = parseFloat(comparassion.stocktaking_value);
        var register_number = parseFloat(comparassion.register_value.replace(",", "."));
        var result = stocktaking_number - register_number;
        return parseFloat(result.toFixed(2));
    },

    handleFileUpload() {
        this.file = this.$refs.file.files[0];
    },

    compare(){

        let formData = new FormData()
        formData.append('file', this.file);
        formData.append('stocktaking_id', this.stocktaking_id);

        _.each(this.formData, (value, key) => {
          formData.append(key, value)
        })

        const filter_url = `/stocktaking/compare`;

        return new Promise(resolve => {            
            window.axios.post(filter_url, formData, {
            headers: {
              'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }
            ).then(response => {
                console.log(response.data);
                this.comparassions = response.data;
            }).then(response => {}).catch(error => {})
        });
    },
  },
};
</script>
