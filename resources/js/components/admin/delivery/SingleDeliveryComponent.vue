<template>
    <div class="container">
        <div class="categories-index-container">

            <!-- seach container-->
            <div class="search-bar-container" style="gap:0;">


                <div class="search-bar">
                    <input type="text" name="search" id="search" v-model="query" :placeholder="this.translations.Search_products"/>
                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-bar__icon">
                        <path d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z" fill="currentColor"/>
                    </svg>
                </div>

                <!-- export -->
                <a :href="'/delivery/'+this.delivery.id+'/export'">
                    <button class="search-bar__button" style="margin-left:1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="100" height="100" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                    </button>
                </a>

            </div>

            <!-- item list -->
            <div class="categories-list">
                <!-- header -->
                <div class="list-header mt-3">
                    <span class="p-info">{{this.translations.Product}}</span>
                    <span class="p-info">{{this.translations.Quantity}}</span>
                </div>

                <!-- items -->
                <div v-for="product in products" :key="product.id" class="category stocktaking-row">
                    <!-- stocktakin data-->
                    <div class="category__title-container">                            
                        <!-- location -->
                        <div class="stocktaking-col" style="text-align:left !important;width:fit-content;">
                            <span>{{ product.product_name }}</span>
                        </div>
                        <!-- date -->
                        <div class="stocktaking-col">
                            <span v-if="product.weight != null" class="p-info">{{ product.weight }} g</span>
                            <span v-if="product.quantity != null" class="p-info">{{ product.quantity }} pcs</span>
                            <span v-if="product.liters != null" class="p-info">{{ product.liters }} l</span>
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

        props: ["delivery","products","translations"],

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

        methods: {
                search(){
                const filter_url = `/delivery/single/search`;
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
                        
                        this.products = response.data;
                    }).then(response => {}).catch(error => {})
                });
            },
        }
    }
</script>
