@extends('partials.layout')

@section('content')

    <?php
    $data = json_decode(base64_decode($data));

    $showBarcode = $data->barcode == 1 ? true : false;
    $plant = $data->plant;
    $color = $data->color;
    $start = $data->start;
    $end = $data->end;
    $copy = $data->copy;

    $barcodeCount = 1;

    //$breakCount = $copy == 1 ? 8 : 4;
    $breakCount = 8;

    $left = true;

    /// https://novatools:8890/nova-ug-baskets/baskets/eyJwbGFudCI6IkEiLCJzdGFydCI6IjEiLCJlbmQiOiIzIn0=

    ?>

    @if($showBarcode)
        @for($i = $start; $i <= $end; $i++)
            @for($j = 1; $j <= $copy; $j++)
                @if($left)
                    <div class="flex">
                        <div class="flex w-1/2 border-4 border-50 rounded-lg" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem">
                            <div class="w-full flex">
                                <div class="m-3 flex-no-shrink" style="width: 200px; height: 200px">
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
                                    <qr-code :size="200" text="{{ base64_encode(json_encode($barcode)) }}" />
                                </div>
                                <div class="border-l border-50 w-full flex" style="flex-direction: column">
                                    <div class="flex flex-1 border-b border-50" style="flex-direction: column; align-items: center; justify-content: center;">
                                        <span>Plant</span>
                                        <span class="font-bold" style="font-size: 120px">{{ $plant }}</span>
                                    </div>
                                    <div class="flex flex-1" style="flex-direction: column; align-items: center; justify-content: center;">
                                        <span>Number</span>
                                        <span class="font-bold" style="font-size: 35px">{{ $colorNumber }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $left = false; ?>
                        @else
                            <div class="flex w-1/2 border-4 border-50 rounded-lg" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem">
                                <div class="w-full flex">
                                    <div class="m-3 flex-no-shrink" style="width: 200px; height: 200px">
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
                                        <qr-code :size="200" text="{{ base64_encode(json_encode($barcode)) }}" />
                                    </div>
                                    <div class="border-l border-50 w-full flex" style="flex-direction: column">
                                        <div class="flex flex-1 border-b border-50" style="flex-direction: column; align-items: center; justify-content: center;">
                                            <span>Plant</span>
                                            <span class="font-bold" style="font-size: 120px">{{ $plant }}</span>
                                        </div>
                                        <div class="flex flex-1" style="flex-direction: column; align-items: center; justify-content: center;">
                                            <span>Number</span>
                                            <span class="font-bold" style="font-size: 35px">{{ $colorNumber }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php $left = true; ?>
                @endif
                @if($barcodeCount % $breakCount == 0)
                    <div style="page-break-after: always"></div>
                @endif
                <?php $barcodeCount++; ?>
            @endfor
        @endfor
    @else
        @for($i = $start; $i <= $end; $i++)
            @for($j = 1; $j <= $copy; $j++)
                @if($left)
                    <div class="flex">
                        <div class="flex w-1/2 border-4 border-50 rounded-lg" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem">
                            <div class="w-full flex" style="height: 220px; align-items: center; justify-content: center;">
                                <span style="font-size: 140px">{{ $plant }} - {{ $i }}</span>
                            </div>
                        </div>
                        <?php $left = false; ?>
                        @else
                            <div class="flex w-1/2 border-4 border-50 rounded-lg" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem">
                                <div class="w-full flex" style="align-items: center; justify-content: center;">
                                    <span style="font-size: 140px">{{ $plant }} - {{ $i }}</span>
                                </div>
                            </div>
                    </div>
                    <?php $left = true; ?>
                @endif
                @if($barcodeCount % $breakCount == 0)
                    <div style="page-break-after: always"></div>
                @endif
                <?php $barcodeCount++; ?>
            @endfor
        @endfor
    @endif

    @if(! $left)
        <div class="w-1/2" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem;">
        </div>
    @endif

@endsection
