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
          v-model="register"
          class="category-create-edit__dropdown">
          <option value="microgram" >Micro gram</option>
          <option value="pos-elektroncek" selected>Pos Elektroncek</option>
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
      <div class="categories-list" style="margin-top:6rem;">


          <!-- header -->
          <div v-if="compared" class="list-header mt-3 w-100 stocktaking-heading">
              <span class="p-info info-name">Izdelek</span>
              <span class="p-info">Stanje v aplikaciji (realno)</span>
              <span class="p-info">Stanje v blagajni</span>
              <span class="p-info">Razlika</span>
          </div>


          <!-- POS elektroncek comparasion-->
          <div v-if="register == 'pos-elektroncek' && compared" v-for="comparassion in comparassions" :key="comparassion.id" class="category stocktaking-row" >
            <div class="category__title-container">

                <!-- name -->
                <div class="stocktaking-col col-name">
                  <span>{{comparassion.name}}</span>
                </div>

                <!-- app STOCK -->
                <div class="stocktaking-col">
                  <span class="p-info" style="margin-left:-20px;">{{posElektroncekGetAppStock(comparassion)}}</span>
                </div>

                <!-- register STOCK -->
                <div class="stocktaking-col">
                  <span class="p-info" style="margin-left:-20px;">{{comparassion.excel_stock}} {{ comparassion.excel_unit }}</span>
                </div>

                <!-- difference -->
                <div class="stocktaking-col">
                  <span 
                    class="p-info" 
                    :style="{
                      marginLeft: '-20px',
                      color: Number(posElektroncekGetDifference(comparassion).split(' ')[0]) < 0 ? 'red' : 'green'
                    }"
                  >
                    {{ posElektroncekGetDifference(comparassion) }}
                  </span>
                </div>


            </div>
          </div>


          <!-- MICROGRAM comparasion. -->
          <div v-if="register == 'microgram' && compared" v-for="comparassion in comparassions" :key="comparassion.id" class="category stocktaking-row" >

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
      register: "pos-elektroncek",
      compared:false,
    };
  },


  methods: {


    posElektroncekGetAppStock(comparassion){
      if(comparassion.enum == "pcs"){
       return comparassion.stocktaking_quantity+"  pcs";
      }
      
      if(comparassion.enum == "l"){
        let liters = 0;
        
        // Check quantity and multiply by packing size
        if(comparassion.stocktaking_quantity) {
          liters += comparassion.stocktaking_quantity * comparassion.packing_size;
        }
        
        // Add weight converted to liters if exists
        if(comparassion.stocktaking_weight) {
          // Convert grams to liters (1000g = 1L)
          liters += comparassion.stocktaking_weight / 1000;
        }
        
        return liters.toFixed(2) + " l";
      }
    },

    posElektroncekGetDifference(comparassion){
      

        //KOS  ---------
        if(comparassion.enum == "pcs" && (comparassion.excel_unit == "kos" || comparassion.excel_unit == "steklenica" ) ){
          return parseFloat(comparassion.stocktaking_quantity) - parseFloat(comparassion.excel_stock)+ " steklenica";
        }

        //STEKLENICA (liter in app)-------
        if(comparassion.enum == "l" && comparassion.excel_unit == "steklenica") {

          // Full bottles
          let fullBottles = parseFloat(comparassion.stocktaking_quantity || 0);
          
          // Partial bottle from weight
          let partialBottle = 0;
          if(comparassion.stocktaking_weight) {
            let weightInLiters = comparassion.stocktaking_weight / 1000; // Convert g to L
            partialBottle = weightInLiters / comparassion.packing_size; // Get percentage of bottle
          }

          // Combine full bottles + partial bottle and calculate difference with excel stock
          let totalBottles = parseFloat((fullBottles + partialBottle).toFixed(2));
          let difference = totalBottles - parseFloat(comparassion.excel_stock);
          return difference.toFixed(2) + " steklenica";
        }

        //LITER ---------
        if(comparassion.enum == "l" && comparassion.excel_unit == "lit") {

          let liters = 0;
          if(comparassion.stocktaking_quantity) {
            liters += comparassion.stocktaking_quantity * comparassion.packing_size;
          }
        
          // Add weight converted to liters if exists
          if(comparassion.stocktaking_weight) {
            // Convert grams to liters (1000g = 1L)
            liters += comparassion.stocktaking_weight / 1000;
          }

          let result = liters - parseFloat(comparassion.excel_stock);

          return result.toFixed(2) + " l";
          
        }





    },

    getDifference(comparassion){
        var stocktaking_number = parseFloat(comparassion.stocktaking_value);
        var register_number = parseFloat(comparassion.register_value.replace(",", "."));
        var result = stocktaking_number - register_number;
        return parseFloat(result.toFixed(2));
    },

    handleFileUpload() {
        this.file = this.$refs.file.files[0];
    },


    //POST request
    compare(){

        let formData = new FormData()
        formData.append('file', this.file);
        formData.append('stocktaking_id', this.stocktaking_id);
        formData.append('register', this.register);

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
                //console.log(response.data);
                this.comparassions = response.data;
                this.compared = true;
                console.log(this.comparassions);
                
            }).then(response => {}).catch(error => {})
        });
    },
  },
};
</script>
