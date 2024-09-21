<template>
  <div class="drinks-food-edit__container" style="min-height: fit-content">
    <!-- food TOGGLE -->
    <div class="mt-3">
      <div
        class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
        <label for="weight">Enable food</label>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input
              type="checkbox"
              checked
              v-on:change="toggle_food($event.target.checked)" />
            <div class="slider round"></div>
          </label>
        </div>
      </div>
    </div>
    <hr />

    <!-- drinks TOGGLE -->
    <div class="mt-3">
      <div
        class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
        <label for="weight">Enable Drinks</label>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input
              type="checkbox"
              checked
              v-on:change="toggle_drinks($event.target.checked)" />
            <div class="slider round"></div>
          </label>
        </div>
      </div>
    </div>
    <hr />

    <!-- extra categories TOGGLE -->
    <div class="mt-3">
      <div
        class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
        <label for="weight">Enable Extra Categories</label>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input
              type="checkbox"
              v-on:change="toggle_extra_categories($event.target.checked)" />
            <div class="slider round"></div>
          </label>
        </div>
      </div>
    </div>
    <hr />

    <div
      class="categories-create-edit-container w-100"
      style="margin-top: 120px; height: fit-content !important">
      <div
        class="drinks-food-create-edit__weight-label events-create__entry-fee-label">
        <label for="weight">Add new Parent Category</label>
      </div>

      <!-- CATEGORY NAME -->
      <input
        v-model="name"
        type="text"
        class="category-create-edit__input"
        placeholder="Vpiši ime kategorije" />

      <textarea
        class="category-create-edit__input"
        rows="15"
        v-model="icon"
        placeholder="Add SVG code for ICON"
        style="height: fit-content">
      </textarea>

      <!-- create BUTTON -->
      <button
        v-on:click="create()"
        class="category-create-edit__add-button mt-3">
        Create Category
      </button>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getLocations();
  },

  data() {
    return {
      selected_locations: [],
      food_enabled: true,
      drinks_enabled: true,
      toggle_extra_categories: false,
      icon: null,
      location_id: 0,
    };
  },

  methods: {
    create() {

        alert(this.location_id);
      const filter_url = `/settings/parent_category/store`;
      return new Promise((resolve) => {
        window.axios
          .post(
            filter_url,
            {
              name: this.name,
              icon: this.icon,
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

            

            if (response.data == "success") {
              this.$toast.success(
                "Success"
              );
              setTimeout(() => {
                window.location.href = "/settings";
              }, 1500);
            }

          })
          .then((response) => {})
          .catch((error) => {});
      });
    },

    toggle_food(value) {
      this.food_enabled = value;
    },

    toggle_drinks(value) {
      this.drinks_enabled = value;
    },

    toggle_extra_categories(value) {
      this.toggle_extra_categories = value;
    },

    getLocations() {
      const get_locations_url = "/api/get-locations/";
      axios
        .get(get_locations_url)
        .then((response) => {
          this.locations = response.data;
          this.fillLocations();
        })
        .catch((error) => {
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },

    getCurrentLocationID() {
      const get_location_id_url = "/get-current-location-id/";
      axios
        .get(get_location_id_url)
        .then((response) => {
          this.location_id = response.data;
          const location = this.options.find(
            (option) => option.value === this.location_id
          );
          if (location) {
            this.selected_locations.push(location.label);
          }
        })
        .catch((error) => {
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
