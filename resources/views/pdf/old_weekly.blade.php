<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .day-title {
            color: #cbbfa2;
            margin-top: 30px;
            margin-bottom: 0px;
        }

        .col-6 {
            width: 50%;
            float: right;
        }

        .category-icon {
            width: 18px;
        }

        .category-name {
            font-size: 14px;
            color: #C39F6D;
            margin-bottom: 2px;
            display: inline-block;
            vertical-align: middle;
        }

        .category-line {
            vertical-align: middle;
            height: 30px;
            max-height: 15px;
            display: inline-block;
            width: 100%;
            margin-bottom: 10px !important;
            margin-top: 22px;
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
            font-size: 12px;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            color: #707070
        }

        .allergens {
            color: #C39F6D;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            font-size: 12px;
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
        <tr>
            @php
                $dayCount = 0;
            @endphp
            @foreach ($foods as $available_date => $foods_by_date)
                @if ($dayCount % 2 == 0 && $dayCount != 0)
        </tr>
        <tr>
            @endif
            <td>
                <div class="day-title">{{ getDayName($available_date) }}</div>
                @foreach ($foods_by_date as $food)
                    <div class="category-line">
                        <img src="{{ $food->category_icon_link }}" class="category-icon" />
                        <span class="category-name">{{ $food->category_name }}</span>
                    </div>

                    <!-- NAME + PRICE -->
                    <p class="product-name" style="margin-bottom: 0px !important;">
                        {{ $food->name }} - {{ $food->price }}€
                    </p>

                    <!-- DESCRIPTION + ALLERGENS -->
                    <p class="product-name description">
                        @if ($food->allergens != '')
                            <span class="allergens"> ({{ $food->allergens }}) </span>
                        @endif
                        {{ $food->description }}
                    </p>
                @endforeach
            </td>
            @php
                $dayCount++;
            @endphp
            @endforeach
        </tr>
    </table>


    <div class="footer">
        @foreach ($allergens as $allergen)
            <span class="category-name" style="margin-left: 10px;">{{ $allergen->shortcode }} - {{ $allergen->name }}
                |</span>
        @endforeach
    </div>



</body>

</html>
