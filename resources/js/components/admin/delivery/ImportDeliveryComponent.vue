<template>
  <div class="drinks-food-edit__container">
    <!-- FORM -->
    <div class="drinks-food-create-edit__form-container">


    <!-- DATE -->
    <date-pick v-model="date">
        <template v-slot:default="{ toggle, inputValue }">
            <button
                @click="toggle"
                class="drinks-food-create-edit__input"
                style="text-align: left"
            >
                {{
                    inputValue
                        ? formatDate(inputValue)
                        : "Izberite datum"
                }}
            </button>
        </template>
        <template v-slot:cellContent="{ item }">
            <div class="vdpCellContent">
                <strong>{{ item.date.getDate() }}</strong>
            </div>
        </template>
    </date-pick>

    <!-- TIME -->
    <div class="d-none drinks-food-create-edit__input-with-symbol-container">
        <input
            type="time"
            class="drinks-food-create-edit__input-with-symbol"
            placeholder="Izberite čas ( ni obvezno )"
            v-model="time"
        />
    </div>


    <!-- FILE -->
    <input type="file" id="file" ref="file" class="drinks-food-create-edit__input" style="padding-bottom: 2.5rem; padding-top: 1rem"
        @change="handleFileUpload($event)"/>
    </div>

    <!-- BUTTON -->
    <div class="drinks-food-create-edit__bottom-buttons">
        <button
            v-on:click="importDelivery()"
            class="drinks-food-create-edit__add-allergens-button mt-5">
            Import
        </button>
    </div>

    <div class="categories-index-container" style="margin-top:5rem;max-width:100% !important;width:100%;">
        <p v-if="linked_count != null"  style="color:green;">Number of successfully added product to delivery: <span style="font-weight:700;">{{ this.linked_count }}</span></p>
        <p v-if="unlinked_count != null"  style="color:red;" >Number of unlinked products: <span style="font-weight:700;">{{ this.unlinked_count }}</span></p>

        <div v-if="unlinked_products != null && unlinked_products.length > 0" class="categories-list">

            <!-- header -->
            <div class="list-header mt-3 w-100 stocktaking-heading">
                <span class="p-info info-name">Name</span>
                <span class="p-info">Quantity</span>
            </div>

            <!-- items -->
            <div v-for="product in unlinked_products" class="category stocktaking-row">

                <div class="category__title-container">
                                        
                    <!-- name -->
                    <div class="stocktaking-col col-name">
                        <span>{{ product.name }}</span>
                    </div>
                    <!-- name -->
                    <div class="stocktaking-col">
                        <span>{{ product.value }}</span>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>

    <!-- v-if="linked_count != null" -->
    
    <div v-if="unlinked_count != null" class="drinks-food-create-edit__bottom-buttons" style="margin-top:3rem;">
        <button v-on:click="completeDelivery()" class="drinks-food-create-edit__add-allergens-button">
            <div class="drinks-food-create-edit__photo-upload-icon">
                <svg style="width: 1.5rem;fill: white;margin-right: 10px;" id="Layer_1" version="1.1" viewBox="0 0 30 30" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path fill="white;" d="M22,4h-2v6c0,0.552-0.448,1-1,1h-9c-0.552,0-1-0.448-1-1V4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18  c1.105,0,2-0.895,2-2V8L22,4z M22,24H8v-6c0-1.105,0.895-2,2-2h10c1.105,0,2,0.895,2,2V24z"/>
                    <rect height="5" width="2" x="16" y="4"/>
                </svg>
                Save Delivery
            </div>

        </button>
        <button v-on:click="add()" class="drinks-food-create-edit__add-allergens-button">
            <svg class="feather feather-edit" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Add manually
        </button>
    </div>



  </div>
</template>

<script>

import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";

export default {

  components: { DatePick },
  mounted() {
    console.log("Component mounted.");
  },

  data() {
    return {
      file: "",
      date: null,
      time: null,
      delivery_id:null,

      //response data 
      unlinked_count:null,
      unlinked_products:null,
      linked_count:null,
    };
  },

  methods: {

    completeDelivery(){
        const filter_url = `/delivery/app/complete`;
        return new Promise(resolve => {
            window.axios.post(filter_url, {
                'delivery_id': this.delivery_id,
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                }
            }).then(response => {
                
                if(response.data == 'success'){
                    this.$toast.success("You successfully saved delivery");
                    window.location.href="/delivery";
                }
                
            }).then(response => {}).catch(error => {})
        });
    },

    add(){
        window.location.href = "/delivery/"+this.delivery_id+"/app";
    },

    save(){
        alert("save delivey");
    },

    formatDate(date) {
        var date_array = date.split("-");
        var formated_date =
        date_array[2] + "." + date_array[1] + "." + date_array[0];
        return formated_date;
    },

    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },

    importDelivery() {

        if(this.file == "" || this.date == null){
            alert("Enter all data");
            return 0;
        }

        let formData = new FormData();
        formData.append('file', this.file);
        formData.append("date", this.date);
        formData.append("time", this.time);

        _.each(this.formData, (value, key) => {
          formData.append(key, value)
        })

        const filter_url = `/delivery/import-excel`;

        return new Promise(resolve => {            
            window.axios.post(filter_url, formData, {
            headers: {
              'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }
            ).then(response => {

                if(response.data.status == "error"){
                    alert("error ocurred");
                }

                if(response.data.status == "success"){

                    this.linked_count = response.data.linked;
                    this.unlinked_count = response.data.unlinked;
                    this.delivery_id = response.data.delivery_id;

                    if(this.unlinked_count > 0){
                        this.unlinked_products = response.data.unlinked_products;
                    }
                    
                }

                console.log(response.data);

            }).then(response => {}).catch(error => {})
        });

    },
  },
};
</script>
