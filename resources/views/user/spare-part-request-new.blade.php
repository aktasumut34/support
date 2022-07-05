@extends('layouts.usermaster')

@section('styles')
<!-- INTERNAl Summernote css -->
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.css') }}?v=<?php echo time(); ?>">

<!-- INTERNAl DropZone css -->
<link href="{{ asset('assets/plugins/dropzone/dropzone.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

<link href="{{ asset('assets/plugins/wowmaster/css/animate.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

<link href="{{ asset('assets/css/tailwind.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
<style>
    .enter-active,
    .leave-active {
        overflow: hidden;
        transition: height .2s linear;
    }
</style>
@endsection

@section('content')
<!-- Section -->
<section>
    <div class="bannerimg cover-image" data-bs-image-src="{{ asset('assets/images/photos/banner1.jpg') }}">
        <div class="header-text mb-0">
            <div class="container">
                <div class="row text-white">
                    <div class="col">
                        <h1 class="mb-0">{{ trans('langconvert.spare_parts.spare_part_request') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section -->

<!--Section-->
<section>
    <div class="cover-image sptb">
        <div class="appcontainer container">
            <div class="row">
                @include('includes.user.verticalmenu')
                <div class="col-xl-9">
                    <div id="app">
                        <div class="t-grid t-grid-cols-1 lg:t-grid-cols-3 t-gap-4 t-items-start">
                            <div class="t-flex t-col-span-1 lg:t-col-span-2 t-flex-col t-gap-4">
                                <div class="t-flex t-flex-col t-gap-4 t-shadow-2xl t-p-4 lg:t-p-8 t-rounded-lg" style="background-color: #fff;" v-for='lineup in lineups'>
                                    <div class="t-flex t-justify-between">
                                        <div class="t-text-lg lg:t-text-xl 2xl:t-text-2xl t-font-semibold">{{ trans('langconvert.lineups.lineup') }}: ${
                                            lineup.name }$
                                        </div>
                                        <div class="t-flex t-gap-4">
                                            <input type="text" class="form-control" v-model="lineup.term" placeholder="{{ trans('langconvert.spare_parts.search') }}..." />
                                            <button class="t-text-2xl t-border-0 t-text-sky-600 t-bg-transparent" @click='toggleLineupShow(lineup)'>
                                                <i v-if='lineup.show' class="feather feather-chevron-up"></i>
                                                <i v-else class="feather feather-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <transition-collapse-height>
                                        <div class="t-flex t-gap-6 t-flex-col" v-show='lineup.show' v-if='filterMachines(lineup).length > 0'>
                                            <div class="t-flex t-flex-col t-gap-2" v-for='machine in filterMachines(lineup)'>
                                                <div class="t-flex t-justify-between t-items-center">
                                                    <div class="t-flex t-flex-col">
                                                        <div class="t-text-base lg:t-text-lg 2xl:t-text-xl t-text-slate-700 t-font-semibold">
                                                            ${ machine.name }$ - ${ machine.code }$
                                                        </div>
                                                        <span class="t-text-slate-500">{{ trans('langconvert.machines.serial_number') }}:
                                                            ${machine.pivot.serial_number}$</span>
                                                    </div>
                                                    <button class="t-text-2xl t-border-0 t-text-sky-600 t-bg-transparent" @click='toggleMachineShow(machine)'>
                                                        <i v-if='machine.show' class="feather feather-chevron-up"></i>
                                                        <i v-else class="feather feather-chevron-down"></i>
                                                    </button>
                                                </div>
                                                <template v-if='machine.show'>
                                                    <div class="t-grid t-grid-cols-2 lg:t-grid-cols-3 2xl:t-grid-cols-3 t-gap-4" v-if='machine.spare_parts && machine.spare_parts.length'>
                                                        <div v-for='spare_part in machine.spare_parts' class="t-flex t-p-4 t-rounded-lg t-flex-col t-bg-white t-border t-border-slate-900 t-shadow-xl">
                                                            <img :src="spare_part.image" alt="spare_part" class="t-w-full">
                                                            <span class="t-text-center t-font-bold t-pt-2 t-mt-auto t-leading-5">${
                                                                spare_part.name
                                                                }$</span>
                                                            <span class="t-text-center t-text-slate-600">${
                                                                spare_part.code
                                                                }$</span>
                                                                <span class="t-text-center t-text-slate-600 t-my-1" v-if="spare_part.size">Size: ${
                                                                spare_part.size
                                                                }$</span>
                                                            <div class="t-flex  t-justify-between t-items-center">
                                                                <div class="t-flex t-gap-2 t-items-center">
                                                                    <button class="t-bg-sky-600 t-border-0 t-text-white t-rounded-full t-w-6 t-h-6 t-flex t-items-center t-justify-center" @click='decrease(spare_part)'>

                                                                        <i class="feather feather-minus"></i> </button>
                                                                    ${ spare_part.quantity }$
                                                                    <button class="t-bg-sky-600 t-border-0 t-text-white t-rounded-full t-w-6 t-h-6 t-flex t-items-center t-justify-center" @click='increase(spare_part)'>

                                                                        <i class="feather feather-plus"></i> </button>
                                                                </div>
                                                                <button class="btn btn-primary" @click='addToCart(machine,spare_part)'>{{ trans('langconvert.spare_parts.add') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <div class="alert alert-info">
                                                            {{ trans('langconvert.spare_parts.no_spare_part') }}
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="alert alert-info">
                                                    {{ trans('langconvert.spare_parts.no_spare_part_query') }}
                                            </div>
                                        </div>
                                    </transition-collapse-height>
                                </div>
                            </div>

                            <div class="t-col-span-1 t-flex t-flex-col t-gap-4 t-p-4 lg:t-p-8 t-rounded-lg t-shadow-2xl" style="background-color: #fff;">
                                <div class="t-text-lg lg:t-text-xl 2xl:t-text-2xl t-font-semibold">
                                    Cart
                                </div>
                                <div v-if='cart.length'>
                                    <div class="t-flex t-flex-col t-gap-2 t-py-4" style="border-bottom: 1px solid #adadad;" v-for='cart_item in cart'>
                                        <div class="t-flex t-flex-col">
                                            <div class="t-text-base lg:t-text-lg 2xl:t-text-xl t-text-slate-700 t-font-semibold">
                                                ${ cart_item.machine.name }$ - ${ cart_item.machine.code }$
                                            </div>
                                            <span class="t-text-slate-500">{{ trans('langconvert.machines.serial_number') }}:
                                                ${cart_item.machine.pivot.serial_number}$</span>
                                        </div>
                                        <div class="t-flex t-flex-col t-gap-3" v-if='cart_item.spare_parts'>
                                            <div class="t-grid t-grid-cols-6 t-gap-2 t-items-center" v-for='cart_spare_part in cart_item.spare_parts'>
                                                <img :src="cart_spare_part.image" alt="spare_part">
                                                <div class="t-flex t-flex-col t-col-span-3">
                                                    <span class="t-text-lg t-font-bold">${
                                                        cart_spare_part.name
                                                        }$</span>
                                                    <span class="t-text-slate-600">${
                                                        cart_spare_part.code
                                                        }$</span>
                                                </div>
                                                <div class="t-flex t-justify-between t-items-center t-col-span-2 t-gap-2">
                                                    <div class="t-flex t-gap-2 t-items-center">
                                                        <button class="t-bg-sky-600 t-border-0 t-text-white t-rounded-full t-w-6 t-h-6 t-flex t-items-center t-justify-center" @click='decrease(cart_spare_part)'>

                                                            <i class="feather feather-minus"></i> </button>
                                                        ${ cart_spare_part.quantity }$
                                                        <button class="t-bg-sky-600 t-border-0 t-text-white t-rounded-full t-w-6 t-h-6 t-flex t-items-center t-justify-center" @click='increase(cart_spare_part)'>
                                                            <i class="feather feather-plus"></i> </button>
                                                    </div>
                                                    <button class="t-text-red-500 t-p-0 t-border-0 t-text-xl t-bg-transparent" @click='removeFromCart(cart_item,cart_spare_part)'>
                                                        <i class="feather feather-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('spare-part-request-store') }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="cart" :value='cartComputed'>
                                        <button class="btn btn-primary t-mt-4"><i class="feather feather-send"></i>
                                            {{ trans('langconvert.spare_parts.send_request') }}</button>
                                    </form>
                                </div>
                                <div v-else>
                                    <div class="alert alert-info">
                                        {{ trans('langconvert.spare_parts.cart_no_items') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section-->
@endsection
@section('scripts')
<!-- INTERNAL Vertical-scroll js-->
<script src="{{ asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js') }}?v=<?php echo time(); ?>">
</script>

<!-- INTERNAL Summernote js  -->
<script src="{{ asset('assets/plugins/summernote/summernote.js') }}?v=<?php echo time(); ?>"></script>

<!-- INTERNAL Index js-->
<script src="{{ asset('assets/js/support/support-sidemenu.js') }}?v=<?php echo time(); ?>"></script>
<script src="{{ asset('assets/js/select2.js') }}?v=<?php echo time(); ?>"></script>

<!-- INTERNAL Dropzone js-->
<script src="{{ asset('assets/plugins/dropzone/dropzone.js') }}?v=<?php echo time(); ?>"></script>

<!-- wowmaster js-->
<script src="{{ asset('assets/plugins/wowmaster/js/wow.min.js') }}?v=<?php echo time(); ?>"></script>
<script src="https://unpkg.com/vue@3"></script>

<script>
    const comp = {
        name: 'transition-collapse-height',
        template: `<transition
    enter-active-class="enter-active"
    leave-active-class="leave-active"
    @before-enter="beforeEnter"
    @enter="enter"
    @after-enter="afterEnter"
    @before-leave="beforeLeave"
    @leave="leave"
    @after-leave="afterLeave"
  >
    <slot />
  </transition>`,
        methods: {
            /**
             * @param {HTMLElement} element
             */
            beforeEnter(element) {
                requestAnimationFrame(() => {
                    if (!element.style.height) {
                        element.style.height = '0px';
                    }

                    element.style.display = null;
                });
            },
            /**
             * @param {HTMLElement} element
             */
            enter(element) {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        element.style.height = `${element.scrollHeight}px`;
                    });
                });
            },
            /**
             * @param {HTMLElement} element
             */
            afterEnter(element) {
                element.style.height = null;
            },
            /**
             * @param {HTMLElement} element
             */
            beforeLeave(element) {
                requestAnimationFrame(() => {
                    if (!element.style.height) {
                        element.style.height = `${element.offsetHeight}px`;
                    }
                });
            },
            /**
             * @param {HTMLElement} element
             */
            leave(element) {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        element.style.height = '0px';
                    });
                });
            },
            /**
             * @param {HTMLElement} element
             */
            afterLeave(element) {
                element.style.height = null;
            },
        },
    };
    var app = Vue.createApp({
        components: {
            transitionCollapseHeight: comp,
        },
        data() {
            return {
                lineups: JSON.parse('{!! json_encode($lineups) !!}'),
                cart: []
            }
        },
        methods: {
            toggleLineupShow(lineup) {
                lineup.show = !lineup.show;
            },
            toggleMachineShow(machine) {
                machine.show = !machine.show;
            },
            filterMachines(lineup) {
                if (lineup.term.length) {
                    const rArray = [];
                    lineup.machines.forEach(machine => {
                        machine.spare_parts.forEach(spare_part => {
                            if (spare_part.name.toLowerCase().includes(lineup.term
                                    .toLowerCase()) || spare_part.code.toLowerCase()
                                .includes(
                                    lineup.term.toLowerCase())) {
                                let arrayMachine = rArray.find(r => r.id === machine.id)
                                if (arrayMachine) {
                                    arrayMachine.spare_parts.push(spare_part)
                                } else {
                                    rArray.push({
                                        ...machine,
                                        show: true,
                                        spare_parts: [spare_part]
                                    })
                                }
                            }
                        })
                    })
                    if (rArray.length) {
                        return rArray;
                    } else {
                        return lineup.machines.filter(machine => {
                            const machineMatched = machine.name.toLowerCase().includes(lineup.term
                                    .toLowerCase()) ||
                                machine.pivot.serial_number.toLowerCase().includes(lineup.term
                                    .toLowerCase()) || machine.code.toLowerCase().includes(lineup.term
                                    .toLowerCase());
                            return machineMatched;
                        })
                    }
                } else return lineup.machines;
            },
            increase(spare_part) {
                spare_part.quantity++;
            },
            decrease(spare_part) {
                if (spare_part.quantity > 1) spare_part.quantity--;
            },
            addToCart(machine, spare_part) {
                const cartItem = this.cart.find((item) => item.machine.pivot.serial_number == machine.pivot
                    .serial_number);
                if (cartItem) {
                    const p = cartItem.spare_parts.find((item) => item.id == spare_part.id);
                    if (p) {
                        p.quantity += spare_part.quantity;
                    } else {
                        cartItem.spare_parts.push({...spare_part});
                    }
                } else {
                    this.cart.push({
                        machine: {
                            ...machine,
                            spare_parts: []
                        },
                        spare_parts: [{
                            ...spare_part
                        }]
                    });
                }
                spare_part.quantity = 1;
            },
            removeFromCart(cart_item, cart_spare_part) {
                const index = this.cart.indexOf(cart_item);
                if (index > -1) {
                    const index_spare_part = cart_item.spare_parts.indexOf(cart_spare_part);
                    if (index_spare_part > -1) {
                        cart_item.spare_parts.splice(index_spare_part, 1);
                    }
                    if (cart_item.spare_parts.length == 0) {
                        this.cart.splice(index, 1);
                    }
                }
            }
        },
        computed: {
            cartComputed() {
                return JSON.stringify(this.cart);
            }
        },
        compilerOptions: {
            delimiters: ["${", "}$"]
        }
    }).mount('#app');
</script>
@endsection
