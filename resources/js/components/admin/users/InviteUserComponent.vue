<template>
  <div class="categories-create-edit-container">


      <!-- LOADING -->
      <div v-if="loading == true" class="loading-overlay">
        <div class="loading-overlay__inner">
            <div class="loading-overlay__content">
                <span class="loading-spinner"></span>
            </div>
        </div>
      </div>

    <!-- CATEGORY NAME -->
    <input v-model="email" type="email" class="category-create-edit__input" :placeholder="translations.Enter_email" />

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

    <!-- weightable TOGLE -->
    <div class="mt-3">

        <!-- manage products -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_products}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'products_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage deliveries -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_deliveries}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'deliveries_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage deliveries -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{ this.translations.Manage_needing_lists }}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'needings_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage stocktaking -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_stocktaking}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'stocktaking_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage stocktaking archive -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_stocktaking_archive}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'stocktaking_archive_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage users -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_users}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'users_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

        <!-- manage categories -->  
        <div class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
            <label for="weight">{{this.translations.Manage_categories}}</label>
            <div class="drinks-food-allergens__allergen-switch">
                <label class="switch">
                <input type="checkbox" checked v-on:change="toggle_access($event.target.checked,'categories_access')" />
                <div class="slider round"></div>
                </label>
            </div>
        </div>

    </div>

    <button class="category-create-edit__add-button" v-on:click="invite()">
      {{this.translations.Invite}}
    </button>

    <div v-if="success" class="popup success ">
      <p> {{ this.success_message }} </p>
    </div>

    <div v-if="error" class="popup error">
      <p> {{ this.error_message }} </p>
    </div>

  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },

  props: ["user_types", "translations"],

  data() {
    return {
      email: null,
      loading: false,
      user_type_id: null,

      products_access: true,
      deliveries_access: true,
      needings_access:true,
      stocktaking_access: true,
      stocktaking_archive_access: true,
      users_access: true,
      categories_access: true,


      error:false,
      error_message:null,

      success: false,
      success_message:null,
      

    };
  },

  methods: {

    closeErrorMessage(){
      this.error = false;
    },

    closeSuccessMessage(){
      this.success = false;
      window.location.href = "/user";
    },

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

    invite() {

      //user type error
      if(this.user_type_id == null){
        this.error_message = this.translations.Choose_user_type_before_inviting_user;
        this.error = true;
        setTimeout(this.closeErrorMessage, 2500);
        return 0;
      }

      this.loading = true;
      const invite_url = `/user/invite/send`;
      return new Promise((resolve) => {
        window.axios
          .post(
            invite_url,
            {
                email: this.email,
                user_type_id: this.user_type_id,
                products_access: this.products_access,
                deliveries_access: this.deliveries_access,
                needings_access: this.needings_access,
                stocktaking_access: this.stocktaking_access,
                stocktaking_archive_access: this.stocktaking_archive_access,
                users_access: this.users_access,
                categories_access: this.categories_access,
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
            
            this.loading = false;
            
            //error
            if(response.data == "error"){
              this.error_message = this.translations.User_with_this_email_is_already_invited_for_registration;
              this.error = true;
              setTimeout(this.closeErrorMessage, 2500);
            }

            //success
            if (response.data == "success") {
              this.$toast.success(this.translations.You_successfully_invite_for_registration_to+" - "+this.email);
              //this.success = true;
              setTimeout(this.closeSuccessMessage, 3000);
            }
          })
          .then((response) => {})
          .catch((error) => {});
      });
    },
  },
};
</script>
