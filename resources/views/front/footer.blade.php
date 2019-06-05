<footer>
        @php $customPages = Helpers::getCustomPages(); @endphp
        <div class="container">
            <div class="foo">
                <div class="footer_top">
                    <a href="mailto:hi@beforetheshop.com">Contact us</a>
                    @foreach($customPages as $customPage)
                         <a href="{{ route('custom.page.get', ['slug' => $customPage->slug]) }}" target="_blank">{{$customPage->name}}</a>
                    @endforeach
                </div>
                <div class="footer_share">
                    <a href="https://www.facebook.com/BeforeTheShop" target="_blank">Facebook</a>
                    <a href="https://twitter.com/BeforeTheShop?lang=en" target="_blank">Twitter</a>
                    <a href="#"><span id="open_popup">Newsletter</span></a>
                </div>
                <p>Copyright 2019 Before The Shop</p>
            </div>
        </div>
    </footer>

    