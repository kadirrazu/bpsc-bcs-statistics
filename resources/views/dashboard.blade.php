<x-layout-main>

<!-- Contents Starts Here -->

    <div class="pricing-header mx-auto text-center">
      <h3>বাংলাদেশ সরকারী কর্ম কমিশন সচিবালয় এর বার্ষিক প্রতিবেদন প্রণয়নের জন্য সহায়ক রিপোর্ট</h3>
      <p class="text-start">
        <strong>বিশেষ দ্রষ্টব্যঃ</strong> 
        <br>
        সিস্টেম জেনারেটেড রিপোর্ট অবশ্যই প্রতিবেদনে প্রকাশের পূর্বে প্রতিবেদন প্রকাশের দায়িত্বপ্রাপ্ত সংশ্লিষ্ট ইউনিট তথ্যের সঠিকতা নিশ্চিত হয়ে তারপর প্রকাশ করবে।
      </p>
      <p>
        <table class="table table-bordered">
          <tr>
            <th>রিপোর্টিং বিসিএস</th>
            <td>
              <span class="text-info">  
                {{ en_to_bn_number( $configs->where('field', 'current_bcs')->first()['value']) }}
              </span>
            </td>
          </tr>
          <tr>
            <th>রিপোর্টিং বিসিএস এর ধরণ</th>
            <td>
              <span class="text-info">
                @if( strtolower( $configs->where('field', 'current_bcs_type')->first()['value'] ) == 'special' )
                  বিশেষ বিসিএস
                @else
                  সাধারণ বিসিএস
                @endif
              </span>
            </td>
          </tr>
        </table>
      </p>
    </div>

    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">

          <div class="card-header">
            <h4 class="my-0 text-success">রিপোর্ট ম্যেনু</h4>
          </div>

          <div class="card-body text-start">
            <ul class="list-unstyled mt-3 mb-4 fs-menu-item">
              <li>
                <a href="{{ url('/geneder-wise-registered') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০১। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-passed-preli') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০২। প্রাথমিক বাছাই (প্রিলিমিনারী) পরীক্ষায় উত্তীর্ণ প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান 
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৩। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-registered-district-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৪। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-district-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৫। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-registered-district-wise-div-group') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৬। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক - বিভাগওয়ারী গ্রুপকৃত)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-district-wise-div-group') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৭। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক - বিভাগওয়ারী গ্রুপকৃত)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-registered-division-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৮। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (বিভাগভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-division-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ০৯। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (বিভাগভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-institute-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ১০। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (শিক্ষা প্রতিষ্ঠান ভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-others-institute-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ১১। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (শিক্ষা প্রতিষ্ঠান ভিত্তিক - Others)
                </a>
              </li>
              <li>
                <a href="{{ url('/age-wise-registered') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ১২। আবেদনকারী প্রার্থীদের বয়সভিত্তিক পরিসংখ্যান
                </a>
              </li>
              <li>
                <a href="{{ url('/age-wise-selected') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ১৩। সুপারিশপ্রাপ্ত প্রার্থীদের বয়সভিত্তিক পরিসংখ্যান
                </a>
              </li>
            </ul>
          </div>
        </div>
        
        </div>
      </div>

<!-- Contents Ends Here -->

</x-layout-main>