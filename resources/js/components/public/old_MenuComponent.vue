<template>
    <div>
        <!-- TOP CATEGORIES -->
        <nav id="nav-public" class="nav-public--menu">
            <div class="logo-button-container">
                <a href="/" style="width: auto; text-decoration: none">
                    <img
                        src="/images/logo.png"
                        alt="logo"
                        href="/"
                        class="nav__logo--menu"
                    />
                </a>
                <button class="btn btn-primary" onclick="openSidebar()">
                    <svg
                        width="16"
                        height="9"
                        viewBox="0 0 16 9"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="open-sidebar-button"
                    >
                        <path
                            d="M0 0H16V1.34737H0V0ZM0 3.36842H16V4.71579H0V3.36842ZM0 6.73684H16V8.08421H0V6.73684Z"
                            fill="currentColor"
                        />
                    </svg>
                </button>
            </div>

            <div class="category-types">
                <a
                    v-on:click="changeTopCategory(1)"
                    :class="{ '--active': top_category === 1 }"
                    class="category-type"
                    >Hrana</a
                >
                <a
                    v-on:click="changeTopCategory(2)"
                    :class="{ '--active': top_category === 2 }"
                    class="category-type"
                    >Pijača</a
                >
                <a
                    v-on:click="changeTopCategory(3)"
                    :class="{ '--active': top_category === 3 }"
                    class="category-type"
                    >Tedenska ponudba</a
                >
            </div>
        </nav>

        <!-- bottom categories -->
        <div class="categories-container">
            <div v-if="top_category != 3" class="categories">
                <!-- <a href="" class="category --active">Brezalkoholne pijače</a> -->
                <a
                    v-for="category in active_categories"
                    class="category"
                    :class="{ '--active': category.id === active_category_id }"
                    v-on:click="changeActiveCategoryID(category.id)"
                >
                    {{ category.categoryName }}
                </a>
            </div>
        </div>

        <!-- REDNA PONUDBA -->
        <main v-if="top_category != 3" id="main-public--menu">
            <!-- ON SELECTED CATEGORY-->
            <div class="types-list">
                <div class="type">
                    <div class="items-list">
                        <a v-for="product in products" class="item" href="#">
                            <!-- <img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" /> -->
                            <div class="item__text-container">
                                <h4 class="item__title">{{ product.name }}</h4>
                                <div class="item__description">
                                    {{ product.description }}
                                </div>
                                <div
                                    class="item__description"
                                    style="font-weight: 200; font-size: 12px"
                                >
                                    <span v-if="product.allergens != ''">
                                        ( {{ product.allergens }} )
                                    </span>
                                </div>
                                <div class="item__size-price-container">
                                    <!-- size -->
                                    <div class="item__size">
                                        <span
                                            v-if="product.packing_size != null"
                                            >{{ product.packing_size }} l
                                        </span>
                                        <span v-if="product.weight != null"
                                            >{{ product.weight }} g
                                        </span>
                                    </div>

                                    <!-- price -->
                                    <div class="item__price">
                                        {{ product.price }} €
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- TEDENSKA PONUDBA -->
        <main v-if="top_category == 3" id="main-public--menu">
            <div class="types-list">
                <!-- LOOP DAYS-->
                <div
                    class="type"
                    v-for="(day, index) in groupedFood"
                    :key="index"
                >
                    <h2 class="type-title">{{ formatDay(day.date) }}</h2>

                    <div class="items-list">
                        <!-- loop items in that DAT-->
                        <a
                            class="item"
                            v-for="(foodItem, foodIndex) in day.foodItems"
                            :key="foodIndex"
                        >
                            <!--<img class="item__picture" src="https://bellyfull.net/wp-content/uploads/2021/07/Tequilla-Sunrise-blog-768x1024.jpg" />-->
                            <div class="item__text-container">
                                
                                <h4 class="item__title category-item-title">
                                    <img class="category-icon" :src="'/images_dynamic/categories/'+foodItem.category_icon">
                                    <span class="category-icon-name">{{ foodItem.category_name }}</span>
                                </h4>
                                <h4 class="item__title">
                                    {{ foodItem.name }}
                                </h4>
                                <div class="item__description">
                                    {{ foodItem.description }}
                                </div>
                                <div
                                    class="item__description"
                                    style="font-weight: 200; font-size: 12px"
                                >
                                    <span v-if="foodItem.allergens != ''">
                                        ( {{ foodItem.allergens }} )
                                    </span>
                                </div>

                                <!-- packing size or weight-->
                                <div class="item__size-price-container">
                                    <!-- size -->
                                    <div class="item__size">
                                        <span v-if="foodItem.weight != null"
                                            >{{ foodItem.weight }} g
                                        </span>
                                    </div>

                                    <!-- price -->
                                    <div class="item__price">
                                        {{ foodItem.price }} €
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <foooter class="menu-footer">
            <div class="allergens-container ">
                <div class="row">
                        <p v-for="allergen in allergens">
                            {{ allergen.shortcode }} - {{ allergen.name }}
                        </p>
                </div>
            </div>
        </foooter>

    </div>
