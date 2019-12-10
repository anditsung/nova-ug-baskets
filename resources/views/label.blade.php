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

    /// https://novatools:8890/nova-ug-baskets/baskets/eyJwbGFudCI6IkEiLCJzdGFydCI6IjEiLCJlbmQiOiIzIn0=

    ?>

    <div class="flex flex-wrap">
    @if($showBarcode)
        @for($i = $start; $i <= $end; $i++)
            @for($j = 1; $j <= $copy; $j++)
                <div class="w-1/2">
                    <div class="border-4 border-50 rounded-lg flex" style="margin-left: 1.75rem; margin-right: 1.75rem; margin-top: 1.5rem;">
                        <div class="m-5">
                            <div style="width: 200px; height: 200px">
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
                        </div>
                        <div style="background-color: white; border-left: 1px solid #8a97a2; width: 100%; display: flex; flex-direction: column;">
                            <div class="flex-1 border-b border-50">
                                <div class="flex h-full items-center justify-center">
                                    <div class="flex flex-1 items-center" style="flex-direction: column">
                                        <div class="m-2 uppercase font-bold">
                                            Plant
                                        </div>
                                        <div class="flex-1 uppercase" style="font-size: 100px">
                                            {{ $plant }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex h-full items-center justify-center">
                                    <div class="flex flex-1 items-center" style="flex-direction: column">
                                        <div class="m-2 uppercase font-bold">
                                            Number
                                        </div>
                                        <div class="flex-1 uppercase" style="font-size: 30px">
                                            {{ $colorNumber }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endfor
    @else
        @for($i = $start; $i <= $end; $i++)
            @for($j = 1; $j <= $copy; $j++)
                <div class="w-1/2">
                    <div class="border-4 border-50 rounded-lg flex mt-12" style="margin: 1.75rem">
                        <div class="m-5 w-full">
                            <div class="flex items-center justify-center" style="height: 200px;">
                                <h1 style="font-size: 150px">
                                    {{ $i }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @endfor
    @endif
    </div>

@endsection
