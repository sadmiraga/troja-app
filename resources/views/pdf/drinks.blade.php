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
            margin-bottom: 0px;
            font-weight: bold;
            clear: both;
            margin-top: 30px;
            margin-bottom: 5px;
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
            margin-top: 0px !important;
            margin-bottom: 5px !important;
            color: #707070;
        }

        .product-name-price {
            color: #555555;
        }

        .wrapper {
            min-height: 100%;
            position: relative;
        }

        .footer{
            position: fixed;
            bottom: 0;
            text-align: center
        }

        .footer .allergen-name{
            margin-left: 10px;
            font-size: 14px;
            color: #C39F6D;
            margin-bottom: 2px;        
        }

        .product-allergens{
            color: #C39F6D;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            font-size: 12px;
        }


        
    </style>
</head>

<body>

    <div class="wrapper">

        <div class="content">
            @foreach ($drinks as $category_id => $drinksInCategory)
                <h2 class="category-title">{{ getCategoryName($category_id) }}</h2>
                <div>
                    @foreach ($drinksInCategory as $index => $drink)
                        <div class="col-6">
                            <!-- NAME + PRICE -->
                            <p class="product-name" style="margin-bottom: 0px !important;margin-top:10px;">
                                {{ $drink->name }}
                                @if ($drink->packing_size != null || $drink->packing_size != '')
                                    {{ $drink->packing_size }}l
                                @endif
                                -
                                <span class="product-name-price">{{ $drink->price }}€</span>
                            </p>

                            <p class="product-name description">
                                @if ($drink->allergens != '' && $drink->allergens != null)
                                    <span class="product-allergens"> ({{ $drink->allergens }}) </span>
                                @endif
                                {{ $drink->description }}
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
