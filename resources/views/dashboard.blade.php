<x-layout-main>

<!-- Contents Starts Here -->

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h3>বাংলাদেশ সরকারী কর্ম কমিশন সচিবালয় এর বার্ষিক প্রতিবেদন প্রণয়নের জন্য সহায়ক রিপোর্ট</h3>
      <p">
        নিচের ম্যেনু থেকে রিপোর্ট জেনারেট করা যাবে। সিস্টেম জেনারেটেড রিপোর্ট অবশ্যই প্রতিবেদনে প্রকাশের পূর্বে প্রতিবেদন প্রকাশের দায়িত্বপ্রাপ্ত সংশ্লিষ্ট ইউনিট তথ্যের সঠিকতা নিশ্চিত হয়ে তারপর প্রকাশ করবে।

        রিপোর্ট সংক্রান্ত যে কোন অসঙ্গতির ক্ষেত্রে প্রতিবেদন প্রকাশের পূর্বে সংশ্লিষ্ট ইউনিট অবশ্যই তথ্য-প্রযুক্তি শাখায় বিস্তারিত জানাবে এবং তথ্য সংশোধনের উদ্যোগ নিবে।
      </p>
      <p>
        <h4>বর্তমান রিপোর্টের জন্য নির্ধারিত BCS: <span class="text-danger">{{ $configs->where('field', 'current_bcs')->first()['value'] }}</span></h4>
        <h4>রিপোর্টের জন্য নির্ধারিত BCS এর ধরণ: <span class="text-danger">{{ $configs->where('field', 'current_bcs_type')->first()['value'] }}</span></h4>
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
                  ১। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ২। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-registered-district-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৩। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-district-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৪। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (জেলাভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-registered-division-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৫। আবেদনকারী প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (বিভাগভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-division-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৬। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (বিভাগভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-institute-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৭। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (শিক্ষা প্রতিষ্ঠান ভিত্তিক)
                </a>
              </li>
              <li>
                <a href="{{ url('/geneder-wise-selected-others-institute-wise') }}" target="_blank" class="text-decoration-none text-dark mb-2">
                  ৮। সুপারিশপ্রাপ্ত প্রার্থীদের জেন্ডারভিত্তিক পরিসংখ্যান (শিক্ষা প্রতিষ্ঠান ভিত্তিক - Others)
                </a>
              </li>
            </ul>
          </div>
        </div>
        
        </div>
      </div>

<!-- Contents Ends Here -->

</x-layout-main>