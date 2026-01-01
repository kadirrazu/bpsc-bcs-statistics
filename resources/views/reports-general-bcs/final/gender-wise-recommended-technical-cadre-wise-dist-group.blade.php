<x-layout-report>

<!-- Contents Starts Here -->

    <div class="container report-container">
        <div class="row">
            <div class="col-md-12">

            <!-- Report Body -->
            <h4 class="report-title fw-bolder text-center">
                <span>রিপোর্ট ০৪/১২</span> 
            </h4>
            <h4 class="report-title fw-bolder text-center">
                <span class="text-info">
                    কারিগরি ক্যাডারে সুপারিশকৃত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান [জেলাওয়ারী]
                </span>
            </h4>

            <hr>

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
                <tr>
                    <th>কারিগরি ক্যাডারে সুপারিশপ্রাপ্ত সর্বমোট প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-success fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_total ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>কারিগরি ক্যাডারে সুপারিশপ্রাপ্ত পুরুষ প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-info fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_male ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>কারিগরি ক্যাডারে সুপারিশপ্রাপ্ত মহিলা প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-primary fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_female ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>কারিগরি ক্যাডারে সুপারিশপ্রাপ্ত তৃতীয় লিঙ্গের প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-secondary fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_third_gender ) }}
                        </span>
                    </td>
                </tr>
            </table>

            @php 

            $cadreWiseGroup = $cadreWise->groupBy('assigned_cadre');

            @endphp

            @foreach( $cadreWiseGroup as $cadreAbbr => $cadreWiseData )

            <table class="table table-bordered">
                <tr class="fw-bold text-center">
                    <td colspan="6">
                        কারিগরি ক্যাডারে সুপারিশকৃত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান [জেলাওয়ারী]
                    </td>
                </tr>
                <tr class="fw-bold text-start">
                    <td colspan="6">
                        ক্যাডারের নামঃ 
                        {{ $cadreAbbr }} - {{ get_cadre_name_by_abbr($cadreAbbr) }}
                    </td>
                </tr>
                <tr class="fw-bold text-center">
                    <td>ক্রমিক</td>
                    <td>জেলা</td>
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
                    <td>(৬)</td>
                </tr>

                @php

                    $countMale = 0;
                    $counFemale = 0;
                    $countThirdGender = 0;
                    $countTotal = 0;

                @endphp

                @foreach( $cadreWiseData as $cadreWiseSingle )

                <tr class="fw-light text-center">
                    <td class="text-center">
                        {{ en_to_bn_number( $loop->index + 1 ) }}.
                    </td>
                    <td class="text-start">  
                        {{ strtoupper( $cadreWiseSingle->dist_name ) }}
                    </td>
                    <td>
                        {{ en_to_bn_number( $cadreWiseSingle->total_male ) }}
                        @php $countMale += $cadreWiseSingle->total_male  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $cadreWiseSingle->total_male / $cadreWiseSingle->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $cadreWiseSingle->total_female ) }}
                        @php $counFemale += $cadreWiseSingle->total_female  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $cadreWiseSingle->total_female / $cadreWiseSingle->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $cadreWiseSingle->total_third_gender ) }}
                        @php $countThirdGender += $cadreWiseSingle->total_third_gender  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $cadreWiseSingle->total_third_gender / $cadreWiseSingle->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td class="text-total">
                        {{ en_to_bn_number( $cadreWiseSingle->total ) }}
                        @php $countTotal += $cadreWiseSingle->total  @endphp
                    </td>
                </tr>

                @endforeach

                <tr class="text-center">
                    <th></th>
                    <th></th>
                    <th>
                        {{ en_to_bn_number( $countMale ) }}
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $countMale / $countTotal ) * 100) ) }}%
                        </span>
                    </th>
                    <th>
                        {{ en_to_bn_number( $counFemale ) }}
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $counFemale / $countTotal ) * 100) ) }}%
                        </span>
                    </th>
                    <th>
                        {{ en_to_bn_number( $countThirdGender ) }}
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $countThirdGender / $countTotal ) * 100) ) }}%
                        </span>
                    </th>
                    <th>
                        {{ en_to_bn_number( $countTotal ) }}
                    </th>
                </tr>
            </table>

            @endforeach

            <!-- Report Body Ends Here -->

            </div>
        </div>
    </div>

<!-- Contents Ends Here -->

</x-layout-report>