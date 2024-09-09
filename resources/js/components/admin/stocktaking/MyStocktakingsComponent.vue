<template>
    <div class="container">
        <div class="categories-index-container">

            <!-- POPUP MESSAGE -->
            <div :class="{ 'popup-message': true, 'active': showPopupMessage }" class="error-popup">
                <div class="popup-content">
                    <span>{{ message }}</span>
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
                            <h3 class="p-bold">
                                {{ this.translations.Are_you_sure_you_want_to_update_this_stocktaking }}
                            </h3>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                                <button class="save-button" type="button" data-bs-dismiss="modal">
                                    {{this.translations.No}}
                                </button>

                                <!-- YES -->
                                <a class="w-100" :href="'mystocktaking/'+stocktaking_id+'/update'">
                                    <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                        {{this.translations.Yes}}
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

            <!-- buttons container-->
            <div class="search-bar-container fullwidth-button-container">

                <!-- Start new stocktaking -->
                <div v-if="this.open_stocktaking_id == 0" class="w-100">
                    <a href="/mystocktaking/create" class="search-bar__button">
                            {{this.translations.Start_new_stocktaking}}
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
                    </a>
                </div>

                <!-- complete EXISTING stocktaking -->
                <div v-if="this.open_stocktaking_id != 0" class="w-100">
                    <a :href="'/mystocktaking/'+this.open_stocktaking_id+'/app'" class="search-bar__button">
                        {{this.translations.Click_here_to_continue_unfinished_stocktaking}}
                    </a>
                </div>

            </div>

            <!-- item list -->
            <div class="categories-list">
                <!-- header -->
                <div class="list-header mt-3 stocktaking-heading">
                    <span class="p-info w-60" style="text-align:left !important;">{{this.translations.Location}}</span>
                    <span class="p-info" style="margin-left:-4rem;">{{this.translations.Time}}</span>
                    <span class="p-info">{{this.translations.Date}}</span>
                </div>

                <!-- items -->
                <div v-for="stocktaking in stocktakings" 
                    :key="stocktaking.id"
                    v-on:click="update(stocktaking)"
                    class="category stocktaking-row"
                    :class="{ 
                        'stocktaking-row-pasive': stocktaking.completed != true && (Date.now() - new Date(stocktaking.end).getTime() >= 4 * 60 * 60 * 1000) 
                    }">

                    <!-- stocktakin data-->
                    <div class="category__title-container">                            
                        <!-- location -->
                        <div class="stocktaking-col w-60" style="text-align:left !important;">
                            {{ stocktaking.location_name }}
                        </div>
                        <!-- time -->
                        <div class="stocktaking-col">
                            {{ formatTimeOnly(stocktaking.start) }} - {{ stocktaking.end ? formatTimeOnly(stocktaking.end) : null }}
                        </div>
                        <!-- date -->
                        <div class="stocktaking-col">
                            {{ formatDateOnly(stocktaking.start) }}
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
            console.log('Component mounted.');
            console.log(this.stocktakings);
        },

        props: ["stocktakings","translations","open_stocktaking_id"],

        data() {
            return {
                query: null,
                loading: false,
                stocktaking_id:null,
                showModal: false,
                showPopupMessage: false,
                message: 'message value'
            };
        },

        methods: {

            update(stocktaking) {

                if(stocktaking.completed == true && (Date.now() - new Date(stocktaking.end).getTime() <= 8 * 60 * 60 * 1000) && this.open_stocktaking_id == 0){
                    //trigger modal here
                    this.openModalViaButton();
                    this.stocktaking_id = stocktaking.id;
                } else {
                    this.message = this.translations.You_cant_edit_this_stocktaking;
                    this.showPopupMessage = true;
                }
                setTimeout(this.closePopupMessage, 2500); // Close the popup after 3 seconds
            },

            openModalViaButton() {
                let button = document.getElementById('trigger-modal');
                button.click();
            },

            closePopupMessage() {
                this.showPopupMessage = false;
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
