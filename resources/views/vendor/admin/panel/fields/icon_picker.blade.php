{{-- icon picker input --}}

<?php
    // if no iconset was provided, set the default iconset to Font-Awesome
    if (!isset($field['iconset'])) {
        $field['iconset'] = 'fontawesome';
    }
?>

<div @include('admin::panel.inc.field_wrapper_attributes') >
    <label class="form-label fw-bolder">{!! $field['label'] !!}</label>
    @include('admin::panel.fields.inc.translatable_icon')

    <div>
        <button class="btn btn-secondary " role="iconpicker" data-icon="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}" data-iconset="{{ $field['iconset'] }}"></button>
        <input
            type="hidden"
            name="{{ $field['name'] }}"
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('admin::panel.inc.field_attributes')
        >
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <div class="form-text">{!! $field['hint'] !!}</div>
    @endif
</div>


@if ($xPanel->checkIfFieldIsFirstOfItsType($field, $fields))

    @if($field['iconset'] == 'glyphicon')
        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Glyphicon -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-glyphicon.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'ionicon')
        @push('crud_fields_styles')
            {{-- Ionicons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/ionicons-1.5.2/css/ionicons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Ionicons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-ionicon-1.5.2.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'weathericon')
        @push('crud_fields_styles')
            {{-- Weather Icons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/weather-icons-1.2.0/css/weather-icons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Weather Icons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-weathericon-1.2.0.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'mapicon')
        @push('crud_fields_styles')
            {{-- Map Icons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/map-icons-2.1.0/css/map-icons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Map Icons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-mapicon-2.1.0.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'octicon')
        @push('crud_fields_styles')
            {{-- Octicons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/octicons-2.1.2/css/octicons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Octicons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-octicon-2.1.2.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'typicon')
        @push('crud_fields_styles')
            {{-- Typicons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/typicons-2.0.6/css/typicons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Typicons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-typicon-2.0.6.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'elusiveicon')
        @push('crud_fields_styles')
            {{-- Elusive Icons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Elusive Icons -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-elusiveicon-2.0.0.min.js') }}"></script>
        @endpush
    @elseif($field['iconset'] == 'materialdesign')
        @push('crud_fields_styles')
            {{-- Material Icons --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/material-design-1.1.1/css/material-design-iconic-font.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Material Design -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-materialdesign-1.1.1.min.js') }}"></script>
        @endpush
    @else
        @push('crud_fields_styles')
            {{-- Font Awesome --}}
            <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css') }}"/>
        @endpush

        @push('crud_fields_scripts')
            <!-- Bootstrap-Iconpicker Iconset for Font Awesome -->
            <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.2.0.min.js') }}"></script>
        @endpush
    @endif

    {{-- FIELD EXTRA CSS  --}}
    @push('crud_fields_styles')
        <!-- Bootstrap-Iconpicker -->
        <link rel="stylesheet" href="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}"/>
    @endpush

    {{-- FIELD EXTRA JS --}}
    @push('crud_fields_scripts')
        <!-- Bootstrap-Iconpicker -->
        <script type="text/javascript" src="{{ asset('vendor/admin/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js') }}"></script>

        {{-- Bootstrap-Iconpicker - set hidden input value --}}
        <script>
            jQuery(document).ready(function($) {
                $('button[role=iconpicker]').on('change', function(e) {
                    $(this).siblings('input[type=hidden]').val(e.icon);
                });
            });
        </script>
    @endpush

@endif


{{-- Note: you can use @if ($xPanel->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}