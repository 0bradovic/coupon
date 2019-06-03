

    <section id="carousel">
                <div id="my-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    @foreach($slides as $slide)
                        <div @if($slide == $slides[0]) class="carousel-item active" @else class="carousel-item" @endif>
                            
                                <img class="d-block w-100" src="{{ $slide->img_src }}" alt="{{ $slide->alt_tag }}">
                            
                            @if($slide->center_text)
                                <p class="caroP"  style="@if($slide->center_text_color) color:{{ $slide->center_text_color }};  @endif @if($slide->font_family) font-family:'{{ $slide->font_family }}',sans-serif; @endif @if($slide->font_size) font-size:{{$slide->font_size}}; @endif">{!! $slide->center_text !!}</p>
                            @endif
                            @if($slide->left_text)
                                <p class="caroPleft"  style="@if($slide->left_text_color) color:{{ $slide->left_text_color }}; @endif @if($slide->font_family) font-family:'{{ $slide->font_family }}',sans-serif; @endif @if($slide->font_size) font-size:{{$slide->font_size}}; @endif" >{!! $slide->left_text !!}</p>
                            @endif
                            @if($slide->right_text)
                                <p class="caroPright"  style="@if($slide->right_text_color) color:{{ $slide->right_text_color }}; @endif @if($slide->font_family) font-family:'{{ $slide->font_family }}',sans-serif; @endif @if($slide->font_size) font-size:{{$slide->font_size}}; @endif" >{!! $slide->right_text !!}</p>
                            @endif
                        </div>
                    @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#my-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#my-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
        </section>
       