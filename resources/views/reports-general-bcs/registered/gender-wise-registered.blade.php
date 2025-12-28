<x-layout-report>

<!-- Contents Starts Here -->

    <div class="container report-container">
        <div class="row">
            <div class="col-md-12">

            <!-- Report Body -->
            <h4 class="report-title fw-bolder text-center">
                <span>রিপোর্ট ০১/০১</span> 
            </h4>
            <h4 class="report-title fw-bolder text-center">
                <span class="text-info">
                    আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান
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
                    <th>সর্বমোট আবেদনকারী প্রার্থীঃ</th>
                    <td class="fw-bold">
                        <span class="text-success fs-expanded">
                            {{ en_to_bn_number( $total ) }}
                        </span>
                    </td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="fw-bold text-center">
                    <td colspan="4">
                        আবেদনকারী প্রার্থীর সংখ্যা
                    </td>
                </tr>
                <tr class="fw-bold text-center">
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
                </tr>
                <tr class="fw-light text-center">
                    <td>
                        {{ en_to_bn_number( $male ) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $male / $total ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $female ) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $female / $total ) * 100) ) }}%</span>
                    </td>
                    <td>
                        {{ en_to_bn_number( $tgender ) }}
                        <br>
                        <span class="text-primary">{{ en_to_bn_number( sprintf('%.2f', ( $tgender / $total ) * 100) ) }}%</span>
                    </td>
                    <td class="text-total">
                        {{ en_to_bn_number( $total ) }}
                    </td>
                </tr>
            </table>

            <!-- Report Body Ends Here -->

            </div>
        </div>
    </div>

<!-- Contents Ends Here -->

</x-layout-report>