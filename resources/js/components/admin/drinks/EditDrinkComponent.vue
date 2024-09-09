<template>
    <div class="drinks-food-edit__container">

        <!-- DRINK INFO -->
        <div v-if="step == 1" id="step-1">
            <div class="drinks-food-create-edit__form-container">
                <!-- DRINK IMAGE
                <div class="drinks-food-create-edit__photo-container">
                    <a href="https://images.unsplash.com/photo-1624552184280-9e9631bbeee9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1887&q=80" target="_blank">
                        <img src="https://images.unsplash.com/photo-1624552184280-9e9631bbeee9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1887&q=80" />
                    </a>
                </div>
                -->
                <!-- NAME -->
                <input
                    type="text"
                    class="drinks-food-create-edit__input"
                    placeholder="Vnesite ime pijače"
                    v-model="name"
                />

                <!-- PRICE -->
                <div
                    class="drinks-food-create-edit__input-with-symbol-container"
                >
                    <input
                        type="number"
                        class="drinks-food-create-edit__input-with-symbol"
                        placeholder="Vnesite ceno artikla"
                        v-model="price"
                    />

                    <div class="drinks-food-create-edit__input-symbol">€</div>
                </div>

                <!-- DESCRIPTION -->
                <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="10"
                    class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
                    placeholder="Vnesi opis artikla"
                    v-model="description"
                ></textarea>

                <!-- CATEGORY -->
                <div>
                    <div class="drinks-food-create-edit__input-label">
                        <label for="category"
                            >Izberite kategorijo artikla</label
                        >
                    </div>
                    <div class="drinks-food-create-edit__dropdown-container">
                        <select
                            name="category"
                            id="category"
                            class="drinks-food-create-edit__dropdown"
                            v-model="category_id"
                        >
                            <option
                                v-for="category in categories"
                                v-bind:key="category.id"
                                :value="category.id"
                            >
                                {{ category.categoryName }}
                            </option>
                        </select>

                        <svg
                            width="14"
                            height="8"
                            viewBox="0 0 14 8"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="drinks-food-create-edit__dropdown-arrow"
                        >
                            <path
                                d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z"
                                fill="currentColor"
                            />
                        </svg>
                    </div>
                </div>

                <!-- PACKING SIZE -->
                <div class="drinks-food-create-edit__volume-container">
                    <div
                        class="drinks-food-create-edit__input-with-symbol-container"
                    >
                        <input
                            type="number"
                            class="drinks-food-create-edit__input-with-symbol"
                            value="0,00"
                            v-model="packing_size"
                            placeholder="Vpišite velikost embelaže"
                        />

                        <div class="drinks-food-create-edit__input-symbol">
                            l
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="drinks-food-create-edit__bottom-buttons">
                <button v-on:click="update()">Shrani</button>
                <button
                    v-on:click="goToAllergens"
                    class="drinks-food-create-edit__add-allergens-button"
                >
                    Posodobi alergene
                </button>
            </div>
        </div>

        <!-- ALLERGENS -->
        <div v-if="step == 2" id="step-2">
            <div class="drinks-food-allergens__container">
                <ol class="drinks-food-allergens__list-container">

                    <li v-for="selected_allergen in selected_allergens">
                        <div class="drinks-food-allergens__allergen-container">
                            <div class="drinks-food-allergens__allergen-name">
                                {{ selected_allergen.shortcode }} - {{ selected_allergen.name }} 
                            </div>
                            <div class="drinks-food-allergens__allergen-switch">
                                <label class="switch">
                                    <input
                                        type="checkbox"

                                        :checked="selected_allergen.selected"

                                        v-on:change="
                                            switchAllergen(
                                                selected_allergen.id,
                                                $event.target.checked
                                            )
                                        "
                                    />
                                    <div class="slider round" />
                                </label>
                            </div>
                        </div>
                    </li>
                </ol>
                <div class="drinks-food-allergens__bottom-buttons">
                    <button v-on:click="goToCreate()">Nazaj na podatke</button>
                    <button v-on:click="update()">Shrani</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    mounted() {

        //console.log(this.db_selected_allergens);

        //set update data
        this.drink_id = this.drink.id;
        this.name = this.drink.name;
        this.price = this.drink.price;
        this.description = this.drink.description;
        this.category_id = this.drink.category_id;
        this.packing_size = this.drink.packing_size;

        //create selected_allergens array
        this.allergens.forEach((allergen) => {

            var found =  this.db_selected_allergens.find(item => item.allergen_id === allergen.id);
            
            //allergen is selected
            if(found != null){
                this.selected_allergens.push({ id: allergen.id,name:allergen.name,shortcode:allergen.shortcode, selected: true });
            } else {
                this.selected_allergens.push({ id: allergen.id,name:allergen.name,shortcode:allergen.shortcode, selected: false });
            }

        });

        
    },

    props: ["drink", "categories","allergens","db_selected_allergens"],

    data() {
        return {
            drink_id: null,
            name: null,
            price: null,
            description: null,
            category_id: null,
            packing_size: null,
            step: 1,
            selected_allergens: [],
        };
    },

    methods: {
        goToAllergens() {
            this.step = 2;
        },

        goToCreate() {
            this.step = 1;
        },

        switchAllergen(allergen_id, value) {
            let allergen = this.selected_allergens.find(
                (allergen) => allergen.id === allergen_id
            );

            // Update its selected value
            if (allergen) {
                allergen.selected = value;
            }
        },

        update(){
            
            const filter_url = `/drink/update`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            drink_id : this.drink_id,
                            name: this.name,
                            price: String(this.price).replace(',', '.'),
                            description: this.description,
                            category_id: this.category_id,
                            packing_size: this.packing_size,
                            selected_allergens : this.selected_allergens 
                        },
                        {
                            headers: {
                                "Content-Type": "application/json",
                                Accept: "application/json",
                                "app-token":
                                    "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
                            },
                        }
                    )
                    .then((response) => {
                        console.log(response.data);
                        window.location.href = "/drink/index";

                        
                    })
                    .then((response) => {})
                    .catch((error) => {});
            });
        },
        

        
    },
};
</script>
