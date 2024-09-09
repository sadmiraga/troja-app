<template>
  <div>
    
    <!-- edit modal -->
    <div class="modal fade warning-popup" id="confirm-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header close -->
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <h3 class="p-bold">
              {{ this.translations.Are_you_sure_you_want_to_update_this_delivery }}
            </h3>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
              <button class="save-button" type="button" data-bs-dismiss="modal">
                {{ this.translations.No }}
              </button>

              <!-- YES -->
              <a class="w-100" :href="'delivery/app/' + this.delivery_id + '/edit'">
                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1c6979">
                  {{ this.translations.Yes }}
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button type="button" id="trigger-modal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#confirm-modal">
      Open Modal
    </button>

    <!-- DELETE  modal -->
    <div class="modal fade warning-popup" id="confirm-delete-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header close -->
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <h3 class="p-bold">
                {{ this.translations.Are_you_sure_you_wanto_to_delete_this_delivery }}
            </h3>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
              <button class="save-button" type="button" data-bs-dismiss="modal">
                {{ this.translations.No }}
              </button>

              <!-- YES -->
              <a class="w-100" v-on:click="confirmDelete(delivery_id)">
                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1c6979">
                  {{ this.translations.Yes }}
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button type="button" id="trigger-delete-modal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#confirm-delete-modal">
      Open Modal
    </button>


    <!-- search & top buttons-->
    
      <div class="categories-index-container">
        <div class="search-bar-container-weekly">

          <!-- search -->
          <div class="search-bar">
            <input type="text" name="search" id="search" v-model="query" :placeholder="this.translations.Search_deliveries" />
            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-bar__icon">
                <path d="M11.0769 6.76923C11.0769 5.58333 10.6554 4.56891 9.8125 3.72596C8.96955 2.88301 7.95513 2.46154 6.76923 2.46154C5.58333 2.46154 4.56891 2.88301 3.72596 3.72596C2.88301 4.56891 2.46154 5.58333 2.46154 6.76923C2.46154 7.95513 2.88301 8.96955 3.72596 9.8125C4.56891 10.6554 5.58333 11.0769 6.76923 11.0769C7.95513 11.0769 8.96955 10.6554 9.8125 9.8125C10.6554 8.96955 11.0769 7.95513 11.0769 6.76923ZM16 14.7692C16 15.1026 15.8782 15.391 15.6346 15.6346C15.391 15.8782 15.1026 16 14.7692 16C14.4231 16 14.1346 15.8782 13.9038 15.6346L10.6058 12.3462C9.45833 13.141 8.17949 13.5385 6.76923 13.5385C5.85256 13.5385 4.97596 13.3606 4.13942 13.0048C3.30288 12.649 2.58173 12.1683 1.97596 11.5625C1.37019 10.9567 0.889423 10.2356 0.533654 9.39904C0.177885 8.5625 0 7.6859 0 6.76923C0 5.85256 0.177885 4.97596 0.533654 4.13942C0.889423 3.30288 1.37019 2.58173 1.97596 1.97596C2.58173 1.37019 3.30288 0.889423 4.13942 0.533654C4.97596 0.177885 5.85256 0 6.76923 0C7.6859 0 8.5625 0.177885 9.39904 0.533654C10.2356 0.889423 10.9567 1.37019 11.5625 1.97596C12.1683 2.58173 12.649 3.30288 13.0048 4.13942C13.3606 4.97596 13.5385 5.85256 13.5385 6.76923C13.5385 8.17949 13.141 9.45833 12.3462 10.6058L15.6442 13.9038C15.8814 14.141 16 14.4295 16 14.7692Z" fill="currentColor" />
            </svg>
          </div>

          <!-- CREATE delivery -->
          <div v-if="this.open_delivery_id == 0">
            <a href="/delivery/create">
                <button class="search-bar__button">
                <svg viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 6.5H8V0.5H6V6.5H0V8.5H6V14.5H8V8.5H14V6.5Z" fill="currentColor" />
                </svg></button
            ></a>
          </div>
          <!-- CONTINUE delivery -->
          <div v-if="this.open_delivery_id != 0" style="width: 180px">
              <a :href="'/delivery/' + open_delivery_id + '/app'" style="align-items: end;display: flex;justify-content: end;width: fit-content;">
                  <button class="search-bar__button" style="display: flex; align-items: center">
                  {{ this.translations.Continue_Delivery }}
                  </button>
              </a>
          </div>

          <!-- IMPORT delivery -->
          <div>
            <a href="/delivery/import">
                <button class="search-bar__button">
                  <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.5 7.5L21.879 5.015C21.7708 4.58232 21.5212 4.19821 21.1697 3.9237C20.8182 3.6492 20.385 3.50007 19.939 3.5L5.061 3.5C4.61501 3.50007 4.18183 3.6492 3.83033 3.92371C3.47882 4.19821 3.22915 4.58232 3.121 5.015L2.5 7.5M12.5 9.5L12.5 21.5L12.5 9.5ZM12.5 9.5L16.5 13.5L12.5 9.5ZM12.5 9.5L8.5 13.5L12.5 9.5Z" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button
            ></a>
          </div>

        </div>
      </div>
    



    <!-- BODY CONTENT -->
    <div id="drinks" class="drinks-food-index-container">

        <!-- product list -->
        <div class="drinks-food-list">
        <!-- v-for="product in products"  -->
        <a v-for="delivery in deliveries" class="drinks-food-list__item --drink-item" style="justify-content: space-between;height: auto !important;align-items: start !important;height: 100%;">
            <div class="drinks-food-list__text-container w-100">

            <!-- storage -->
            <h4 class="drinks-food-list__title mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M16.434 3C16.752 3.00006 17.0653 3.07593 17.3481 3.22132C17.6309 3.36671 17.8749 3.57743 18.06 3.836L18.149 3.971L20.573 8.011C20.8119 8.40941 20.955 8.85786 20.991 9.321L21 9.554V19C21.0002 19.5046 20.8096 19.9906 20.4665 20.3605C20.1234 20.7305 19.6532 20.9572 19.15 20.995L19 21H5C4.49542 21.0002 4.00943 20.8096 3.63945 20.4665C3.26947 20.1234 3.04284 19.6532 3.005 19.15L3 19V9.554C3.00003 9.08888 3.10821 8.63013 3.316 8.214L3.428 8.01L5.85 3.971C6.0136 3.69815 6.23994 3.46826 6.51021 3.30043C6.78048 3.13259 7.08689 3.03166 7.404 3.006L7.566 3H16.434ZM19 10H5V19H19V10ZM11 5H7.566L5.766 8H11V5ZM16.434 5H13V8H18.234L16.434 5Z" fill="currentColor"/>
            </svg>
                {{ delivery.storage }}
            </h4>

            <h4 class="drinks-food-list__title mb-4">
                {{ translations.Employee }}:
                <span style="font-weight: 400">{{ delivery.user_name }}</span>
            </h4>

            <!-- location -->
            <h4 class="drinks-food-list__title mb-4">
                {{ translations.Location }}:
                <span style="font-weight: 400">{{ delivery.location_name }}</span>
            </h4>

            <!-- date -->
            <h4 class="drinks-food-list__title mb-4">
                {{ translations.Date }}:
                <span v-if="delivery.completed == true" style="font-weight: 400">
                    {{ formatDateOnly(delivery.end) }}
                </span>
            </h4>

            <!-- time -->
            <h4 class="drinks-food-list__title mb-4">
                {{ translations.Time }}:
                <span v-if="delivery.completed == true" style="font-weight: 400">
                  {{ formatTimeOnly(delivery.end) }}
                  </span
                >
            </h4>

            <!-- Delivery not completed YET.-->
            <div v-if="delivery.completed == false" class="row">
                <h4 class="drinks-food-list__title mb-4">
                <span style="font-weight: 400">
                    {{ translations.Delivery_is_not_completed_yet }}
                </span>
                </h4>
            </div>

            <!-- Control buttons -->
            <div v-if="delivery.completed == true" class="row">

                <!-- Export -->
                <a :href="'/delivery/'+delivery.id+'/export'" class="w-25">
                  <button  class="btn btn-primary w-100" style="box-sizing: border-box">
                    Export
                  </button>
                </a>

                <!-- view -->
                <a :href="'/delivery/' + delivery.id + '/single'" class="w-25">
                <button class="btn btn-primary w-100" style="box-sizing: border-box">
                    {{translations.View}}
                </button>
                </a>

                <!-- edit -->
                <a class="w-25">
                  <button v-on:click="update(delivery)" class="btn btn-primary w-100" style="box-sizing: border-box">
                      {{translations.Edit}}
                  </button>
                </a>

                <!-- delete -->
                <a v-on:click="deleteDelivery(delivery)" class="w-25">
                <button  class="btn btn-primary w-100" style="box-sizing: border-box">
                  {{translations.Delete}}
                </button>
                </a>


            </div>

            </div>
        </a>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    console.log(this.open_delivery_id);
    console.log(this.user);
  },

  props: ["deliveries", "translations", "open_delivery_id", "user"],

  data() {
    return {
      query: null,
      delivery_id: null,
      showModal: false,
      message: "message value",
      showPopupMessage: false,

    };
  },

  watch: {
    query: function (newVal) {
      this.search();
    },
  },

  methods: {

    deleteDelivery(delivery){
        this.delivery_id = delivery.id;
        let button = document.getElementById("trigger-delete-modal");
        button.click();
    },

    confirmDelete(delivery_id){
        const filter_url = `/delivery/delete`;
        return new Promise(resolve => {
            window.axios.post(filter_url, {
                'delivery_id':delivery_id
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'app-token': 'U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG',
                }
            }).then(response => {
                if(response.data == "success"){
                    this.$toast.success(this.translations.You_successfully_deleted_delivery);
                    this.search()
                    setTimeout(() => {
                        window.location.href = "/delivery";
                    }, 1500);
                }
            }).then(response => {}).catch(error => {})
        });
    },
    
    update(delivery) {
      if ( delivery.completed == true && Date.now() - new Date(delivery.updated_at).getTime() <= 8 * 60 * 60 * 1000 && this.open_delivery_id == 0) {
        this.delivery_id = delivery.id;
        this.openModalViaButton();
      } else {
        this.$toast.error(this.translations.You_cant_edit_this_delivery);
      }
    },

    openModalViaButton() {
      let button = document.getElementById("trigger-modal");
      button.click();
    },

    search() {
      const filter_url = `/delivery/search`;
      return new Promise((resolve) => {
        window.axios
          .post(
            filter_url,
            {
              query: this.query,
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
            this.deliveries = response.data;
          })
          .then((response) => {})
          .catch((error) => {});
      });
    },

    formatDateOnly(timestamp) {
      timestamp = timestamp.replace(" ", "T"); // Fix for Safari
      let date = new Date(timestamp);
      let day = date.getDate().toString().padStart(2, "0");
      let month = (date.getMonth() + 1).toString().padStart(2, "0"); // Months are 0-indexed in JavaScript
      let year = date.getFullYear();
      return `${day}.${month}.${year}`;
    },

    formatTimeOnly(timestamp) {
      timestamp = timestamp.replace(" ", "T"); // Fix for Safari
      let date = new Date(timestamp);
      let hours = date.getHours().toString().padStart(2, "0");
      let minutes = date.getMinutes().toString().padStart(2, "0");
      return `${hours}:${minutes}`;
    },
  },
};
</script>
