<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .day-title {
            color: #948b77;
            margin-top: 10px !important;
            margin-bottom: 0px;
        }

        .col-6 {
            width: 50%;
            float: right;
        }

        .category-icon {
            width: 12px;
        }

        .category-name {
            font-size: 12px;
            color: #876e4b;
            margin-bottom: 2px;
            display: inline-block;
            vertical-align: middle;
        }

        .category-line {
            vertical-align: middle;
            max-height: 10px;
            display: inline-block;
            width: 100%;
            margin-bottom: 10px !important;
            margin-top: 10px;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            width: 50%;
            vertical-align: top;
        }

        .day-title {
            font-weight: bold;
        }

        .category-icon {
            display: inline-block;
            vertical-align: middle;
        }

        .product-name {
            font-size: 8px;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            color: #292929
        }

        .allergens {
            color: #866c49;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            font-size: 8px !important;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        use Carbon\Carbon;
    @endphp

    <table>
        <!-- ... previous code ... -->
        <tr>
            @php
                $dayCount = 0;
            @endphp
            @foreach ($foods as $available_date => $foods_by_date)
                
        </tr>
        <tr>
            
            <td>
                <div class="day-title">{{ getDayName($available_date) }}</div>
                <table style="width: 100%;">
                    <tr>
                        @php
                            $productCount = 0;
                        @endphp
                        @foreach ($foods_by_date as $food)
                            @if ($productCount % 3 == 0 && $productCount != 0)
                    </tr>
                    <tr>
                        @endif
                        <td style="width: 50%;">
                            <div class="category-line">
                                <img src="{{ $food->category_icon_link }}" class="category-icon" />
                                <span class="category-name">{{ $food->category_name }}</span>
                            </div>
                            <!-- NAME + PRICE -->
                            <p class="product-name" style="margin-bottom: 0px !important;padding-right:10px;">
                                {{ $food->name }} - {{ $food->price }}€
                            </p>
                            <!-- DESCRIPTION + ALLERGENS -->
                            <p class="product-name description">
                                @if ($food->allergens != '')
                                    <span class="allergens"> ({{ $food->allergens }}) </span>
                                @endif
                                {{ $food->description }}
                            </p>
                        </td>
                        @php
                            $productCount++;
                        @endphp
                        @endforeach
                    </tr>
                </table>
            </td>
            @php
                $dayCount++;
            @endphp
            @endforeach
        </tr>
        <!-- ... next code ... -->

    </table>


    <div class="footer">
        @foreach ($allergens as $allergen)
            <span class="category-name" style="margin-left: 10px;">{{ $allergen->shortcode }} - {{ $allergen->name }}
                |</span>
        @endforeach
    </div>



</body>

</html>
