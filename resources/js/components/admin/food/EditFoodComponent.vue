<template>
    <div class="drinks-food-create__container">
        
        <!-- DRINK INFO -->
        <div v-if="step == 1" id="step-1">
            <div class="drinks-food-edit__container">
                <!-- FOOD IMAGE -->
                <!--
                <div class="drinks-food-create-edit__photo-container">
                    <a href="https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=465&q=80" target="_blank">
                        <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=465&q=80" />
                    </a>
                </div> 
            -->

                <!-- food list -->
                <div
                    class="drinks-food-create-edit__form-container --edit-form-margin"
                >
                    <input
                        type="text"
                        class="drinks-food-create-edit__input"
                        placeholder="Vnesite ime hrane"
                        v-model="name"
                    />
                    <div
                        class="drinks-food-create-edit__input-with-symbol-container"
                    >
                        <input
                            type="number"
                            class="drinks-food-create-edit__input-with-symbol"
                            placeholder="Vnesite ceno hrane"
                            v-model="price"
                        />

                        <div class="drinks-food-create-edit__input-symbol">
                            €
                        </div>
                    </div>
                    <textarea
                        name="description"
                        id="description"
                        cols="30"
                        rows="10"
                        class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
                        placeholder="Vnesi opis izdelka"
                        v-model="description"
                    ></textarea>
                    <div>
                        <div class="drinks-food-create-edit__input-label">
                            <label for="category"
                                >Izberite kategorijo artikla</label
                            >
                        </div>
                        <div
                            class="drinks-food-create-edit__dropdown-container"
                        >
                            <select
                                v-model="category_id"
                                name="category"
                                id="category"
                                class="drinks-food-create-edit__dropdown"
                            >
                                <option
                                    v-for="category in categories"
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
                    <div>
                        <div class="drinks-food-create-edit__weight-label">
                            <label for="weight"
                                >Teža hrane. Ni obvezno polje.</label
                            >
                        </div>

                        <div
                            class="drinks-food-create-edit__input-with-symbol-container"
                        >
                            <input
                                type="number"
                                class="drinks-food-create-edit__input-with-symbol"
                                value="0,00"
                                name="weight"
                                v-model="weight"
                            />

                            <div class="drinks-food-create-edit__input-symbol">
                                g
                            </div>
                        </div>
                    </div>
                </div>

                <!-- buttons -->
                <div class="drinks-food-create-edit__bottom-buttons" style="margin-top:3rem;">
                    <button v-on:click="update()">Shrani</button>
                    <button
                        class="drinks-food-create-edit__add-allergens-button"
                        v-on:click="goToAllergens()"
                    >
                        Posodobi alergene
                    </button>
                </div>
            </div>
        </div>

        <!-- ALLERGENS -->
        <div v-if="step == 2" id="step-2">
            <div class="drinks-food-allergens__container">
                <ol class="drinks-food-allergens__list-container">
                    <li v-for="selected_allergen in selected_allergens">
                        <div class="drinks-food-allergens__allergen-container">
                            <div class="drinks-food-allergens__allergen-name">
                                {{ selected_allergen.name }}
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
        //populate data info
        this.food_id = this.food.id;
        this.name = this.food.name;
        this.price = this.food.price;
        this.description = this.food.description;
        this.category_id = this.food.category_id;
        this.weight = this.food.weight;

        //create selected_allergens array
        this.allergens.forEach((allergen) => {
            var found = this.db_selected_allergens.find(
                (item) => item.allergen_id === allergen.id
            );

            //allergen is selected
            if (found != null) {
                this.selected_allergens.push({
                    id: allergen.id,
                    name: allergen.name,
                    selected: true,
                });
            } else {
                this.selected_allergens.push({
                    id: allergen.id,
                    name: allergen.name,
                    selected: false,
                });
            }
        });
    },

    props: ["food", "categories", "allergens", "db_selected_allergens"],

    data() {
        return {
            food_id: null,
            name: null,
            price: null,
            description: null,
            category_id: null,
            weight: null,
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

        update() {
            const filter_url = `/food/update`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            food_id: this.food_id,
                            name: this.name,
                            price: String(this.price).replace(",", "."),
                            description: this.description,
                            category_id: this.category_id,
                            packing_size: String(this.packing_size).replace(
                                ",",
                                "."
                            ),
                            selected_allergens: this.selected_allergens,
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
                        window.location.href = "/drink/index?page=2";
                    })
                    .then((response) => {})
                    .catch((error) => {});
            });
        },
    },
};
</script>
