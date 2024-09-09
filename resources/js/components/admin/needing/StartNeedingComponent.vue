<template>
    <div class="container">
        <div class="container categories-create-edit-container" style="grid-template-rows:auto;">

            <div class="public-events-index-container">

                <div class="public-events-list">
                    <!-- BAR -->
                    <a href="#" v-on:click="changeStorage('bar')" v-bind:class="{ 'card-button-hover': barHoverClass }" class="public-events-list__item card-button">
                        <!-- ICON -->
                        <div class="card-body">
                            <h1 class="h3-secondary">{{this.translations.Bar}}</h1>
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

                    <!-- RESTAURANT -->
                    <a href="#" v-on:click="changeStorage('restaurant')" v-bind:class="{ 'card-button-hover': restaurantHoverClass }" class="public-events-list__item card-button">
                        <!-- ICON -->
                        <div class="card-body">
                            <h1 class="h3-secondary">{{this.translations.Restaurant}}</h1>
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

            <button v-if="storage != null"  class="category-create-edit__add-button" v-on:click="create()">
                {{this.translations.Create_needing_list}}
            </button>

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        props: ["translations"],

        data() {
            return {
                storage: null,
                barHoverClass:false,
                restaurantHoverClass:false
            };
        },

        methods:{

            create(){
                const filter_url = `/needing/start/create`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'storage': this.storage,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        
                        window.location.href="/needing/"+response.data.id+"/app";
                        
                        
                    }).then(response => {}).catch(error => {})
                });
            },

            changeStorage(value){
                this.storage = value;

                if(value == "bar"){
                    this.barHoverClass = true;
                    this.restaurantHoverClass=false;
                }

                if(value == "restaurant"){
                    this.barHoverClass = false;
                    this.restaurantHoverClass=true;
                }

                
            }
        }
    }
</script>
