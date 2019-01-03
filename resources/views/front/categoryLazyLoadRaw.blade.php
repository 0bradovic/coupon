@foreach($offers as $offer)
      <div class="dva">
        <div class="box">
          <div class="fix">
            <div class="slika">
              <div class="fix-img">
              <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                <img src="{{ $offer->img_src }}" alt="">
                </a>
              </div>
            </div>
            <div class="fix-text">
              <a href="{{ route('offer',['slug' => $offer->slug]) }}" class="fix-a">{{ $offer->name }}</a>
              @if($offer->detail)
              <a href="{{ route('offer',['slug' => $offer->slug]) }}" class="fix-a">
                @php chop($offer->detail,'<p></p>') @endphp
                @if(strpos($offer->detail,'<br><p></p>') !== false)
                    <p> {!! chop($offer->detail, '<br><p></p>')!!} </p>
                @elseif(strpos($offer->detail,'<br></p>') !== false)
                    <p> {!! chop($offer->detail, '<br></p>')!!} </p>
                @else
                    <p>{!! $offer->detail !!}</p>
                @endif
              </a>
              @endif
            </div>
            <div class="dugmici">
              <p class="datum">@if($offer->endDate)Ends {{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
              <a href="{{ $offer->link }}" class="dugme">Get offers</a>
            </div>
          </div>
        </div>
       @endforeach