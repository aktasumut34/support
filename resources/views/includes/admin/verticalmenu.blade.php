                    <!--aside open-->
                    <aside class="app-sidebar">
                        <div class="app-sidebar__logo">
                            <a class="header-brand" href="{{ url('admin') }}">
                                {{-- Logo --}}
                                @if ($title->image == null)
                                    <img src="{{ asset('uploads/logo/logo/logo-white.png') }}"
                                        class="header-brand-img dark-logo" alt="logo">
                                @else
                                    <img src="{{ asset('uploads/logo/logo/' . $title->image) }}"
                                        class="header-brand-img dark-logo" alt="logo">
                                @endif

                                {{-- Dark-Logo --}}
                                @if ($title->image1 == null)
                                    <img src="{{ asset('uploads/logo/darklogo/logo.png') }}"
                                        class="header-brand-img desktop-lgo" alt="dark-logo">
                                @else
                                    <img src="{{ asset('uploads/logo/darklogo/' . $title->image1) }}"
                                        class="header-brand-img desktop-lgo" alt="dark-logo">
                                @endif

                                {{-- Mobile-Logo --}}
                                @if ($title->image2 == null)
                                    <img src="{{ asset('uploads/logo/icon/icon.png') }}"
                                        class="header-brand-img mobile-logo" alt="mobile-logo">
                                @else
                                    <img src="{{ asset('uploads/logo/icon/' . $title->image2) }}"
                                        class="header-brand-img mobile-logo" alt="mobile-logo">
                                @endif

                                {{-- Mobile-Dark-Logo --}}
                                @if ($title->image3 == null)
                                    <img src="{{ asset('uploads/logo/darkicon/icon-white.png') }}"
                                        class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @else
                                    <img src="{{ asset('uploads/logo/darkicon/' . $title->image3) }}"
                                        class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
                                @endif

                            </a>
                        </div>
                        <div class="app-sidebar3">
                            <div class="app-sidebar__user">
                                <div class="dropdown user-pro-body text-center">
                                    <div class="user-pic">
                                        @if (Auth::user()->image == null)
                                            <img src="{{ asset('uploads/profile/user-profile.png') }}"
                                                class="avatar-xxl rounded-circle mb-1" alt="default">
                                        @else
                                            <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}"
                                                class="avatar-xxl rounded-circle mb-1"
                                                alt="{{ Auth::user()->image }}">
                                        @endif

                                    </div>
                                    <div class="user-info">
                                        <h5 class="mb-2">{{ Auth::user()->name }}</h5>
                                        @if (!empty(Auth::user()->getRoleNames()[0]))
                                            <span
                                                class="text-muted app-sidebar__user-name text-sm">{{ Auth::user()->getRoleNames()[0] }}</span>
                                        @endif
                                        @php
                                            use App\Models\usersettings;
                                            if (Auth::check() && Auth::user()->id) {
                                                $avgrating1 = usersettings::where('users_id', Auth::id())->sum('star1');
                                                $avgrating2 = usersettings::where('users_id', Auth::id())->sum('star2');
                                                $avgrating3 = usersettings::where('users_id', Auth::id())->sum('star3');
                                                $avgrating4 = usersettings::where('users_id', Auth::id())->sum('star4');
                                                $avgrating5 = usersettings::where('users_id', Auth::id())->sum('star5');

                                                $avgr = 5 * $avgrating5 + 4 * $avgrating4 + 3 * $avgrating3 + 2 * $avgrating2 + 1 * $avgrating1;
                                                $avggr = $avgrating1 + $avgrating2 + $avgrating3 + $avgrating4 + $avgrating5;

                                                if ($avggr == 0) {
                                                    $avggr = 1;
                                                    $avg1 = $avgr / $avggr;
                                                } else {
                                                    $avg1 = $avgr / $avggr;
                                                }
                                            }
                                        @endphp

                                        <div class="allprofilerating pt-1" data-rating="{{ $avg1 }}"></div>
                                    </div>
                                </div>
                            </div>
                            <ul class="side-menu custom-ul">

                                <li class="slide">
                                    <a class="side-menu__item" href="{{ url('admin/') }}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
                                        </svg>
                                        <span
                                            class="side-menu__label">{{ trans('langconvert.menu.dashboard') }}</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ url('/admin/profile') }}">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 9c2.7 0 5.8 1.29 6 2v1H6v-.99c.2-.72 3.3-2.01 6-2.01m0-11C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <span class="side-menu__label">{{ trans('langconvert.menu.profile') }}</span>
                                    </a>
                                </li>
                                @can('Ticket Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M22 10V6c0-1.11-.9-2-2-2H4c-1.1 0-1.99.89-1.99 2v4c1.1 0 1.99.9 1.99 2s-.89 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zm-2-1.46c-1.19.69-2 1.99-2 3.46s.81 2.77 2 3.46V18H4v-2.54c1.19-.69 2-1.99 2-3.46 0-1.48-.8-2.77-1.99-3.46L4 6h16v2.54zM11 15h2v2h-2zm0-4h2v2h-2zm0-4h2v2h-2z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.menu.ticket') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Ticket Create')
                                                <li><a href="{{ url('/admin/createticket') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.createticket') }}</a>
                                                </li>
                                            @endcan

                                            @can('All Tickets')
                                                <li><a href="{{ url('/admin/alltickets') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.alltickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('My Tickets')
                                                <li><a href="{{ url('/admin/myticket') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.mytickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('Active Tickets')
                                                <li><a href="{{ url('/admin/activeticket') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.activetickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('Closed Tickets')
                                                <li><a href="{{ url('/admin/closedticket') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.closetickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('Assigned Tickets')
                                                <li><a href="{{ url('/admin/assignedtickets') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.assigntickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('My Assigned Tickets')
                                                <li><a href="{{ url('/admin/myassignedtickets') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.myassigntickets') }}</a>
                                                </li>
                                            @endcan
                                            @can('Onhold Tickets')
                                                <li><a href="{{ route('admin.onholdticket') }}" class="slide-item">
                                                        {{ trans('langconvert.adminmenu.onholdtickets') }} </a></li>
                                            @endcan
                                            @can('Overdue Tickets')
                                                <li><a href="{{ route('admin.overdueticket') }}" class="slide-item">
                                                        {{ trans('langconvert.adminmenu.overduetickets') }}</a></li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('Categories Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path
                                                    d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z">
                                                </path>
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.categories') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Category Access')
                                                <li><a href="{{ url('/admin/categories') }}"
                                                        class="slide-item">{{ trans('langconvert.newwordslang.maincategories') }}</a>
                                                </li>
                                            @endcan

                                            @can('Subcategory Access')
                                                <li><a href="{{ url('/admin/subcategories') }}"
                                                        class="slide-item">{{ trans('langconvert.newwordslang.subcategory') }}</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>

                                @endcan

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="sidemenu_icon"
                                            height="24px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;"
                                            xml:space="preserve">
                                            <g id="controller">
                                            </g>
                                            <g id="eco">
                                            </g>
                                            <g id="smartphone">
                                            </g>
                                            <g id="wrench">
                                            </g>
                                            <g id="screwdriver">
                                            </g>
                                            <g id="trolley">
                                            </g>
                                            <g id="Warehouse">
                                            </g>
                                            <g id="Factory">
                                            </g>
                                            <g id="Dump_truck">
                                            </g>
                                            <g id="Forklift">
                                            </g>
                                            <g id="plastic">
                                            </g>
                                            <g id="retail">
                                            </g>
                                            <g id="passed">
                                            </g>
                                            <g id="nuclear">
                                            </g>
                                            <g id="Failed">
                                            </g>
                                            <g id="Refinery">
                                            </g>
                                            <g id="Truck">
                                            </g>
                                            <g id="Digital">
                                            </g>
                                            <g id="Conveyor_belt">
                                            </g>
                                            <g id="Robot">
                                            </g>
                                            <g id="Crane">
                                            </g>
                                            <g id="Building">
                                            </g>
                                            <g id="service">
                                            </g>
                                            <g id="worker">
                                            </g>
                                            <g id="Steel">
                                            </g>
                                            <g id="supervisor">
                                            </g>
                                            <g id="Chemical">
                                            </g>
                                            <g id="electric_car">
                                            </g>
                                            <g id="Conveyor">
                                                <g>
                                                    <path d="M54.9976,43.4995H24.4139c0.1121-0.3143,0.1843-0.6476,0.1843-1v-6.3975c0-1.6543-1.3457-3-3-3h-6.397
   c-1.6543,0-3,1.3457-3,3v6.3975c0,0.3524,0.0723,0.6857,0.1843,1H8.9976C4.5132,43.4995,1,47.0146,1,51.502
   c0,4.4844,3.5132,7.9976,7.9976,7.9976h46c4.4126,0,8.0024-3.5879,8.0024-7.9976C63,47.0146,59.4849,43.4995,54.9976,43.4995z
   M14.2012,42.4995v-6.3975c0-0.5513,0.4487-1,1-1h6.397c0.5513,0,1,0.4487,1,1v6.3975c0,0.5513-0.4487,1-1,1h-6.397
   C14.6499,43.4995,14.2012,43.0508,14.2012,42.4995z M54.9976,57.4995h-46C5.6343,57.4995,3,54.8652,3,51.502
   c0-3.3657,2.6343-6.0024,5.9976-6.0024h6.2036h6.397h33.3994c3.3657,0,6.0024,2.6367,6.0024,6.0024
   C61,54.8091,58.3071,57.4995,54.9976,57.4995z" />
                                                    <path d="M2,6.501h37.5034v2.748c0,1.1177,0.9072,2.0269,2.022,2.0269h0.6748v4.639l-9.2168,7.1949
   c-0.6445,0.502-1.04,1.2236-1.1143,2.0317c-0.0776,0.8408,0.2002,1.665,0.7891,2.3291l7.4409,8.2134v0.1177c0,1.6543,1.3457,3,3,3
   h6.3975c1.7104,0,3-1.2896,3-3V35.569l7.249-8.1061c0.582-0.6563,0.8599-1.4805,0.7822-2.3213
   c-0.0742-0.8081-0.4697-1.5298-1.1094-2.0283l-9.1187-7.1949v-4.6425h0.9688c1.1147,0,2.022-0.9092,2.022-2.0269V6.501H62
   c0.5522,0,1-0.4478,1-1s-0.4478-1-1-1h-9.7095h-2.9883c-0.0009,0-0.0016-0.0005-0.0024-0.0005h-6.0996
   c-0.0009,0-0.0016,0.0005-0.0024,0.0005h-2.6943H2c-0.5522,0-1,0.4478-1,1S1.4478,6.501,2,6.501z M50.4966,35.8018
   c0,0.6909-0.5024,1-1,1h-6.3975c-0.5513,0-1-0.4487-1-1v-6.4019c0-0.5518,0.4487-1.0005,1-1.0005h6.3975
   c0.5513,0,1,0.4487,1,1.0005V35.8018z M48.3099,16.4501c0.0038,0.0797,0.024,0.1541,0.0466,0.2308
   c0.0148,0.0494,0.0244,0.0988,0.0463,0.1447c0.0305,0.0648,0.0751,0.1199,0.1198,0.1778c0.0362,0.0466,0.0687,0.093,0.1124,0.1325
   c0.017,0.0154,0.0251,0.0367,0.0433,0.0511l9.5059,7.5c0.2617,0.2041,0.3359,0.459,0.3525,0.6377
   c0.0259,0.2847-0.0762,0.5728-0.2847,0.8081l-5.7554,6.4357v-3.1686c0-1.6543-1.3457-3.0005-3-3.0005h-6.3975
   c-1.6543,0-3,1.3462-3,3.0005v3.3051l-5.9517-6.5693c-0.2109-0.2383-0.313-0.5264-0.2871-0.8115
   c0.0166-0.1782,0.0908-0.4331,0.353-0.6377l9.603-7.4966c0.0181-0.0142,0.0262-0.0351,0.0431-0.0502
   c0.0474-0.0422,0.0832-0.0916,0.1218-0.1421c0.0415-0.0545,0.0833-0.106,0.1123-0.1666c0.0243-0.0501,0.0358-0.104,0.0516-0.1584
   c0.0206-0.0721,0.0396-0.1415,0.0437-0.2162c0.0012-0.0196,0.0113-0.0361,0.0113-0.056v-5.1245h4.0996v5.1245
   C48.2998,16.418,48.309,16.4327,48.3099,16.4501z M51.2847,6.501l-0.0161,2.7749L41.5034,9.249V6.501H51.2847z" />
                                                    <path
                                                        d="M12.397,47.9111c-2.0332,0-3.6875,1.6543-3.6875,3.6875c0,2.0337,1.6543,3.688,3.6875,3.688
   c2.0337,0,3.688-1.6543,3.688-3.688C16.085,49.5654,14.4307,47.9111,12.397,47.9111z M12.397,53.2866
   c-0.9307,0-1.6875-0.7573-1.6875-1.688s0.7568-1.6875,1.6875-1.6875s1.688,0.7568,1.688,1.6875S13.3276,53.2866,12.397,53.2866z" />
                                                    <path d="M25.501,47.9111c-2.0332,0-3.6875,1.6543-3.6875,3.6875c0,2.0337,1.6543,3.688,3.6875,3.688
   c2.0361,0,3.6929-1.6543,3.6929-3.688C29.1938,49.5654,27.5371,47.9111,25.501,47.9111z M25.501,53.2866
   c-0.9307,0-1.6875-0.7573-1.6875-1.688s0.7568-1.6875,1.6875-1.6875c0.9336,0,1.6929,0.7568,1.6929,1.6875
   S26.4346,53.2866,25.501,53.2866z" />
                                                    <path d="M38.271,47.9111c-2.0332,0-3.6875,1.6543-3.6875,3.6875c0,2.0337,1.6543,3.688,3.6875,3.688
   c2.0361,0,3.6929-1.6543,3.6929-3.688C41.9639,49.5654,40.3071,47.9111,38.271,47.9111z M38.271,53.2866
   c-0.9307,0-1.6875-0.7573-1.6875-1.688s0.7568-1.6875,1.6875-1.6875c0.9336,0,1.6929,0.7568,1.6929,1.6875
   S39.2046,53.2866,38.271,53.2866z" />
                                                    <path d="M51.1284,47.9111c-2.0332,0-3.6875,1.6543-3.6875,3.6875c0,2.0337,1.6543,3.688,3.6875,3.688s3.6875-1.6543,3.6875-3.688
   C54.8159,49.5654,53.1616,47.9111,51.1284,47.9111z M51.1284,53.2866c-0.9307,0-1.6875-0.7573-1.6875-1.688
   s0.7568-1.6875,1.6875-1.6875s1.6875,0.7568,1.6875,1.6875S52.0591,53.2866,51.1284,53.2866z" />
                                                </g>
                                            </g>
                                            <g id="Car_factory">
                                            </g>
                                        </svg>
                                        <span class="side-menu__label">Lineups & Machines</span><i
                                            class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        <li><a href="{{ url('/admin/lineups') }}"
                                                class="slide-item">Lineups</a>
                                        </li>
                                        <li><a href="{{ url('/admin/lineup-documents') }}"
                                                class="slide-item">Lineup
                                                Documents</a></li>
                                        <li><a href="{{ url('/admin/machines') }}"
                                                class="slide-item">Machines</a>
                                        </li>
                                        <li><a href="{{ url('/admin/machine-documents') }}"
                                                class="slide-item">Machine
                                                Documents</a></li>
                                        <li><a href="{{ url('/admin/spare-parts') }}" class="slide-item">Spare
                                                Parts</a></li>
                                    </ul>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ url('/admin/spare-part-requests') }}">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"
                                            height="24px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;"
                                            xml:space="preserve" fill="#fff">
                                            <g id="controller">
                                            </g>
                                            <g id="eco">
                                            </g>
                                            <g id="smartphone">
                                            </g>
                                            <g id="wrench">
                                            </g>
                                            <g id="screwdriver">
                                            </g>
                                            <g id="trolley">
                                            </g>
                                            <g id="Warehouse">
                                            </g>
                                            <g id="Factory">
                                            </g>
                                            <g id="Dump_truck">
                                            </g>
                                            <g id="Forklift">
                                            </g>
                                            <g id="plastic">
                                            </g>
                                            <g id="retail">
                                            </g>
                                            <g id="passed">
                                            </g>
                                            <g id="nuclear">
                                            </g>
                                            <g id="Failed">
                                            </g>
                                            <g id="Refinery">
                                            </g>
                                            <g id="Truck">
                                            </g>
                                            <g id="Digital">
                                            </g>
                                            <g id="Conveyor_belt">
                                            </g>
                                            <g id="Robot">
                                            </g>
                                            <g id="Crane">
                                            </g>
                                            <g id="Building">
                                            </g>
                                            <g id="service">
                                                <g>
                                                    <path d="M56.1377,34.0542v-0.3008c0-1.8962-1.1446-3.4677-2.7917-4.1c0.6059-0.7567,0.9875-1.6962,0.9875-2.7155v-0.2959
   c0-2.4731-1.9351-4.4102-4.4053-4.4102H47.625V17.03c2.2462-1.7021,3.7061-4.3899,3.7061-7.4192
   c0-3.7886-2.1118-7.0566-5.5117-8.5283C45.5107,0.9497,45.1548,0.98,44.873,1.1641C44.5913,1.3491,44.4219,1.6631,44.4219,2
   v8.0303l-2.4053,1.9087l-2.4053-1.9087V2c0-0.3389-0.1719-0.6548-0.4561-0.8394c-0.2847-0.1841-0.6431-0.2109-0.9521-0.0732
   c-3.3413,1.4946-5.5005,4.8403-5.5005,8.5234c0,3.0748,1.5038,5.798,3.8076,7.4952v5.1259h-5.7061l-0.002-0.002
   c-0.8169-0.8193-1.9204-1.2715-3.1064-1.2725c-0.0015,0-0.0029,0-0.0039,0c-1.187,0-2.2925,0.4517-3.1133,1.2725l-0.002,0.002
   H22.585c-2.0573,0-3.7498,1.528-4.0437,3.5073h-5.6335c-2.7822,0-5.0454,2.2461-5.0454,5.0068v13.2231
   c0,2.8076,2.2163,5.0068,5.0454,5.0068h5.6332c0.2922,1.9788,1.9854,3.5073,4.0441,3.5073h13.9253v5.0103
   c0,1.4893,0.5649,2.8784,1.5933,3.9136C39.1006,62.4048,40.5635,63,42.0166,63c3.04,0,5.6084-2.5684,5.6084-5.6084v-4.811h4.1079
   c2.4702,0,4.4048-1.9351,4.4048-4.4053v-0.3008c0-1.3813-0.6183-2.5798-1.5836-3.3817c0.9547-0.8154,1.5836-2.0074,1.5836-3.3273
   v-0.3008c0-1.395-0.6303-2.6038-1.6122-3.4053C55.5074,36.658,56.1377,35.4492,56.1377,34.0542z M52.3335,26.6421v0.2959
   c0,1.3066-1.1016,2.4102-2.4053,2.4102h-2.4009c-1.3516,0-2.4102-1.0586-2.4102-2.4102v-0.2959
   c0-1.3516,1.0586-2.4102,2.4102-2.4102h2.4009C51.2769,24.2319,52.3335,25.2905,52.3335,26.6421z M34.7026,9.6108
   c0-2.3369,1.104-4.5005,2.9087-5.8652v6.7676c0,0.3052,0.1392,0.5938,0.3784,0.7832l3.4053,2.7021
   c0.3643,0.2891,0.8789,0.2891,1.2432,0l3.4053-2.7021c0.2393-0.1895,0.3784-0.478,0.3784-0.7832V3.7168
   c1.8252,1.3379,2.9092,3.48,2.9092,5.894c0,4.0332-3.2813,7.3145-7.3145,7.3145c-1.3766,0-2.661-0.3894-3.7619-1.0535
   c-0.1185-0.1355-0.2699-0.2319-0.4455-0.288C35.9333,14.2582,34.7026,12.0775,34.7026,9.6108z M36.5103,24.2319v3.7031
   l-3.705-3.7031H36.5103z M27.6919,22.9575c0.6172,0.0332,1.2539,0.2432,1.6948,0.686l8.6147,8.6099
   c0.9204,0.9209,0.9204,2.4771,0,3.3979l-0.1987,0.1987c-0.1403,0.1404-0.3043,0.2502-0.4768,0.3458
   c-0.1528,0.0297-0.2899,0.0886-0.4094,0.1792c-0.8517,0.2786-1.8729,0.1089-2.5069-0.525l-8.6147-8.6147
   c-0.4399-0.4399-0.6821-1.0425-0.6821-1.6968c0-0.6538,0.2422-1.2563,0.6831-1.6973l0.1978-0.1982
   C26.436,23.2012,27.0391,22.9575,27.6919,22.9575z M9.8623,43.9692V30.7461c0-1.6582,1.3662-3.0068,3.0454-3.0068h5.5728v19.2368
   h-5.5728C11.1714,46.9761,9.8623,45.6836,9.8623,43.9692z M22.585,50.4834c-1.1406,0-2.1045-0.9639-2.1045-2.1045v-0.4028V26.7393
   v-0.3979c0-1.1436,0.9639-2.1094,2.1045-2.1094h0.74c-0.1268,0.4182-0.2122,0.8525-0.2122,1.3066
   c0,1.1885,0.4502,2.293,1.2681,3.1108l8.6147,8.6147c0.8174,0.8179,1.9219,1.2681,3.1104,1.2681
   c0.1377,0,0.2692-0.0266,0.4043-0.0385v11.9897H22.585z M42.0166,61c-0.9204,0-1.8779-0.3857-2.4966-1.0044
   c-0.6606-0.665-1.0098-1.5303-1.0098-2.502v-6.0103V37.8298c0.2523-0.1632,0.4905-0.3496,0.7065-0.5656l0.1987-0.1987
   c1.687-1.687,1.6875-4.5381,0-6.2266l-0.9053-0.9048v-6.7021v-4.9973c1.0834,0.4422,2.2658,0.6907,3.5063,0.6907
   c1.2789,0,2.498-0.2596,3.6084-0.728v4.4671c-1.4911,0.6999-2.5078,2.1929-2.5078,3.9777v0.2959
   c0,1.3969,0.6314,2.6073,1.6149,3.4097c-0.9835,0.8015-1.6149,2.0105-1.6149,3.4058v0.3008c0,1.395,0.6311,2.6038,1.6143,3.4053
   c-0.9832,0.8015-1.6143,2.0103-1.6143,3.4053v0.3008c0,1.3656,0.6052,2.5526,1.5524,3.3545
   c-0.9473,0.8019-1.5524,1.9889-1.5524,3.3545v0.3008c0,1.7827,1.0167,3.2742,2.5078,3.9733v5.243
   C45.625,59.3477,43.9727,61,42.0166,61z M54.1377,47.8745v0.3008c0,1.3486-1.0562,2.4053-2.4048,2.4053h-4.2056
   c-1.3516,0-2.4102-1.0566-2.4102-2.4053v-0.3008c0-1.175,0.8042-2.1271,1.905-2.3531c0.1678,0.0186,0.3315,0.0494,0.5052,0.0494
   h4.2056c0.1693,0,0.3312-0.0321,0.4962-0.0518C53.3318,45.7419,54.1377,46.6965,54.1377,47.8745z M54.1377,40.8647v0.3008
   c0,1.1364-0.837,2.1181-1.9153,2.3516c-0.1628-0.0175-0.3213-0.0479-0.4895-0.0479h-4.2056c-0.1736,0-0.3373,0.0308-0.5052,0.0494
   c-1.1008-0.226-1.905-1.1781-1.905-2.3531v-0.3008c0-1.3486,1.0586-2.4053,2.4102-2.4053h4.2056
   C53.0815,38.4595,54.1377,39.5161,54.1377,40.8647z M47.5273,36.4595c-1.3516,0-2.4102-1.0566-2.4102-2.4053v-0.3008
   c0-1.3486,1.0586-2.4053,2.4102-2.4053h2.4009h1.8047c1.3486,0,2.4048,1.0566,2.4048,2.4053v0.3008
   c0,1.3486-1.0562,2.4053-2.4048,2.4053H47.5273z" />
                                                    <path d="M14.1689,41.4946h-0.0098c-0.5522,0-0.9951,0.4478-0.9951,1s0.4526,1,1.0049,1s1-0.4478,1-1
   S14.7212,41.4946,14.1689,41.4946z" />
                                                    <path d="M42.0557,55.3926h-0.0098c-0.5522,0-0.9951,0.4478-0.9951,1s0.4526,1,1.0049,1s1-0.4478,1-1
   S42.6079,55.3926,42.0557,55.3926z" />
                                                </g>
                                            </g>
                                            <g id="worker">
                                            </g>
                                            <g id="Steel">
                                            </g>
                                            <g id="supervisor">
                                            </g>
                                            <g id="Chemical">
                                            </g>
                                            <g id="electric_car">
                                            </g>
                                            <g id="Conveyor">
                                            </g>
                                            <g id="Car_factory">
                                            </g>
                                        </svg>
                                        <span class="side-menu__label">Spare Part Requests</span><i
                                            class="angle fa fa-angle-right"></i>
                                    </a>
                                </li>


                                @can('Knowledge Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <g>
                                                    <rect fill="none" height="24" width="24" />
                                                </g>
                                                <g>
                                                    <g />
                                                    <g>
                                                        <path
                                                            d="M17,19.22H5V7h7V5H5C3.9,5,3,5.9,3,7v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-7h-2V19.22z" />
                                                        <path
                                                            d="M19,2h-2v3h-3c0.01,0.01,0,2,0,2h3v2.99c0.01,0.01,2,0,2,0V7h3V5h-3V2z" />
                                                        <rect height="2" width="8" x="7" y="9" />
                                                        <polygon points="7,12 7,14 15,14 15,12 12,12" />
                                                        <rect height="2" width="8" x="7" y="15" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.menu.knowledge') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">

                                            @can('Article Access')
                                                <li><a href="{{ url('/admin/article') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.articles') }}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('Project Access')
                                    <li class="slide">
                                        <a class="side-menu__item" href="{{ url('/admin/projects') }}">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <g>
                                                    <rect fill="none" height="24" width="24" />
                                                    <g>
                                                        <path
                                                            d="M19,5v14H5V5H19 M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3L19,3z" />
                                                    </g>
                                                    <path d="M14,17H7v-2h7V17z M17,13H7v-2h10V13z M17,9H7V7h10V9z" />
                                                </g>
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.projects') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Managerole Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <g>
                                                    <path d="M0,0h24v24H0V0z" fill="none" />
                                                </g>
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z" />
                                                        <path
                                                            d="M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4C7.79,4,6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2 c-1.1,0-2-0.9-2-2S8.9,6,10,6z" />
                                                        <path
                                                            d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.manageroles') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Roles & Permission Access')
                                                <li><a href="{{ url('/admin/role') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.rolespermission') }}</a>
                                                </li>
                                            @endcan
                                            @can('Roles & Permission Create')
                                                <li><a href="{{ url('/admin/employee/create') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.createemployee') }}</a>
                                                </li>
                                            @endcan
                                            @can('Employee Access')
                                                <li><a href="{{ url('/admin/employee') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.employeeslist') }}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('Landing Page Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.landingpagesetting') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Banner Access')
                                                <li><a href="{{ url('/admin/bannersetting') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.banner') }}</a>
                                                </li>
                                            @endcan
                                            @can('Feature Box Access')
                                                <li><a href="{{ url('/admin/feature-box') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.featurebox') }}</a>
                                                </li>
                                            @endcan
                                            @can('Call To Action Access')
                                                <li><a href="{{ url('/admin/call-to-action') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.callactionbox') }}</a>
                                                </li>
                                            @endcan
                                            @can('Testimonial Access')
                                                <li><a href="{{ url('/admin/testimonial') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.testimonial') }}</a>
                                                </li>
                                            @endcan
                                            @can('FAQs Access')
                                                <li><a href="{{ url('/admin/faq') }}"
                                                        class="slide-item">{{ trans('langconvert.menu.faq') }}</a></li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('Customers Access')
                                    <li class="slide">
                                        <a class="side-menu__item" href="{{ url('/admin/customer') }}">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5zM4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25H4.34zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5 5.5 6.57 5.5 8.5 7.07 12 9 12zm0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7zm7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44zM15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.customers') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @php $module = Module::all(); @endphp

                                @if (in_array('Uhelpupdate', $module))
                                    @can('Canned Response Access')
                                        <li class="slide">
                                            <a class="side-menu__item" href="{{ route('admin.cannedmessages') }}">
                                                <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                    enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                    width="24px" fill="#000000">
                                                    <g>
                                                        <rect fill="none" height="24" width="24" />
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <polygon
                                                                points="16.6,10.88 15.18,9.46 10.94,13.71 8.82,11.58 7.4,13 10.94,16.54" />
                                                            <path
                                                                d="M19,4H5C3.89,4,3,4.9,3,6v12c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V6C21,4.9,20.11,4,19,4z M19,18H5V8h14V18z" />
                                                        </g>
                                                    </g>
                                                </svg>
                                                <span
                                                    class="side-menu__label">{{ trans('langconvert.newwordslang.cannedresponse') }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Envato Access')
                                        @if (setting('ENVATO_ON') == 'on')
                                            <li class="slide">
                                                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                                    <svg class="sidemenu_icon"
                                                        style="enable-background:new 0 0 512 512; width: 18px; height: 18px;"
                                                        version="1.1" viewBox="0 0 512 512" xml:space="preserve"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                        <g id="_x38_5-envato">
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="M401.225,19.381c-17.059-8.406-103.613,1.196-166.01,61.218      c-98.304,98.418-95.947,228.089-95.947,228.089s-3.248,13.335-17.086-6.011c-30.305-38.727-14.438-127.817-12.651-140.23      c2.508-17.494-8.615-17.999-13.243-12.229c-109.514,152.46-10.616,277.288,54.136,316.912      c75.817,46.386,225.358,46.354,284.922-85.231C509.547,218.042,422.609,29.875,401.225,19.381L401.225,19.381z M401.225,19.381" />
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="Layer_1" />
                                                    </svg>
                                                    <span
                                                        class="side-menu__label">{{ trans('langconvert.newwordslang.envato') }}</span><i
                                                        class="angle fa fa-angle-right"></i>
                                                </a>
                                                <ul class="slide-menu custom-ul">

                                                    @can('Envato API Token Access')
                                                        <li>
                                                            <a href="{{ route('admin.envatoapitoken') }}"
                                                                class="slide-item">{{ trans('langconvert.newwordslang.envatolicense') }}</a>
                                                        </li>
                                                    @endcan
                                                    @can('Envato License Details Access')
                                                        <li>
                                                            <a href="{{ route('admin.envatolicensesearch') }}"
                                                                class="slide-item">{{ trans('langconvert.newwordslang.envatolicensesearch') }}</a>
                                                        </li>
                                                    @endcan

                                                </ul>
                                            </li>
                                        @endif
                                    @endcan
                                    @can('App Info Access')
                                        <li class="slide">
                                            <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                                <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" width="24px" fill="#000000">
                                                    <path d="M0 0h24v24H0V0z" fill="none" />
                                                    <path
                                                        d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                                </svg>
                                                <span
                                                    class="side-menu__label">{{ trans('langconvert.newwordslang.appinfo') }}</span><i
                                                    class="angle fa fa-angle-right"></i>
                                            </a>
                                            <ul class="slide-menu custom-ul">
                                                @can('App Purchase Code Access')
                                                    <li>
                                                        <a href="{{ route('admin.licenseinfo') }}"
                                                            class="slide-item">{{ trans('langconvert.newwordslang.appcode') }}</a>
                                                    </li>
                                                @endcan

                                            </ul>
                                        </li>
                                    @endcan
                                @endif

                                @can('Groups Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <rect fill="none" height="24" width="24" />
                                                <g>
                                                    <path
                                                        d="M4,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C2,12.1,2.9,13,4,13z M5.13,14.1C4.76,14.04,4.39,14,4,14 c-0.99,0-1.93,0.21-2.78,0.58C0.48,14.9,0,15.62,0,16.43V18l4.5,0v-1.61C4.5,15.56,4.73,14.78,5.13,14.1z M20,13c1.1,0,2-0.9,2-2 c0-1.1-0.9-2-2-2s-2,0.9-2,2C18,12.1,18.9,13,20,13z M24,16.43c0-0.81-0.48-1.53-1.22-1.85C21.93,14.21,20.99,14,20,14 c-0.39,0-0.76,0.04-1.13,0.1c0.4,0.68,0.63,1.46,0.63,2.29V18l4.5,0V16.43z M16.24,13.65c-1.17-0.52-2.61-0.9-4.24-0.9 c-1.63,0-3.07,0.39-4.24,0.9C6.68,14.13,6,15.21,6,16.39V18h12v-1.61C18,15.21,17.32,14.13,16.24,13.65z M8.07,16 c0.09-0.23,0.13-0.39,0.91-0.69c0.97-0.38,1.99-0.56,3.02-0.56s2.05,0.18,3.02,0.56c0.77,0.3,0.81,0.46,0.91,0.69H8.07z M12,8 c0.55,0,1,0.45,1,1s-0.45,1-1,1s-1-0.45-1-1S11.45,8,12,8 M12,6c-1.66,0-3,1.34-3,3c0,1.66,1.34,3,3,3s3-1.34,3-3 C15,7.34,13.66,6,12,6L12,6z" />
                                                </g>
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.groups') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Groups Create')
                                                <li><a href="{{ url('/admin/groups/create') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.creategroup') }}</a>
                                                </li>
                                            @endcan
                                            @can('Groups List Access')
                                                <li><a href="{{ url('/admin/groups') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.grouplist') }}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan

                                <li class="slide">
                                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                        <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z" />
                                        </svg>
                                        <span
                                            class="side-menu__label">{{ trans('langconvert.adminmenu.notification') }}</span><i
                                            class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu custom-ul">
                                        <li><a href="{{ route('notificationpage') }}"
                                                class="slide-item smark-all">{{ trans('langconvert.adminmenu.allnotifys') }}</a>
                                        </li>

                                        @can('Custom Notifications Access')
                                            <li><a href="{{ route('mail.index') }}"
                                                    class="slide-item">{{ trans('langconvert.adminmenu.customnotify') }}</a>
                                            </li>
                                        @endcan

                                    </ul>
                                </li>
                                @can('Custom Pages Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M11.99 18.54l-7.37-5.73L3 14.07l9 7 9-7-1.63-1.27zM12 16l7.36-5.73L21 9l-9-7-9 7 1.63 1.27L12 16zm0-11.47L17.74 9 12 13.47 6.26 9 12 4.53z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.custompages') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('Pages Access')
                                                <li><a href="{{ url('/admin/pages') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.pages') }}</a>
                                                </li>
                                            @endcan
                                            @can('404 Error Page Access')
                                                <li><a href="{{ url('/admin/error404') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.404errorpage') }}</a>
                                                </li>
                                            @endcan
                                            @can('Under Maintanance Page Access')
                                                <li><a href="{{ url('/admin/maintenancepage') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.undermaintanenece') }}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('App Setting Access')

                                    <li class="slide">
                                        <a class="side-menu__item" data-bs-toggle="slide" href="#">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.appsetting') }}</span><i
                                                class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu custom-ul">
                                            @can('General Setting Access')
                                                <li><a href="{{ url('/admin/general') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.generalsetting') }}</a>
                                                </li>
                                            @endcan
                                            @can('Ticket Setting Access')
                                                <li><a href="{{ url('/admin/ticketsetting') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.ticketsetting') }}</a>
                                                </li>
                                            @endcan
                                            @can('SEO Access')
                                                <li><a href="{{ url('/admin/seo') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.seo') }}</a>
                                                </li>
                                            @endcan
                                            @can('Google Analytics Access')
                                                <li><a href="{{ url('/admin/googleanalytics') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.googleanalytics') }}</a>
                                                </li>
                                            @endcan
                                            @can('Custom JS & CSS Access')
                                                <li><a href="{{ url('/admin/customcssjssetting') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.customjscss') }}</a>
                                                </li>
                                            @endcan
                                            @can('Captcha Setting Access')
                                                <li><a href="{{ url('/admin/captcha') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.captchasetting') }}</a>
                                                </li>
                                            @endcan
                                            @can('Social Logins Access')
                                                <li><a href="{{ url('/admin/sociallogin') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.sociallogin') }}</a>
                                                </li>
                                            @endcan
                                            @can('Email Setting Access')
                                                <li><a href="{{ url('/admin/emailsetting') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.emailsetting') }}</a>
                                                </li>
                                            @endcan
                                            @can('Custom Chat Access')
                                                <li><a href="{{ url('/admin/customchatsetting') }}"
                                                        class="slide-item">{{ trans('langconvert.admindashboard.externalchat') }}</a>
                                                </li>
                                            @endcan
                                            @can('Maintenance Mode Access')
                                                <li><a href="{{ url('/admin/maintenancemode') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.maintanacemode') }}</a>
                                                </li>
                                            @endcan
                                            @can('SecruitySetting Access')
                                                <li><a href="{{ url('/admin/securitysetting') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.securitysetting') }}</a>
                                                </li>
                                            @endcan
                                            @can('IpBlock Access')
                                                <li><a href="{{ route('ipblocklist') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.iplist') }}</a>
                                                </li>
                                            @endcan
                                            @can('Emailtoticket Access')
                                                <li><a href="{{ route('admin.emailtoticket') }}"
                                                        class="slide-item">{{ trans('langconvert.adminmenu.emailtoticket') }}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                @can('Announcements Access')
                                    <li class="slide">
                                        <a class="side-menu__item" href="{{ url('/admin/announcement') }}">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                                width="24px" fill="#000000">
                                                <g>
                                                    <rect fill="none" height="24" width="24" />
                                                </g>
                                                <path
                                                    d="M18,11c0,0.67,0,1.33,0,2c1.2,0,2.76,0,4,0c0-0.67,0-1.33,0-2C20.76,11,19.2,11,18,11z" />
                                                <path
                                                    d="M16,17.61c0.96,0.71,2.21,1.65,3.2,2.39c0.4-0.53,0.8-1.07,1.2-1.6c-0.99-0.74-2.24-1.68-3.2-2.4 C16.8,16.54,16.4,17.08,16,17.61z" />
                                                <path
                                                    d="M20.4,5.6C20,5.07,19.6,4.53,19.2,4c-0.99,0.74-2.24,1.68-3.2,2.4c0.4,0.53,0.8,1.07,1.2,1.6 C18.16,7.28,19.41,6.35,20.4,5.6z" />
                                                <path
                                                    d="M4,9c-1.1,0-2,0.9-2,2v2c0,1.1,0.9,2,2,2h1v4h2v-4h1l5,3V6L8,9H4z M9.03,10.71L11,9.53v4.94l-1.97-1.18L8.55,13H8H4v-2h4 h0.55L9.03,10.71z" />
                                                <path
                                                    d="M15.5,12c0-1.33-0.58-2.53-1.5-3.35v6.69C14.92,14.53,15.5,13.33,15.5,12z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.announcements') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Email Template Access')
                                    <li class="slide">
                                        <a class="side-menu__item" href="{{ url('/admin/emailtemplates') }}">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.emailtemplate') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Reports Access')
                                    <li class="slide">
                                        <a class="side-menu__item" href="{{ url('/admin/reports') }}">
                                            <svg class="sidemenu_icon" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 0 24 24" width="24px" fill="#000000">
                                                <path d="M0 0h24v24H0V0z" fill="none" />
                                                <path
                                                    d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5zM19 19.09H5V4.91h14v14.18zM6 15h12v2H6zm0-4h12v2H6zm0-4h12v2H6z" />
                                            </svg>
                                            <span
                                                class="side-menu__label">{{ trans('langconvert.adminmenu.report') }}</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>

                        </div>
                    </aside>
                    <!--aside closed-->
