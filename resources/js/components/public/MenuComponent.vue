<template>
    <div>
        <!-- TOP CATEGORIES -->
        <nav id="nav-public" style="height:fit-content;" class="nav-public--menu">

            <div class="logo-button-container">

                <a href="#" style="color:white;">
                    EN
                </a>

                <a href="/meni" style="width: auto; text-decoration: none">
                    <img
                        src="/images/logo.png"
                        alt="logo"
                        
                        class="nav__logo--menu"
                        style="width: 170px;"
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
                    class="category-type d-none"
                    >Tedenska ponudba</a
                >
            </div>
        </nav>

        <!-- bottom categories -->
        <div class="categories-container">
            <div v-if="top_category != 3" class="categories" style="padding-bottom: 15px;">
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
        <main  id="main-public--menu">
            <!-- ON SELECTED CATEGORY-->
            <div class="types-list">
                <div class="type">
                    <div class="items-list">
                        <a v-for="menu_item in menu_items" 
                            v-if="menu_item.category_id == active_category_id"
                            class="item" 
                            href="#">

                             <img v-if="menu_item.image != null" class="item__picture" :src="'images_dynamic/menu_items/'+menu_item.image" />
                            <div class="item__text-container">
                                <h4 class="item__title">{{ menu_item.name }}</h4>
                                <div class="item__description">
                                    {{ menu_item.description }}
                                </div>
                                <div
                                    class="item__description"
                                    style="font-weight: 200; font-size: 12px"
                                >
                                <span >
                                    {{menu_item.allergens}}
                                </span>
                                <!-- 
                                    <span v-if="product.allergens != ''">
                                        alergens here ...
                                    </span>
                                -->
                                </div>
                                <div class="item__size-price-container">
                                    <!-- size -->
                                    <div class="item__size">
                                        <span
                                            v-if="menu_item.packing_size != null"
                                            >{{ menu_item.packing_size }} l
                                        </span>
                                        <span v-if="menu_item.weight != null"
                                            >{{ menu_item.weight }} g
                                        </span>
                                    </div>

                                    <!-- price -->
                                    <div class="item__price" style="color: #B79238;">
                                        {{ menu_item.price }} €
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>


    </div>
</template>

<script>
export default {
    mounted() {
        console.log(this.menu_items);
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
        "menu_items",
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

    

    methods: {


        setActiveCategoryDefault() {
            //food
            if (this.top_category == 1) {
                this.active_category_id = this.food_categories[0]["id"];
            } else if (this.top_category == 2) {
                this.active_category_id = this.drink_categories[0]["id"];
            }
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

        

        

        
    },
};
</script>
