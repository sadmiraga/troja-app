<template>
    
  <div class="container">
    <div class="container categories-create-edit-container">


      <!-- choos STrage -->
      <div  class="public-events-index-container">
        <div class="public-events-list">

          <!-- KG -->
          <a href="#" v-on:click="changeStorage('bar')" v-bind:class="{ 'card-button-hover': barClass }"
            class="public-events-list__item card-button">
            <!-- ICON -->
            <div class="card-body">
              <h1 class="h3-secondary">{{this.translations.Bar}}</h1>
            </div>
            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z" fill="white" />
                </svg>
              </div>
            </div>
          </a>
  
          <!-- G -->
          <a v-on:click="changeStorage('restaurant')" v-bind:class="{ 'card-button-hover': restaurantClass }" href="#"
            class="public-events-list__item card-button">
            <!-- ICON -->
            <div class="card-body">
              <h1 class="h3-secondary">{{this.translations.Restaurant}}</h1>
            </div>
            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z" fill="white" />
                </svg>
              </div>
            </div>
          </a>
        </div>
      </div>
        
      <!-- Choose method-->
      <div v-if="storage != null" class="public-events-index-container">
        <!-- <h1 class="h1-primary">Choose stocktaking method</h1> -->
        <div class="public-events-list">


          <!-- scale -->
          <a v-on:click="changeMethod('scale')" v-bind:class="{ 'card-button-hover': scaleHoverClass }" id="scale" class="public-events-list__item card-button">
            <!-- ICON -->
            <div class="card-body">
              <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                <path d="M3.16663 29.3332C3.16663 26.8665 3.49463 24.7612 4.15063 23.0172C4.80663 21.2732 5.64485 19.8229 6.66529 18.6665C7.68752 17.5109 8.83196 16.6163 10.0986 15.9825C11.3653 15.3487 12.6102 14.9101 13.8333 14.6665V10.6665C10.7888 10.2887 8.24974 9.34961 6.21596 7.84917C4.18218 6.34873 3.16574 4.62117 3.16663 2.6665H29.8333C29.8333 4.62206 28.8164 6.35006 26.7826 7.8505C24.7488 9.35095 22.2102 10.2896 19.1666 10.6665V14.6665C20.3888 14.9109 21.6333 15.3501 22.9 15.9838C24.1666 16.6176 25.3111 17.5118 26.3333 18.6665C27.3555 19.8221 28.1946 21.2723 28.8506 23.0172C29.5066 24.7621 29.8342 26.8674 29.8333 29.3332H21.8333V26.6665H27C26.6 23.2887 25.3386 20.8443 23.216 19.3332C21.0933 17.8221 18.8546 17.0665 16.5 17.0665C14.1444 17.0665 11.9053 17.8221 9.78263 19.3332C7.65996 20.8443 6.39907 23.2887 5.99996 26.6665H11.1666V29.3332H3.16663ZM16.5 8.1665C18.5222 8.1665 20.3222 7.89406 21.9 7.34917C23.4777 6.80428 24.7333 6.13228 25.6666 5.33317H7.33329C8.26663 6.13317 9.52218 6.80561 11.1 7.3505C12.6777 7.89539 14.4777 8.16739 16.5 8.1665ZM16.5 29.3332C15.7666 29.3332 15.1386 29.0718 14.616 28.5492C14.0933 28.0265 13.8324 27.3989 13.8333 26.6665C13.8333 26.2887 13.9057 25.9443 14.0506 25.6332C14.1955 25.3221 14.3897 25.0443 14.6333 24.7998C15.1666 24.2665 16.0666 23.7052 17.3333 23.1158C18.6 22.5265 20.1 21.9323 21.8333 21.3332C21.2111 23.0665 20.6111 24.5665 20.0333 25.8332C19.4555 27.0998 18.9 27.9998 18.3666 28.5332C18.1222 28.7776 17.8444 28.9723 17.5333 29.1172C17.2222 29.2621 16.8777 29.3341 16.5 29.3332Z" fill="#FDA53C" />
              </svg>
              <h1 class="h3-secondary">{{this.translations.Scale}}</h1>
            </div>

            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z" fill="white" />
                </svg>
              </div>
            </div>
          </a>
  
          <!-- paper -->
          <a v-bind:class="{ 'card-button-hover': paperHoverClass }" v-on:click="changeMethod('paper')" id="paper" class="public-events-list__item card-button">

            <!-- ICON -->
            <div class="card-body">
              
              <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                <path d="M26.3182 7.57681V3.87863C26.3182 3.55715 26.1905 3.24884 25.9632 3.02153C25.7359 2.79421 25.4275 2.6665 25.1061 2.6665H21.4697V5.09075H23.8939V8.75135C23.8939 8.75135 26.3182 10.1138 26.3182 12.9695V26.9089H21.4697V29.3332H27.5303C27.8518 29.3332 28.1601 29.2055 28.3874 28.9781C28.6147 28.7508 28.7424 28.4425 28.7424 28.121V12.9695C28.7439 11.9502 28.5284 10.9421 28.1105 10.0124C27.6925 9.08261 27.0816 8.25238 26.3182 7.57681ZM16.6212 26.9089H12.9849V29.3332H17.8333C18.1548 29.3332 18.4631 29.2055 18.6904 28.9781C18.9178 28.7508 19.0455 28.4425 19.0455 28.121V23.2726H16.6212V26.9089ZM6.92425 23.2726H4.50001V28.121C4.50001 28.4425 4.62771 28.7508 4.85503 28.9781C5.08235 29.2055 5.39065 29.3332 5.71213 29.3332H10.5606V26.9089H6.92425V23.2726ZM16.6212 15.9998H19.0455V20.8483H16.6212V15.9998ZM4.50001 15.9998H6.92425V20.8483H4.50001V15.9998ZM16.6212 7.57681V3.87863C16.6212 3.55715 16.4935 3.24884 16.2662 3.02153C16.0389 2.79421 15.7306 2.6665 15.4091 2.6665H8.13637C7.8149 2.6665 7.50659 2.79421 7.27927 3.02153C7.05195 3.24884 6.92425 3.55715 6.92425 3.87863V7.57681C6.16088 8.25238 5.54993 9.08261 5.13197 10.0124C4.714 10.9421 4.49858 11.9502 4.50001 12.9695V13.5756H6.92425V12.9695C6.92425 10.1138 9.34849 8.75135 9.34849 8.75135V5.09075H14.197V8.75135C14.197 8.75135 16.6212 10.1138 16.6212 12.9695V13.5756H19.0455V12.9695C19.0469 11.9502 18.8315 10.9421 18.4135 10.0124C17.9955 9.08261 17.3846 8.25238 16.6212 7.57681Z" fill="#FDA53C" />
              </svg>

              <h1 class="h3-secondary">{{this.translations.Paper_scale}}</h1>
            </div>
            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none">
                  <path
                    d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                    fill="white" />
                </svg>
              </div>
            </div>
          </a>
        </div>
      </div>
  
      <!-- choos unit -->
      <div v-if="this.method != null" class="public-events-index-container">
        <div class="public-events-list">

          <!-- KG -->
          <a href="#" v-on:click="changeUnit('kg')" v-bind:class="{ 'card-button-hover': kghoverClass }"
            class="public-events-list__item card-button">
            <!-- ICON -->
            <div class="card-body">
              <h1 class="h3-secondary">{{this.translations.Kilograms}}</h1>
            </div>
            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z" fill="white" />
                </svg>
              </div>
            </div>
          </a>
  
          <!-- G -->
          <a v-on:click="changeUnit('g')" v-bind:class="{ 'card-button-hover': ghoverClass }" href="#"
            class="public-events-list__item card-button">
            <!-- ICON -->
            <div class="card-body">
              <h1 class="h3-secondary">{{this.translations.Grams}}</h1>
            </div>
            <!-- button icon -->
            <div class="card-footer">
              <div class="card-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z" fill="white" />
                </svg>
              </div>
            </div>
          </a>
        </div>
      </div>


  
      <button v-if="this.unit != null"  class="category-create-edit__add-button" v-on:click="create()">
        {{ this.translations.Start_stocktaking }}
      </button>
    </div>
  </div>
  </template>
  
  <script>
  export default {
    mounted() {
      console.log("Component mounted.");
    },

    props: ["translations"],
  
    data() {
      return {
        method: null,
        unit: null,
        storage:null,

        barClass:false,
        restaurantClass:false,
  
        scaleHoverClass: false,
        paperHoverClass: false,

        ghoverClass: false,
        kghoverClass: false,
      };
    },
  
    watch: {

    //storage 
    storage: function(newVal){
      if(newVal == "bar"){
        this.barClass = true;
        this.restaurantClass = false;
      }

      if(newVal == "restaurant"){
        this.barClass = false;
        this.restaurantClass = true;
      }
    },
    
    //method
      method: function (newVal) {
        if (newVal == "scale") {
          this.scaleHoverClass = true;
          this.paperHoverClass = false;
        } 
  
        if(newVal == "paper"){
          this.paperHoverClass = true;
          this.scaleHoverClass = false;
        }

        this.unit = null,
        this.kghoverClass = false;
        this.ghoverClass = false;
      },

    //unit
    unit: function (newVal){
        if(newVal == 'kg'){
            this.kghoverClass = true;
            this.ghoverClass = false;
        }

        if(newVal == 'g'){
            this.kghoverClass = false;
            this.ghoverClass = true;
        }
    }


    },
  
    methods: {
      changeMethod(method) {
        this.method = method;
  
        if (method == "paper") {
          this.changeUnit(null);
          this.ghoverClass = false;
          this.kghoverClass = false;
        }
  
      },

      changeUnit(unit){
        this.unit = unit;
      },

      changeStorage(storage){
        this.storage = storage;
      },

      create() {
            this.loading = true;
            return new Promise(resolve => {
                window.axios.post(`/mystocktaking/store`, {
                    'method': this.method,
                    'unit': this.unit,
                    'storage': this.storage,
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                    }
                }).then(response => {
                    window.location.href = "/mystocktaking/"+response.data+"/app";
                }).then(response => {}).catch(error => {})
            });
        },
    },
  };
  </script>
  