<x-layout-report>

<!-- Contents Starts Here -->

    <div class="container report-container">
        <div class="row">
            <div class="col-md-12">

            <!-- Report Body -->

            <h2 class="report-title">
                <span>রিপোর্টের শিরোনামঃ</span> 
                <span class="text-info">
                    সুপারিশকৃত প্রার্থীদের বয়সভিত্তিক পরিসংখ্যান
                </span>
            </h2>

            <table class="table table-bordered insight-table">
                <tr>
                    <th>বিসিএস পরীক্ষাঃ</th>
                    <td>
                        <span class="text-danger fw-bold">
                            {{ $configs->where('field', 'current_bcs')->first()['value'] }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>বিসিএস পরীক্ষার ধরণঃ</th>
                    <td>
                        <span class="text-danger fw-bold">
                            {{ $configs->where('field', 'current_bcs_type')->first()['value'] }}
                        </span>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="fw-bold text-center">
                    <td colspan="5">
                        সুপারিশকৃত প্রার্থীর সংখ্যা
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
                    <td class="fw-bold">
                        {{ en_to_bn_number( $age->total ) }}
                        @php $totalCount += $age->total; @endphp
                    </td>
                </tr>

                @endforeach

                <tr class="fw-bold text-center">
                    <td></td>
                    <td>{{ en_to_bn_number($maleCount) }}</td>
                    <td>{{ en_to_bn_number($femaleCount) }}</td>
                    <td>{{ en_to_bn_number($tgCount) }}</td>
                    <td>
                        {{ en_to_bn_number( $totalCount ) }}
                    </td>
                </tr>

            </table>  

            <br><br>

            <!-- <a href="{{ url('/geneder-wise-registered-pdf-dl') }}" target="_blank" class="btn btn-primary">Export as PDF</a> -->

            <!-- Report Body Ends Here -->

            </div>
        </div>
    </div>

<!-- Contents Ends Here -->

</x-layout-report>