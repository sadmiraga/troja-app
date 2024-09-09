<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            height: 100%;
            margin: 0;
        }

        .category-title {
            color: #cbbfa2;
            font-weight: bold;
            clear: both;
            margin-bottom: 5px !important;
            margin-top: 0px !important;
            font-size: 16px;
        }

        .category-title:nth-child(1) {
            margin-top: 0px !important;
        }

        .col-6 {
            width: 50%;
            float: left;
            box-sizing: border-box;
            padding: 0 10px;
        }

        .product-name {
            font-size: 12px;
            margin-top: 10px !important;
            margin-bottom: 0px !important;
            color: #707070;
        }

        .description{
            margin-bottom: 0px !important;
            margin-top: 0px !important;
        }

        .product-name-price {
            color: #555555;
        }

        .wrapper {
            min-height: 100%;
            position: relative;
        }

        .footer {
            position: fixed;
            bottom: 0;
            text-align: center
        }

        .footer .allergen-name {
            margin-left: 10px;
            font-size: 14px;
            color: #C39F6D;
            margin-bottom: 2px;
        }

        .product-allergens {
            color: #C39F6D;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            font-size: 12px;
        }

        .mb-3{
            width: 100%;
            border:1px solid black;
            position: relative;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <div class="content">
            @foreach ($foods as $category_id => $foodInCategory)
                <h2 class="category-title">{{ getCategoryName($category_id) }}</h2>

                <div>
                    @foreach ($foodInCategory as $index => $food)
                        <div class="col-6">
                            <!-- NAME + PRICE -->
                            <p class="product-name">
                                {{ $food->name }}
                                @if ($food->weight != null || $food->weight != '')
                                    {{ $food->weight }}g
                                @endif
                                -
                                <span class="product-name-price">{{ $food->price }}€</span>
                            </p>

                            <p class="product-name description"
                            @if($loop->last)
                                style="margin-bottom:40px !important;"
                            @endif
                            >
                                @if ($food->allergens != '' && $food->allergens != null)
                                    <span class="product-allergens"> ({{ $food->allergens }}) </span>
                                @endif
                                {{ $food->description }}
                            </p>
                        </div>

                        

                        @if (($index + 1) % 2 == 0)
                            <div style="clear:both;"></div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

        <br>
        <br>

        <!-- Footer (only appears once, at the end of the content) -->
        <div class="footer">
            @foreach ($allergens as $allergen)
                <span class="allergen-name">{{ $allergen->shortcode }} - {{ $allergen->name }} | </span>
            @endforeach
        </div>


    </div>

</body>

</html>
