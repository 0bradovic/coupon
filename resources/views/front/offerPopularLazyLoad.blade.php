@foreach($popularSimillarOffers as $off)
            <div class="red">
                <div class="image">
                 @if($off->img_src)
                <?php
                    list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                ?>
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                @else style="height:auto;width:100%"; 
                @endif>
                    <img src="{{ '/public/'.$off->img_src }}"  
                    @if($height>$width) style="height:100%;width:auto;"
                    @else style="height:auto;width:100%"; 
                    @endif>
                </a>
                </div>
                @else
                
                <div class="holdarevitj">
                <a href="{{ route('offer',['slug' => $off->slug]) }}">
                    
                </a>
                </div>
                
                @endif
                </div>
                <div class="title">
                    @if($off->offerType)
                <div class="sticker" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</div>
                @endif
                <a href="{{ route('offer',['slug' => $off->slug]) }}">
                    <h6>{{ $off->name }}</h6>
                </a>
                <div class="date"><a  class="dateA">@if($off->endDate)ends <br> {{ $off->frontDateFormat( $off->endDate ) }}@else Ongoing @endif</a></div>
                </div>
                <div class="btn mobile"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Get offer</a></div>
                <div class="text">
                <a href="{{ route('offer',['slug' => $off->slug]) }}">
                    
                        <small>
                            {!! $off->formatDetails($off->detail) !!}
                        </small>  
                                
                </a>
                    
                <div class="btn all-screan"><a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank" class="butt">Click here to get this offer</a></div>
                </div>
                
                
                
            </div>
        @endforeach