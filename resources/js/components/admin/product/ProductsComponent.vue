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
                        <h3 class="p-bold text-left">{{this.translations.Delete_from_locations}}</h3>

                        <div class="mt-3">
                            <Multiselect v-model="selected_locations"
                            :options="labelOptions"
                            :close-on-select="false"
                            :multiple="true"
                            :placeholder="this.translations.Choose_locations_to_delete_category_from" 
                            >
                            </Multiselect>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                            <!-- CONFIRM -->
                            <a class="w-100" v-on:click="confirmDelete()" >
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    <!-- {{this.translations.Yes}} -->
                                    {{this.translations.Confirm}}
                                </button>
                            </a>

                            <!-- YES - NO -->
                            <div class="d-none">
                                <button class="save-button" type="button" data-bs-dismiss="modal">
                                    {{this.translations.No}}
                                </button>

                                <!-- YES -->
                                <a class="w-100" :href="'/product/delete/' + this.product_id">
                                    <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                        {{this.translations.Yes}}
                                    </button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- trigger modal button-->
        <button type="button" id="trigger-modal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#confirm-modal">
            Open Modal
        </button>

        <!-- TOP-->
        <div v-if="this.settings.has_restaurant == true" class="drinks-food-navbar">
            <div class="drinks-food-navbar__links">

                <!-- bar -->
                <a href="#" v-on:click="gotoPage('bar')" class="drinks-food-navbar__link"
                    :class="{
                        'drinks-food-navbar__link--active': this.page === 'bar',
                    }">
                    {{this.translations.Bar}}
                </a>

                <!-- restaurant -->
                <a href="#" v-on:click="gotoPage('restaurant')" class="drinks-food-navbar__link"
                    :class="{
                        'drinks-food-navbar__link--active': this.page === 'restaurant',
                    }">
                    {{this.translations.Restaurant}}
                </a>
            </div>
        </div>

        <!-- DRINKS -->
        <div id="drinks" class="drinks-food-index-container">

            <!-- search -->
            <div class="search-bar-container-weekly">
                <div class="search-bar">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        :placeholder="this.translations.Search_products"
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
                    <a :href="'/product/create/'+this.page">
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
            <div class="drinks-food-list products-list">

                <a v-for="product in products" 
                    class="drinks-food-list__item --drink-item product-card"
                    style="justify-content: space-between;height: auto !important;align-items:start !important;height:100%;"
                    v-if="product.storage == page"
                >
                    <div class="drinks-food-list__text-container">
                        <h4 class="drinks-food-list__title">
                            {{ product.name }}
                        </h4>

                        <!-- packing size and packing weight -->
                        <div  class="drinks-food-list__category" style="margin-top: 22px;display:flex;align-items:center;">


                            <!-- PACKING SIZE -->
                            <span v-if="product.packing_size != null" style="font-size:14px;display:flex;align-items:center;">                                    
                                <svg class="packing-size-icon" viewBox="0 0 21 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 14.3511C21 14.1723 20.9268 10.1031 14.8585 8.76465V7.04293C15.8583 6.9429 16.6415 6.09475 16.6415 5.06621V1.98675C16.6415 0.891256 15.7528 0 14.6604 0H6.43868C5.34628 0 4.45755 0.891256 4.45755 1.98675V5.06621C4.45755 6.06018 5.18997 6.88359 6.14151 7.02813V8.74717C0.308264 9.96723 0 13.6052 0 14.3511V17.1476C0 18.0119 0.367005 18.8093 0.951934 19.3942C0.367005 19.9473 0 20.7014 0 21.5187V25.5477C0 26.3353 0.336496 27.0645 0.878533 27.6136C0.336496 28.1605 0 28.8865 0 29.6705V33.6997C0 34.5093 0.357198 35.2569 0.92816 35.8102C0.357198 36.3623 0 37.1083 0 37.9161V41.9453C0 43.6011 1.49239 45 3.25896 45H17.9193C19.6468 45 21 43.6581 21 41.9453V37.9161C21 37.1072 20.6725 36.3715 20.1401 35.8252C20.6749 35.2791 21 34.5337 21 33.6997V29.6705C21 28.8699 20.7007 28.1505 20.2034 27.6119C20.7007 27.0713 21 26.3502 21 25.5477V21.5187C21 20.6778 20.6663 19.9272 20.1186 19.3817C20.6636 18.8026 21 18.015 21 17.1476V14.3511ZM6.43868 1.98675H14.6604L14.6606 5.06621H6.43868V1.98675ZM19.0189 41.9452C19.0189 42.5639 18.5565 43.0131 17.9193 43.0131H3.25896C2.57824 43.0131 1.98113 42.5142 1.98113 41.9452V37.916C1.98113 37.3504 2.57824 36.8542 3.25896 36.8542H13.3726C13.9196 36.8542 14.3632 36.4094 14.3632 35.8608C14.3632 35.8441 14.3615 35.8278 14.3607 35.8112C14.3615 35.7946 14.3632 35.7783 14.3632 35.7615C14.3632 35.213 13.9196 34.7681 13.3726 34.7681H3.25896C2.57824 34.7681 1.98113 34.2689 1.98113 33.6996V29.6704C1.98113 29.1051 2.57824 28.6091 3.25896 28.6091H12.7783H12.9764C13.5234 28.6091 13.967 28.1643 13.967 27.6157C13.967 27.0672 13.5234 26.6224 12.9764 26.6224H12.7783H3.25896C2.59013 26.6224 1.98113 26.1101 1.98113 25.5476V21.5186C1.98113 20.9565 2.57824 20.4634 3.25896 20.4634H12.4811C13.0281 20.4634 13.4717 20.0186 13.4717 19.4701C13.4717 19.4533 13.47 19.437 13.4692 19.4204C13.47 19.4038 13.4717 19.3875 13.4717 19.3707C13.4717 18.8222 13.0281 18.3773 12.4811 18.3773H3.25896C2.59013 18.3773 1.98113 17.7913 1.98113 17.1475V14.351C1.98113 13.8552 2.2367 11.3422 7.28225 10.5579C7.80923 10.476 8.17316 9.99147 8.11363 9.46498C8.11898 9.42316 8.12264 9.38094 8.12264 9.33763V7.05296H12.8774V9.5364C12.8774 9.93733 13.1147 10.2819 13.4557 10.4388C13.5655 10.5107 13.691 10.562 13.8284 10.5858C18.9495 11.4727 19.0188 14.3224 19.0189 14.351V17.1475C19.0189 17.8256 18.5035 18.3773 17.8698 18.3773C17.3228 18.3773 16.8792 18.8222 16.8792 19.3707C16.8792 19.416 16.8833 19.4602 16.8892 19.5039C16.9071 20.0368 17.3423 20.4634 17.878 20.4634C18.5283 20.4634 19.0189 20.917 19.0189 21.5186V25.5476C19.0189 26.1503 18.5196 26.6224 17.8822 26.6224C17.3352 26.6224 16.8916 27.0672 16.8916 27.6157C16.8916 28.1643 17.3352 28.6091 17.8822 28.6091C17.885 28.6091 17.8877 28.6089 17.8906 28.6089C17.892 28.6089 17.8933 28.6091 17.8946 28.6091C18.5356 28.6091 19.0189 29.0654 19.0189 29.6704V33.6996C19.0189 34.2988 18.5196 34.7681 17.8822 34.7681C17.4135 34.7681 17.0217 35.0951 16.9189 35.5336C16.8831 35.6362 16.8627 35.746 16.8627 35.8608C16.8627 36.4094 17.3063 36.8542 17.8533 36.8542C18.5068 36.8542 19.0189 37.3206 19.0189 37.916V41.9452Z" fill="black"/>
                                    </svg>
                                {{ product.packing_size }} l
                            </span>

                            <!-- PACKING WEIGHT -->
                            <span v-if="product.packing_weight != null" style="font-size: 14px;display:flex;align-items:center;margin-left:30px;">
                                <svg class="packing-weight-icon" width="43" height="45" viewBox="0 0 43 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.86844 41.7153H36.3061C37.5851 41.7153 38.6413 40.7162 38.7122 39.4392L40.5864 5.70264C40.6632 4.32141 39.5638 3.15926 38.1804 3.15926H4.99426C3.61083 3.15926 2.51147 4.32141 2.58819 5.70264L4.46245 39.4392C4.53339 40.7162 5.58959 41.7153 6.86844 41.7153ZM36.3061 44.125C38.864 44.125 40.9763 42.1268 41.1182 39.5729L42.9924 5.83638C43.1459 3.07381 40.9471 0.749512 38.1804 0.749512H4.99426C2.22743 0.749512 0.0286876 3.0738 0.182165 5.83638L2.05641 39.5729C2.1983 42.1268 4.31061 44.125 6.86844 44.125H36.3061Z" fill="#333333"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M33.8716 14.492C32.6091 13.1503 31.1314 12.0205 29.4943 11.1517C27.143 9.90385 24.5296 9.23032 21.8679 9.18598C19.2064 9.14176 16.572 9.72806 14.1805 10.8969C12.5155 11.7107 11.0009 12.7907 9.69436 14.0897L15.2816 18.2929C15.2998 18.2988 15.3467 18.3079 15.4396 18.2994C15.6285 18.2824 15.8936 18.1957 16.1503 18.0219C16.5256 17.7677 16.9195 17.5395 17.3291 17.3393C18.7041 16.6673 20.2185 16.3303 21.7487 16.3557C23.2789 16.3811 24.7813 16.7684 26.1331 17.4858C26.5359 17.6995 26.9218 17.9407 27.2886 18.2073C27.5393 18.3895 27.8014 18.4851 27.9897 18.5082C28.0822 18.5197 28.1294 18.5122 28.1476 18.5069L33.8716 14.492ZM28.1569 18.503C28.1572 18.5033 28.1538 18.5051 28.1476 18.5069C28.1528 18.5039 28.1567 18.5027 28.1569 18.503ZM15.2726 18.2886C15.2728 18.2883 15.2764 18.2897 15.2816 18.2929C15.2755 18.2907 15.2722 18.2889 15.2726 18.2886ZM35.8666 13.1003C36.7607 14.0861 36.4867 15.6012 35.3971 16.3655L29.5266 20.4831C28.4371 21.2474 26.9484 20.9389 25.8719 20.1566C25.5963 19.9562 25.3062 19.775 25.0035 19.6144C23.9876 19.0752 22.8585 18.7843 21.7085 18.7651C20.5586 18.7459 19.4205 18.9993 18.3872 19.5043C18.0793 19.6548 17.7834 19.8262 17.5014 20.0173C16.3994 20.7635 14.9012 21.0222 13.8378 20.2222L8.10754 15.9114C7.044 15.1113 6.82049 13.5879 7.74692 12.6324C9.29531 11.0355 11.1129 9.71396 13.1224 8.73187C15.8556 7.39602 18.8662 6.72599 21.9081 6.77659C24.9499 6.8272 27.9367 7.59699 30.6239 9.02308C32.5995 10.0714 34.3721 11.4527 35.8666 13.1003Z" fill="#333333"/>
                                    <path d="M25.4214 12.2823C25.8581 11.7803 26.6191 11.7272 27.1212 12.1639C27.6234 12.6007 27.6764 13.3617 27.2396 13.8637L23.9306 17.6686C23.4939 18.1707 22.7328 18.2237 22.2307 17.7871C21.7287 17.3503 21.6756 16.5893 22.1123 16.0872L25.4214 12.2823Z" fill="#333333"/>
                                </svg>
                                {{ product.packing_weight }} g
                            </span>



                        </div>

                        <!-- CATEGORY -->
                        <div class="drinks-food-list__category" style="display: flex; align-items:center;margin-top:20px;">
                            <svg style="height: 15px;margin-right:7px;" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar__categories-icon">
                                <path d="M21.75 0.5H2.25C1.00734 0.5 0 1.50734 0 2.75V19.25C0 20.4927 1.00734 21.5 2.25 21.5H21.75C22.9927 21.5 24 20.4927 24 19.25V2.75C24 1.50734 22.9927 0.5 21.75 0.5ZM21.4688 19.25H2.53125C2.45666 19.25 2.38512 19.2204 2.33238 19.1676C2.27963 19.1149 2.25 19.0433 2.25 18.9688V3.03125C2.25 2.95666 2.27963 2.88512 2.33238 2.83238C2.38512 2.77963 2.45666 2.75 2.53125 2.75H21.4688C21.5433 2.75 21.6149 2.77963 21.6676 2.83238C21.7204 2.88512 21.75 2.95666 21.75 3.03125V18.9688C21.75 19.0433 21.7204 19.1149 21.6676 19.1676C21.6149 19.2204 21.5433 19.25 21.4688 19.25ZM19.5 14.9375V16.0625C19.5 16.3731 19.2481 16.625 18.9375 16.625H9.5625C9.25186 16.625 9 16.3731 9 16.0625V14.9375C9 14.6269 9.25186 14.375 9.5625 14.375H18.9375C19.2481 14.375 19.5 14.6269 19.5 14.9375ZM19.5 10.4375V11.5625C19.5 11.8731 19.2481 12.125 18.9375 12.125H9.5625C9.25186 12.125 9 11.8731 9 11.5625V10.4375C9 10.1269 9.25186 9.875 9.5625 9.875H18.9375C19.2481 9.875 19.5 10.1269 19.5 10.4375ZM19.5 5.9375V7.0625C19.5 7.37314 19.2481 7.625 18.9375 7.625H9.5625C9.25186 7.625 9 7.37314 9 7.0625V5.9375C9 5.62686 9.25186 5.375 9.5625 5.375H18.9375C19.2481 5.375 19.5 5.62686 19.5 5.9375ZM7.6875 6.5C7.6875 7.43197 6.93197 8.1875 6 8.1875C5.06803 8.1875 4.3125 7.43197 4.3125 6.5C4.3125 5.56803 5.06803 4.8125 6 4.8125C6.93197 4.8125 7.6875 5.56803 7.6875 6.5ZM7.6875 11C7.6875 11.932 6.93197 12.6875 6 12.6875C5.06803 12.6875 4.3125 11.932 4.3125 11C4.3125 10.068 5.06803 9.3125 6 9.3125C6.93197 9.3125 7.6875 10.068 7.6875 11ZM7.6875 15.5C7.6875 16.432 6.93197 17.1875 6 17.1875C5.06803 17.1875 4.3125 16.432 4.3125 15.5C4.3125 14.568 5.06803 13.8125 6 13.8125C6.93197 13.8125 7.6875 14.568 7.6875 15.5Z" fill="currentColor" />
                            </svg>
                            <span class="fs-14">{{ product.category_name }}</span>
                        </div>

                        <!-- Linked-->
                        <div v-if="product.type = 'global'" class="drinks-food-list__price-label mt-22 d-none">
                            <svg class="link-icon" width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9998 23.0835C13.3016 20.3749 13.5447 15.7392 16.5427 12.7296L25.2279 4.01053C28.2259 1.0009 32.8436 0.756913 35.5419 3.46557C38.2401 6.17425 37.997 10.8098 34.999 13.8194L30.6563 18.179" stroke="black" stroke-width="3" stroke-linecap="round"/>
                                <path d="M23.0002 15.9165C25.6984 18.6251 25.4553 23.2607 22.4573 26.2704L18.1147 30.6298L13.772 34.9895C10.774 37.9992 6.15633 38.243 3.45813 35.5344C0.759934 32.8257 1.00299 28.1901 4.00099 25.1805L8.3437 20.8208" stroke="black" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                            <span class="fs-14" style="margin-left:-5px;"> {{ product.product_count }} {{ translations.Locations }}</span>
                        </div>

                        <!-- PRICE -->
                        <div v-if="product.price != null" class="drinks-food-list__category" style="display: flex; align-items:center;margin-top:20px;">
                            <span class="fs-14" style="margin-right: 5px !important;">{{ translations.Price }}:</span>
                            <span class="fs-14">{{ product.price }}€</span>
                        </div>

                        <!-- description -->
                        <div class="drinks-food-list__category mt-22">
                            <span class="fs-12" >{{ product.description }}</span>
                        </div>

                    </div>

                    <div class="drinks-food-list__text-container delete-button-container" style="align-items:end;">

                        <!-- edit -->
                        <a :href="'/product/edit/' + product.id" class="w-100">
                            <button class="btn btn-warning w-100" style="box-sizing: border-box;">
                                {{ translations.Edit }}
                            </button>
                        </a>

                        <!-- delete -->
                        <a  v-on:click="openModalViaButton(product)" class="w-100">
                            <button class="btn btn-danger w-100" style="box-sizing: border-box;">
                                {{ translations.Delete }}
                            </button>
                        </a>
                    </div>
                </a>

            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components: {Multiselect},

        mounted() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get("page");

            if(page == 'bar'){
                this.page = 'bar';
            }

            if(page == 'restaurant'){
                this.page = 'restaurant';
            }

            if(this.settings.has_restaurant == false){
                this.page = 'bar';
            }
            

        },
        
        props: ["products","translations","settings"],

        watch:{
            query: function(newVal){
                this.search();
            }
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
                selected_locations: [],
                options: [],
                locations:null,

                page: "bar",
                query: "",
                product_id: null,
                product_name: null,
                product_count:null,
            };
        },

        methods: {


            confirmDelete(){
                const delete_url = `/product/delete/multiple`;
                return new Promise(resolve => {
                    window.axios.post(delete_url, {

                        'product_id':this.product_id,
                        'selected_locations':this.selected_location_ids
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {

                        if(response.data == "success"){
                            this.$toast.warning("Successfully deleted product");
                            setTimeout(() => {
                                window.location.href = "/product/?page="+this.page;
                            }, 1500);
                        }
                        
                        
                    }).then(response => {}).catch(error => {})
                });
            },

            openModalViaButton(product) {
                
                this.getLocations(product);
                this.product_id = product.id;

                this.product_id = product.id;
                this.product_name = product.name;
                this.product_count = product.product_count;

                let button = document.getElementById('trigger-modal');
                button.click();
            },

            //get locations linked to this category
            getLocations(product)
            {
                const filter_url = `/product/get-locations`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product.id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        
                    this.locations = response.data;
                    this.selected_locations = []; // Clear the selected locations
                    this.fillLocations(); 

                    }).then(response => {}).catch(error => {})
                });
            },

            fillLocations() {
                this.options = []; // Clear the options before filling
                if (this.locations != null) {
                    for (var i = 0; i < this.locations.length; i++) {
                        var temp_location = {
                            value: this.locations[i].id,
                            label: this.locations[i].name,
                        };
                        this.options.push(temp_location);
                    }
                }
            },



            search(){
                const filter_url = `/product/search`;
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
                        this.products = response.data;
                    }).then(response => {}).catch(error => {})
                });
            },

            gotoPage(page){
                this.page = page;
            }
        }
    }
</script>
