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
                        <h3 class="p-bold text-center">{{ this.modal_heading }}</h3>
                        <p class="p-regular text-center mt-3">{{ this.modal_explanation }}</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                            <!-- CONFIRM -->
                            <a class="w-50" :href="modal_link" >
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                     {{ this.translations.Yes }}
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

        <div id="drinks" class="drinks-food-index-container">

            <!-- search -->
            <div class="search-bar-container-weekly">
                <div class="search-bar">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        :placeholder="this.translations.Search_needing_lists"
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

                <div >
                    <a v-if="opened_needing == null && delivery_id == null" href="/needing/start">
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
                    <a v-if="opened_needing != null" :href="'/needing/'+opened_needing.id+'/app'">
                        <button class="search-bar__button" style="display:flex;align-items:center;">
                            {{this.translations.Continue}}
                        </button>
                    </a>

                    <a v-if="delivery_id != null" :href="'/delivery/'+delivery_id+'/app'" class="w-25" style="text-decoration:none;">
                        <button class="search-bar__button success" style="display:flex;align-items:center;
                                                                    width: 12rem;
                                                                    display: flex;
                                                                    justify-content: center;
                                                                    text-decoration: none;">
                            {{translations.Continue_confirmation}}
                        </button>
                    </a>
                </div>
            </div>

            <!-- product list -->
            <div class="drinks-food-list">

                <!-- v-for="product in products"  -->
                <a v-for="needing in needings" class="drinks-food-list__item --drink-item" style="justify-content: space-between;height: auto !important;align-items:start !important;height:100%;">
                    <div class="drinks-food-list__text-container w-100">

                        <h4 class="drinks-food-list__title mb-4">
                            <svg id='Todo_List_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                <g transform="matrix(1.54 0 0 1.54 12 12)" >
                                    <path fill="#1C6979" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; fill-rule: nonzero; opacity: 1;" transform=" translate(-8.51, -7.43)" d="M 5.648438 1.648438 L 3.5 3.792969 L 2.726563 3.023438 L 2.023438 3.726563 L 3.5 5.207031 L 6.351563 2.351563 Z M 8 3 L 8 4 L 15 4 L 15 3 Z M 5.648438 5.648438 L 3.5 7.792969 L 2.726563 7.023438 L 2.023438 7.726563 L 3.5 9.207031 L 6.351563 6.351563 Z M 8 7 L 8 8 L 15 8 L 15 7 Z M 5.648438 9.648438 L 3.5 11.792969 L 2.726563 11.019531 L 2.023438 11.730469 L 3.5 13.207031 L 6.351563 10.355469 Z M 8 11 L 8 12 L 15 12 L 15 11 Z" stroke-linecap="round" />
                                </g>
                            </svg>
                            <span style="margin-left:0.5rem;">{{needing.storage}}</span>
                        </h4>

                        <h4 class="drinks-food-list__title mb-4">
                            {{translations.Employee}}: <span style="font-weight:400">{{ needing.user_name }}</span>
                        </h4>

                        <h4 class="drinks-food-list__title mb-4">
                            {{translations.Location}}: <span style="font-weight:400">{{ needing.location_name }}</span>
                        </h4>
                        
                        <!-- date -->
                        <h4 class="drinks-food-list__title mb-4">
                            {{translations.Date}}: <span v-if="needing.completed == true" style="font-weight:400">{{ formatDateOnly(needing.updated_end_time) }}</span>
                        </h4>

                        <h4 class="drinks-food-list__title mb-4">
                            {{translations.Time}}: 
                            <span v-if="needing.completed == true" style="font-weight:400">{{formatTimeOnly(needing.updated_end_time)}}</span>
                        </h4>

                        <div v-if="needing.completed == true" class="row">
                            <!-- edit -->
                            <a  v-if="needing.confirmed_status != 'in_progress' && needing.confirmed_status != 'confirmed'" class="w-25 plain-link">
                                <button v-on:click="edit(needing)" class="btn btn-primary w-100" style="box-sizing: border-box;">
                                    {{translations.Edit}}
                                </button>
                            </a>
                            <!-- view -->
                            <a :href="'/needing/'+needing.id+'/view'" class="w-25 plain-link">
                                <button class="btn btn-primary w-100" style="box-sizing: border-box;">
                                    {{translations.View}}
                                </button>
                            </a>
                            <!-- delete -->
                            <a v-if="needing.confirmed_status != 'in_progress' && needing.confirmed_status != 'confirmed'" class="w-25 plain-link">
                                <button v-on:click="deleteNeeding(needing)" class="btn btn-primary w-100" style="box-sizing: border-box;">
                                    {{ translations.Delete }}
                                </button>
                            </a>
                            <!-- confirm -->
                            <a v-if="needing.confirmed_status == 'not_confirmed'" class="w-25 plain-link">
                                <button v-on:click="confirm(needing)" 
                                        class="btn btn-primary w-100" 
                                        style="box-sizing: border-box;">
                                    {{ translations.Confirm }}
                                </button>
                            </a>

                            <!-- Continue confimation -->
                            <a  v-if="hasOpenConfirmation(needing)" class="w-50"
                                :href="'/delivery/'+needing.delivery_id+'/app'" >
                                <button class="btn btn-success w-100" style="box-sizing: border-box;">
                                    {{translations.Continue_confirmation}}
                                </button>
                            </a>

                            <!-- Confirmation in progress text -->
                            <p v-if="needing.confirmed_status == 'in_progress' && needing.delivery_user_id != user.id" 
                                class="w-50" style="display: flex;align-items: end;" >
                                {{translations.Confirmation_in_progress}}
                            </p>

                            <!-- confirmed -->
                            <p class="w-50" style="display: flex;align-items: end;" v-if="needing.confirmed_status == 'confirmed'">{{ translations.Confirmed }}</p>

                        </div>

                        <div v-if="needing.completed == false" class="row">
                            <h4 class="drinks-food-list__title mb-4">
                                <span style="font-weight:400">
                                    {{ translations.Needing_list_is_not_completed_yet }}
                                </span>
                            </h4>
                        </div>
                        
                    </div>

                    
                </a>

            </div>

        </div>
    </div>
