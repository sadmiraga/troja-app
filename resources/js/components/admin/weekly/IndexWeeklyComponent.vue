<template>
    <div class="weekly-index-container">
        <!-- The Modal -->
        <div class="modal fade" id="popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4
                            class="drinks-food-list__title"
                            style="
                                color: #1c6979;
                                font-size: 1rem;
                                line-height: 1.2188rem;
                                font-weight: 700;
                            "
                        >
                            Izvoz tedenske ponudbe v PDF
                        </h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons">
                            <button
                                class="drinks-food-create-edit__add-allergens-button"
                                @click="download('this')"
                            >
                                Ta teden
                            </button>
                            <button
                                class="drinks-food-create-edit__add-allergens-button"
                                @click="download('next')"
                            >
                                Naslednji teden
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOP NAVBAR -> search and create -->
        <div class="search-bar-container-weekly">
            <div class="search-bar">
                <input
                    type="text"
                    name="search"
                    id="search"
                    placeholder="Išči po tedenski ponudbi"
                    v-model="food_query"
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
            <div>
                <a id="export" data-bs-toggle="modal" data-bs-target="#popup">
                    <button class="search-bar__button">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-download"
                            width="100"
                            height="100"
                            viewBox="0 0 24 24"
                            stroke-width="3"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"
                            />
                            <path d="M7 11l5 5l5 -5" />
                            <path d="M12 4l0 12" />
                        </svg>
                    </button>
                </a>
            </div>
            <div>
                <a href="/weekly/create">
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
            </div>
        </div>

        <div class="weekly-list">
            <div
                class="weekly-list__item"
                v-for="(day, index) in groupedFood"
                :key="index"
            >
                <div class="weekly-list__day">
                    <div>{{ formatDay(day.date) }}</div>
                    <div>{{ formatDate(day.date) }}</div>
                </div>
                <div class="weekly-list__food-list">
                    <a
                        class="drinks-food-list__item --food-item --weekly-flow"
                        style="justify-content:space-between;"
                        v-for="(foodItem, foodIndex) in day.foodItems"
                        :key="foodIndex"
                        :href="'/weekly/edit/' + foodItem.id"
                    >
                        <!-- <img class="drinks-food-list__picture" src="" /> -->
                        <div class="drinks-food-list__text-container --breakable">
                            <h4 class="drinks-food-list__title">
                                {{ foodItem.name }}
                            </h4>
                            <div class="drinks-food-list__category">
                                <!-- Here you might need to display the category name instead of id -->
                                {{ foodItem.category_name }}
                            </div>
                            <div class="drinks-food-list__price-label">
                                <span class="drinks-food-list__price">
                                    {{ foodItem.price }} €
                                </span>
                            </div>
                        </div>
                        <div class="drinks-food-list__delete-button-container">
                                <a :href="'/weekly/edit/' + foodItem.id" >
                            <button class="drinks-food-list__delete-button btn btn-warning">Uredi</button>
                        </a>
                        <a :href="'/weekly/delete/' + foodItem.id" >
                            <button class="drinks-food-list__delete-button">Izbriši</button>
                        </a>
                        </div>
                        <!--
                        <div class="edit-button-container">
                            <a>
                                <button class="category__edit-button">Uredi</button>
                            </a>
                        </div>
                        -->
                        
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
        console.log(this.food);
    },

    props: ["food"],

    data() {
        return {
            food_query: "",
            showModal: false,
        };
    },

    watch: {
        food_query: function (newVal) {
            this.searchFood();
        },
    },

    computed: {
        groupedFood() {
            let result = [];
            let dates = [
                ...new Set(this.food.map((item) => item.available_date)),
            ]; // get unique dates

            dates.forEach((date) => {
                let foodItems = this.food.filter(
                    (item) => item.available_date === date
                ); // get food items for each date
                result.push({ date: date, foodItems: foodItems });
            });

            return result;
        },
    },

    methods: {
        download(wich) {
            location.href = "/weekly/export/" + wich;
        },

        formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },

        formatDay(dateString) {
            let date = new Date(dateString);
            let days = [
                "Nedelja",
                "Ponedeljek",
                "Torek",
                "Sreda",
                "Četrtek",
                "Petek",
                "Sobota",
            ];
            return days[date.getDay()];
        },

        searchFood() {
            const filter_url = `/weekly/search`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            query: this.food_query,
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
                        this.food = response.data;
                    })
                    .then((response) => {})
                    .catch((error) => {});
            });
        },
    },
};
</script>
