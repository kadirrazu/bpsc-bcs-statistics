<x-layout-report>

<!-- Contents Starts Here -->

    <div class="container report-container">
        <div class="row">
            <div class="col-md-12">

            <!-- Report Body -->
            <h3 class="report-title fw-bolder">
                <span>রিপোর্ট ১০ - </span> 
                <span class="text-info">
                    সুপারিশকৃত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (শিক্ষা প্রতিষ্ঠান ভিত্তিক)
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
                <tr>
                    <th>সর্বমোট সুপারিশকৃত প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-success fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_total ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>সর্বমোট সুপারিশকৃত পুরুষ প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-info fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_male ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>সর্বমোট সুপারিশকৃত মহিলা প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-primary fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_female ) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>সর্বমোট সুপারিশকৃত তৃতীয় লিঙ্গের প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-secondary fs-expanded">
                            {{ en_to_bn_number( $grandTotal->grand_third_gender ) }}
                        </span>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="fw-bold text-center">
                    <td colspan="6">
                        সুপারিশকৃত প্রার্থীর সংখ্যা (শিক্ষা প্রতিষ্ঠান ভিত্তিক)
                    </td>
                </tr>
                <tr class="fw-bold text-center">
                    <td colspan="2">বিভাগের নাম</td>
                    <td>পুরুষ <br>(সংখ্যা ও %)</td>
                    <td>মহিলা <br>(সংখ্যা ও %)</td>
                    <td>তৃতীয় লিঙ্গ <br>(সংখ্যা ও %)</td>
                    <td>সর্বমোট <br>(সংখ্যা)</td>
                </tr>
                <tr class="fw-bold text-center">
                    <td colspan="2">(১)</td>
                    <td>(২)</td>
                    <td>(৩)</td>
                    <td>(৪)</td>
                    <td>(৫)</td>
                </tr>

                @php

                    $countMale = 0;
                    $counFemale = 0;
                    $countThirdGender = 0;
                    $countTotal = 0;

                @endphp

                @foreach( $institutesWise as $institute )

                <tr class="fw-light text-center">
                    <td class="text-center">
                        {{ en_to_bn_number( $loop->index + 1 ) }}.
                    </td>
                    <td class="text-start">  
                        {{ $institute->name }}
                    </td>
                    <td>
                        {{ en_to_bn_number( $institute->total_male ) }}
                        @php $countMale += $institute->total_male  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $institute->total_male / $institute->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $institute->total_female ) }}
                        @php $counFemale += $institute->total_female  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $institute->total_female / $institute->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $institute->total_third_gender ) }}
                        @php $countThirdGender += $institute->total_third_gender  @endphp
                        <br>
                        <span class="text-primary">
                            {{ en_to_bn_number( sprintf('%.2f', ( $institute->total_third_gender / $institute->total ) * 100) ) }}%
                        </span>
                    </td>
                    <td class="text-total">
                        {{ en_to_bn_number( $institute->total ) }}
                        @php $countTotal += $institute->total  @endphp
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

            <!-- Report Body Ends Here -->

            </div>
        </div>
    </div>

<!-- Contents Ends Here -->

</x-layout-report>