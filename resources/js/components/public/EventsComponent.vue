<template>
    <div>
        <nav id="nav-public" class="nav-public--events">
            <div class="logo-button-container">
                <a href="/" style="width: auto; text-decoration: none">
                    <img
                        src="/images/logo.png"
                        alt="logo"
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
        </nav>

        <main id="main-public--events">
            <div class="public-events-index-container">
                <div class="public-events-list">
                    <a
                        v-for="event in events"
                        class="public-events-list__item"
                        href=""
                    >
                        <img
                            class="public-events-list__event-image"
                            :src="'/images_dynamic/events/' + event.image"
                        />
                        <div class="public-events-list__event-info">
                            <span class="public-events-lists__event-title">
                                {{ event.name }}
                            </span>
                            <div class="public-events-list__event-date-entry">
                                <div class="public-events-list__event-date">
                                    {{ formatDate(event.date) }} -
                                    {{ formatTime(event.time) }}
                                </div>
                                <div class="public-events-list__event-entry">
                                    <span v-if="event.price == 0"
                                        >prosti vstop</span
                                    >
                                    <span v-if="event.price != 0"
                                        >{{ event.price }} €</span
                                    >
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },

    props: ["events"],

    methods: {
        formatDate(date) {
            var date_array = date.split("-");
            var formated_date =
                date_array[2] + "." + date_array[1] + "." + date_array[0];
            return formated_date;
        },

        formatTime(time) {
            return time.slice(0, -3);
        },
    },
};
</script>