</template>

<script>
    export default {

        props: ["translations","needings","opened_needing","user"],

        mounted() {
            console.log('Component mounted.');

            console.log(this.needings);
        },

        data() {
            return {
                query: "",

                modal_heading: "",
                modal_explanation:"",
                modal_link:"",

                delivery_id:null,
                
            };
        },

        methods: {

            hasOpenConfirmation(needing){
                if(needing.confirmed_status == 'in_progress' && needing.delivery_user_id == this.user.id){
                    this.delivery_id = needing.delivery_id;
                    return true;
                }
                return false;
            },

            openModal(){
                let button = document.getElementById('trigger-modal');
                button.click();
            },

            edit(needing){
                this.modal_heading = this.translations.Are_you_sure_you_want_to_edit_needing_list;
                this.modal_explanation = this.translations.Other_users_will_not_be_able_to_preview_this_needing_list_while_you_edit_it;
                this.modal_link = '/needing/'+needing.id+'/edit';
                this.openModal();
            },

            deleteNeeding(needing){
                this.modal_heading = this.translations.Are_you_sure_you_want_to_delete_needing_list;
                this.modal_explanation = this.translations.This_will_result_in_losing_all_products_noted_to_needing_list_will_lost;
                this.modal_link = '/needing/'+needing.id+'/delete';
                this.openModal();
            },

            confirm(needing){
                this.modal_heading = this.translations.Are_you_sure_you_want_to_confirm_shipping_of_this_needing_list;
                this.modal_explanation = this.translations.confirm_needing_list_explanation;
                this.modal_link = '/needing/'+needing.id+'/confirm';
                this.openModal();
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
