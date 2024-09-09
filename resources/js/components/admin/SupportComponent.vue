<template>
    <div class="categories-create-edit-container">


        <!-- NAME -->
        <div class="drinks-food-create-edit__form-container">
            <input type="text" v-model="name" class="drinks-food-create-edit__input" 
            :placeholder="translations.Enter_page_name_where_problem_occured" />
        </div>

        <!-- Description -->
        <div class="drinks-food-create-edit__form-container">
            <textarea
            id="description"
            cols="40"
            rows="20"
            class="drinks-food-create-edit__input drinks-food-create-edit__textarea" style="height:10rem !important;"
            :placeholder="translations.Describe_your_problem"
            v-model="description"></textarea>            
        </div>
        

        <!-- BUTTON -->
        <div class="drinks-food-create-edit__bottom-buttons">
            <button v-on:click="send()" class="drinks-food-create-edit__add-allergens-button mt-5">
             {{ this.translations.Send_support_ticket }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');

            console.log(this.translations);
            this.link = document.referrer;
        },

        props: ["link","location","translations"],

        data() {
            return {
                name:null,
                description:null,
                link:null,
            };
        },

        methods:{
            send(){

                if(this.name == null){
                    this.$toast.error(this.translations.Enter_page_name_where_problem_occured);
                    return 0;
                }

                if(this.description == null){
                    this.$toast.error(this.translations.Describe_your_problem);
                    return 0;
                }

                const filter_url = `/ticket/create`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'name': this.name,
                        'description': this.description,
                        'link': this.link,
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {

                        if(response.data == "success"){
                            this.$toast.success(this.translations.You_successfully_submited_support_ticket_We_will_resolve_the_problem_and_contact_you_ass_soon_as_possible);

                            setTimeout(() => {
                                window.location.href = "/dashboard";
                            }, 1500);
                        }
                        
                    }).then(response => {}).catch(error => {})
                });
            },
        }
    }
</script>
