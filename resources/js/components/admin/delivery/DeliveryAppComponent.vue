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
                        <h3 class="p-bold text-center">{{this.translations.Are_you_sure_you_want_to_cancel_delivery}}</h3>
                        <p class="p-regular text-center mt-3">{{ this.translations.This_will_result_deleting_delivery_and_all_data_inside_it }}</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                            <!-- CONFIRM -->
                            <a class="w-50" v-on:click="deleteDelivery()" >
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

        <!-- TOP PAGES -->
        <div v-if="confirmation == true" class="drinks-food-navbar mb-3">
            <div class="drinks-food-navbar__links">
                <a href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoTopPage('needings')"
                    :class="{ 'drinks-food-navbar__link--active': this.topPage === 'needings', }" >
                    {{this.translations.Needing_list}}
                </a>
                <a href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoTopPage('all_products')"
                    :class="{ 'drinks-food-navbar__link--active': this.topPage === 'all_products', }" >
                    {{ this.translations.All_products}}
                </a>
            </div>
        </div>

        <!-- PAGES -->
        <div class="drinks-food-navbar">
            <div class="drinks-food-navbar__links">

                <!-- Needing list -->
                <a v-if="topPage == 'needings' " href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoPage('needing_products')"
                    :class="{ 'drinks-food-navbar__link--active': this.page === 'needing_products', }" >
                    {{this.translations.Needing_products_list}}
                </a>

                <!-- all products -->
                <a v-if="topPage == 'all_products' || confirmation == false" href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoPage('products')"
                    :class="{ 'drinks-food-navbar__link--active': this.page === 'products', }" >
                    {{this.translations.Products}}
                </a>

                <!-- Added products -->
                <a href="#" class="drinks-food-navbar__link"
                    v-on:click="gotoPage('added_products')"
                    :class="{ 'drinks-food-navbar__link--active': this.page === 'added_products', }" >
                    {{this.translations.Added_products}}
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="drinks-food-index-container">

            <!-- search -->
            <div class="search-bar-container-weekly" style="gap:0px;">
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
            </div>

            <!-- NEEDING LIST -->
            <div v-if="topPage == 'needings' && page == 'needing_products'" class="drinks-food-list mt-3">
                
                
                <a v-for="product in localNeedings" class="drinks-food-list__item --drink-item stocktaking-card">
                    <div class="header">
                        {{product.name}}
                    </div>

                    <!-- insert COUNT -->
                    <div class="card-input-row mt-2">

                        <!-- inputs -->
                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('needing','-',product.product_id)">
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
                                        :value="getProductValue(product)" 
                                        :id="'needing-input-'+product.product_id" 
                                        type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('needing','+',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 13V19H11V13H5V11H11V5H13V11H19V13H13Z" fill="#0E0E0E"/>
                                </svg>
                            </button>
                        </div>


                        <!-- CONFIRM -->
                        <div class="card-button-col">
                            <button v-on:click="addNeedingValue(product)" class="submit-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 12L10 18L20 6" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </a>
                
            </div>

            <!-- PRODUCTS -->
            <div v-if="page == 'products' && topPage == 'all_products'" class="drinks-food-list mt-3">
                <a v-for="product in localProduct" class="drinks-food-list__item --drink-item stocktaking-card">
                    <div class="header">
                        {{ product.name }}
                    </div>

                    <!-- INPUTS -->
                    <div class="card-input-row mt-2">

                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('product','-',product.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- CARD -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">
                                    <span v-if="checkProductEnum(product) == 'l'">{{translations.Liters}}</span>
                                    <span v-if="checkProductEnum(product) == 'pcs'">{{translations.Pieces}}</span>
                                    <span v-if="checkProductEnum(product) == 'g'" >{{translations.Grams}}</span>                               
                                </p>

                                <!-- input field -->
                                <input class="card-input-value" 
                                    :value="0" 
                                    :id="'product-input-'+product.id" 
                                    type="number"
                                    @focus="focusInput($event)" 
                                    @blur="blurInput($event)"
                                    min="0">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('product','+',product.id)">
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
            </div>

            <!-- ADDDED products -->
            <div v-if="page == 'added_products'" class="drinks-food-list mt-3">
                <!-- loop delivery_products -->
                <a v-for="product in localAddedProducts" class="drinks-food-list__item --drink-item stocktaking-card">

                    <div class="header">
                        {{ product.name }} - 
                        <span v-if="checkProductEnum(product) == 'l'">{{product.liters}} l</span>
                        <span v-if="checkProductEnum(product) == 'pcs'">{{product.quantity}} {{translations.Pieces}}</span>
                        <span v-if="checkProductEnum(product) == 'g'" >{{product.weight}} g</span>
                    </div>

                    <!-- send value -->
                    <div class="card-input-row mt-2" style="align-items:center;">

                        <div class="card-input-col">

                            <!-- (-) BUTTON -->
                            <button class="minus-button" v-on:click="updateInput('added-product','-',product.product_id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 11H19V13H5V11Z" fill="#0E0E0E"/>
                                </svg>
                            </button>

                            <!-- INPUT -->
                            <div class="input-wrapper">
                                <p class="input-disclaimer">
                                    <span v-if="checkProductEnum(product) == 'l'">{{translations.Liters}}</span>
                                    <span v-if="checkProductEnum(product) == 'pcs'">{{translations.Pieces}}</span>
                                    <span v-if="checkProductEnum(product) == 'g'" >{{translations.Grams}}</span>
                                </p>
                                
                                <input  class="card-input-value" :value="0" 
                                        :id="'added-product-input-'+product.product_id" 
                                        @focus="focusInput($event)" 
                                        @blur="blurInput($event)"
                                        min="0"
                                        type="number">
                            </div>

                            <!-- (+) BUTTON -->
                            <button class="plus-button" v-on:click="updateInput('added-product','+',product.product_id)">
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
                            <button v-on:click="addExtraValue(product,'add')" class="submit-button">
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
                    </div>
                </a>
            </div>

            <h3  v-if="page == 'added_products' && this.localAddedProducts.length == 0" class="p-bold mt-5 text-center w-100">
                {{ translations.No_added_products }}
            </h3>
        </div>

        <!-- complete button -->
        <div  class="categories-create-edit-container mt-5 bottom-button-container" >
            <button v-on:click="completeDelivery()" class="category-create-edit__add-button" >
                {{ this.translations.Save_delivery }}
            </button>
        </div>

    </div>
</template>

<script>
    export default {

        beforeMount(){
            if(this.delivery.needing_id != null){
                this.confirmation = true;
                this.topPage = "needings"
                this.page = "needing_products";
            }
            
            if(this.delivery.needing_id == null){

                this.confirmation = false;
                this.topPage = "all_products"
                this.page = "products";
            }
        },

        mounted() {
            //alert("produkti");
            console.log(this.products);
            var goBackButton = document.getElementById("cancel-stocktaking");
            goBackButton.addEventListener('click', this.cancelDelivery);

        },

        props: ["products","translations","delivery","added_products","needings"],

        data() {
            return {

                confirmation:false,

                page: "products",
                topPage:"",
                query: null,
                localProduct: this.products,
                localAddedProducts: this.added_products,
                localNeedings: this.needings,
                loading:false,
            };
        },

        watch:{
            query: function(newVal){
                this.search();
            }
        },

        methods: {

            setExtraValue(product){
                //get new value
                var new_value = document.getElementById('added-product-input-'+product.product_id).value;

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

            //ADD EXTRA VALUE
            addExtraValue(product,add_or_remove){
                var value = document.getElementById('added-product-input-'+product.product_id).value;
                if(value <= 0 ){
                    return 0;
                }
                var needing_enum = this.checkProductEnum(product);

                this.sendExtraValue(product,value,needing_enum,add_or_remove)
            },

            sendExtraValue(product,value,product_enum,add_or_remove){
            this.loading = true;
                
                const filter_url = `/delivery/app/send-extra-value`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {

                        'product_id': product.product_id,
                        'value': value,
                        'enum':product_enum,
                        'delivery_id': this.delivery.id,
                        'add_or_remove':add_or_remove,
                        'delivery_product_id':product.delivery_product_id,
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
                        this.localNeedings = response.data.needings;
                        this.$toast.success(this.translations.You_successfully_updated_delivery_list);
                    }).then(response => {}).catch(error => {})
                });
            },

            //ADD from NEEDING
            addNeedingValue(product){
                var value = document.getElementById('needing-input-'+product.product_id).value;
                if(value < 0){
                    return 0;
                }
                var enum_temp = this.checkProductEnum(product);
                this.sendValue(product.product_id,value,enum_temp);
            },

            //ADD VALUE
            addValue(product){
                var get_value = document.getElementById('product-input-'+product.id).value;
                var enum_value = this.checkProductEnum(product);
                if(0 >= get_value){
                    return 0;
                }

                this.sendValue(product.id,get_value,enum_value)
            },

            sendValue(product_id,value,enum_value){
                this.loading = true;
                const filter_url = `/delivery/app/send-value`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {

                        'product_id': product_id,
                        'value': value,
                        'enum':enum_value,
                        'delivery_id': this.delivery.id,
                        'query':this.query
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
                        this.localNeedings = response.data.needings;

                        this.$toast.success(this.translations.You_successfully_added_product_data_to_delivery_list_You_can_update_this_under_the_added_products_tab);

                    }).then(response => {}).catch(error => {})
                });
            },


            cancelDelivery(){
                let button = document.getElementById('trigger-modal');
                button.click();
            },

            deleteDelivery(){
                const filter_url = `/delivery/delete`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'delivery_id':this.delivery.id
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {

                        if(response.data == "success"){
                        this.$toast.warning(this.translations.You_successfully_canceled_delivery);
                        setTimeout(() => {

                            if(this.delivery.needing_id != null){
                                window.location.href = "/needing";
                            } else {
                                window.location.href = "/delivery";
                            }

                            
                        }, 1500);
                    }

                    }).then(response => {}).catch(error => {})
                });
            },


            gotoTopPage(page){
                
                if(page == "all_products"){
                    this.page = "products";
                }

                if(page == "needings"){
                    this.page = "needing_products";
                }

                this.topPage = page;
            },

            gotoPage(page){
                this.page = page;
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

            getProductValue(product){
                let enum_temp = this.checkProductEnum(product);
                if(enum_temp == "pcs"){
                    return product.quantity;
                }

                if(enum_temp == "l"){
                    return product.liters;
                }

                if(enum_temp == "g"){
                    return product.weight;
                }
            },

            search(){
                const filter_url = `/delivery/app/search`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'query': this.query,
                        'delivery_id':this.delivery.id
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {

                        this.localProduct = response.data.products;
                        this.localAddedProducts = response.data.added_products;
                        this.localNeedings = response.data.needings;

                    }).then(response => {}).catch(error => {})
                });
            },

            completeDelivery(){
                const filter_url = `/delivery/app/complete`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'delivery_id': this.delivery.id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        
                        if(response.data == 'success'){
                            window.location.href="/delivery";
                        }
                        
                    }).then(response => {}).catch(error => {})
                });

            },
            
            addExtraWeight(delivery_product_id,product_id){
                this.loading = true;

                var weight = document.getElementById('w-input-'+product_id).value;

                const filter_url = `/delivery/app/add-extra-weight`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'product_id': product_id,
                        'weight': weight,
                        'delivery_id': this.delivery.id,
                        'delivery_product_id': delivery_product_id,
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
                        
                        document.getElementById('w-input-'+product_id).value = 0;
                        
                    }).then(response => {}).catch(error => {})
                });
                

            },

            addExtraPcs(delivery_product_id,product_id){
                this.loading = true;

                var pcs = document.getElementById('q-input-'+product_id).value;

                
                    const filter_url = `/delivery/app/add-extra-pcs`;
                    return new Promise(resolve => {
                        window.axios.post(filter_url, {

                            'product_id': product_id,
                            'pcs': pcs,
                            'delivery_product_id': delivery_product_id,
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

        }

    }
</script>
