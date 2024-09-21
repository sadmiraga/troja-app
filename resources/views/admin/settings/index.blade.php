@extends('layouts.adminLayout')

@push('title')
    Settings
    <script src="{{ asset('js/goback.js') }}" defer></script>
@endpush


@section('content')
    <div class="container">

        <!-- HELLO MESSAGE -->
        <div class="categories-index-container">
            <h1 class="h1-primary">Settings</h1>
        </div>

        <!-- Dashboard cards -->
        <div class="public-events-index-container">
            <div class="public-events-list">

                <!-- Style -->
                <a class="public-events-list__item card-button" href="{{ route('settings.style') }}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg fill="#FCA53B" width="33" height="33" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M517.257 1127.343c72.733 0 148.871 36.586 221.274 107.45 87.455 110.418 114.922 204.135 81.632 278.296-72.733 162.274-412.664 234.897-618.666 259.178 34.609-82.62 75.15-216.88 75.15-394.645 0-97.123 66.47-195.455 157.88-233.689 26.698-11.097 54.494-16.59 82.73-16.59Zm229.404-167.109c54.055 28.895 106.462 65.371 155.133 113.494l13.844 15.6c28.016 35.378 50.649 69.987 70.425 104.155-29.554 26.259-59.878 52.737-90.75 79.545-18.898-35.488-43.069-71.964-72.843-109.319l-4.285-4.834c-48.342-47.683-99.43-83.39-151.727-107.011 26.368-30.653 53.066-61.196 80.203-91.63Zm1046.49-803.133c7.801 7.8 18.129 21.754 16.92 52.187-6.043 155.683-284.338 494.405-740.509 909.266-19.995-32.302-41.969-64.822-67.788-97.453l-22.523-25.27c-49.22-48.671-101.408-88.883-156.012-121.074 350.588-385.855 728.203-734.356 910.254-741.828 30.983-.109 44.497 9.01 59.658 24.172Zm126.678 56.472c2.087-53.615-14.832-99.98-56.142-141.29-34.28-34.279-81.962-51.198-134.588-49.11-304.554 12.414-912.232 683.377-1179.54 996.17-53.616-5.383-106.682 2.088-157.441 23.402-132.61 55.263-225.339 193.038-225.339 334.877 0 268.517-103.935 425.737-104.923 427.275L0 1896.747l110.307-6.153c69.217-3.735 681.29-45.375 810.165-332.46 24.39-54.604 29.225-113.163 15.93-175.239 374.32-321.802 972.11-879.71 983.427-1169.322" />
                        </svg>
                        <h2 class="h3-secondary"> Style </h1>
                    </div>
                    <!-- button icon -->
                    <div class="card-footer">
                        <div class="card-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Menu settings. -->
                <a class="public-events-list__item card-button" href="{{ route('settings.menu.settings') }}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg fill="#FCA53B" width="33" height="33" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 2h2v20H3zm7 4h7v2h-7zm0 4h7v2h-7z" />
                            <path d="M19 2H6v20h13c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 18H8V4h11v16z" />
                        </svg>
                        <h2 class="h3-secondary"> Menu Settings </h1>
                    </div>
                    <!-- button icon -->
                    <div class="card-footer">
                        <div class="card-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Locations -->
                <a class="public-events-list__item card-button" href="{{ route('settings.locations') }}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.5 28.2515L17.4615 27.168C18.5525 25.9185 19.5339 24.733 20.407 23.6054L21.1278 22.6545C24.1373 18.5997 25.6428 15.3814 25.6428 13.0027C25.6428 7.92538 21.5499 3.80957 16.5 3.80957C11.4501 3.80957 7.35712 7.92538 7.35712 13.0027C7.35712 15.3814 8.86264 18.5997 11.8722 22.6545L12.5929 23.6054C13.8385 25.2014 15.1418 26.7501 16.5 28.2515Z"
                                stroke="#FDA53C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M16.5 16.762C18.6039 16.762 20.3095 15.0564 20.3095 12.9524C20.3095 10.8485 18.6039 9.1429 16.5 9.1429C14.396 9.1429 12.6904 10.8485 12.6904 12.9524C12.6904 15.0564 14.396 16.762 16.5 16.762Z"
                                stroke="#FDA53C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h2 class="h3-secondary"> Locations </h1>
                    </div>
                    <!-- button icon -->
                    <div class="card-footer">
                        <div class="card-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Languages -->
                <a class="public-events-list__item card-button" href="{{ route('settings.languages') }}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg width="33" height="33" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#FDA53C" class="bi bi-translate">
                            <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286H4.545zm1.634-.736L5.5 3.956h-.049l-.679 2.022H6.18z"/>
                            <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2zm7.138 9.995c.193.301.402.583.63.846-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6.066 6.066 0 0 1-.415-.492 1.988 1.988 0 0 1-.94.31z"/>
                          </svg>
                        <h2 class="h3-secondary"> Languages </h1>
                    </div>
                    <!-- button icon -->
                    <div class="card-footer">
                        <div class="card-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M4.79999 12.0001L8.79999 8.0001L4.79999 4.0001L5.59999 2.4001L11.2 8.0001L5.59999 13.6001L4.79999 12.0001Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>

    </div>
@endsection
