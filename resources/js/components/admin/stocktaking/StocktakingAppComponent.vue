<template>
    <div>

         <!-- LOADING -->
        <div v-if="loading" class="loading-overlay">
            <div class="loading-overlay__inner">
                <div class="loading-overlay__content">
                    <span class="loading-spinner"></span>
                </div>
            </div>
        </div>


        <!-- modal -->
        <div class="modal fade warning-popup" id="confirm-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header close -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="p-bold text-center">{{this.translations.Are_you_sure_you_want_to_cancel_stocktaking}}</h3>
                        <p class="p-regular text-center mt-3">{{ this.translations.This_will_result_deleting_stocktaking_and_all_data_inside_it }}</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                            <!-- CONFIRM -->
                            <a class="w-50" v-on:click="deleteStocktaking()" >
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                     {{this.translations.Yes}}
                                </button>
                            </a>
                            <a class="w-50" >
                                <button type="button" data-bs-dismiss="modal" class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    {{this.translations.No}}
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

        <!-- PAGES -->
        <div class="drinks-food-navbar">
            <div class="drinks-food-navbar__links">
                <a href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoPage('products')"
                    :class="{ 'drinks-food-navbar__link--active': this.page === 'products', }" >
                    {{ this.translations.Products }}
                </a>
                <a href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoPage('added_products')"
                    :class="{ 'drinks-food-navbar__link--active': this.page === 'added_products', }" >
                    {{ this.translations.Added_products }}
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="drinks-food-index-container">
            <!-- search -->
            <div class="search-bar-container-weekly" style="gap:0px;">
                <div class="search-bar">
                    <input type="text" name="search" id="search"
                        :placeholder="translations.Search_products"
                        v-model="query"
                    />
                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-bar__icon" >
                        <path d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>

            <!-- ALL products -->
            <div class="drinks-food-list mt-3">

                <!-- PRODUCTS -->
                <a v-if="page == 'products'" v-for="product in localProduct" class="drinks-food-list__item --drink-item stocktaking-card">
                    <div class="header">
                        {{product.name}}
                    </div>

                    <!-- insert COUNT -->
                    <div v-if="product.stocktaking_quantity == null && (product.enum == 'pcs' || product.packing_size != null)" class="card-input-row mt-2">

                        <!-- inputs -->
                        <div class="card-input-col">
                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('q','-',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Pieces}}</p>
                                <input min="0" class="card-input-value" 
                                       @focus="focusInput($event)" 
                                       @blur="blurInput($event)"
                                       value="0" 
                                       :id="'q-input-'+product.id" 
                                       type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('q','+',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>

                        <!-- CONFIRM -->
                        <div class="card-button-col">
                            <button v-on:click="addPcs(product.id)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <!-- insert WEIGHT |||||  condition is for food  2. condition is for drinks.  --> 
                    <div v-if="(product.enum == 'g' && product.stocktaking_weight == null) || (product.weightable == true && product.stocktaking_weight == null && stocktaking.method == 'scale')" class="card-input-row mt-2">

                        <!-- input fields -->
                        <div class="card-input-col">
                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('w','-',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Stocktaking_weight}} ({{ stocktaking.unit }})</p>
                                <input min="0" class="card-input-value" 
                                    @focus="focusInput($event)" 
                                    @blur="blurInput($event)"
                                    value="0" 
                                    :id="'w-input-'+product.id" 
                                    type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('w','+',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>

                        <!-- CONFIRM -->
                        <div class="card-button-col">
                            <button v-on:click="addWeight(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <!-- insert LITERS -->
                    <div v-if="product.enum != 'g' && stocktaking.method == 'paper' && product.weightable == true && product.stocktaking_liters == null" class="card-input-row mt-2">

                        <!-- input fields -->
                        <div class="card-input-col">
                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('l','-',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Liters}}</p>
                                <input min="0" class="card-input-value" 
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)" 
                                        value="0" 
                                        :id="'l-input-'+product.id" 
                                        type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('l','+',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- CONFIRM -->
                        <div class="card-button-col">
                            <button v-on:click="addLiters(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>


                    </div>

                </a>

                <!-- ADDDED products -->                    
                <a v-if="page == 'added_products'" v-for="product in localAddedProducts" class="drinks-food-list__item --drink-item stocktaking-card">

                    <div class="header">
                        {{ product.name }}  
                        <span v-if="product.quantity!= null"> - {{ product.quantity }} {{translations.Pieces}} </span>
                        <span v-if="product.weight!= null"> - {{ product.weight}}g </span>
                        <span v-if="product.liters!= null"> - {{ product.liters}} {{ translations.Liters }} </span>
                        
                    </div>

                    <!-- COUNT inputs. -->
                    <div v-if="product.quantity != null" class="card-input-row mt-2" style="align-items:center;">

                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('q','-',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Pieces}}</p>
                                <input  class="card-input-value" 
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)"
                                        value="0" 
                                        :id="'q-input-'+product.product_id" 
                                        type="number"
                                        min="0">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('q','+',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                        </div>

                        <!-- add & remove -->
                        <div class="card-button-col double-button-col">
                            <!-- remove -->
                            <button v-on:click="addExtraPcs(product.product_stocktaking_id,product.product_id,'remove')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="white"/>
                                </svg>
                            </button>
                            <!--add -->
                            <button v-on:click="addExtraPcs(product.product_stocktaking_id,product.product_id,'add')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="white"/>
                                </svg>
                            </button>
                        </div>

                        <!-- removeValue & setValue -->
                        <div class="card-button-col double-button-col">
                            <!-- removeValue -->
                            <button v-on:click="removeExtraValue(product,'pcs')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="close">
                                    <path fill="white"
                                        d="M2.39705176,2.55378835 L2.46966991,2.46966991 C2.73593648,2.20340335 3.15260016,2.1791973 3.44621165,2.39705176 L3.53033009,2.46966991 L8,6.939 L12.4696699,2.46966991 C12.7625631,2.1767767 13.2374369,2.1767767 13.5303301,2.46966991 C13.8232233,2.76256313 13.8232233,3.23743687 13.5303301,3.53033009 L9.061,8 L13.5303301,12.4696699 C13.7965966,12.7359365 13.8208027,13.1526002 13.6029482,13.4462117 L13.5303301,13.5303301 C13.2640635,13.7965966 12.8473998,13.8208027 12.5537883,13.6029482 L12.4696699,13.5303301 L8,9.061 L3.53033009,13.5303301 C3.23743687,13.8232233 2.76256313,13.8232233 2.46966991,13.5303301 C2.1767767,13.2374369 2.1767767,12.7625631 2.46966991,12.4696699 L6.939,8 L2.46966991,3.53033009 C2.20340335,3.26406352 2.1791973,2.84739984 2.39705176,2.55378835 L2.46966991,2.46966991 L2.39705176,2.55378835 Z">
                                    </path>
                                </svg>
                            </button>
                            <!-- setValue -->
                            <button v-on:click="setExtraValue(product,'pcs')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>


                        <!-- CONFIRM 
                        <div class="card-button-col">
                            <button v-on:click="addExtraPcs(product.product_stocktaking_id,product.product_id)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        -->


                    </div>

                    <!-- insert WEIGHT -->
                    <div v-if="product.weight != null" class="card-input-row mt-2" style="align-items:center;">
                        <!-- input fields -->
                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('w','-',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Stocktaking_weight}} ({{ stocktaking.unit }})</p>
                                <input class="card-input-value"
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)"
                                        value="0" 
                                        :id="'w-input-'+product.product_id" 
                                        type="number"
                                        min="0">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('w','+',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>

                        <!-- REMOVE -->
                        <div class="card-button-col double-button-col">
                            <button v-on:click="addExtraWeight(product,'remove')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="white"/>
                                </svg>
                            </button>
                            <button v-on:click="addExtraWeight(product,'add')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="white"/>
                                </svg>
                            </button>
                        </div>

                        <!-- setValue & removeValue -->
                        <div class="card-button-col double-button-col">
                            <button v-on:click="removeExtraValue(product,'g')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="close">
                                    <path fill="white"
                                        d="M2.39705176,2.55378835 L2.46966991,2.46966991 C2.73593648,2.20340335 3.15260016,2.1791973 3.44621165,2.39705176 L3.53033009,2.46966991 L8,6.939 L12.4696699,2.46966991 C12.7625631,2.1767767 13.2374369,2.1767767 13.5303301,2.46966991 C13.8232233,2.76256313 13.8232233,3.23743687 13.5303301,3.53033009 L9.061,8 L13.5303301,12.4696699 C13.7965966,12.7359365 13.8208027,13.1526002 13.6029482,13.4462117 L13.5303301,13.5303301 C13.2640635,13.7965966 12.8473998,13.8208027 12.5537883,13.6029482 L12.4696699,13.5303301 L8,9.061 L3.53033009,13.5303301 C3.23743687,13.8232233 2.76256313,13.8232233 2.46966991,13.5303301 C2.1767767,13.2374369 2.1767767,12.7625631 2.46966991,12.4696699 L6.939,8 L2.46966991,3.53033009 C2.20340335,3.26406352 2.1791973,2.84739984 2.39705176,2.55378835 L2.46966991,2.46966991 L2.39705176,2.55378835 Z">
                                    </path>
                                </svg>
                            </button>
                            <button v-on:click="setExtraValue(product,'g')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>


                        
                    </div>

                    <!-- insert LITERS-->
                    <div v-if="product.liters != null" class="card-input-row mt-2">
                        
                        <!-- input fields -->
                        <div class="card-input-col">
                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('l','-',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">{{translations.Liters}}</p>
                                <input class="card-input-value" 
                                       @focus="focusInput($event)" 
                                       @blur="blurInput($event)"
                                       value="0" 
                                       :id="'l-input-'+product.product_id" 
                                       type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('l','+',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>

                        <!-- add & remove  -->
                        <div class="card-button-col double-button-col">
                            <!-- remove -->
                            <button v-on:click="addExtraLiters(product,'remove')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="white"/>
                                </svg>
                            </button>
                            <!-- add -->
                            <button v-on:click="addExtraLiters(product,'add')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="white"/>
                                </svg>
                            </button>
                        </div>

                        <!-- setValue & removeValue -->
                        <div class="card-button-col double-button-col">
                            <button v-on:click="removeExtraValue(product,'l')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="close">
                                    <path fill="white"
                                        d="M2.39705176,2.55378835 L2.46966991,2.46966991 C2.73593648,2.20340335 3.15260016,2.1791973 3.44621165,2.39705176 L3.53033009,2.46966991 L8,6.939 L12.4696699,2.46966991 C12.7625631,2.1767767 13.2374369,2.1767767 13.5303301,2.46966991 C13.8232233,2.76256313 13.8232233,3.23743687 13.5303301,3.53033009 L9.061,8 L13.5303301,12.4696699 C13.7965966,12.7359365 13.8208027,13.1526002 13.6029482,13.4462117 L13.5303301,13.5303301 C13.2640635,13.7965966 12.8473998,13.8208027 12.5537883,13.6029482 L12.4696699,13.5303301 L8,9.061 L3.53033009,13.5303301 C3.23743687,13.8232233 2.76256313,13.8232233 2.46966991,13.5303301 C2.1767767,13.2374369 2.1767767,12.7625631 2.46966991,12.4696699 L6.939,8 L2.46966991,3.53033009 C2.20340335,3.26406352 2.1791973,2.84739984 2.39705176,2.55378835 L2.46966991,2.46966991 L2.39705176,2.55378835 Z">
                                    </path>
                                </svg>
                            </button>
                            <button v-on:click="setExtraValue(product,'l')" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        
                    </div>

                </a>
            </div>
        </div>

        <!-- complete button -->
        <div  class="categories-create-edit-container mt-5 bottom-button-container" >
            <button v-on:click="completeStocktaking()" class="category-create-edit__add-button" >
                {{this.translations.Complete_stocktaking}}
            </button>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            var goBackButton = document.getElementById("cancel-stocktaking");
            goBackButton.addEventListener('click', this.cancelStocktaking);
        },

        props: ["stocktaking","products","added_products","translations"],

        data() {
            return {
                page: "products",
                query: "",
                localProduct: this.products,
                localAddedProducts: this.added_products,
                loading:false,
            };
        },

        watch:{
            query: function(newVal){
                this.search();
            }
        },

        methods: {

            focusInput(event) {
                if (event.target.value == '0') {
                    event.target.value = '';
                }
            },

            blurInput(event) {
                if (event.target.value === '') {
                    event.target.value = 0;
                }
            },

            cancelStocktaking(){
                let button = document.getElementById('trigger-modal');
                button.click();
            },

            deleteStocktaking(){
                const filter_url = `/mystocktaking/cancel`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'stocktaking_id': this.stocktaking.id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        //this.localProduct = response.data.products;
                        //this.localAddedProducts = response.data.added_products;

                        if(response.data == "success"){
                            this.$toast.warning(this.translations.You_successfully_canceled_stocktaking);
                            setTimeout(() => {
                                window.location.href = "/mystocktaking";
                            }, 1500);
                        }
                        

                    }).then(response => {}).catch(error => {})
                });
            },

            search(){
                const filter_url = `/mystocktaking/app/search`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'query': this.query,
                        'stocktaking_id':this.stocktaking.id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;

                    }).then(response => {}).catch(error => {})
                });
            },

            //LITERS 
            addLiters(product){
                var liters = document.getElementById('l-input-'+product.id).value;
                if(liters > 0){
                    this.sendLiters(liters,product.id);
                }
            },

            sendLiters(liters,product_id){
                this.loading = true;
                const filter_url = `/mystocktaking/app/add-liters`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product_id,
                        'liters': liters,
                        'stocktaking_id': this.stocktaking.id,
                        'query':this.query,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.loading = false;
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;
                        this.$toast.success(this.translations.liters_success_message);
                        //document.getElementById('q-input-'+product_id).value = 0;
                        //document.getElementById('w-input-'+product_id).value = 0;
                        document.getElementById('l-input-'+product_id).value = 0;
                    }).then(response => {}).catch(error => {})
                });
            },

            addExtraLiters(product,add_or_remove){
                //get liters valie
                var liters = document.getElementById('l-input-'+product.product_id).value;

                if(liters == 0){
                    return 0;
                }

                if(add_or_remove == "remove"){
                    liters = parseInt(liters) * -1;
                }

                //get other data
                var product_stocktaking_id = product.product_stocktaking_id;
                var product_id = product.product_id;    
                
                this.sendExtraLiters(product_id,product_stocktaking_id,liters);
            },

            sendExtraLiters(product_id,product_stocktaking_id,liters){
                this.loading = true;
                const url = `/mystocktaking/app/add-extra-liters`;
                return new Promise(resolve => {
                    window.axios.post(url, {
                        'product_id': product_id,
                        'liters': liters,
                        'stocktaking_id': this.stocktaking.id,
                        'product_stocktaking_id': product_stocktaking_id,
                        'query':this.query,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.loading = false;
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;
                        this.$toast.success(this.translations.liters_success_message);

                        document.getElementById('l-input-'+product_id).value = 0;
                        document.getElementById('q-input-'+product_id).value = 0;
                        document.getElementById('w-input-'+product_id).value = 0;
                    }).then(response => {}).catch(error => {})
                });
            },

            //WEIGHT
            addWeight(product){
                
                //
                var weight = document.getElementById('w-input-'+product.id).value;
                
                if(weight > 0){
                    
                    //weight to grams 
                    var unit = this.stocktaking.unit;
                    
                    //convert weight to grams if stocktaking is in KILOGRAMS
                    if(unit == 'kg'){
                        weight = weight  * 1000;
                    }

                    //alert(weight);
                    if(parseFloat(product.packing_weight) >= parseFloat(weight)){
                        this.$toast.error(this.translations.Packing_weight_is_greater_than_inputed_weight_That_cant_be_possible);
                        return 0;
                    }
                    this.sendWeight(product.id,weight);
                }

            },

            sendWeight(product_id,weight){
                this.loading = true;
                const filter_url = `/mystocktaking/app/add-weight`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product_id,
                        'weight': weight,
                        'stocktaking_id': this.stocktaking.id,
                        'query':this.query,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.loading = false;
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;
                        this.$toast.success(this.translations.added_weight_success_message);
                        document.getElementById('w-input-'+product_id).value = 0;
                        document.getElementById('q-input-'+product_id).value = 0;
                    }).then(response => {}).catch(error => {})
                });
            },

            addExtraWeight(product,add_or_remove){

                var weight = document.getElementById('w-input-'+product.product_id).value;

                if(weight < 0){
                    return 0;
                }
                
                //weight to grams 
                var unit = this.stocktaking.unit;

                if(add_or_remove == "remove"){
                    weight = parseInt(weight) * -1;
                }
                
                //convert weight to grams if stocktaking is in KILOGRAMS
                if(unit == 'kg'){
                    weight = weight  * 1000;
                }

                //alert(weight);
                if(product.weightable == true && parseFloat(product.packing_weight) >= parseFloat(weight) && add_or_remove == 'add'){
                    this.$toast.error(this.translations.Packing_weight_is_greater_than_inputed_weight_That_cant_be_possible);
                    return 0;
                }

                this.sendExtraWeight(product,add_or_remove,weight);
            },

            sendExtraWeight(product,add_or_remove,weight){
                this.loading = true;
                const filter_url = `/mystocktaking/app/add-extra-weight`;
                    return new Promise(resolve => {
                        window.axios.post(filter_url, {
                            'product_id': product.product_id,
                            'weight': weight,
                            'stocktaking': this.stocktaking.id,
                            'product_stocktaking_id': product.product_stocktaking_id,
                            'add_or_remove': add_or_remove,
                            'query':this.query,
                        }, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                            }
                        }).then(response => {
                            this.loading = false;
                            if(response.data == "error"){
                                this.$toast.error("Error occured");
                            } else {
                                this.localProduct = response.data.products;
                                this.localAddedProducts = response.data.added_products;
                                document.getElementById('w-input-'+product.product_id).value = 0;
                                this.$toast.success(this.translations.weight_success_message);
                            }
                        }).then(response => {}).catch(error => {})
                    });
            },

            //PIECES
            addPcs(product_id){
                var pcs = document.getElementById('q-input-'+product_id).value;
                if(pcs > 0){
                    this.sendPcs(pcs,product_id);
                }
            },

            sendPcs(pcs,product_id){
                this.loading = true;
                const filter_url = `/mystocktaking/app/add-pcs`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product_id,
                        'pcs': pcs,
                        'stocktaking_id': this.stocktaking.id,
                        'query':this.query,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.loading = false;
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;

                        this.$toast.success(this.translations.added_quantity_success_message);
                        document.getElementById('q-input-'+product_id).value = 0;
                        document.getElementById('w-input-'+product_id).value = 0;
                        document.getElementById('l-input-'+product_id).value = 0;
                    }).then(response => {}).catch(error => {})
                });
            },

            removeExtraValue(product,enum_value){

                var product_id = product.product_id;

                //pcs
                if(enum_value == "pcs"){
                    var value = product.quantity;
                    value = parseInt(value) * -1;
                    this.sendExtraPcs(product_id,product.product_stocktaking_id,value);
                }

                //grams
                if(enum_value == "g"){
                    var value = product.weight;
                    value = parseInt(value) * -1;
                    this.sendExtraWeight(product,"remove",value);
                }

                //liters
                if(enum_value == "l"){
                    var value = product.liters;
                    value = parseInt(value) * -1;
                    this.sendExtraLiters(product_id,product.product_stocktaking_id,value);
                }
            },

            setExtraValue(product,enum_value){

                //PCS
                if(enum_value == "pcs"){

                    var new_value = 0;    
                    var old_pcs = product.quantity;
                    var pcs = document.getElementById('q-input-'+product.product_id).value;
                    if(pcs <= 0){
                        return 0;
                    }

                    if(old_pcs == pcs){
                        return 0;
                    }

                    //DB value is greater than new input value
                    if(old_pcs > pcs){
                        new_value = old_pcs - pcs;
                        new_value = parseInt(new_value) * -1;
                    }

                    //input value is grater than DB value
                    if(old_pcs < pcs){
                        new_value = pcs - old_pcs
                    }
                    
                    this.sendExtraPcs(product.product_id,product.product_stocktaking_id,new_value);
                }

                if(enum_value == "g"){

                    var weight = document.getElementById('w-input-'+product.product_id).value;
                    var old_value = product.weight;

                    //0
                    if(weight <= 0){
                        return 0;
                    }


                    if(product.weightable == true && parseFloat(product.packing_weight) > parseFloat(weight)){
                        this.$toast.error(this.translations.Packing_weight_is_greater_than_inputed_weight_That_cant_be_possible);
                        return 0;
                    }
                    

                    //DB value is greater than new input value
                    if(old_value > weight){
                        weight = weight - old_value;
                        this.sendExtraWeight(product,"add",weight);
                    } else {
                        weight = weight - old_value;
                        this.sendExtraWeight(product,"add",weight);
                    }

                    return 0;
                }

                //liters
                if(enum_value == "l"){
                    
                    //this value will be SET and sent.
                    var new_value = 0;

                    var old_value = product.liters;
                    var liters = document.getElementById('l-input-'+product.product_id).value;
                    
                    if(liters == old_value || liters <=0){
                        return 0;
                    }

                    //DB value is greater than new input value
                    if(old_value > liters){
                        new_value = old_value - liters;
                        new_value = parseInt(new_value) * -1;
                    }

                    //input value is grater than DB value
                    if(old_value < liters){
                        new_value = liters - old_value
                    }

                    this.sendExtraLiters(product.product_id,product.product_stocktaking_id,new_value);
                    
                }
                
            },


            addExtraPcs(product_stocktaking_id,product_id,add_or_remove){

                var pcs = document.getElementById('q-input-'+product_id).value;

                if(pcs == 0){
                    return 0;
                }

                if(add_or_remove == "remove"){
                    pcs = parseInt(pcs) * -1;
                }
                this.sendExtraPcs(product_id,product_stocktaking_id,pcs);
            },

            sendExtraPcs(product_id,product_stocktaking_id,pcs){
                this.loading = true;
                const filter_url = `/mystocktaking/app/add-extra-pcs`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {

                        'product_id': product_id,
                        'pcs': pcs,
                        'product_stocktaking_id': product_stocktaking_id,
                        'query':this.query,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        this.loading = false;
                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;

                        this.$toast.success(this.translations.quantity_success_message);
                        
                        document.getElementById('q-input-'+product_id).value = 0;
                        document.getElementById('w-input-'+product_id).value = 0;

                        
                        
                    }).then(response => {}).catch(error => {})
                });
            },

            updateInput(prefix, method, product_id) {
                // Get the input element by its id
                let inputElem = document.getElementById(prefix + '-input-' + product_id);
                
                if (method === '+') {
                    inputElem.stepUp();
                } else if (method === '-') {
                    inputElem.stepDown();
                }
            },

            gotoPage(page){
                this.page = page;
            },

            completeStocktaking(){
                window.location.href="/mystocktaking/"+this.stocktaking.id+"/save";
            },

        }
    }
</script>
