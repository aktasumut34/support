<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<style>
    .container {
        max-width: unset !important;
        padding: 0 50px !important;
    }

    @media screen and (max-width: 768px) {
        .container {
            padding: 0 15px !important;
        }
    }

</style>

<head>
    @include('includes.styles')
    @if (setting('GOOGLE_ANALYTICS_ENABLE') == 'yes')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('GOOGLE_ANALYTICS') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ setting('GOOGLE_ANALYTICS') }}');
        </script>
    @endif

</head>

<body
    class="@if (str_replace('_', '-', app()->getLocale()) == 'عربى') rtl @endif @if (setting('SPRUKOADMIN_C') == 'off') @if (setting('DARK_MODE') == 1) dark-mode @endif @else @if (Auth::guard('customer')->check()) @if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->custsetting != null)
			@if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->custsetting->darkmode == 1) dark-mode @endif @endif @else @if (setting('DARK_MODE') == 1) dark-mode @endif @endif @endif">

    @include('includes.user.mobileheader')

    @include('includes.user.menu')

    <div class="page">
        <div class="page-main">

            @yield('content')


        </div>
    </div>

    @include('includes.footer')
    @include('includes.scripts')

    @guest
        @if (customcssjs('CUSTOMCHATENABLE') == 'enable')
            @if (customcssjs('CUSTOMCHATUSER') == 'public')
                @php echo customcssjs('CUSTOMCHAT') @endphp;
            @endif
        @endif
    @else
        @if (customcssjs('CUSTOMCHATENABLE') == 'enable')
            @if (Auth::check() && Auth::user()->role_id == '4')
                @php echo customcssjs('CUSTOMCHAT') @endphp;
            @endif
        @endif
    @endguest



    @if (Session::has('error'))
        <script>
            toastr.error("{!! Session::get('error') !!}");
        </script>
    @elseif(Session::has('success'))
        <script>
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @elseif(Session::has('info'))
        <script>
            toastr.info("{!! Session::get('info') !!}");
        </script>
    @elseif(Session::has('warning'))
        <script>
            toastr.warning("{!! Session::get('warning') !!}");
        </script>
    @endif

    @if (setting('REGISTER_POPUP') == 'yes')
        @if (!Auth::guard('customer')->check())

            @include('user.auth.modalspopup.register')

            @include('user.auth.modalspopup.login')

            @include('user.auth.modalspopup.forgotpassword')
        @endif
    @endif

    @if (setting('GUEST_TICKET') == 'yes')

        @include('guestticket.guestmodal')

    @endif

    @yield('modal')

</body>

</html>
