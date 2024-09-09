@extends('layouts.adminLayout')

@push('title')
    {{ __('Dashboard') }}
    <script src="{{ asset('js/goback.js') }}" defer></script>
@endpush

@section('content')
    <div class="container">

        <!-- HELLO MESSAGE -->
        <div class="categories-index-container">
            <h1 class="h1-primary">{{__('Hello')}}!</h1>
            <h1 class="h1-secondary"> {{ $user->name }} </h1>
            <h2 class="h3-secondary"> {{ $location->name }} </h1>
        
        </div>
                
        <!-- Dashboard cards -->
        <div class="public-events-index-container">
            <div class="public-events-list">

                <!-- STOCKTAKING contiue or start -->
                <a class="public-events-list__item card-button" 
                    @if(getOpenedStocktakingID(auth()->user()) == null )
                        href="{{route('mystocktaking.create')}}"
                    @else 
                        href="{{route('mystocktaking.app',getOpenedStocktakingID(auth()->user()))}}"
                    @endif
                    >
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="32" viewBox="0 0 29 32" fill="none">
                            <path d="M25.1156 8.32127C25.3911 8.59904 25.6272 8.97603 25.8239 9.45222C26.0207 9.92841 26.1191 10.3649 26.1191 10.7617V27.9046C26.1191 28.3014 25.9813 28.6387 25.7059 28.9165C25.4304 29.1943 25.0959 29.3332 24.7024 29.3332H4.86906C4.47554 29.3332 4.14105 29.1943 3.86559 28.9165C3.59012 28.6387 3.45239 28.3014 3.45239 27.9046V4.09508C3.45239 3.69825 3.59012 3.36095 3.86559 3.08317C4.14105 2.80539 4.47554 2.6665 4.86906 2.6665H18.0913C18.4848 2.6665 18.9177 2.76571 19.3899 2.96412C19.8621 3.16254 20.236 3.40063 20.5114 3.67841L25.1156 8.32127ZM18.5635 4.69031V10.2856H24.1121C24.0137 9.99785 23.9055 9.79448 23.7875 9.67543L19.1685 5.01769C19.0505 4.89865 18.8488 4.78952 18.5635 4.69031ZM24.2302 27.4284V12.1903H18.0913C17.6978 12.1903 17.3633 12.0514 17.0878 11.7736C16.8123 11.4959 16.6746 11.1586 16.6746 10.7617V4.57127H5.34128V27.4284H24.2302Z" fill="#FDA53C"/>
                            <path d="M20.4524 18.6667H15.4524V23.6667H13.7858V18.6667H8.78577V17H13.7858V12H15.4524V17H20.4524V18.6667Z" fill="#FDA53C"/>
                            </svg>

                            @if(getOpenedStocktakingID(auth()->user()) == null )
                                <h2 class="h3-secondary"> {{ __('Start stocktaking') }}</h1>
                            @else 
                                <h2 class="h3-secondary"> {{ __('Continue stocktaking') }}</h1>
                            @endif
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

                <!-- Delivery  -->
                <a class="public-events-list__item card-button" 
                
                    @if(getOpenedDeliveryID(auth()->user()) == null)
                        href="{{route('delivery.create')}}" 
                    @else 
                        href="{{route('delivery.app',getOpenedDeliveryID(auth()->user()))}}"
                    @endif
                    
                    
                >
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                            <g clip-path="url(#clip0_1261_556)"> <path d="M22.412 4C22.836 4.00008 23.2538 4.10124 23.6308 4.2951C24.0079 4.48895 24.3333 4.76991 24.58 5.11467L24.6987 5.29467L27.9307 10.6813C28.2492 11.2126 28.44 11.8105 28.488 12.428L28.5 12.7387V25.3333C28.5002 26.0061 28.2461 26.6541 27.7887 27.1474C27.3312 27.6407 26.7042 27.9429 26.0333 27.9933L25.8333 28H7.16667C6.4939 28.0002 5.84591 27.7461 5.3526 27.2887C4.85929 26.8312 4.55712 26.2042 4.50667 25.5333L4.5 25.3333V12.7387C4.50004 12.1185 4.64428 11.5068 4.92133 10.952L5.07067 10.68L8.3 5.29467C8.51814 4.93086 8.81992 4.62434 9.18028 4.40057C9.54064 4.17679 9.94919 4.04221 10.372 4.008L10.588 4H22.412ZM25.8333 13.3333H7.16667V25.3333H25.8333V13.3333ZM15.1667 6.66667H10.588L8.188 10.6667H15.1667V6.66667ZM22.412 6.66667H17.8333V10.6667H24.812L22.412 6.66667Z" fill="#FDA53C"/></g><defs><clipPath id="clip0_1261_556"> <rect width="32" height="32" fill="white" transform="translate(0.5)"/></clipPath></defs>
                        </svg>
                        <h2 class="h3-secondary"> 
                            @if(getOpenedDeliveryID(auth()->user()) == null)
                                {{ __('New delivery') }} 
                            @else 
                                {{ __('Continue Delivery') }} 
                            @endif
                            
                        </h1>
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

                <!-- View stocktakings -->
                <a class="public-events-list__item card-button" href="{{route('stocktaking.index')}}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                            <path d="M18.5 31H6.5C5.4 31 4.5 30.1 4.5 29V12H6.5V29H18.5V31Z" fill="#FDA53C"/>
                            <path d="M22.5 27H10.5C9.4 27 8.5 26.1 8.5 25V8H10.5V25H22.5V27Z" fill="#FDA53C"/>
                            <path d="M16.5 16H24.5V18H16.5V16Z" fill="#FDA53C"/>
                            <path d="M28.2 9.3L21.2 2.3C21 2.1 20.8 2 20.5 2H14.5C13.4 2 12.5 2.9 12.5 4V21C12.5 22.1 13.4 23 14.5 23H26.5C27.6 23 28.5 22.1 28.5 21V10C28.5 9.7 28.4 9.5 28.2 9.3ZM20.5 4.4L26.1 10H20.5V4.4ZM26.5 21H14.5V4H18.5V10C18.5 11.1 19.4 12 20.5 12H26.5V21Z" fill="#FDA53C"/>
                          </svg>
                        <h2 class="h3-secondary"> {{ __('Stocktakings archive') }} </h1>
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

                <!-- Needing list -->
                <a class="public-events-list__item card-button" href="{{route('needing.index')}}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg id='Todo_List_24' width='32' height='32' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                            <g transform="matrix(1.54 0 0 1.54 12 12)" >
                                <path fill="#FDA53C" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; fill-rule: nonzero; opacity: 1;" transform=" translate(-8.51, -7.43)" d="M 5.648438 1.648438 L 3.5 3.792969 L 2.726563 3.023438 L 2.023438 3.726563 L 3.5 5.207031 L 6.351563 2.351563 Z M 8 3 L 8 4 L 15 4 L 15 3 Z M 5.648438 5.648438 L 3.5 7.792969 L 2.726563 7.023438 L 2.023438 7.726563 L 3.5 9.207031 L 6.351563 6.351563 Z M 8 7 L 8 8 L 15 8 L 15 7 Z M 5.648438 9.648438 L 3.5 11.792969 L 2.726563 11.019531 L 2.023438 11.730469 L 3.5 13.207031 L 6.351563 10.355469 Z M 8 11 L 8 12 L 15 12 L 15 11 Z" stroke-linecap="round" />
                            </g>
                        </svg>
                        <h2 class="h3-secondary"> {{ __('Needing list') }} </h1>
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

                <!-- Manage products -->
                <a class="public-events-list__item card-button" href="{{route('product.index')}}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                            <path d="M3.16663 28V25.3333H27.1666V28H3.16663ZM27.1666 10.6667V6.66667H24.5V10.6667H27.1666ZM27.1666 4C27.8739 4 28.5521 4.28095 29.0522 4.78105C29.5523 5.28115 29.8333 5.95942 29.8333 6.66667V10.6667C29.8333 11.3739 29.5523 12.0522 29.0522 12.5523C28.5521 13.0524 27.8739 13.3333 27.1666 13.3333H24.5V17.3333C24.5 18.7478 23.9381 20.1044 22.9379 21.1046C21.9377 22.1048 20.5811 22.6667 19.1666 22.6667H11.1666C9.75214 22.6667 8.39558 22.1048 7.39539 21.1046C6.3952 20.1044 5.83329 18.7478 5.83329 17.3333V4H27.1666ZM21.8333 6.66667H8.49996V17.3333C8.49996 18.0406 8.78091 18.7189 9.28101 19.219C9.7811 19.719 10.4594 20 11.1666 20H19.1666C19.8739 20 20.5521 19.719 21.0522 19.219C21.5523 18.7189 21.8333 18.0406 21.8333 17.3333V6.66667Z" fill="#FDA53C"/>
                        </svg>
                        <h2 class="h3-secondary"> {{ __('Manage products') }} </h1>
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

                <!-- Change location -->
                <a class="public-events-list__item card-button" href="{{route('locations')}}">
                    <!-- ICON -->
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 28.2515L17.4615 27.168C18.5525 25.9185 19.5339 24.733 20.407 23.6054L21.1278 22.6545C24.1373 18.5997 25.6428 15.3814 25.6428 13.0027C25.6428 7.92538 21.5499 3.80957 16.5 3.80957C11.4501 3.80957 7.35712 7.92538 7.35712 13.0027C7.35712 15.3814 8.86264 18.5997 11.8722 22.6545L12.5929 23.6054C13.8385 25.2014 15.1418 26.7501 16.5 28.2515Z" stroke="#FDA53C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 16.762C18.6039 16.762 20.3095 15.0564 20.3095 12.9524C20.3095 10.8485 18.6039 9.1429 16.5 9.1429C14.396 9.1429 12.6904 10.8485 12.6904 12.9524C12.6904 15.0564 14.396 16.762 16.5 16.762Z" stroke="#FDA53C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h2 class="h3-secondary"> {{ __('Change location') }} </h1>
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
