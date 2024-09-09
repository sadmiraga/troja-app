<template>
    <div>

        <!-- LOADING -->
        <div v-if="loading == true" class="loading-overlay">
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
                        <h3 class="p-bold text-center">{{this.translations.Are_you_sure_you_want_to_cancel_creation_of_needing_list}}</h3>
                        <p class="p-regular text-center mt-3">{{ this.translations.This_will_result_deleting_needing_list_and_all_data_inside_it }}</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                            <!-- CONFIRM -->
                            <a class="w-50" v-on:click="deleteNeeding()" >
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
                    {{this.translations.Needing_list}}
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

            <!-- products -->
            <div class="drinks-food-list mt-3">

                <!-- PRODUCTS -->
                <a v-if="page == 'products'" v-for="product in localProduct" class="drinks-food-list__item --drink-item stocktaking-card">
                    <div class="header">
                        {{product.name}}
                    </div>

                    <!-- insert COUNT -->
                    <div class="card-input-row mt-2">

                        <!-- inputs -->
                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('v','-',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">

                                <!-- product enum condition -->
                                <p class="input-disclaimer"> 
                                    <span v-if="checkProductEnum(product) == 'l'">{{translations.Liters}}</span>
                                    <span v-if="checkProductEnum(product) == 'pcs'">{{translations.Pieces}}</span>
                                    <span v-if="checkProductEnum(product) == 'g'" >{{translations.Grams}}</span>
                                </p>
                                <input min="0" class="card-input-value" 
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)"
                                        value="0" 
                                        :id="'v-input-'+product.id" 
                                        type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('v','+',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>

                        <!-- CONFIRM -->
                        <div class="card-button-col">
                            <button v-on:click="addValue(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </a>

                <!-- NEEDING LIST  -->
                <a v-if="page == 'added_products'" v-for="product in localAddedProducts" class="drinks-food-list__item --drink-item stocktaking-card">
                    <div class="header">
                        {{product.name}}
                        -
                        <span v-if="checkProductEnum(product) == 'l'">{{product.liters}} l</span>
                        <span v-if="checkProductEnum(product) == 'pcs'">{{product.quantity}} {{translations.Pieces}}</span>
                        <span v-if="checkProductEnum(product) == 'g'" >{{product.weight}} g</span>
                    </div>

                    <!-- need LIST of products. -->
                    <div class="card-input-row mt-2" style="align-items: center;" >

                        <!-- inputs -->
                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('ev','-',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">

                                <!-- product enum condition -->
                                <p class="input-disclaimer"> 
                                    <span v-if="checkProductEnum(product) == 'l'">{{translations.Liters}}</span>
                                    <span v-if="checkProductEnum(product) == 'pcs'">{{translations.Pieces}}</span>
                                    <span v-if="checkProductEnum(product) == 'g'" >{{translations.Grams}}</span>
                                </p>
                                <input min="0" class="card-input-value" 
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)"
                                        value="0" 
                                        :id="'ev-input-'+product.product_id" 
                                        type="number">
                            </div>
                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('ev','+',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- add & remove -->
                        <div class="card-button-col double-button-col">
                            <!-- remove -->
                            <button v-on:click="addExtraValue(product,'remove')" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="white"/>
                                </svg>
                            </button>
                            <!-- add -->
                            <button v-on:click="addExtraValue(product,'add')" class="submit-button" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="white"/>
                                </svg>
                            </button>
                        </div>

                        <!-- setValue & removeValue -->
                        <div class="card-button-col double-button-col">
                            <button v-on:click="removeExtraValue(product)" class="submit-button" style="margin-bottom:1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" id="close">
                                    <path fill="white"
                                        d="M2.39705176,2.55378835 L2.46966991,2.46966991 C2.73593648,2.20340335 3.15260016,2.1791973 3.44621165,2.39705176 L3.53033009,2.46966991 L8,6.939 L12.4696699,2.46966991 C12.7625631,2.1767767 13.2374369,2.1767767 13.5303301,2.46966991 C13.8232233,2.76256313 13.8232233,3.23743687 13.5303301,3.53033009 L9.061,8 L13.5303301,12.4696699 C13.7965966,12.7359365 13.8208027,13.1526002 13.6029482,13.4462117 L13.5303301,13.5303301 C13.2640635,13.7965966 12.8473998,13.8208027 12.5537883,13.6029482 L12.4696699,13.5303301 L8,9.061 L3.53033009,13.5303301 C3.23743687,13.8232233 2.76256313,13.8232233 2.46966991,13.5303301 C2.1767767,13.2374369 2.1767767,12.7625631 2.46966991,12.4696699 L6.939,8 L2.46966991,3.53033009 C2.20340335,3.26406352 2.1791973,2.84739984 2.39705176,2.55378835 L2.46966991,2.46966991 L2.39705176,2.55378835 Z">
                                    </path>
                                </svg>
                            </button>
                            <button v-on:click="setExtraValue(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                        <!-- CONFIRM -->
                        <!--
                        <div class="card-button-col">
                            <button v-on:click="addExtraValue(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        -->

                    </div>

                </a>


            </div>
            
        </div>

        <!-- complete button -->
        <div  class="categories-create-edit-container mt-5 bottom-button-container" >
            <button v-on:click="completeNeedingList()" class="category-create-edit__add-button" >
                {{this.translations.Save_Needing_list}}
            </button>
        </div>

    </div>
</template>

<script>
    export default {

        mounted() {
            var goBackButton = document.getElementById("cancel-needing");
            goBackButton.addEventListener('click', this.cancelNeeding);

            console.log(this.localAddedProducts);
        },

        props: ["products","added_products","translations","location","needing"],

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

        methods:{

            setExtraValue(product){
                //get new value
                var new_value = document.getElementById('ev-input-'+product.product_id).value;

                if(new_value <= 0){
                    return 0;
                }
                //get database value
                var needing_enum = this.checkProductEnum(product);
                var value = null;
                if(needing_enum == 'l'){
                    value = product.liters;
                }
                if(needing_enum == 'pcs'){
                    value = product.quantity;
                }
                if(needing_enum == 'g'){
                    value = product.weight;
                }

                //set add or remove.
                var add_or_remove = null;
                // old 20   - new 500 
                if(new_value < value){  
                    add_or_remove = "add";
                    new_value = new_value - value;
                }
                if(new_value > value){
                    add_or_remove = "remove";
                    new_value =  value - new_value;
                }
                this.sendExtraValue(product,new_value,needing_enum,add_or_remove);
            },

            removeExtraValue(product){
                var needing_enum = this.checkProductEnum(product);
                var value = null;
                if(needing_enum == 'l'){
                    value = product.liters;
                }
                if(needing_enum == 'pcs'){
                    value = product.quantity;
                }
                if(needing_enum == 'g'){
                    value = product.weight;
                }
                this.sendExtraValue(product,value,needing_enum,"remove");
            },

            completeNeedingList(){
                const filter_url = `/needing/app/complete`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'needing_id': this.needing.id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        
                        if(response.data == "success"){
                            this.$toast.success(this.translations.You_successfully_saved_needing_list);
                            setTimeout(() => {
                                window.location.href = "/needing";
                            }, 1500);
                        }
                        
                    }).then(response => {}).catch(error => {})
                });
            },

            checkProductEnum(product){
                if(product.enum == 'l' && product.packing_size == null){
                    return 'l';
                }

                if( product.enum == 'pcs' || (product.enum == 'l' && product.packing_size != null & product.packing_size != 0) ){
                    return 'pcs';
                }

                if(product.enum == 'g'){
                    return 'g';
                }
            },

            cancelNeeding(){
                let button = document.getElementById('trigger-modal');
                button.click();
            },

            deleteNeeding(){
                const filter_url = `/needing/cancel`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'needing_id': this.needing.id,
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
                            this.$toast.warning(this.translations.You_successfully_canceled_needing);
                            setTimeout(() => {
                                window.location.href = "/needing";
                            }, 1500);
                        }

                        if(response.data == "error"){
                            this.$toast.warning(this.translations.Error_occured);
                        }
                        

                    }).then(response => {}).catch(error => {})
                });
            },

            gotoPage(page){
                this.page = page;
            },

            search(){
                const filter_url = `/needing/app/search`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'query': this.query,
                        'needing_id':this.needing.id,
                        'storage':this.needing.storage
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {

                        console.log(response.data.products);

                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;

                    }).then(response => {}).catch(error => {})
                });
            },

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

            updateInput(prefix, method, product_id) {
                // Get the input element by its id
                let inputElem = document.getElementById(prefix + '-input-' + product_id);
                
                if (method === '+') {
                    inputElem.stepUp();
                } else if (method === '-') {
                    inputElem.stepDown();
                }
            },

            addValue(product){
                var value = document.getElementById('v-input-'+product.id).value;
                if(value < 0){
                    return 0;
                }
                var needing_enum = this.checkProductEnum(product);
                this.sendValue(product.id,value,needing_enum);
            },

            sendValue(product_id,value,needing_enum){
                this.loading = true;
                const filter_url = `/needing/app/add-value`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product_id,
                        'value': value,
                        'needing_enum': needing_enum,
                        'needing_id': this.needing.id,
                        'query': this.query
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
                        this.$toast.success(this.translations.You_successfully_added_products_value_to_needing_list_You_can_update_it_under_needing_list_tab);
                        document.getElementById('v-input-'+product_id).value = 0;
                    }).then(response => {}).catch(error => {})
                });
            },

            addExtraValue(product,add_or_remove){
                
                var value = document.getElementById('ev-input-'+product.product_id).value;

                if(value < 0 ){
                    return 0;
                }

                var needing_enum = this.checkProductEnum(product);
              
                this.sendExtraValue(product,value,needing_enum,add_or_remove);
                
            },

            sendExtraValue(product,value,needing_enum,add_or_remove){
                //app/add-extra-value
                this.loading = true;
                const filter_url = `/needing/app/add-extra-value`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product.product_id,
                        'value': value,
                        'needing_enum': needing_enum,
                        'needing_id': this.needing.id,
                        'query': this.query,
                        'product_needing_id':product.product_needing_id,
                        'add_or_remove':add_or_remove
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
                        this.$toast.success(this.translations.You_successfully_updated_needing_list);
                        document.getElementById('ev-input-'+product.product_id).value = 0;

                    }).then(response => {}).catch(error => {})
                });
            },


        }
    }
</script>
