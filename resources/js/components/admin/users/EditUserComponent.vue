<template>
    <div class="categories-create-edit-container">

        <!-- USER TYPE -->
        <div>
            <div class="drinks-food-create-edit__input-label">
            <label for="category">{{ this.translations.Choose_user_type }}</label>
            </div>
            <div class="category-create-edit__dropdown-container">
            <select v-model="user_type_id" class="category-create-edit__dropdown">
                <option
                v-for="user_type in user_types"
                :key="user_type.id"
                :value="user_type.id">
                {{ user_type.name }}
                </option>
            </select>
            <svg
                width="14"
                height="8"
                viewBox="0 0 14 8"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="category-create-edit__dropdown-arrow">
                <path d="M2 0L7 5L12 0L14 1L7 8L0 1L2 0Z" fill="currentColor" />
            </svg>
            </div>
        </div>

        <div class="mt-3">

            <!-- manage products -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_products}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="products_access" v-on:change="toggle_access($event.target.checked,'products_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        
            <!-- manage deliveries -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_deliveries}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="deliveries_access" v-on:change="toggle_access($event.target.checked,'deliveries_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>

            <!-- manage deliveries -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{ this.translations.Manage_needing_lists }}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="needings_access" v-on:change="toggle_access($event.target.checked,'needings_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        
            <!-- manage stocktaking -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_stocktaking}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="stocktaking_access" v-on:change="toggle_access($event.target.checked,'stocktaking_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        
            <!-- manage stocktaking archive -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_stocktaking_archive}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="stocktaking_archive_access" v-on:change="toggle_access($event.target.checked,'stocktaking_archive_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        
            <!-- manage users -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_users}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="users_access" v-on:change="toggle_access($event.target.checked,'users_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        
            <!-- manage categories -->  
            <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
                <label for="weight">{{this.translations.Manage_categories}}</label>
                <div class="drinks-food-allergens__allergen-switch">
                    <label class="switch">
                        <input type="checkbox" v-model="categories_access" v-on:change="toggle_access($event.target.checked,'categories_access')" />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        </div>
        

        <button class="category-create-edit__add-button" v-on:click="update()">
            {{this.translations.Save}}
        </button>
        
    </div>
</template>

<script>
    export default {

        beforeMount() {
            this.user_type_id = this.user.user_type_id;
            // Initialize checkbox states based on permissions
            this.products_access = this.permissions.product;
            this.deliveries_access = this.permissions.delivery;
            this.needings_access = this.permissions.needing;
            this.stocktaking_access = this.permissions.mystocktaking;
            this.stocktaking_archive_access = this.permissions.stocktaking;
            this.users_access = this.permissions.user;
            this.categories_access = this.permissions.category;
        },


        mounted() {
            console.log('Component mounted.');
            console.log(this.permissions);
        },

        props: ["user_types", "user", "translations", "permissions"],


        data() {
            return {
            loading: false,
            user_type_id: null,

            products_access: true,
            deliveries_access: true,
            needings_access: true,
            stocktaking_access: true,
            stocktaking_archive_access: true,
            users_access: true,
            categories_access: true,
            };
        },

        methods:{
            toggle_access(value,access) {
      
                if(access == "products_access"){
                    this.products_access = value;
                }

                if(access == "deliveries_access"){
                    this.deliveries_access = value;
                }

                if(access == "needings_access"){
                    this.needings_access = value;
                }

                if(access == "stocktaking_access"){
                    this.stocktaking_access = value;
                }

                if(access == "stocktaking_archive_access"){
                    this.stocktaking_archive_access = value;
                }

                if(access == "users_access"){
                    this.users_access = value;
                }

                if(access == "categories_access"){
                    this.categories_access = value;
                }

            },

            update() {
                const invite_url = `/user/update`;
                return new Promise((resolve) => {
                window.axios
                    .post(
                    invite_url,
                    {
                        user_type_id: this.user_type_id,
                        product: this.products_access,
                        delivery: this.deliveries_access,
                        needing: this.needings_access,
                        mystocktaking: this.stocktaking_access,
                        stocktaking: this.stocktaking_archive_access,
                        user: this.users_access,
                        category: this.categories_access,
                        user_id: this.user.id
                    },
                    {
                        headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "app-token": "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
                        },
                    }
                    )
                    .then((response) => {
                    console.log(response.data);

                    if (response.data == "success") {
                        window.location.href = "/user";
                    }
                    })
                    .then((response) => {})
                    .catch((error) => {});
                });
            },
        }


    }
</script>
