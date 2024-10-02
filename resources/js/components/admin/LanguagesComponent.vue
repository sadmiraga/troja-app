<template>
    <div class="container" style="padding-left:0px;padding-right:0px;">
        <div class="categories-index-container">
            <div class="categories-list">
                <div v-for="language in languages" class="category">
                    <div class="category__title-container">

                        <div class="category__title language-title">
                            <!-- Ime kategorije -->
                            <div class="category__title language-title">
                                <div v-html="language.icon"></div> 
                                {{language.name}}
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="drinks-food-allergens__allergen-switch">
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    v-bind:checked="language.enabled"
                                    v-on:change="switchLang($event.target.checked,language.id)" />
                                <div class="slider round" style="border: 1px solid lightgray;"></div>
                            </label>
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

        props: ["languages"],

        methods:{

            switchLang(value,language_id){
                const filter_url = `/settings/languages/enable-disable`;

                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'value': value,
                        'language_id': language_id,
                        
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        console.log(response.data);                      
                    }).then(response => {}).catch(error => {})
                });
            },
        }
    }
</script> 
