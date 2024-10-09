/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('support-component', require('./components/admin/SupportComponent.vue').default);

//POPUP MESSAGE
Vue.component('popup-component', require('./components/PopupMessageComponent.vue').default);

//categories
Vue.component('categories-component', require('./components/admin/category/CategoriesComponent.vue').default);
Vue.component('newcategory-component', require('./components/admin/category/CreateCategoryComponent.vue').default);
Vue.component('editcategory-component', require('./components/admin/category/EditCategoryComponent.vue').default);
Vue.component('category-translation-component', require('./components/admin/category/CategoryTranslationComponent.vue').default);



//drinks
Vue.component('drinks-component', require('./components/admin/drinks/DrinksComponent.vue').default);
Vue.component('new-drink-component', require('./components/admin/drinks/CreateDrinkComponent.vue').default);
Vue.component('edit-drink-component', require('./components/admin/drinks/EditDrinkComponent.vue').default);


//food
Vue.component('new-food-component', require('./components/admin/food/CreateFoodComponent.vue').default);
Vue.component('edit-food-component', require('./components/admin/food/EditFoodComponent.vue').default);

//weekly 
Vue.component('index-weekly-component', require('./components/admin/weekly/IndexWeeklyComponent.vue').default);
Vue.component('create-weekly-component', require('./components/admin/weekly/CreateWeeklyComponent.vue').default);
Vue.component('edit-weekly-component', require('./components/admin/weekly/EditWeeklyComponent.vue').default);

//events 
Vue.component('create-event-component', require('./components/admin/event/CreateEventComponent.vue').default);
Vue.component('events-component', require('./components/admin/event/EventsComponent.vue').default);
Vue.component('edit-event-component', require('./components/admin/event/EditEventComponent.vue').default);
//new-drink-component


//PUBLIC ROUTES 
Vue.component('menu-component', require('./components/public/MenuComponent.vue').default);
Vue.component('public-events-component', require('./components/public/EventsComponent.vue').default);
Vue.component('form-component', require('./components/public/FormComponent.vue').default);

//USERS
Vue.component('invite-user', require('./components/admin/users/InviteUserComponent.vue').default);
Vue.component('users-component', require('./components/admin/users/UsersComponent.vue').default);
Vue.component('edit-user', require('./components/admin/users/EditUserComponent.vue').default);

//PRODUCTS
Vue.component('products-component', require('./components/admin/product/ProductsComponent.vue').default);
Vue.component('create-product', require('./components/admin/product/CreateProductComponent.vue').default);
Vue.component('edit-product', require('./components/admin/product/EditProductComponent.vue').default);


//MENU items 
Vue.component('admin-menu-items-component', require('./components/admin/menu/MenuItemsIndexComponent.vue').default);
Vue.component('create-menu-items-component', require('./components/admin/menu/CreateMenuItemComponent.vue').default);
Vue.component('edit-menu-items-component', require('./components/admin/menu/EditMenuItemComponent.vue').default);
Vue.component('edit-menu-items-component', require('./components/admin/menu/EditMenuItemComponent.vue').default);
Vue.component('menu-item-translations-component', require('./components/admin/menu/MenuItemTranslationComponent.vue').default);

//MY STOCKTAKING
Vue.component('my-stocktakings', require('./components/admin/stocktaking/MyStocktakingsComponent.vue').default);
Vue.component('inspect-stocktaking', require('./components/admin/stocktaking/InspectStocktakingComponent.vue').default);
Vue.component('compare-stocktaking', require('./components/admin/stocktaking/CompareStocktakingComponent.vue').default);
Vue.component('start-stocktaking', require('./components/admin/stocktaking/StartStocktakingComponent.vue').default);

//stocktaking APP
Vue.component('stocktaking-app', require('./components/admin/stocktaking/StocktakingAppComponent.vue').default);
Vue.component('stocktaking-archive', require('./components/admin/stocktaking/StocktakingArchiveComponent.vue').default);


//NEEDINGS
Vue.component('needings-component', require('./components/admin/needing/NeedingsComponent.vue').default);
Vue.component('start-needing-component', require('./components/admin/needing/StartNeedingComponent.vue').default);
Vue.component('needings-app', require('./components/admin/needing/NeedingAppComponent.vue').default);
Vue.component('single-needing', require('./components/admin/needing/SingleNeedingComponent.vue').default);




//DELIVERIES
Vue.component('deliveries-component', require('./components/admin/delivery/DeliveriesComponent.vue').default);
Vue.component('delivery-app-component', require('./components/admin/delivery/DeliveryAppComponent.vue').default);
Vue.component('single-delivery-component', require('./components/admin/delivery/SingleDeliveryComponent.vue').default);
Vue.component('start-delivery-component', require('./components/admin/delivery/StartDeliveryComponent.vue').default);
Vue.component('unfinished-delivery-component', require('./components/admin/delivery/UnfinishedDeliveryComponent.vue').default);
Vue.component('import-delivery-component', require('./components/admin/delivery/ImportDeliveryComponent.vue').default);


//REVIEWS 
Vue.component('rate-us-component', require('./components/reviews/RateUsComponent.vue').default);

Vue.component('menu-settings-component', require('./components/admin/settings/menuSettingsComponent.vue').default);

Vue.component('languages-component', require('./components/admin/LanguagesComponent.vue').default);



//LOGIN 
Vue.component('login-component', require('./components/stock/LoginComponent.vue').default);


import Vue from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

Vue.use(Toast);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
