@foreach($simillarOffers as $off)
            <div class="dva">
                <div class="box">
                    <div class="fix">
                        <div class="slika">
                            <div class="fix-img">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <img src="{{ $off->img_src }}">
                            </a>
                            </div>
                        </div>
                        <div class="fix-text">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">{{ $off->name }}</a>
                            <a href="{{ route('offer',['slug' => $off->slug]) }}" class="fix-a">
                                @php chop($off->detail,'<p></p>') @endphp
                                @if(strpos($off->detail,'<br><p></p>') !== false)
                                    <p> {!! chop($off->detail, '<br><p></p>')!!} </p>
                                @elseif(strpos($off->detail,'<br></p>') !== false)
                                    <p> {!! chop($off->detail, '<br></p>')!!} </p>
                                @else
                                    <p>{!! $off->detail !!}</p>
                                @endif
                            </a>
                        </div>
                        <div class="dugmici">
                            <p class="datum">@if($off->endDate){{ $off->dateFormat( $off->endDate )->toFormattedDateString() }}@else Ongoing @endif</p>
                            <a href="{{ $off->link }}" class="dugme">Get offer</a>
                        </div>
                    </div>
                </div>
                
            </div>
        @endforeach