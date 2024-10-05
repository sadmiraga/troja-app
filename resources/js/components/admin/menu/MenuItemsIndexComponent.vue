<template>
  <div>

    <!-- modal -->
    <div class="modal fade warning-popup" id="confirm-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header close -->
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h3 class="p-bold text-left">Are you sure you want to delete {{this.menu_item_name}}?</h3>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                      <button class="save-button" type="button" data-bs-dismiss="modal">
                          No
                      </button>

                      <!-- YES -->
                      <a class="w-100" :href="'menu_items/delete/'+this.menu_item_id">
                          <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                              Yes
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


    <!-- TOP bar -->
    <div class="drinks-food-navbar">
      <div class="drinks-food-navbar__links">
        <a
          href="#"
          v-on:click="goToDrinks()"
          class="drinks-food-navbar__link"
          :class="{
            'drinks-food-navbar__link--active': this.page === 'drink',
          }">
          Pijače
        </a>
        <a
          href="#"
          v-on:click="goToFood()"
          class="drinks-food-navbar__link"
          :class="{
            'drinks-food-navbar__link--active': this.page === 'food',
          }">
          Hrana
        </a>
        <a
          href="#"
          v-on:click="goToShisha()"
          class="drinks-food-navbar__link"
          :class="{
            'drinks-food-navbar__link--active': this.page === 'shisha',
          }">
          Shisha
        </a>
      </div>
    </div>


    <!-- PRODUCTS LIST -->
    <div id="drinks" class="drinks-food-index-container">

        <!-- search -->
        <div class="search-bar-container-weekly">
            <div class="search-bar">
                <input
                    type="text"
                    name="search"
                    id="search"
                    placeholder="Search products"
                    v-model="query"
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
                <a :href="'/menu_items/create/'+this.page">
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
                        </svg>
                    </button>
                </a>
            </div>
        </div> 

        <!-- product list -->
        <div class="drinks-food-list products-list" style="grid-template-columns: repeat(1, 1fr);">
          
          <a v-for="menu_item in menu_items" 
              v-if="menu_item.drink_or_food == page"
              class="drinks-food-list__item --drink-item product-card"
              style="justify-content: space-between;height: auto !important;align-items:start !important;height:100%;">

              <!-- image -->
               <div v-if="menu_item.image != null" class="drinks-food-list__text-container menu-item-image-part">
                  <img :src="'/images_dynamic/menu_items/' + menu_item.image"  class="admin-menu-item-image">
                  
               </div>

              <!-- Card content -->
              <div class="drinks-food-list__text-container menu-item-text-part">

                <!-- title -->
                <h4 class="drinks-food-list__title">
                  {{ menu_item.name }}
                  <span v-if="menu_item.packing_size != null" style="font-size:14px;display:flex;align-items:center;">                                    
                      {{ menu_item.packing_size }} l
                  </span>
                  <!-- PACKING WEIGHT -->
                  <span v-if="menu_item.packing_weight != null" style="font-size: 14px;display:flex;align-items:center;margin-left:30px;">
                    {{ menu_item.packing_weight }} g
                  </span>
                </h4>
                <!-- PACKING SIZE -->
              

                <!-- CATEGORY -->
                <div class="drinks-food-list__category" style="display: flex; align-items:center;margin-top:12px;">
                  <svg style="height: 15px;margin-right:7px;" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar__categories-icon">
                      <path d="M21.75 0.5H2.25C1.00734 0.5 0 1.50734 0 2.75V19.25C0 20.4927 1.00734 21.5 2.25 21.5H21.75C22.9927 21.5 24 20.4927 24 19.25V2.75C24 1.50734 22.9927 0.5 21.75 0.5ZM21.4688 19.25H2.53125C2.45666 19.25 2.38512 19.2204 2.33238 19.1676C2.27963 19.1149 2.25 19.0433 2.25 18.9688V3.03125C2.25 2.95666 2.27963 2.88512 2.33238 2.83238C2.38512 2.77963 2.45666 2.75 2.53125 2.75H21.4688C21.5433 2.75 21.6149 2.77963 21.6676 2.83238C21.7204 2.88512 21.75 2.95666 21.75 3.03125V18.9688C21.75 19.0433 21.7204 19.1149 21.6676 19.1676C21.6149 19.2204 21.5433 19.25 21.4688 19.25ZM19.5 14.9375V16.0625C19.5 16.3731 19.2481 16.625 18.9375 16.625H9.5625C9.25186 16.625 9 16.3731 9 16.0625V14.9375C9 14.6269 9.25186 14.375 9.5625 14.375H18.9375C19.2481 14.375 19.5 14.6269 19.5 14.9375ZM19.5 10.4375V11.5625C19.5 11.8731 19.2481 12.125 18.9375 12.125H9.5625C9.25186 12.125 9 11.8731 9 11.5625V10.4375C9 10.1269 9.25186 9.875 9.5625 9.875H18.9375C19.2481 9.875 19.5 10.1269 19.5 10.4375ZM19.5 5.9375V7.0625C19.5 7.37314 19.2481 7.625 18.9375 7.625H9.5625C9.25186 7.625 9 7.37314 9 7.0625V5.9375C9 5.62686 9.25186 5.375 9.5625 5.375H18.9375C19.2481 5.375 19.5 5.62686 19.5 5.9375ZM7.6875 6.5C7.6875 7.43197 6.93197 8.1875 6 8.1875C5.06803 8.1875 4.3125 7.43197 4.3125 6.5C4.3125 5.56803 5.06803 4.8125 6 4.8125C6.93197 4.8125 7.6875 5.56803 7.6875 6.5ZM7.6875 11C7.6875 11.932 6.93197 12.6875 6 12.6875C5.06803 12.6875 4.3125 11.932 4.3125 11C4.3125 10.068 5.06803 9.3125 6 9.3125C6.93197 9.3125 7.6875 10.068 7.6875 11ZM7.6875 15.5C7.6875 16.432 6.93197 17.1875 6 17.1875C5.06803 17.1875 4.3125 16.432 4.3125 15.5C4.3125 14.568 5.06803 13.8125 6 13.8125C6.93197 13.8125 7.6875 14.568 7.6875 15.5Z" fill="currentColor" />
                  </svg>
                  <span class="fs-14">{{ menu_item.category_name }}</span>
                </div>

                <!-- price section -->
                <div v-if="menu_item.price != null || menu_item.night_price != null" class="drinks-food-list__category" style="display: flex; align-items:center;margin-top:20px;gap:22px;">
                  <!-- price -->
                  <div v-if="menu_item.price != null">
                    <span class="fs-14" style="margin-right: 5px !important;">Cena:</span>
                    <span class="fs-14">{{ menu_item.price }}€</span>
                  </div>
                  <!-- night price -->
                  <div v-if="menu_item.night_price != null">
                    <span class="fs-14" style="margin-right: 5px !important;">Nočna cena:</span>
                    <span class="fs-14">{{ menu_item.night_price }}€</span>
                  </div>
                </div>

                <!-- description -->
                <div class="drinks-food-list__category mt-22" style="margin-top:12px !important;">
                  <span class="fs-12" >Description:   {{ menu_item.description }}</span>
                </div>
                

              </div>

              <!-- Buttons -->
              <div class="drinks-food-list__text-container delete-button-container" style="align-items:end;">
                  <!-- edit -->
                  <a :href="'/menu_items/edit/' + menu_item.id" class="w-100">
                      <button class="btn btn-warning w-100" style="box-sizing: border-box;">
                          Edit
                      </button>
                  </a>

                  <!-- delete -->
                  <a  v-on:click="openModalViaButton(menu_item)" class="w-100">
                      <button class="btn btn-danger w-100" style="box-sizing: border-box;">
                          Delete
                      </button>
                  </a>
                  <!-- delete -->
                  <a :href="'/menu_items/translations/'+menu_item.id" class="w-100">
                      <button class="btn btn-warning w-100" style="box-sizing: border-box;">
                          Translations
                      </button>
                  </a>
              </div>

          </a>


        </div>

        
    </div>


  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    const urlParams = new URLSearchParams(window.location.search);
    const page = Number(urlParams.get("page"));

    if (page != 0) {
      this.page = page;
    }
  },

  props: ["menu_items"],

  data() {
    return {
      page: "drink",
      drinks_query: "",
      food_query: "",
      query: "",
      menu_item_id:null,
      menu_item_name:null,
    };
  },

  watch:{
    query: function(newVal){
        this.search();
    }
  },

  methods: {

    search(){
      alert(this.query);
    },

    goToFood() {
      this.page = "food";
    },

    goToDrinks() {
      this.page = "drink";
    },

    goToShisha(){
      this.page = "shisha";
    },

    openModalViaButton(menu_item){
      this.menu_item_id = menu_item.id;
      this.menu_item_name = menu_item.name;
      let button = document.getElementById('trigger-modal');
      button.click();
    },

    search(){
        const filter_url = `/menu_items/search`;
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
                this.menu_items = response.data;
            }).then(response => {}).catch(error => {})
        });
    },


    
  },
};
</script>
