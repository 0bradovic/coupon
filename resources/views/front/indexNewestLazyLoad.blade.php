@foreach($newestOffers as $offer)
<div class="red">
                <div class="image">
                 @if($offer->img_src)
                <?php
                    list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                ?>
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                @else style="height:auto;width:100%"; 
                @endif>
                    <img src="{{ '/public/'.$offer->img_src }}"  
                    @if($height>$width) style="height:100%;width:auto;"
                    @else style="height:auto;width:100%"; 
                    @endif>
                </a>
                </div>
                @else
                
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                  
                </a>
                </div>
                
                @endif
                </div>
                <div class="title">
                    @if($offer->offerType)
                <div class="sticker" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</div>
                @endif
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                    <h6>{{ $offer->name }}</h6>
                </a>
                <div class="date"><a  class="dateA">@if($offer->endDate)ends <br> {{ $offer->frontDateFormat( $offer->endDate ) }}@else Ongoing @endif</a></div>
                </div>
                <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                <div class="text">
                <a href="{{ route('offer',['slug' => $offer->slug]) }}">
                        <small>
                            {!! $offer->formatDetails($offer->detail) !!}
                        </small> 
                </a>
                    
                <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $offer->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>
                </div>
               
                
                
            </div>
@endforeach