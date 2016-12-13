<div class="col-sm-12 footer">
    <footer>
        <div class="col-sm-4 social">
            <a href="#"><img src="{{ asset('images/ar/icon_call_me.png') }}" alt=""/></a> &nbsp;
            <strong>{{ trans('front.footer.phone') }}</strong>
        </div>
        <div class="col-md-8 col-sm-8">
            <div class="labour_office_logo"><a href="#"><img
                        src="{{ asset('images/ar/logo_labour_office.png') }}" alt=""/></a></div>

            <p>
                {{ trans('front.footer.copyrights') }}
                <strong class="footer_links">
                    <a href="{{ url('/about') }}">{{ trans('front.menu.about') }}</a> |
                    <a href="#">{{ trans('front.footer.contact') }}</a>
                </strong>
            </p>
        </div>
    </footer>
</div>