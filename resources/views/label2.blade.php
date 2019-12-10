<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \Laravel\Nova\Nova::name() }}</title>

    <!-- Fonts -->
    <link href="{{ mix('google-font-nunito.css', 'vendor/unilatex') }}" rel="stylesheet">

    {{--    <link rel="stylesheet" href="{{ mix('web.css', '/vendor/unilatex') }}">--}}

    <style>

        @media print {
            .page-break { height:0; page-break-before:always; margin:0; border-top:none; }
        }

        .basket-flex {
            display: flex;
        }

        .basket-flex-col {
            flex-direction: column;
            flex-grow: 1;
            align-items: center;
            justify-content: center;
        }

        .basket-code {
            margin: 1.25rem;
        }

        .basket-info {
            display: flex;
            flex-direction: column;
            border-left: #e3e7eb 2px solid;
            width: 100%;
        }

        .basket {
            width: 50%;
            display: flex;
            border-style: solid;
            border-color: #e3e7eb;
            border-radius: .5rem;
            margin-left: 1.75rem;
            margin-right: 1.75rem;
            margin-top: 1.5rem;
        }

        .pagebreak {
            page-break-after: always;
        }
    </style>

</head>
<body>
<div id="app">
    <?php
    $data = json_decode(base64_decode($data));

    $showBarcode = $data->barcode == 1 ? true : false;
    $plant = $data->plant;
    $color = $data->color;
    $start = $data->start;
    $end = $data->end;
    $copy = $data->copy;

    $breakCount = $copy == 1 ? 8 : 4;

    $left = true;

    /// https://novatools:8890/nova-ug-baskets/baskets/eyJwbGFudCI6IkEiLCJzdGFydCI6IjEiLCJlbmQiOiIzIn0=

    ?>

    @if($showBarcode)
        @for($i = $start; $i <= $end; $i++)
            @for($j = 1; $j <= $copy; $j++)
                @if($left)
                    <div class="basket-flex">
                        <div class="basket">
                            <div class="basket-code" style="width: 200px; height: 200px">
                                <?php

                                $colorNumber = strval($i);

                                while(strlen($colorNumber) < 3) {
                                    $colorNumber = "0" . $colorNumber;
                                }
                                $colorNumber = $color . '-' . $colorNumber;

                                $barcode = array(
                                    'plant' => $plant,
                                    'color' => $color,
                                    'number' => $colorNumber,
                                )

                                ?>
                                <qr-code size="200" text="{{ base64_encode(json_encode($barcode)) }}" />
                            </div>
                            <div class="basket-info">
                                <div class="basket-flex basket-flex-col" style="border-bottom: #e3e7eb 1px solid;">
                                    <span>Plant</span>
                                    <span style="font-size: 90px">{{ $plant }}</span>
                                </div>
                                <div class="basket-flex basket-flex-col">
                                    <span>Number</span>
                                    <span style="font-size: 30px">{{ $colorNumber }}</span>
                                </div>
                            </div>
                        </div>
                        <?php $left = false; ?>
                        @else
                            <div class="basket">
                                <div class="basket-code" style="width: 200px; height: 200px">
                                    <?php

                                    $colorNumber = strval($i);

                                    while(strlen($colorNumber) < 3) {
                                        $colorNumber = "0" . $colorNumber;
                                    }
                                    $colorNumber = $color . '-' . $colorNumber;

                                    $barcode = array(
                                        'plant' => $plant,
                                        'color' => $color,
                                        'number' => $colorNumber,
                                    )

                                    ?>
                                    <qr-code size="200" text="{{ base64_encode(json_encode($barcode)) }}" />
                                </div>
                                <div class="basket-info">
                                    <div class="basket-flex basket-flex-col" style="border-bottom: #e3e7eb 1px solid;">
                                        <span>Plant</span>
                                        <span style="font-size: 90px">{{ $plant }}</span>
                                    </div>
                                    <div class="basket-flex basket-flex-col">
                                        <span>Number</span>
                                        <span style="font-size: 30px">{{ $colorNumber }}</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php $left = true; ?>
                @endif
            @endfor
            @if($i % $breakCount == 0)
                <div class="pagebreak"></div>
            @endif
        @endfor
    @else
        <div>Number</div>
    @endif
</div>

<script>
    window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
                    'apiToken' => Auth()->user()->api_token ?? null,
                ]) !!}
</script>
<script src="{{ mix('manifest.js', '/vendor/unilatex' ) }}" type="text/javascript"></script>
<script src="{{ mix('vendor.js', '/vendor/unilatex' ) }}" type="text/javascript"></script>
<script src="{{ mix('app.js', '/vendor/unilatex' ) }}" type="text/javascript"></script>
</body>
</html>
