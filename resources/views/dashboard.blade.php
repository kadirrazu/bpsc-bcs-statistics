<x-layout-main>

<!-- Contents Starts Here -->

    <div class="pricing-header mx-auto text-center">
      <h3>"বাংলাদেশ সরকারী কর্ম কমিশন" এর বার্ষিক প্রতিবেদন প্রণয়নের জন্য বিসিএস পরীক্ষা সংক্রান্ত সহায়ক রিপোর্ট / পরিসংখ্যান</h3>
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
              <span class="text-danger fw-bold">  
                {{ en_to_bn_number( $configs->where('field', 'current_bcs')->first()['value']) }}তম
              </span>
            </td>
          </tr>
          <tr>
            <th>রিপোর্টিং বিসিএস এর ধরণ</th>
            <td>
              <span class="text-primary fw-bold">
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
            <h3 class="my-0 text-secondary fw-bolder">রিপোর্ট মেন্যু</h3>
          </div>

          <div class="card-body text-start">

              <span class="text-danger fw-bold">
                {{ en_to_bn_number( $configs->where('field', 'current_bcs')->first()['value']) }}তম
              </span>

              @if( strtolower( $configs->where('field', 'current_bcs_type')->first()['value'] ) == 'special' )
                <span class="text-primary fw-bold">বিশেষ বিসিএস</span>
              @else
                <span class="text-primary fw-bold">সাধারণ বিসিএস</span>
              @endif

              পরীক্ষার পরিসংখ্যান সংক্রান্ত রিপোর্টসমূহ -


            @if( strtolower( $configs->where('field', 'current_bcs_type')->first()['value'] ) == 'special' )

              @include('report-menu-special-bcs')

            @else

              @include('report-menu-general-bcs')

            @endif


          </div>
        </div>
        
        </div>
      </div>

<!-- Contents Ends Here -->

</x-layout-main>