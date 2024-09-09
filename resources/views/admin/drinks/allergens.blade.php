@extends('layouts.adminLayout')


@section('content')

@push('title')
Dodaj alergene
@endpush

<div class="drinks-food-allergens__container">
  <ol class="drinks-food-allergens__list-container">
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Gluten</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Raki</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Jajca</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <!-- Repeat the list items for these items: Ribe, Arašidi, Soja, Laktoza, Oreški, Zelena, Gorčično  seme, Sezamovo seme, Žveplov dioksid, Voljči bob, Mehkužci -->
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Ribe</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Arašidi</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Soja</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Laktoza</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox" checked>
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Oreški</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Zelena</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Gorčično seme</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Sezamovo seme</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Žveplov dioksid</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Voljči bob</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
    <li>
      <div class="drinks-food-allergens__allergen-container">
        <div class="drinks-food-allergens__allergen-name">Mehkužci</div>
        <div class="drinks-food-allergens__allergen-switch">
          <label class="switch">
            <input type="checkbox">
            <div class="slider round" />
          </label>
        </div>
      </div>
    </li>
  </ol>
  <div class="drinks-food-allergens__bottom-buttons">
    <button>Nazaj na podatke</button>
    <button>Dodaj izdelek</button>
  </div>
</div>


@endsection