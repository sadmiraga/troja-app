<template>
    <section class="reservation secular" id="rezervacija">
        <popup-component ref="popup"></popup-component>
        <div class="transition-reverse"></div>
        <div class="reservation__heading">Rezerviraj prostor</div>
        <div class="reservation__form">
            <div class="reservation__form-row">
                <input
                    class="reservation__form-input"
                    name="fname"
                    type="text"
                    placeholder="Ime"
                    v-model="first_name"
                />
                <input
                    class="reservation__form-input"
                    name="lname"
                    type="text"
                    placeholder="Priimek"
                    v-model="last_name"
                />
            </div>
            <div class="reservation__form-row">
                <input
                    class="reservation__form-input"
                    type="email"
                    placeholder="Elektronski naslov"
                    v-model="email"
                />
            </div>
            <div class="reservation__form-row">
                <input
                    class="reservation__form-input"
                    name="phone"
                    type="tel"
                    placeholder="Telefonska številka"
                    v-model="phone"
                />
                <input
                    class="reservation__form-input"
                    name="company"
                    type="text"
                    placeholder="Podjetje"
                    v-model="company"
                />
            </div>
            <div class="reservation__form-row">
                <input
                    class="reservation__form-input"
                    name="numberOfPeople"
                    type="number"
                    placeholder="Število oseb"
                    v-model="number_of_guests"
                />

                
                <input
                    class="reservation__form-input"
                    name="date"
                    type="date"
                    placeholder="Datum"
                    v-model="date"
                /> 
                
            </div>
            <div class="reservation__form-row">
                <textarea
                    class="reservation__form-input"
                    name="notes"
                    placeholder="Opombe"
                    rows="5"
                    v-model="notes"
                ></textarea>
            </div>
            <div class="reservation__form-btn-container">
                <button v-on:click="sendForm()" class="reservation-btn secular">
                    Rezerviraj
                </button>
            </div>
        </div>
    </section>
</template>

<script>
import PopupComponent from "../PopupMessageComponent.vue";
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";

export default {
    components: {
        DatePick,
        "popup-component": PopupComponent,
    },
    mounted() {
        console.log("Component mounted.");
    },

    data() {
        return {
            first_name: null,
            last_name: null,
            email: null,
            phone: null,
            company: null,
            number_of_guests: null,
            date: null,
            notes: null,
        };
    },

    methods: {
        sendForm() {
            if (this.first_name == null) {
                this.$refs.popup.showMessage("error", "Vpišite vaše ime");
                return 0;
            }

            if (this.last_name == null) {
                this.$refs.popup.showMessage("error", "Vpišite vaš priimek");
                return 0;
            }

            if (this.email == null) {
                this.$refs.popup.showMessage(
                    "error",
                    "Vpišite vaš elektronski naslov"
                );
                return 0;
            }

            if (this.date == null) {
                this.$refs.popup.showMessage(
                    "error",
                    "Izberite datum"
                );
                return 0;
            }

            if (this.phone == null) {
                this.$refs.popup.showMessage(
                    "error",
                    "Vpišite vašo telefonsko številko"
                );
                return 0;
            }

            this.create();
        },

        formatDate(date) {
            var date_array = date.split("-");
            var formated_date =
                date_array[2] + "." + date_array[1] + "." + date_array[0];
            return formated_date;
        },

        create() {
            const filter_url = `/submit-form`;
            return new Promise((resolve) => {
                window.axios
                    .post(
                        filter_url,
                        {
                            first_name: this.first_name,
                            last_name: this.last_name,
                            email: this.email,
                            phone: this.phone,
                            company: this.company,
                            number_of_guests: this.number_of_guests,
                            date: this.date,
                            notes: this.notes,
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
                            this.$refs.popup.showMessage("success", "Uspešna rezervacija. Vas kontaktiramo v kratkem.");
                            //window.location.href = "/category/index";
                        }
                    })
                    .then((response) => {})
                    .catch((error) => {});
            });
        },
    },
};
</script>
