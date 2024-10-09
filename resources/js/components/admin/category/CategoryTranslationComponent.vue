<template>
    <div>
        <div id="drinks" class="drinks-food-index-container">

            <div class="drinks-food-list products-list" style="grid-template-columns: repeat(1, 1fr);">
                
                <a v-for="language in languages" 
                v-if="language.main_language != true"
                class="drinks-food-list__item --drink-item product-card"
                style="justify-content: space-between;height: auto !important;align-items:start !important;height:100%;">

                <div class="drinks-food-list__text-container menu-item-text-part">

                    <!--title -->
                    <h4 class="drinks-food-list__title language-title" style="display: flex;align-items: center;gap: 6px;">
                        <div v-html="language.icon"></div> 
                        {{ language.name }}
                    </h4>


                    <!-- CATEGORY NAME -->
                        <input
                        type="text"
                        class="category-create-edit__input mt-3 mb-3"
                        placeholder="Ime izdelka"
                        :id="language.id+'-name'"
                    />

                    <!-- DESCRIPTION -->
                    <textarea
                        name="description"
                        id="description"
                        cols="30"
                        rows="10"
                        class="drinks-food-create-edit__input drinks-food-create-edit__textarea description-input"
                        placeholder="Vnesi opis izdelka"
                        :id="language.id+'-description'"
                    ></textarea>

                    <!-- create BUTTON -->
                    <button v-on:click="saveTranslation(language.id)" class="category-create-edit__add-button green-save-button">
                        Save Translation
                    </button>
                    
                </div>
                </a>                
            </div>



        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            console.log(this.translations);

            this.translations.forEach(translation => {
                
                var name_id = translation.language_id+"-name";
                var description_id = translation.language_id+"-description";

                var nameInput = document.getElementById(name_id);
                var descriptionInput = document.getElementById(description_id);

                if (nameInput) {
                    nameInput.value = translation.name;
                }

                if (descriptionInput) {
                    descriptionInput.value = translation.description;
                }

                //find the name of the input and set the translation.name for name and translation.description for descrtioion

            });
        },

        props: ["category","languages","translations"],

        data() {
        return {
                name:null,
            };
        },


        methods: {

            saveTranslation(lang_id) {

                //ids
                var name_id = lang_id+"-name";
                var description_id = lang_id+"-description";

                //variables.
                var name = document.getElementById(name_id).value;
                var description = document.getElementById(description_id).value;


                if(name==""){
                    alert("Vpiši ime v prevod");
                    return 0;
                }


                const filter_url = `/category/translations/save`;
                return new Promise(resolve => {
                    window.axios.post(filter_url, {
                        'name': name,
                        'description':description,
                        'language_id':lang_id,
                        'category_id':this.category.id
                    }, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                        }
                    }).then(response => {
                        if(response.data == "success"){
                            this.$toast.success("You successfully saved translation");
                        }
                        
                    }).then(response => {}).catch(error => {})
                });
                

            }
            

        }


    }
</script>
