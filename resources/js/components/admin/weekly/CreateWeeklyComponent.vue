<template>
    <div class="drinks-food-create__container">
        <!-- FOOD INFO -->
        <div v-if="step == 1" id="step-1">
            <div class="drinks-food-create__container">
                <div class="drinks-food-create-edit__form-container">
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

                    <!-- DATE -->
                    <date-pick v-model="date">
                        <template v-slot:default="{ toggle, inputValue }">
                            <button
                                @click="toggle"
                                class="drinks-food-create-edit__input"
                                style="text-align: left"
                            >
                                {{
                                    inputValue
                                        ? formatDate(inputValue)
                                        : "Izberite datum"
                                }}
                            </button>
                        </template>
                        <template v-slot:cellContent="{ item }">
                            <div class="vdpCellContent">
                                <strong>{{ item.date.getDate() }}</strong>
                            </div>
                        </template>
                    </date-pick>

                    <textarea
                        name="description"
                        id="description"
                        cols="30"
                        rows="10"
                        class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
                        placeholder="Vnesi opis izdelka"
                        v-model="description"
                    ></textarea>

                    <!-- CATEGORY -->
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
                                    {{ category.name }}
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

                    <!-- weight -->
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
                <div class="drinks-food-create-edit__bottom-buttons">
                    <button v-on:click="create()">Dodaj izdelek</button>
                    <button
                        class="drinks-food-create-edit__add-allergens-button"
                        v-on:click="goToAllergens()"
                    >
                        Dodaj alergene
                    </button>
                </div>
            </div>
        </div>

        <!-- ALLERGENS -->
        <div v-if="step == 2" id="step-2">
            <div class="drinks-food-allergens__container">
                <ol class="drinks-food-allergens__list-container">
                    <li v-for="allergen in allergens">
                        <div class="drinks-food-allergens__allergen-container">
                            <div class="drinks-food-allergens__allergen-name">
                                {{ allergen.shortcode }} - {{ allergen.name }} 
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
                    <button v-on:click="goToCreate()">Nazaj na podatke</button>
                    <button v-on:click="create()">Dodaj izdelek</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";

export default {
    components: { DatePick },

    mounted() {
        console.log("Component mounted.");
        console.log(this.allergens);

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
            weight: null,
            date: null,
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

        formatDate(date) {
            var date_array = date.split("-");
            var formated_date =
                date_array[2] + "." + date_array[1] + "." + date_array[0];
            return formated_date;
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

        create() {

            const filter_url = `/weekly/store`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            name: this.name,
                            price: this.price,
                            description: this.description,
                            weekly_category_id: this.category_id,
                            weight: this.weight,
                            selected_allergens: this.selected_allergens,
                            date: this.date
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

                        if (response.data == "success") {
                            window.location.href = "/weekly/index";
                        }
                    })
                    .then((response) => {})
                    .catch((error) => {});
            });
        },
    },
};
</script>
