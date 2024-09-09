<template>
    <div class="drinks-food-create__container">
        <!-- DRINK INFO -->
        <div v-if="step == 1" id="step-1">
            <div class="drinks-food-create-edit__form-container">
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

            <!-- IMAGE -->
            <div class="drinks-food-create-edit__bottom-buttons">
                <button v-on:click="create()">Dodaj izdelek</button>
                <button
                    v-on:click="goToAllergens"
                    class="drinks-food-create-edit__add-allergens-button"
                >
                    Dodaj alergene
                </button>
            </div>
        </div>

        <!-- ALLERGENS -->
        <div v-if="step == 2" id="step-2">
            <div class="drinks-food-allergens__container">
                <ol class="drinks-food-allergens__list-container">
                    <li v-for="allergen in allergens">
                        <div class="drinks-food-allergens__allergen-container">
                            <div class="drinks-food-allergens__allergen-name">
                                {{ allergen.name }} ({{ allergen.shortcode }})
                            </div>
                            <div class="drinks-food-allergens__allergen-switch">
                                <label class="switch">
                                    <input
                                        type="checkbox"
                                        v-on:change="
                                            switchAllergen(
                                                allergen.id,
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
                    <button>Nazaj na podatke</button>
                    <button v-on:click="create()">Dodaj izdelek</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        //create selected_allergens array 
        this.allergens.forEach((allergen) => {
            this.selected_allergens.push({ id: allergen.id, selected: false });
        });
    },

    props: ["categories", "allergens"],

    data() {
        return {
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
            this.step = this.step + 1;
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

        goToCreate() {
            this.step = this.step - 1;
        },

        create() {

            if(this.packing_size !=  null){
                var new_packing_size = this.packing_size.replace(',', '.');
            }
            
            const filter_url = `/drink/store`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            name: this.name,
                            price: this.price.replace(',', '.'),
                            description: this.description,
                            category_id: this.category_id,
                            packing_size: new_packing_size,
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
