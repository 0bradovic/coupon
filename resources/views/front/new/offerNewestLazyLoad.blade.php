@foreach($newestSimillarOffers as $off)
                <div class="category_blade_content">
                    <div class="category_blade_box">
                        <div class="category_blade_box_img">
                            @if($off->brand)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->brand->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->brand->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                </a>
                            
                            @elseif($off->img_src)
                                <?php
                                list($width, $height, $type, $attr) = getimagesize(public_path().$off->img_src);
                                ?>
                                <a href="{{ route('offer',['slug' => $off->slug]) }}" @if($height>$width) style="height:100%;width:auto;" 
                                @else style="height:auto;width:100%"; 
                                @endif>
                                    <img src="{{ $off->img_src }}" alt="{{ $off->alt_tag }}" @if($height>$width) style="height:100%;width:auto;"
                                    @else style="height:auto;width:100%";@endif />
                                    
                                </a>
                            @endif
                        </div>
                        <div class="category_blade_box_date">
                            @if($off->offerType)
                                <span class="coupon" style="background-color:{{ $off->offerType->color }}">{{ $off->offerType->name }}</span>
                            @endif
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_date_top">
                                    {{ $off->name }}
                                </div>
                            </a>
                            <div class="category_blade_box_date_bottom">
                                @if($off->endDate)
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>ends</p>
                                    <p @if($off->dateFormat($off->endDate) <  Helpers::expireSoon() ) style="color:red;" @endif>{{ $off->frontDateFormat( $off->endDate ) }}</p>
                                @else
                                    <p>Ongoing</p>
                                @endif
                            </div>
                        </div>
                        <div class="category_blade_box_text">
                            <a href="{{ route('offer',['slug' => $off->slug]) }}">
                                <div class="category_blade_box_text_top">
                                    {{ $off->formatDetails($off->detail) }}
                                </div>
                            </a>
                            <div class="category_blade_box_text_bottom">
                                <a href="{{ route('get.offer',['slug' => $off->slug]) }}" target="_blank">Get This <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach