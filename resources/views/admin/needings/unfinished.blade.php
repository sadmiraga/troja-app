@extends('layouts.adminLayout')

@section('css')
    <style>
        #choose-location,#open-sidebar-button, #back-button{
            display: none;
        }
    </style>
@endsection

@section('content')
    @push('title')
        {{ __('Unfinished needing list') }} !
    @endpush

    <div id="app">

        <!-- DELETE modal -->
        <div class="modal fade warning-popup" id="delete-stocktaking">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header close -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="p-bold">{{__('Are you sure you want to delete unfinished needing list?')}}</h3>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                            <button class="save-button" type="button" data-bs-dismiss="modal">
                                {{__('No')}}
                            </button>

                            <!-- YES -->
                            <a class="w-100" href="{{route('needing.delete',$needing->id)}}">
                                <button class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    {{__('Yes')}}
                                </button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SAVE modal -->
        <div class="modal fade warning-popup" id="save-stocktaking">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header close -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="p-bold">{{__('Are you sure you want to save unfinished needing list?')}}</h3>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">
                            <button class="save-button" type="button" data-bs-dismiss="modal">
                                {{__('No')}}
                            </button>

                            <!-- YES -->
                            <form method="POST" action="{{ route('needing.complete') }}" class="w-100">
                                @csrf
                                <input  type="hidden" name="needing_id" value="{{$needing->id}}">
                                <input type="hidden" name="from_blade" value={{true}}>
                                
                                <button type="su" class="drinks-food-create-edit__add-allergens-button" style="border: 2px solid #1C6979;">
                                    {{__('Yes')}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="drinks-food-create__container">
            <div class="drinks-food-create__container">

                <!-- INFORMATION -->
                <div class="drinks-food-create-edit__form-container">

                    <p class="p-info">{{ __('You didnt complete needing list on your last login. Please choose some of offered options') }}</p>

                    <!-- DATE -->
                    <p class="p-info">
                        <span class="p-bold">{{__('Start Date')}}: </span>
                        <span>{{timestampToDate($needing->created_at)}}</span>
                    </p>

                    <!-- DATE -->
                    <p class="p-info">
                        <span class="p-bold">{{__('Start Time')}}: </span>
                        <span>{{timestampToTime($needing->created_at)}}</span>
                    </p>

                    <!-- LOCATION -->
                    <p class="p-info">
                        <span class="p-bold">{{__('Location')}}: </span>
                        <span>{{$location->name}}</span>
                    </p>

                    <!-- LOCATION -->
                    <p class="p-info">
                        <span class="p-bold">{{__('Storage')}}: </span>
                        <span>{{$needing->storage}}</span>
                    </p>

                </div>

                <!-- delete & save -->
                <div class="drinks-food-create-edit__bottom-buttons two-button-wrapper">

                    <!-- delete -->
                    <button class="delete-button" data-bs-toggle="modal" data-bs-target="#delete-stocktaking">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20"
                            fill="none">
                            <path
                                d="M17.5 3C17.7652 3 18.0196 3.10536 18.2071 3.29289C18.3946 3.48043 18.5 3.73478 18.5 4C18.5 4.26522 18.3946 4.51957 18.2071 4.70711C18.0196 4.89464 17.7652 5 17.5 5H16.5L16.497 5.071L15.564 18.142C15.5281 18.6466 15.3023 19.1188 14.9321 19.4636C14.5619 19.8083 14.0749 20 13.569 20H5.43C4.92414 20 4.43707 19.8083 4.06688 19.4636C3.6967 19.1188 3.47092 18.6466 3.435 18.142L2.502 5.072C2.50048 5.04803 2.49982 5.02402 2.5 5H1.5C1.23478 5 0.98043 4.89464 0.792893 4.70711C0.605357 4.51957 0.5 4.26522 0.5 4C0.5 3.73478 0.605357 3.48043 0.792893 3.29289C0.98043 3.10536 1.23478 3 1.5 3H17.5ZM14.497 5H4.503L5.431 18H13.569L14.497 5ZM11.5 0C11.7652 0 12.0196 0.105357 12.2071 0.292893C12.3946 0.48043 12.5 0.734784 12.5 1C12.5 1.26522 12.3946 1.51957 12.2071 1.70711C12.0196 1.89464 11.7652 2 11.5 2H7.5C7.23478 2 6.98043 1.89464 6.79289 1.70711C6.60536 1.51957 6.5 1.26522 6.5 1C6.5 0.734784 6.60536 0.48043 6.79289 0.292893C6.98043 0.105357 7.23478 0 7.5 0H11.5Z"
                                fill="currentColor" />
                        </svg>
                        <span>
                            {{__('Delete')}}
                        </span>
                    </button>

                    <!-- Save -->
                    <button class="save-button" data-bs-toggle="modal" data-bs-target="#save-stocktaking">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                            fill="none">
                            <path
                                d="M6.5 4.5C6.10218 4.5 5.72064 4.65804 5.43934 4.93934C5.15804 5.22064 5 5.60218 5 6V18C5 18.3978 5.15804 18.7794 5.43934 19.0607C5.72064 19.342 6.10218 19.5 6.5 19.5V14.25C6.5 13.6533 6.73705 13.081 7.15901 12.659C7.58097 12.2371 8.15326 12 8.75 12H16.25C16.8467 12 17.419 12.2371 17.841 12.659C18.2629 13.081 18.5 13.6533 18.5 14.25V19.5C18.8978 19.5 19.2794 19.342 19.5607 19.0607C19.842 18.7794 20 18.3978 20 18V8.4315C19.9999 8.03371 19.8418 7.65224 19.5605 7.371L17.129 4.9395C16.8478 4.65818 16.4663 4.50008 16.0685 4.5H15.5V6.75C15.5 7.34674 15.2629 7.91903 14.841 8.34099C14.419 8.76295 13.8467 9 13.25 9H10.25C9.65326 9 9.08097 8.76295 8.65901 8.34099C8.23705 7.91903 8 7.34674 8 6.75V4.5H6.5ZM9.5 4.5V6.75C9.5 6.94891 9.57902 7.13968 9.71967 7.28033C9.86032 7.42098 10.0511 7.5 10.25 7.5H13.25C13.4489 7.5 13.6397 7.42098 13.7803 7.28033C13.921 7.13968 14 6.94891 14 6.75V4.5H9.5ZM17 19.5V14.25C17 14.0511 16.921 13.8603 16.7803 13.7197C16.6397 13.579 16.4489 13.5 16.25 13.5H8.75C8.55109 13.5 8.36032 13.579 8.21967 13.7197C8.07902 13.8603 8 14.0511 8 14.25V19.5H17ZM3.5 6C3.5 5.20435 3.81607 4.44129 4.37868 3.87868C4.94129 3.31607 5.70435 3 6.5 3H16.0685C16.8641 3.00017 17.627 3.31635 18.1895 3.879L20.621 6.3105C21.1836 6.87298 21.4998 7.63592 21.5 8.4315V18C21.5 18.7956 21.1839 19.5587 20.6213 20.1213C20.0587 20.6839 19.2956 21 18.5 21H6.5C5.70435 21 4.94129 20.6839 4.37868 20.1213C3.81607 19.5587 3.5 18.7956 3.5 18V6Z"
                                fill="#1C6979" />
                        </svg>
                        <span>
                            {{__('Save')}}
                        </span>
                    </button>
                </div>

                <!-- Continue -->
                <div class="drinks-food-create-edit__bottom-buttons mt-3">
                    <a class="w-100" href="{{route('needing.app',$needing->id)}}">
                    <button>{{__('Continue needing list')}}</button>
                    </a>
                </div>
                

            </div>
        </div>


    </div>

@endsection