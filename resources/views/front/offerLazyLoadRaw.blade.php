@foreach($simillarOffers as $off)
                        <div class="fix">
                            <div class="fix-img">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <img class="imag" src="{{ '/public/'.$off->img_src }}" width="170px" height="140px">
                            </a>
                            </div>
                            <div class="fix-text">
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{{ $off->name }}</a>
                                @if($off->detail)
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{!! $off->detail !!}</a>
                                @endif
                            </div>
                            <div class="dugmici">
                                <p class="datum">@if($off->endDate){{ $off->dateFormat( $off->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                                <a href="{{ $off->link }}" class="dugme">Get offer</a>
                            </div>
                        </div>
                        @endforeach