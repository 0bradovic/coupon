@foreach($popularOffers as $offer)
    @if($offer->brand)
            <div class="category_blade_content">
                <div class="category_blade_box">
                    <div class="category_blade_box_img">
                        @if($offer->brand->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->brand->img_src);
                            ?>
                             <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->brand->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%";@endif />
                            </a>
                       
                        @elseif($offer->img_src)
                            <?php
                            list($width, $height, $type, $attr) = getimagesize(public_path().$offer->img_src);
                            ?>
                             <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                            @else style="height:auto;width:100%"; 
                            @endif>
                                <img src="{{ $offer->img_src }}" alt="{{ $offer->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                @else style="height:auto;width:100%"; 
                                @endif/>
                            </a>
                        @endif
                    </div>
                    <div class="category_blade_box_date">
                        @if($offer->offerType)
                            <span class="coupon" style="background-color:{{ $offer->offerType->color }}">{{ $offer->offerType->name }}</span>
                        @endif
                        <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                            <div class="category_blade_box_date_top">
                                {{ $offer->name }}
                            </div>
                        </a>
                        <div class="category_blade_box_date_bottom">
                            @if($offer->endDate)
                                <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                                <p @if($offer->dateFormat($offer->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $offer->frontDateFormat( $offer->endDate ) }}</p>
                            @else
                                <p>Ongoing</p>
                            @endif
                        </div>
                    </div>
                    <div class="category_blade_box_text">
                        <a href="{{ route('offer',['brandSlug' => $offer->brand->slug , 'offerSlug' => $offer->slug]) }}">
                            <div class="category_blade_box_text_top">
                                {!! $offer->formatDetails($offer->detail) !!}
                            </div>
                        </a>
                        <div class="category_blade_box_text_bottom">
                            <a href="{{ route('get.offer',['slug' => $offer->slug]) }}" class="redirect-btn">Get This <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach