<x-layout-report>

<!-- Contents Starts Here -->

    <div class="container report-container">
        <div class="row">
            <div class="col-md-12">

            <!-- Report Body -->
            <h3 class="report-title fw-bolder">
                <span>রিপোর্ট ১৩ - </span> 
                <span class="text-info">
                    আবেদনকারী প্রার্থীদের বয়সভিত্তিক পরিসংখ্যান
                </span>
            </h3>

            <table class="table table-bordered insight-table">
                <tr>
                    <th>বিসিএস পরীক্ষাঃ</th>
                    <td>
                        <span class="text-danger fw-bold" style="font-size: 20px; ">
                            {{ en_to_bn_number( $configs->where('field', 'current_bcs')->first()['value'] ) }}তম
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>বিসিএস পরীক্ষার ধরণঃ</th>
                    <td>
                        <span class="text-danger fw-bold">
                            @if( strtolower( $configs->where('field', 'current_bcs_type')->first()['value'] ) == 'special' )
                                বিশেষ বিসিএস
                            @else
                                সাধারণ বিসিএস
                            @endif
                        </span>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="fw-bold text-center">
                    <td colspan="5">
                        যোগ্য আবেদনকারী প্রার্থীর সংখ্যা (বয়সভিত্তিক)
                    </td>
                </tr>
                <tr class="fw-bold text-center">
                    <td>বয়সের শ্রেণিবিন্যাস</td>
                    <td>পুরুষ <br>(সংখ্যা ও %)</td>
                    <td>মহিলা <br>(সংখ্যা ও %)</td>
                    <td>তৃতীয় লিঙ্গ <br>(সংখ্যা ও %)</td>
                    <td>সর্বমোট <br>(সংখ্যা)</td>
                </tr>
                <tr class="fw-bold text-center">
                    <td>(১)</td>
                    <td>(২)</td>
                    <td>(৩)</td>
                    <td>(৪)</td>
                    <td>(৫)</td>
                </tr>

                @php

                    $totalCount = 0;
                    $maleCount = 0;
                    $femaleCount = 0;
                    $tgCount = 0;

                @endphp

                @foreach($ageWise as $age)

                <tr class="fw-light text-center">
                    <td>{{ en_to_bn_number( $age->age_group ) }}</td>
                    <td>
                        {{ en_to_bn_number( $age->male ) }}
                        @php $maleCount += $age->male; @endphp
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $age->male / $age->total ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $age->female ) }}
                        @php $femaleCount += $age->female; @endphp
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $age->female / $age->total ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $age->third_gender ) }}
                        @php $tgCount += $age->third_gender; @endphp
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $age->third_gender / $age->total ) * 100) ) }}%</span>
                    </td>
                    <td class="text-total">
                        {{ en_to_bn_number( $age->total ) }}
                        @php $totalCount += $age->total; @endphp
                    </td>
                </tr>

                @endforeach

                <tr class="fw-bold text-center">
                    <td></td>
                    <td>
                        {{ en_to_bn_number($maleCount) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $maleCount / $totalCount ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number($femaleCount) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $femaleCount / $totalCount ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number($tgCount) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $tgCount / $totalCount ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $totalCount ) }}
                    </td>
                </tr>

            </table>

            <!-- Report Body Ends Here -->

            </div>
        </div>
    </div>

<!-- Contents Ends Here -->

</x-layout-report>