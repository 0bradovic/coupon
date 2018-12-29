@foreach($offers as $offer)
<div class="red">
                <div class="image">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <img src="{{ $offer->img_src }}">
                </a>
                </div>
                <div class="title">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <h6>{{ $offer->name }}</h6>
                </a>
                </div>
                <div class="text">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    @php chop($offer->detail,'<p></p>') @endphp
                    @if(strpos($offer->detail,'<br><p></p>') !== false)
                        <p> {!! chop($offer->detail, '<br><p></p>')!!} </p>
                    @elseif(strpos($offer->detail,'<br></p>') !== false)
                        <p> {!! chop($offer->detail, '<br></p>')!!} </p>
                    @else
                        <p>{!! $offer->detail !!}</p>
                    @endif
                </a>
                    
                
                </div>
                <div class="date"><a  class="dateA">@if($offer->endDate)Ends {{ $offer->dateFormat( $offer->endDate )->toFormattedDateString() }}@else Ongoing @endif</a></div>
                <div class="btn"><a href="{{ $offer->link }}" class="butt">Get offer</a></div>
            </div>
@endforeach