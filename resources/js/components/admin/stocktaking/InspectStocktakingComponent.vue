<template>
    <div class="container">
        <div class="categories-index-container">

        <!-- modal -->
        <div class="modal fade warning-popup" id="confirm-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header close -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="p-bold">{{this.translations.Are_you_sure_you_want_to_delete_this_stocktaking}}</h3>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                            <button class="save-button" type="button" data-bs-dismiss="modal">
                                {{this.translations.No}}
                            </button>

                            <!-- YES -->
                            <a class="w-100" :href="'/stocktaking/delete/'+this.stocktaking.id">
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    {{this.translations.Yes}}
                                </button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOP NAVBAR -> search and create -->
        <div class="search-bar-container-weekly">

            <div class="search-bar">
                <input type="text" name="search" id="search" :placeholder="this.translations.Search_products" v-model="query"/>
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-bar__icon">
                    <path d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z" fill="currentColor" />
                </svg>
            </div>

            <!-- export button -->
            <div>
                <a :href="'/stocktaking/export/'+this.stocktaking.id">
                    <button class="search-bar__button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="100" height="100" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                    </button>
                </a>
            </div>

            <!-- compare button -->
            <div>
                <a :href="'/stocktaking/'+this.stocktaking.id+'/single/compare'">
                    <button class="search-bar__button">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1411 0.210938L14.0851 1.29019L17.2973 4.50019H1.50007V6.00019H17.2973L14.0858 9.21094L15.1411 10.2894L20.1788 5.25019L15.1411 0.210938ZM5.85982 10.7109L0.819824 15.7502L5.85982 20.7894L6.91432 19.7109L3.70357 16.5002H19.5001V15.0002H3.70282L6.91432 11.7894L5.85982 10.7109Z" fill="#F9F9F9"/>
                            </svg>
                    </button>
                </a>
            </div>

            <!-- delete button -->
            <div class="d-none">
                <a  data-bs-toggle="modal" data-bs-target="#confirm-modal">
                    <button class="search-bar__button danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M12.1569 10.7427L7.91421 6.50008L12.1569 2.25744L10.7426 0.843227L6.5 5.08587L2.25736 0.843227L0.843146 2.25744L5.08579 6.50008L0.843146 10.7427L2.25736 12.1569L6.5 7.91429L10.7426 12.1569L12.1569 10.7427Z" fill="#F9F9F9"/>
                        </svg>
                    </button>
                </a>
            </div>

        </div>

        <!-- item list -->
        <div class="categories-list">
            <!-- header -->
            <div class="list-header mt-3 w-100 stocktaking-heading">
                <span class="p-info info-name">{{this.translations.Product}}</span>
                <span class="p-info">{{this.translations.Pieces}}</span>
                <span class="p-info">{{this.translations.Weighted}}</span>
                <span class="p-info">{{this.translations.Stock}}</span>
                <span class="p-info">{{this.translations.Price}}</span>
            </div>

            <!-- items -->
            <div v-for="product in products" :key="product.id" class="category stocktaking-row">

                <!-- stocktakin data-->
                <div class="category__title-container">
                    
                    
                    
                    <!-- location -->
                    <div class="stocktaking-col col-name">
                        <span>{{product.name}}</span>
                    </div>

                    <!-- pieces -->
                    <div class="stocktaking-col">
                        <span class="p-info" style="margin-left:-20px;">{{ product.quantity }}</span>
                    </div>

                    <!-- weighted -->
                    <div class="stocktaking-col">

                        <span v-if="product.weight != null" class="p-info">
                            <span v-if="product.enum == 'g'" > {{ product.weight }} g </span>
                            <span v-if="product.enum == 'l'"> {{  Math.floor(convertGramsToLiters(product.weight) * 10) / 10   }}l </span>                            
                        </span>

                        <span v-if="product.liters != null" class="p-info">
                            {{ product.liters }} l
                        </span>
                    </div>


                    <!-- STOCK -->
                    <div class="stocktaking-col">
                        <!-- KOS -->
                        <span v-if="product.enum == 'pcs'" class="p-info">
                            {{ product.quantity }} {{translations.Pieces}}
                        </span>
                        
                        <!-- LITER -->
                        <span v-if="product.enum == 'l'" class="p-info">
                            {{ getLiters(product)}} l
                        </span>

                        <!-- GRAMS -->
                        <span v-if="product.enum == 'g'" class="p-info">
                            {{ product.weight }} g
                        </span>
                    </div>

                    <div class="stocktaking-col">
                        <span v-if="product.price != null" class="p-info">
                            {{getStocktakingProductPrice(product)}}€
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
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                query: null,
            };
        },

        watch:{
            query: function(newVal){
                this.search();
            }
        },

        props: ["stocktaking","products","translations"],

        methods:{

            search(){
                const filter_url = `/stocktaking/single/search`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'query': this.query,
                        'stocktaking_id': this.stocktaking.id,
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

            convertGramsToLiters(product_weight) {
                const density = 930;  // Density in kg/m^3. This is an approximation!
                
                var weight = parseFloat(product_weight);
                
                var liters = (weight / density);
                
                return liters;
            },

            getLiters(product){
                var result = 0;

                if(product.quantity != null){
                    var chunk = product.quantity * parseFloat(product.packing_size);

                    result = result + chunk;
                }

                              
                if(product.weight != null){
                    var weighted_liters = this.convertGramsToLiters(product.weight);
                    result = result + weighted_liters;
                }

                if(product.liters != null){
                    result = parseFloat(result) + parseFloat(product.liters);
                }

                return Math.floor(result * 10) / 10;
            },

            getStocktakingProductPrice(product){

                var price = 0;

                // pieces
                if(product.enum == "pcs"){
                    price = product.quantity * product.price;
                }

                // liters
                if(product.enum == "l"){
                    //quantity
                    if(product.quantity != null){
                        price = product.quantity * product.price;
                    }
                    //resto
                    if(product.weight != null){
                        var resto = this.getRestoPrice(product);
                        var resto_price = resto * product.price;
                        price += resto_price;
                    }
                }


                //grams
                if(product.enum == "g"){
                    //quantity
                    if(product.quantity != null){
                        price = product.quantity * product.price;
                    }
                    //weighted
                    if(product.weight != null){
                        var weight_price = this.getGramsPrice(product);
                        price = price + weight_price;
                    }
                }

                

                return Number(parseFloat(price).toFixed(2));
                
            },


            getRestoPrice(product){
                var resto = this.convertGramsToLiters(product.weight);
                var full_size = product.packing_size;
                return (resto / full_size);
            },

            getGramsPrice(product){
                var test = product.weight / product.packing_size;
                var price = test * product.price;
                return price;
            }



        }
    }
</script>