</template>

<script>
export default {
    mounted() {
        const urlParams = new URLSearchParams(window.location.search);
        const page = Number(urlParams.get("page"));

        //set general ( TOP ) category
        if (page != 0 && page != null) {
            this.changeTopCategory(page);
        } else {
            this.changeTopCategory(1);
        }

        this.setActiveCategoryDefault();

        //console.log("DRINK AND FOOD DATA");
        //console.log(this.drinks);
        //console.log(this.food);
    },

    props: [
        "drink_categories",
        "food_categories",
        "food",
        "drinks",
        "weekly_offers",
        "default_food",
        "default_drinks",
        "allergens"
    ],

    data() {
        return {
            top_category: 1, // 1 -> drink || 2 -> food || 3 -> tedenska ponudba
            active_categories: null, // bottom slider for categories
            active_category_id: null, // bottom selected category
            products: null,
        };
    },

    watch: {
        active_category_id: function (newVal) {
            this.changeProductSource();
        },
    },

    computed: {
        groupedFood() {
            let result = [];
            let dates = [
                ...new Set(
                    this.weekly_offers.map((item) => item.available_date)
                ),
            ]; // get unique dates

            dates.forEach((date) => {
                let foodItems = this.weekly_offers.filter(
                    (item) => item.available_date === date
                ); // get food items for each date
                result.push({ date: date, foodItems: foodItems });
            });

            return result;
        },
    },

    methods: {


        setActiveCategoryDefault() {
            //food
            if (this.top_category == 1) {
                this.active_category_id = this.food_categories[0]["id"];
            } else if (this.top_category == 2) {
                this.active_category_id = this.drink_categories[0]["id"];
            }
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

        changeTopCategory(value) {
            this.top_category = value;
            this.active_category_id = null;

            if (this.top_category == 1) {
                this.active_categories = this.food_categories;
                this.setActiveCategoryDefault();
                this.changeProductSource();
            }

            if (this.top_category == 2) {
                this.active_categories = this.drink_categories;
                this.setActiveCategoryDefault();
                this.changeProductSource();
            }

            if (this.top_category == 3) {
                //this.active_categories = this.food_categories;
            }
        },

        //change active bottom category from loop.
        changeActiveCategoryID(category_id) {
            this.active_category_id = category_id;
        },

        getFood() {
            const get_food_link = "/meni/food/" + this.active_category_id;
            axios
                .get(get_food_link)
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },

        getDrinks() {
            const get_food_link = "/meni/drinks/" + this.active_category_id;
            axios
                .get(get_food_link)
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.errored = true;
                })
                .finally(() => (this.loading = false));
        },

        changeProductSource() {
            //Filter food
            if (this.top_category == 1) {
                if (this.active_category_id != null) {
                    this.getFood();
                } else {
                    this.products = this.food;
                }
            }

            if (this.top_category == 2) {
                if (this.active_category_id != null) {
                    this.getDrinks();
                } else {
                    this.products = this.drinks;
                }
            }
        },
    },
};
</script>
