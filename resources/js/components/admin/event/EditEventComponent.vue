<template>
    <div class="drinks-food-edit__container">
        <div class="drinks-food-create-edit__form-container">

            <div v-if="uploaded == false" class="drinks-food-create-edit__photo-container" >
                <a href="#" target="_blank">
                    <img :src="'/images_dynamic/events/' + event.image"  />
                </a>
            </div>

            <div v-if="uploaded == true" class="drinks-food-create-edit__photo-container" >
                <a href="#" target="_blank">
                    <img :src="image_source"  />
                </a>
            </div>

            <input
                type="text"
                v-model="name"
                class="drinks-food-create-edit__input"
                placeholder="Vnesite ime dogodka"
            />

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

            <!-- TIME -->
            <div class="drinks-food-create-edit__input-with-symbol-container">
                <input
                    type="time"
                    class="drinks-food-create-edit__input-with-symbol"
                    placeholder="Izberite čas ( ni obvezno )"
                    v-model="time"
                />
            </div>

            <div class="drinks-food-create-edit__input-with-symbol-container">
                <input
                    type="text"
                    class="drinks-food-create-edit__input-with-symbol"
                    placeholder="Vnesite lokacijo dogodka ( ni obvezno )"
                    v-model="location"
                />
                <!--
                <div class="drinks-food-create-edit__input-symbol">
                    <svg
                        width="16"
                        height="20"
                        viewBox="0 0 16 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M8 10.833C9.38071 10.833 10.5 9.71372 10.5 8.33301C10.5 6.9523 9.38071 5.83301 8 5.83301C6.61929 5.83301 5.5 6.9523 5.5 8.33301C5.5 9.71372 6.61929 10.833 8 10.833Z"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M7.99992 1.6665C6.23181 1.6665 4.53612 2.36888 3.28587 3.61913C2.03563 4.86937 1.33325 6.56506 1.33325 8.33317C1.33325 9.90984 1.66825 10.9415 2.58325 12.0832L7.99992 18.3332L13.4166 12.0832C14.3316 10.9415 14.6666 9.90984 14.6666 8.33317C14.6666 6.56506 13.9642 4.86937 12.714 3.61913C11.4637 2.36888 9.76803 1.6665 7.99992 1.6665V1.6665Z"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>-->
            </div>

            <!-- Description -->
            <textarea
                name="description"
                id="description"
                cols="30"
                rows="10"
                class="drinks-food-create-edit__input drinks-food-create-edit__textarea"
                placeholder="Vnesi opis dogodka"
                v-model="description"
            ></textarea>

            <!-- Price -->
            <div class="mb-3">
                <div
                    class="drinks-food-create-edit__weight-label events-create__entry-fee-label"
                >
                    <label for="weight">Vstopnina</label>
                    <div class="drinks-food-allergens__allergen-switch">
                        <label class="switch">
                            <input
                                type="checkbox"
                                checked
                                :checked="this.show_price == true ? true: false"
                                v-on:change="
                                    toggle_price($event.target.checked)
                                "
                            />
                            <div class="slider round"></div>
                        </label>
                    </div>
                </div>

                <div
                    v-if="show_price == true"
                    class="drinks-food-create-edit__input-with-symbol-container"
                >
                    <input
                        type="number"
                        class="drinks-food-create-edit__input-with-symbol"
                        placeholder="Vnesi ceno vstopnice"
                        name="entryFee"
                        v-model="price"
                    />

                    <div class="drinks-food-create-edit__input-symbol">€</div>
                </div>
            </div>
        </div>

        <!-- BUTTON -->
        <div class="drinks-food-create-edit__bottom-buttons">
            <div class="drinks-food-create-edit__photo-upload-container">
                <div class="drinks-food-create-edit__input-label">
                    Slika dogodka
                </div>
                <label for="photo">
                    <div
                        class="drinks-food-create-edit__photo-upload"
                        role="button"
                    >
                        <div>Spremeni sliko</div>
                        <div class="drinks-food-create-edit__photo-upload-icon">
                            <svg
                                width="20"
                                height="15"
                                viewBox="0 0 20 15"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M16.944 6.612C16.507 3.17 13.56 0.5 10 0.5C7.244 0.5 4.85 2.111 3.757 4.65C1.609 5.292 0 7.32 0 9.5C0 12.257 2.243 14.5 5 14.5H16C18.206 14.5 20 12.706 20 10.5C19.9985 9.60361 19.6966 8.73358 19.1427 8.02883C18.5888 7.32408 17.8147 6.82526 16.944 6.612ZM11 9.5V12.5H9V9.5H6L10 4.5L14 9.5H11Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </div>
                    </div>
                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        @change="previewImage"
                    />
                </label>
            </div>
            <button
                v-on:click="update()"
                class="drinks-food-create-edit__add-allergens-button"
            >
                Shrani dogodek
            </button>
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
        this.event_id = this.event.id;
        this.name = this.event.name;
        this.date = this.event.date;
        this.time = this.event.time;
        this.location = this.event.location;
        this.description = this.event.description;
        this.price = this.event.price;

        if (this.event.price == 0) {
            this.show_price = false;
        } 

    },
    props: ["event"],

    data() {
        return {
            event_id: null,
            name: null,
            date: null,
            time: null,
            location: null,
            description: null,
            price: null,
            show_price: true,
            image_source: null,
            image: null,

            uploaded: false,
        };
    },

    methods: {

        getImageSource(){

            if(this.event.image != null){
                alert(publicPath);
            }
            return 'https://cdn.myshoptet.com/usr/www.porcelanovysvet.cz/user/shop/big/1015-1_hrnek-modre-linky-thun.jpg?58f7929e';
        },

        formatDate(date) {
            var date_array = date.split("-");
            var formated_date =
                date_array[2] + "." + date_array[1] + "." + date_array[0];
            return formated_date;
        },

        toggle_price(value) {
            if (value == false) {
                this.show_price = false;
                this.price = 0;
            } else {
                this.show_price = true;
                this.price = 0;
            }
        },

        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.image_source = e.target.result;
                };
                reader.readAsDataURL(file);
                this.image = file; // Store the File object
            }
            this.uploaded = true;
        },

        update() {
            const url = `/event/update`;

            const formData = new FormData();
            formData.append("name", this.name);
            formData.append("date", this.date);
            formData.append("time", this.time);
            formData.append("location", this.location);
            formData.append("description", this.description);
            formData.append("price", this.price);
            formData.append("event_id", this.event_id);
            formData.append("image", this.image); // Assuming this.image is the File object

            axios
                .post(url, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "app-token": "U0xYT1VaV1RXU1ZUUkxDQjBRMzM3RDBEWUhHSVBG",
                    },
                })
                .then((response) => {
                    console.log(response.data);

                    if (response.data == "success") {
                        window.location.href = "/event/index";
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
