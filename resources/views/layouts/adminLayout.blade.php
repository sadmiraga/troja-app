<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Troja</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    @yield('css')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var history = JSON.parse(sessionStorage.getItem('pageHistory')) || [];
        history.push(window.location.href); // Add current URL to history
        sessionStorage.setItem('pageHistory', JSON.stringify(history));
        });

        document.addEventListener('touchstart', function(event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, { passive: false });

        let lastTouchEnd = 0;
        document.addEventListener('touchend', function(event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div>
        <div id="sidebar">
            <button class="btn btn-primary" onclick="closeSidebar()">
                <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="sidebar__close-button">
                    <path
                        d="M12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41L12.59 0Z"
                        fill="currentColor" />
                </svg>
            </button>

            <div class="sidebar__container" style="overflow-y: scroll;">
                <ul>
                    <li class="sidebar__name">
                        @auth <p>{{ auth()->user()->name }}</p> @endauth
                        <p class="d-none">Direktor</p>
                    </li>

                    <!-- DASHBOARD -->
                    <li>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                                <path d="M2 16H5V10H11V16H14V7L8 2.5L2 7V16ZM0 18V6L8 0L16 6V18H9V12H7V18H0Z" fill="currentColor"/>
                                </svg>
                        </div>
                        <div><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></div>
                    </li>

                    <!-- MENU ITEMS -->
                    <li>
                        <div>
                            <img src="images/icons/restaurant-menu.png" style="width: 30px;">
                        </div>
                        <div><a href="/menu_items">Meni / Ponudba</a></div>
                    </li>

                    <!-- PRODUCTS -->
                    <li>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M2 21V19H20V21H2ZM20 8V5H18V8H20ZM20 3C20.5304 3 21.0391 3.21071 21.4142 3.58579C21.7893 3.96086 22 4.46957 22 5V8C22 8.53043 21.7893 9.03914 21.4142 9.41421C21.0391 9.78929 20.5304 10 20 10H18V13C18 14.0609 17.5786 15.0783 16.8284 15.8284C16.0783 16.5786 15.0609 17 14 17H8C6.93913 17 5.92172 16.5786 5.17157 15.8284C4.42143 15.0783 4 14.0609 4 13V3H20ZM16 5H6V13C6 13.5304 6.21071 14.0391 6.58579 14.4142C6.96086 14.7893 7.46957 15 8 15H14C14.5304 15 15.0391 14.7893 15.4142 14.4142C15.7893 14.0391 16 13.5304 16 13V5Z" fill="currentColor"/>
                                </svg>
                        </div>
                        <div><a href="/product">{{ __('Products') }}</a></div>
                    </li>

                    <!-- MY STOCKTAKINGS -->
                    <li>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="24" viewBox="0 0 21 24" fill="none">
                                <path d="M18.2474 6.24107C18.454 6.4494 18.6311 6.73214 18.7786 7.08929C18.9262 7.44643 19 7.77381 19 8.07143V20.9286C19 21.2262 18.8967 21.4792 18.6901 21.6875C18.4835 21.8958 18.2326 22 17.9375 22H3.0625C2.76736 22 2.51649 21.8958 2.3099 21.6875C2.1033 21.4792 2 21.2262 2 20.9286V3.07143C2 2.77381 2.1033 2.52083 2.3099 2.3125C2.51649 2.10417 2.76736 2 3.0625 2H12.9792C13.2743 2 13.599 2.0744 13.9531 2.22321C14.3073 2.37202 14.5877 2.5506 14.7943 2.75893L18.2474 6.24107ZM13.3333 3.51786V7.71429H17.4948C17.421 7.49851 17.3398 7.34598 17.2513 7.2567L13.7871 3.76339C13.6986 3.67411 13.5473 3.59226 13.3333 3.51786ZM17.5833 20.5714V9.14286H12.9792C12.684 9.14286 12.4332 9.03869 12.2266 8.83036C12.02 8.62202 11.9167 8.36905 11.9167 8.07143V3.42857H3.41667V20.5714H17.5833ZM6.25 10.9286C6.25 10.8244 6.2832 10.7388 6.34961 10.6719C6.41602 10.6049 6.50087 10.5714 6.60417 10.5714H14.3958C14.4991 10.5714 14.584 10.6049 14.6504 10.6719C14.7168 10.7388 14.75 10.8244 14.75 10.9286V11.6429C14.75 11.747 14.7168 11.8326 14.6504 11.8996C14.584 11.9665 14.4991 12 14.3958 12H6.60417C6.50087 12 6.41602 11.9665 6.34961 11.8996C6.2832 11.8326 6.25 11.747 6.25 11.6429V10.9286ZM14.3958 13.4286C14.4991 13.4286 14.584 13.4621 14.6504 13.529C14.7168 13.596 14.75 13.6815 14.75 13.7857V14.5C14.75 14.6042 14.7168 14.6897 14.6504 14.7567C14.584 14.8237 14.4991 14.8571 14.3958 14.8571H6.60417C6.50087 14.8571 6.41602 14.8237 6.34961 14.7567C6.2832 14.6897 6.25 14.6042 6.25 14.5V13.7857C6.25 13.6815 6.2832 13.596 6.34961 13.529C6.41602 13.4621 6.50087 13.4286 6.60417 13.4286H14.3958ZM14.3958 16.2857C14.4991 16.2857 14.584 16.3192 14.6504 16.3862C14.7168 16.4531 14.75 16.5387 14.75 16.6429V17.3571C14.75 17.4613 14.7168 17.5469 14.6504 17.6138C14.584 17.6808 14.4991 17.7143 14.3958 17.7143H6.60417C6.50087 17.7143 6.41602 17.6808 6.34961 17.6138C6.2832 17.5469 6.25 17.4613 6.25 17.3571V16.6429C6.25 16.5387 6.2832 16.4531 6.34961 16.3862C6.41602 16.3192 6.50087 16.2857 6.60417 16.2857H14.3958Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div><a href="{{ route('mystocktaking.index') }}">{{ __('My stocktakings') }}</a></div>
                    </li>

                    <!-- STOCKTAKINGS HISTORY -->
                    <li>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13.5 23.25H4.5C3.675 23.25 3 22.575 3 21.75V9H4.5V21.75H13.5V23.25Z" fill="currentColor"/>
                                <path d="M16.5 20.25H7.5C6.675 20.25 6 19.575 6 18.75V6H7.5V18.75H16.5V20.25Z" fill="currentColor"/>
                                <path d="M12 12H18V13.5H12V12Z" fill="currentColor"/>
                                <path d="M20.775 6.975L15.525 1.725C15.375 1.575 15.225 1.5 15 1.5H10.5C9.675 1.5 9 2.175 9 3V15.75C9 16.575 9.675 17.25 10.5 17.25H19.5C20.325 17.25 21 16.575 21 15.75V7.5C21 7.275 20.925 7.125 20.775 6.975ZM15 3.3L19.2 7.5H15V3.3ZM19.5 15.75H10.5V3H13.5V7.5C13.5 8.325 14.175 9 15 9H19.5V15.75Z" fill="#F9F9F9"/>
                                </svg>
                        </div>
                        <div><a href="{{ route('stocktaking.index') }}">{{ __('Stocktakings archive') }}</a></div>
                    </li>


                    <!-- USERS -->
                    <li>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                                <path d="M8.86823 11.7144C7.79948 11.7478 6.92535 12.1764 6.24583 13.0001H4.91979C4.37882 13.0001 3.92361 12.8645 3.55417 12.5933C3.18472 12.3221 3 11.9253 3 11.403C3 9.03913 3.40903 7.85721 4.22708 7.85721C4.26667 7.85721 4.41016 7.92753 4.65755 8.06815C4.90495 8.20878 5.22656 8.35107 5.6224 8.49505C6.01823 8.63902 6.41076 8.71101 6.8 8.71101C7.24201 8.71101 7.68073 8.634 8.11615 8.47998C8.08316 8.72775 8.06667 8.94873 8.06667 9.14293C8.06667 10.0737 8.33385 10.9309 8.86823 11.7144ZM19.4667 18.1128C19.4667 18.9164 19.2259 19.5508 18.7443 20.0163C18.2627 20.4817 17.6227 20.7144 16.8245 20.7144H8.17552C7.37726 20.7144 6.73733 20.4817 6.25573 20.0163C5.77413 19.5508 5.53333 18.9164 5.53333 18.1128C5.53333 17.7579 5.54488 17.4113 5.56797 17.0732C5.59106 16.735 5.63724 16.37 5.70651 15.9783C5.77578 15.5866 5.86319 15.2233 5.96875 14.8885C6.07431 14.5536 6.21615 14.2272 6.39427 13.9091C6.5724 13.591 6.77691 13.3198 7.00781 13.0955C7.23872 12.8712 7.52075 12.692 7.85391 12.5581C8.18707 12.4242 8.55486 12.3572 8.95729 12.3572C9.02326 12.3572 9.1651 12.4292 9.38281 12.5732C9.60052 12.7171 9.84132 12.8779 10.1052 13.0553C10.3691 13.2328 10.722 13.3935 11.1641 13.5375C11.6061 13.6814 12.0514 13.7534 12.5 13.7534C12.9486 13.7534 13.3939 13.6814 13.8359 13.5375C14.278 13.3935 14.6309 13.2328 14.8948 13.0553C15.1587 12.8779 15.3995 12.7171 15.6172 12.5732C15.8349 12.4292 15.9767 12.3572 16.0427 12.3572C16.4451 12.3572 16.8129 12.4242 17.1461 12.5581C17.4793 12.692 17.7613 12.8712 17.9922 13.0955C18.2231 13.3198 18.4276 13.591 18.6057 13.9091C18.7839 14.2272 18.9257 14.5536 19.0312 14.8885C19.1368 15.2233 19.2242 15.5866 19.2935 15.9783C19.3628 16.37 19.4089 16.735 19.432 17.0732C19.4551 17.4113 19.4667 17.7579 19.4667 18.1128ZM9.33333 5.28578C9.33333 5.99561 9.08594 6.60163 8.59115 7.10386C8.09635 7.6061 7.49931 7.85721 6.8 7.85721C6.10069 7.85721 5.50365 7.6061 5.00885 7.10386C4.51406 6.60163 4.26667 5.99561 4.26667 5.28578C4.26667 4.57596 4.51406 3.96994 5.00885 3.4677C5.50365 2.96547 6.10069 2.71436 6.8 2.71436C7.49931 2.71436 8.09635 2.96547 8.59115 3.4677C9.08594 3.96994 9.33333 4.57596 9.33333 5.28578ZM16.3 9.14293C16.3 10.2077 15.9289 11.1167 15.1867 11.87C14.4445 12.6234 13.549 13.0001 12.5 13.0001C11.451 13.0001 10.5555 12.6234 9.81328 11.87C9.07109 11.1167 8.7 10.2077 8.7 9.14293C8.7 8.07819 9.07109 7.16915 9.81328 6.41581C10.5555 5.66246 11.451 5.28578 12.5 5.28578C13.549 5.28578 14.4445 5.66246 15.1867 6.41581C15.9289 7.16915 16.3 8.07819 16.3 9.14293ZM22 11.403C22 11.9253 21.8153 12.3221 21.4458 12.5933C21.0764 12.8645 20.6212 13.0001 20.0802 13.0001H18.7542C18.0747 12.1764 17.2005 11.7478 16.1318 11.7144C16.6661 10.9309 16.9333 10.0737 16.9333 9.14293C16.9333 8.94873 16.9168 8.72775 16.8839 8.47998C17.3193 8.634 17.758 8.71101 18.2 8.71101C18.5892 8.71101 18.9818 8.63902 19.3776 8.49505C19.7734 8.35107 20.0951 8.20878 20.3424 8.06815C20.5898 7.92753 20.7333 7.85721 20.7729 7.85721C21.591 7.85721 22 9.03913 22 11.403ZM20.7333 5.28578C20.7333 5.99561 20.4859 6.60163 19.9911 7.10386C19.4964 7.6061 18.8993 7.85721 18.2 7.85721C17.5007 7.85721 16.9036 7.6061 16.4089 7.10386C15.9141 6.60163 15.6667 5.99561 15.6667 5.28578C15.6667 4.57596 15.9141 3.96994 16.4089 3.4677C16.9036 2.96547 17.5007 2.71436 18.2 2.71436C18.8993 2.71436 19.4964 2.96547 19.9911 3.4677C20.4859 3.96994 20.7333 4.57596 20.7333 5.28578Z" fill="currentColor"/>
                                </svg>
                        </div>
                        <div><a href="/user">{{ __('Users') }}</a></div>
                    </li>

                    <!-- CATEGORIES -->
                    <li>
                        <div>
                            <svg viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="sidebar__categories-icon">
                                <path
                                    d="M21.75 0.5H2.25C1.00734 0.5 0 1.50734 0 2.75V19.25C0 20.4927 1.00734 21.5 2.25 21.5H21.75C22.9927 21.5 24 20.4927 24 19.25V2.75C24 1.50734 22.9927 0.5 21.75 0.5ZM21.4688 19.25H2.53125C2.45666 19.25 2.38512 19.2204 2.33238 19.1676C2.27963 19.1149 2.25 19.0433 2.25 18.9688V3.03125C2.25 2.95666 2.27963 2.88512 2.33238 2.83238C2.38512 2.77963 2.45666 2.75 2.53125 2.75H21.4688C21.5433 2.75 21.6149 2.77963 21.6676 2.83238C21.7204 2.88512 21.75 2.95666 21.75 3.03125V18.9688C21.75 19.0433 21.7204 19.1149 21.6676 19.1676C21.6149 19.2204 21.5433 19.25 21.4688 19.25ZM19.5 14.9375V16.0625C19.5 16.3731 19.2481 16.625 18.9375 16.625H9.5625C9.25186 16.625 9 16.3731 9 16.0625V14.9375C9 14.6269 9.25186 14.375 9.5625 14.375H18.9375C19.2481 14.375 19.5 14.6269 19.5 14.9375ZM19.5 10.4375V11.5625C19.5 11.8731 19.2481 12.125 18.9375 12.125H9.5625C9.25186 12.125 9 11.8731 9 11.5625V10.4375C9 10.1269 9.25186 9.875 9.5625 9.875H18.9375C19.2481 9.875 19.5 10.1269 19.5 10.4375ZM19.5 5.9375V7.0625C19.5 7.37314 19.2481 7.625 18.9375 7.625H9.5625C9.25186 7.625 9 7.37314 9 7.0625V5.9375C9 5.62686 9.25186 5.375 9.5625 5.375H18.9375C19.2481 5.375 19.5 5.62686 19.5 5.9375ZM7.6875 6.5C7.6875 7.43197 6.93197 8.1875 6 8.1875C5.06803 8.1875 4.3125 7.43197 4.3125 6.5C4.3125 5.56803 5.06803 4.8125 6 4.8125C6.93197 4.8125 7.6875 5.56803 7.6875 6.5ZM7.6875 11C7.6875 11.932 6.93197 12.6875 6 12.6875C5.06803 12.6875 4.3125 11.932 4.3125 11C4.3125 10.068 5.06803 9.3125 6 9.3125C6.93197 9.3125 7.6875 10.068 7.6875 11ZM7.6875 15.5C7.6875 16.432 6.93197 17.1875 6 17.1875C5.06803 17.1875 4.3125 16.432 4.3125 15.5C4.3125 14.568 5.06803 13.8125 6 13.8125C6.93197 13.8125 7.6875 14.568 7.6875 15.5Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                        <div><a href="/category/index">{{ __('Categories') }}</a></div>
                    </li>



                    <li>
                        <div>
                            <svg viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="sidebar__logout-icon">
                                <path
                                    d="M9.79592 18.5363C9.79592 18.5771 9.80102 18.6791 9.81122 18.8424C9.82143 19.0057 9.82398 19.1409 9.81888 19.248C9.81378 19.3551 9.79847 19.475 9.77296 19.6077C9.74745 19.7403 9.69643 19.8398 9.6199 19.9062C9.54337 19.9725 9.43878 20.0057 9.30612 20.0057H4.40816C3.19388 20.0057 2.15561 19.5745 1.29337 18.7123C0.431122 17.85 0 16.8118 0 15.5975V4.82198C0 3.6077 0.431122 2.56943 1.29337 1.70719C2.15561 0.844941 3.19388 0.413818 4.40816 0.413818H9.30612C9.43878 0.413818 9.55357 0.462288 9.65051 0.559227C9.74745 0.656165 9.79592 0.770961 9.79592 0.903614C9.79592 0.944431 9.80102 1.04647 9.81122 1.20974C9.82143 1.373 9.82398 1.50821 9.81888 1.61535C9.81378 1.72249 9.79847 1.84239 9.77296 1.97504C9.74745 2.1077 9.69643 2.20719 9.6199 2.27351C9.54337 2.33984 9.43878 2.373 9.30612 2.373H4.40816C3.73469 2.373 3.15816 2.6128 2.67857 3.09239C2.19898 3.57198 1.95918 4.14851 1.95918 4.82198V15.5975C1.95918 16.271 2.19898 16.8475 2.67857 17.3271C3.15816 17.8067 3.73469 18.0465 4.40816 18.0465H9.18367L9.35969 18.0618L9.53571 18.1077L9.65816 18.1919L9.76531 18.3296L9.79592 18.5363ZM24 10.2097C24 10.475 23.9031 10.7046 23.7092 10.8985L15.3827 19.225C15.1888 19.4189 14.9592 19.5159 14.6939 19.5159C14.4286 19.5159 14.199 19.4189 14.0051 19.225C13.8112 19.0312 13.7143 18.8016 13.7143 18.5363V14.1281H6.85714C6.59184 14.1281 6.36225 14.0312 6.16837 13.8373C5.97449 13.6434 5.87755 13.4138 5.87755 13.1485V7.27096C5.87755 7.00566 5.97449 6.77606 6.16837 6.58219C6.36225 6.38831 6.59184 6.29137 6.85714 6.29137H13.7143V1.88321C13.7143 1.6179 13.8112 1.38831 14.0051 1.19443C14.199 1.00055 14.4286 0.903614 14.6939 0.903614C14.9592 0.903614 15.1888 1.00055 15.3827 1.19443L23.7092 9.52096C23.9031 9.71484 24 9.94443 24 10.2097Z"
                                    fill="currentColor" />
                            </svg>

                        </div>
                        <div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    



                </ul>

            </div>
        </div>

        <nav id="nav-admin">

            <div class="title-container">

                <!-- back button -->
                <button class="btn btn-primary d-none" id="back-button">
                    <svg width="15px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 10L3.29289 10.7071L2.58579 10L3.29289 9.29289L4 10ZM21 18C21 18.5523 20.5523 19 20 19C19.4477 19 19 18.5523 19 18L21 18ZM8.29289 15.7071L3.29289 10.7071L4.70711 9.29289L9.70711 14.2929L8.29289 15.7071ZM3.29289 9.29289L8.29289 4.29289L9.70711 5.70711L4.70711 10.7071L3.29289 9.29289ZM4 9L14 9L14 11L4 11L4 9ZM21 16L21 18L19 18L19 16L21 16ZM14 9C17.866 9 21 12.134 21 16L19 16C19 13.2386 16.7614 11 14 11L14 9Z" fill="white"/>
                        </svg>
                </button>


                <!-- sidebar button -->
                <button class="btn btn-primary" onclick="openSidebar()" id="open-sidebar-button">
                    <svg viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="open-sidebar-button">
                        <path d="M18 12H9V10H18V12ZM18 7H0V5H18V7ZM18 2H0V0H18V2Z" fill="currentColor" />
                    </svg>
                </button>
                <h3>@stack('title')</h3>

                @yield('buttonCorner')
                <a href="{{route('locations')}}" id="choose-location">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M12 21.1884L12.7212 20.3758C13.5395 19.4386 14.2755 18.5495 14.9303 17.7038L15.4709 16.9906C17.728 13.9495 18.8572 11.5358 18.8572 9.75179C18.8572 5.94379 15.7875 2.85693 12 2.85693C8.2126 2.85693 5.14288 5.94379 5.14288 9.75179C5.14288 11.5358 6.27203 13.9495 8.52917 16.9906L9.06974 17.7038C10.004 18.9008 10.9814 20.0623 12 21.1884Z" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 12.5712C13.578 12.5712 14.8572 11.292 14.8572 9.71408C14.8572 8.13612 13.578 6.85693 12 6.85693C10.4221 6.85693 9.14288 8.13612 9.14288 9.71408C9.14288 11.292 10.4221 12.5712 12 12.5712Z" stroke="#F9F9F9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

        </nav>

        <main style="background:#EDE7E3;" id="main-admin">

            <a href="/support" id="help-button">
                <button class="btn btn-primary">
                    {{__('Help')}}
                    <svg id='Online_Support_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                        <g transform="matrix(0.32 0 0 0.32 12 12)" >
                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: white; fill-rule: nonzero; opacity: 1;" transform=" translate(-32, -31)" d="M 31 0 C 18.652344 0 8.550781 9.78125 8.023438 22 L 7 22 C 4.242188 22 2 24.242188 2 27 L 2 41 C 2 43.757813 4.242188 46 7 46 L 10.183594 46 C 10.597656 47.160156 11.699219 48 13 48 C 14.652344 48 16 46.652344 16 45 L 16 23 C 16 21.347656 14.652344 20 13 20 C 11.699219 20 10.597656 20.839844 10.183594 22 L 10.050781 22 C 10.265625 17.515625 11.875 13.402344 14.476563 10.082031 L 19.003906 14.527344 C 19.785156 15.292969 20.800781 15.683594 21.8125 15.683594 C 22.703125 15.683594 23.59375 15.382813 24.328125 14.773438 C 26.472656 12.984375 29.199219 12 32 12 C 34.789063 12 37.507813 12.980469 39.652344 14.757813 C 41.222656 16.058594 43.511719 15.945313 44.980469 14.496094 L 49.488281 10.039063 C 52.109375 13.367188 53.734375 17.496094 53.949219 22 L 53.8125 22 C 53.402344 20.835938 52.300781 20 51 20 C 49.34375 20 48 21.34375 48 23 L 48 45 C 48 46.652344 49.34375 48 51 48 C 52.300781 48 53.402344 47.160156 53.8125 46 L 55 46 L 55 48 C 55 52.960938 50.964844 57 46 57 L 39.859375 57 C 39.410156 55.277344 37.859375 54 36 54 L 34 54 C 31.792969 54 30 55.792969 30 58 C 30 60.203125 31.792969 62 34 62 L 36 62 C 37.859375 62 39.410156 60.71875 39.859375 59 L 46 59 C 52.066406 59 57 54.0625 57 48 L 57 46 C 59.757813 46 62 43.753906 62 41 L 62 27 C 62 24.242188 59.757813 22 57 22 L 55.972656 22 C 55.449219 9.78125 45.347656 0 33 0 Z M 31 2 L 33 2 C 38.96875 2 44.351563 4.515625 48.175781 8.523438 L 43.574219 13.074219 C 42.839844 13.800781 41.703125 13.855469 40.925781 13.21875 C 38.425781 11.144531 35.257813 10 32 10 C 28.734375 10 25.554688 11.148438 23.046875 13.234375 C 22.277344 13.875 21.140625 13.820313 20.40625 13.097656 L 15.785156 8.566406 C 19.613281 4.53125 25.011719 2 31 2 Z M 32 4 C 31.445313 4 31 4.445313 31 5 L 31 7 C 31 7.554688 31.445313 8 32 8 C 32.554688 8 33 7.554688 33 7 L 33 5 C 33 4.445313 32.554688 4 32 4 Z M 37.425781 4.742188 C 37.042969 4.792969 36.707031 5.070313 36.597656 5.472656 L 36.078125 7.40625 C 35.9375 7.9375 36.253906 8.488281 36.785156 8.632813 C 36.875 8.652344 36.960938 8.664063 37.046875 8.664063 C 37.488281 8.664063 37.894531 8.371094 38.015625 7.921875 L 38.53125 5.992188 C 38.675781 5.457031 38.355469 4.910156 37.824219 4.765625 C 37.691406 4.730469 37.554688 4.722656 37.425781 4.742188 Z M 26.574219 4.742188 C 26.445313 4.722656 26.308594 4.730469 26.175781 4.765625 C 25.644531 4.910156 25.324219 5.457031 25.46875 5.992188 L 25.984375 7.921875 C 26.105469 8.371094 26.507813 8.664063 26.953125 8.664063 C 27.039063 8.664063 27.125 8.652344 27.214844 8.632813 C 27.746094 8.488281 28.0625 7.941406 27.921875 7.40625 L 27.402344 5.476563 C 27.292969 5.074219 26.957031 4.796875 26.574219 4.742188 Z M 21.125 6.886719 C 20.996094 6.902344 20.867188 6.945313 20.75 7.015625 C 20.269531 7.292969 20.109375 7.902344 20.386719 8.382813 L 21.386719 10.109375 C 21.570313 10.433594 21.90625 10.609375 22.25 10.609375 C 22.421875 10.609375 22.59375 10.570313 22.75 10.480469 C 23.230469 10.203125 23.390625 9.589844 23.113281 9.109375 L 22.113281 7.382813 C 21.910156 7.023438 21.511719 6.839844 21.125 6.886719 Z M 42.875 6.890625 C 42.484375 6.839844 42.089844 7.023438 41.886719 7.382813 L 40.886719 9.113281 C 40.609375 9.589844 40.769531 10.203125 41.25 10.480469 C 41.40625 10.570313 41.578125 10.613281 41.75 10.613281 C 42.09375 10.613281 42.429688 10.433594 42.613281 10.113281 L 43.613281 8.382813 C 43.890625 7.902344 43.726563 7.292969 43.25 7.015625 C 43.128906 6.945313 43.003906 6.90625 42.875 6.890625 Z M 13 22 C 13.550781 22 14 22.449219 14 23 L 14 45 C 14 45.550781 13.550781 46 13 46 C 12.449219 46 12 45.550781 12 45 L 12 23 C 12 22.449219 12.449219 22 13 22 Z M 51 22 C 51.550781 22 52 22.449219 52 23 L 52 45 C 52 45.550781 51.550781 46 51 46 C 50.449219 46 50 45.550781 50 45 L 50 23 C 50 22.449219 50.449219 22 51 22 Z M 7 24 L 10 24 L 10 44 L 7 44 C 5.347656 44 4 42.652344 4 41 L 4 27 C 4 25.347656 5.347656 24 7 24 Z M 54 24 L 57 24 C 58.652344 24 60 25.347656 60 27 L 60 41 C 60 42.652344 58.652344 44 57 44 L 54 44 Z M 34 56 L 36 56 C 37.101563 56 38 56.898438 38 58 C 38 59.101563 37.101563 60 36 60 L 34 60 C 32.898438 60 32 59.101563 32 58 C 32 56.898438 32.898438 56 34 56 Z" stroke-linecap="round" />
                        </g>
                    </svg>
                </button>
            </a>
            @yield('content')
        </main>
    </div>
</body>

<script>
    let sidebar = document.getElementById("sidebar")

    async function openSidebar() {
        sidebar.style.transition = "transform 0.3s ease-in-out"
        sidebar.style.transform = "translateX(0)"
    }

    function closeSidebar() {
        sidebar.style.transform = "translateX(-100%)"
    }

    function handleResize() {
        // Check if window width is greater than 1440px
        if (window.innerWidth > 1440) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }

    // Add event listener for resize event
    window.addEventListener('resize', handleResize);

    // Call handleResize once initially in case the window is already the right size
    handleResize();
</script>

</html>
