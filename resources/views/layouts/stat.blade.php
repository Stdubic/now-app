<a class="m-pricing-table-1__item col-lg-3 m-link" href="{{ isset($route) && getUser()->canViewRoute($route) ? route($route) : '#' }}">
    <div class="m-pricing-table-1__visual">
        <div class="m-pricing-table-1__hexagon1"></div>
        <div class="m-pricing-table-1__hexagon2"></div>
        <span class="m-pricing-table-1__icon m--font-{{ $color }}"><i class="{{ $icon }}"></i></span>
    </div>
    <span class="m-pricing-table-1__price">{{ $title }}<span class="m-pricing-table-1__label">{{ $label ?? '' }}</span></span>
    <h2 class="m-pricing-table-1__subtitle">{{ strtoupper($subtitle) }}</h2>
</a>
