<template>
    <div class="container">
        <div class="categories-index-container">

            <!-- POPUP MESSAGE -->
            <div :class="{ 'popup-message': true, 'active': showPopupMessage }" class="error-popup">
                <div class="popup-content">
                    <span>{{ message }}</span>
                </div>
            </div>

            <!-- seach container-->
            <div class="search-bar-container" style="gap:0;">
                <div class="search-bar">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        v-model="query"
                        :placeholder="this.translations.Search_stocktaking"
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
    
            <!-- CONTENT -->
            <div class="categories-list">
    
                <!-- header -->
                <div class="list-header mt-3 stocktaking-heading">
                    <span class="p-info" style="text-align:left !important;">{{this.translations.Employee}}</span>
                    <span class="p-info" style="margin-left:15px;">{{this.translations.Location}}</span>
                    <span class="p-info">{{this.translations.Date}}</span>
                    <span class="p-info" >{{this.translations.Time}}</span>
                    <span class="p-info"></span>
                </div>
    
                <!-- items -->
                <a v-for="stocktaking in stocktakings" :key="stocktaking.id" v-on:click="single(stocktaking)"    class="category stocktaking-row" style="padding-right:15px;text-decoration:none;">
                    <!-- stocktakin data-->
                    <div class="category__title-container">                            
    
                        <div class="stocktaking-col" style="text-align:left !important;width:25%;">
                            {{stocktaking.user_name}}
                        </div>
    
                        <div class="stocktaking-col">
                            {{stocktaking.location_name}}
                        </div>
    
                        <div class="stocktaking-col">
                            {{formatDateOnly(stocktaking.start)}}
                        </div>
    
                        <!-- date -->
                        <div class="stocktaking-col">
                            {{formatTimeOnly(stocktaking.start)}} - <span v-if="stocktaking.completed == true"> {{formatTimeOnly(stocktaking.end)}}</span>
                        </div>

                        <!-- date -->
                        <div class="stocktaking-col">

                            <!-- completed -->
                            <svg v-if="stocktaking.completed == true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M4 12L10 18L20 6" stroke="#1C6979" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <svg v-if="stocktaking.completed == false" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 13.4143L7.75736 17.6569L6.34315 16.2427L10.5858 12.0001L6.34315 7.75744L7.75736 6.34323L12 10.5859L16.2426 6.34323L17.6569 7.75744L13.4142 12.0001L17.6569 16.2427L16.2426 17.6569L12 13.4143Z" fill="#0E0E0E"/>
                            </svg>
                        </div>
                    </div>
                </a>
    
            </div>
    
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            console.log(this.stocktakings);        
        },
        
        props: ["stocktakings","translations"],

        data() {
            return {
                query: null,
                showPopupMessage: false,
                message: 'message value'
            };
        },

        watch:{
            query: function(newVal){
                this.search();
            }
        },

        methods: {

            single(stocktaking){
                
                if(stocktaking.completed){
                    window.location.href= "stocktaking/"+stocktaking.id+"/single";
                }else{

                    this.message = this.translations.You_cant_inspect_this_stocktaking;
                    this.showPopupMessage = true;
                    setTimeout(this.closePopupMessage, 2000);
                }

            },

            closePopupMessage() {
                this.showPopupMessage = false;
            },

            search(){
                const filter_url = `/stocktaking/search`;
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
                        
                        this.stocktakings = response.data;

                    }).then(response => {}).catch(error => {})
                });
            },

            formatDateOnly(timestamp) {
                timestamp = timestamp.replace(' ', 'T'); // Fix for Safari
                let date = new Date(timestamp);
                let day = date.getDate().toString().padStart(2, '0');
                let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-indexed in JavaScript
                let year = date.getFullYear();
                return `${day}.${month}.${year}`;
            },

            formatTimeOnly(timestamp) {
                timestamp = timestamp.replace(' ', 'T'); // Fix for Safari
                let date = new Date(timestamp);
                let hours = date.getHours().toString().padStart(2, '0');
                let minutes = date.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }
        }
    }
</script>
