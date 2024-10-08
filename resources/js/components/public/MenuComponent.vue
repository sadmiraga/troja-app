<template>
    <div>
        <!-- Primary color - navbar background - footer background. -->
        <!-- secondary color  - Hamburger icon, active color of the selected, border bottom color.  -->
        <!-- Accent Color - item description  -->


        <!-- TOP CATEGORIES -->
        <nav id="nav-public" :style="'height:fit-content;background-color:' + settings.primary_color + ';'" class="nav-public--menu">

            <div class="logo-button-container" style="margin-bottom: 40px;">

                <!-- Dropdown for languages -->
                <div class="dropdown" style="color:white;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span v-if="selectedLanguage == null">
                            SL
                        </span>
                        <span v-if="selectedLanguage != null">{{this.active_language_shortcode}}</span>
                    </button>
                    <ul class="dropdown-menu menu-language-dropdown" aria-labelledby="dropdownMenuButton">
                        <li v-for="language in languages" :key="language.shortcode">
                            <a class="dropdown-item" href="#" @click="changeLanguage(language)">
                                <div  v-html="language.icon"></div> 
                                <span>{{ language.name }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                

                <a href="/meni" style="width: auto; text-decoration: none">
                    <img
                        :src="'images_dynamic/settings/'+this.settings.logo"
                        alt="logo"
                        
                        class="nav__logo--menu"
                        style="width: 170px;"
                    />
                </a>
                

                <button class="btn btn-primary" onclick="openSidebar()" :style="'height:fit-content;color:white;'">
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
                    :style="{ color: settings.accent_color, backgroundColor: top_category === 1 ? settings.secondary_color : '' }"
                    style="border:none !important;"
                    class="category-type"
                    >Hrana</a
                >
                <a
                    v-on:click="changeTopCategory(2)"
                    :class="{ '--active': top_category === 2 }"
                    :style="{ color: settings.accent_color, backgroundColor: top_category === 2 ? settings.secondary_color : '' }"
                    style="border:none !important;"
                    class="category-type"
                    >Pijača</a
                >
                <a
                    v-if="settings.extra_categories_enabled == true"
                    v-on:click="changeTopCategory(4)"
                    :class="{ '--active': top_category === 4 }"
                    :style="{ color: settings.accent_color, backgroundColor: top_category === 4 ? settings.secondary_color : '' }"
                    style="border:none !important;"
                    class="category-type"
                    >Shisha</a
                >
                <a
                    v-on:click="changeTopCategory(3)"
                    :class="{ '--active': top_category === 3 }"
                    :style="{ color: settings.accent_color, backgroundColor: top_category === 3 ? settings.secondary_color : '' }"
                    style="border:none !important;"
                    class="category-type d-none"
                    >Tedenska ponudba</a
                >
            </div>
        </nav>

        <!-- bottom categories -->
        <div class="categories-container" :style="'height:fit-content;background-color:' + settings.primary_color + ';'">

            <div v-if="top_category != 3 && top_category != 4" class="categories" style="padding-bottom: 15px;" :style="'height:fit-content;background-color:' + settings.primary_color + ';'">

                <!-- <a href="" class="category --active">Brezalkoholne pijače</a> -->
                <a
                    v-for="category in active_categories"
                    class="category"
                    :class="{ '--active': category.id === active_category_id }"
                    :style="{ color: settings.accent_color, backgroundColor: category.id === active_category_id ? settings.secondary_color : '' }"
                    v-on:click="changeActiveCategoryID(category.id)"
                >
                    <div v-html="category.icon"></div> 

                    {{ category.categoryName }}
                </a>
            </div>
        </div>

        <!-- REDNA PONUDBA -->
        <main  id="main-public--menu" :style="settings.tertiary_color || ''">
            <!-- ON SELECTED CATEGORY-->
            <div class="types-list">
                <div class="type">
                    <div class="items-list" :key="selectedLanguage">
                        <a v-for="menu_item in menu_items" 
                            v-if="menu_item.category_id == active_category_id"
                            class="item" 
                            style="border-bottom: 1px solid #B7923880;">

                             <img v-if="menu_item.image != null" class="item__picture" :src="'images_dynamic/menu_items/'+menu_item.image" />

                            <div class="item__text-container" >

                                <!-- default name -->
                                <h4 class="item__title" 
                                    v-if="selectedLanguage == null"
                                    :style="'color:' + settings.secondary_color + ';'">
                                    {{ menu_item.name }}
                                </h4> 

                                <h4 class="item__title" v-else>{{ menu_item.translations.find(translation => translation.language_id === selectedLanguage.id)?.name || menu_item.name }}</h4>

                                <!--- item description -->
                                <div class="item__description" 
                                    v-if="selectedLanguage == null"
                                    :style="'color:' + settings.accent_color + ';'"
                                    >
                                    {{ menu_item.description }}
                                </div>

                                <!-- translated description -->
                                <div class="item__description" 
                                :style="'color:' + settings.accent_color + ';'"
                                v-else>
                                    {{ menu_item.translations.find(translation => translation.language_id === selectedLanguage.id)?.description || menu_item.description }}
                                </div>

                                <div
                                    class="item__description"
                                    style="font-weight: 200; font-size: 12px"
                                    :style="'color:' + settings.accent_color + ';'"
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
                                    <div class="item__price" style="color: #B79238;text-align:right;">

                                        <!-- nočna cena -->
                                        <span v-if="menu_item.night_price != null" class="night-price">Nočna cena: {{ menu_item.night_price }} € </span><br>

                                        <!-- cena -->
                                        <span
                                            :style="'color:' + settings.secondary_color + ';'">
                                            Cena: {{ menu_item.price }} €
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- footer -->
        <foooter class="menu-footer">
            <div class="allergens-container" style="background-color:black;" :style="'height:fit-content;background-color:' + settings.primary_color + ';'">
                
                <div class="row">
                    <p v-for="allergen in allergens">
                        {{ allergen.shortcode }} - {{ allergen.name }}
                    </p>
                </div>
                <div class="row text-center">
                    <p>*Nočna cena je veljavna v času dogodka.</p>
                </div>
                <div class="row text-center">
                    <p>*Slike hrane in pijače so simbolične.</p>
                </div>
            </div>
        </foooter>

    </div>
</template>



<script>
export default {
    mounted() {
        console.log(this.menu_items);
        //console.log();
        const urlParams = new URLSearchParams(window.location.search);
        const page = Number(urlParams.get("page"));

        //set general ( TOP ) category
        if (page != 0 && page != null) {
            this.changeTopCategory(page);
        } else {
            this.changeTopCategory(1);
        }

        this.setActiveCategoryDefault();

        //alert(this.settings.primary_color);

        //console.log("DRINK AND FOOD DATA");
        //console.log(this.drinks);
        //console.log(this.food);
    },

    props: [
        "drink_categories",
        "food_categories",
        "menu_items",
        "allergens",
        "settings",
        "languages"
    ],

    data() {
        return {
            top_category: 1, // 1 -> drink || 2 -> food || 3 -> tedenska ponudba
            active_categories: null, // bottom slider for categories
            active_category_id: null, // bottom selected category
            products: null,

            selectedLanguage: null,

            active_language_shortcode:"SL",
            active_langauge_icon:null,
        };
    },

    /*
    watch: {
        active_category_id: function (newVal) {
            this.changeProductSource();
        },
    },
    */

    watch: {
        selectedLanguage: function(newLang) {
            this.refreshMenuItems();
            console.log(`Language changed to: ${newLang.name}`);
        }
    },

    

    methods: {

        refreshMenuItems() {
            // Optionally re-fetch or update menu items here if necessary.
            // Or simply trigger a change that Vue will recognize.
            this.menu_items = [...this.menu_items]; // Creating a new reference to force reactivity
        },

        changeLanguage(language) {
            this.selectedLanguage = language;
            this.active_language_shortcode = language.shortcode;

            // Perform any additional logic, such as reloading content for the selected language
            console.log(`Language changed to: ${language.name}`);
        },


        setActiveCategoryDefault() {
            //food
            if (this.top_category == 1) {
                this.active_category_id = this.food_categories[0]["id"];
            } else if (this.top_category == 2) {
                this.active_category_id = this.drink_categories[0]["id"];
            } else if(this.top_category == 4){
                this.active_category_id = 0;
            }
            
            
        },

        changeTopCategory(value) {
            this.top_category = value;
            this.active_category_id = null;

            if (this.top_category == 1) {
                this.active_categories = this.food_categories;
                this.setActiveCategoryDefault();
                //this.changeProductSource();
            }

            if (this.top_category == 2) {
                this.active_categories = this.drink_categories;
                this.setActiveCategoryDefault();
                //this.changeProductSource();
            }

            if (this.top_category == 3) {
                //this.active_categories = this.food_categories;
            }

            if(this.top_category == 4){
                this.setActiveCategoryDefault();
                //this.changeProductSource();
            }
        },

        //change active bottom category from loop.
        changeActiveCategoryID(category_id) {
            this.active_category_id = category_id;
        },

        

        

        
    },
};
</script>