<template>
    <div class="container">
        <div class="container categories-create-edit-container" style="grid-template-rows:auto;">

            <div class="public-events-index-container">

                <div v-if="needing_id == null" class="public-events-list">
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

                <div v-if="needing_id != null" class="public-events-list">
                    <h1 class="h3-secondary">
                        {{ this.translations.Needing_list_shipping_confirmation }}<br><br>
                        {{ this.translations.Storage_is_already_choosen_inside_needing_list }} <br><br>
                        {{ this.translations.Storage_for_this_delivery_is }}: {{ this.storage }}
                    </h1>
                </div>

                <button v-if="storage != null"  class="category-create-edit__add-button" v-on:click="create()">
                    {{this.translations.Start_delivery}}
                </button>

            </div>



        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')

            const urlParams = new URLSearchParams(window.location.search);
            const needing_id_par = urlParams.get("needing_id");
            const storage_par = urlParams.get("storage");

            this.needing_id = needing_id_par;
            this.storage = storage_par;


            console.log(this.storage);
        },

        props: ["translations"],

        data() {
            return {
                storage: null,
                barHoverClass:false,
                restaurantHoverClass:false,

                needing_id:null,
                storage:null
            };
        },

        methods:{

            create(){
                const filter_url = `/delivery/store`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'storage': this.storage,
                        'needing_id': this.needing_id,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        console.log(response.data);
                        
                        window.location.href="/delivery/"+response.data+"/app";
                        
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
