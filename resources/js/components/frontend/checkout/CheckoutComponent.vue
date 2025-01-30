<template>
    <LoadingComponent :props="loading" />
    <section class="pt-6 pb-24 sm:pt-8 sm:pb-16">
        <div class="container max-w-[965px]">
            <router-link :to="{ name: 'frontend.home' }"
                class="text-xs font-medium inline-flex mb-3 items-center gap-2 text-primary">
                <i class="lab lab-undo lab-font-size-16"></i>
                <span>{{ $t('label.back_to_home') }}</span>
            </router-link>
            <div class="row">
                <div class="col-12 md:col-7">
                    <div class="p-4 mb-6 rounded-2xl shadow-xs bg-white">
                        <h3 v-if="branches.length > 1" class="capitalize font-medium mb-2">{{
                            $t('label.select_branch')
                        }}</h3>

                        <Swiper v-if="branches.length > 1" :speed="1000" slidesPerView="auto" :spaceBetween="16"
                            class="mb-4">
                            <SwiperSlide v-for="branch in branches" :key="branch" class="branch-navs !w-fit !relative">
                                <button :class="checkoutProps.form.branch_id === branch.id ? 'active' : ''"
                                    :value="branch.id"
                                    class="overflow-hidden py-2 px-3 rounded-lg text-center text-sm whitespace-nowrap text-heading bg-[#F7F7FC] transition hover:text-primary hover:bg-primary/5"
                                    @click.prevent="changeBranch(branch)">
                                    {{ branch.name }}
                                </button>
                            </SwiperSlide>
                        </Swiper>
                        <MapComponent :key="mapKey" v-if="mapShow" :location="location" :position="branchPosition"
                            :setting="{ autocomplete: false, mouseEvent: false, currentLocation: false }" />

                        <div v-if="checkoutProps.form.order_type === orderTypeEnum.TAKEAWAY"
                            class="flex items-center gap-2 mb-3 mt-6">
                            <i class="lab lab-location text-xl text-primary"></i>
                            <span class="text-sm text-heading">{{ branchAddress }}</span>
                        </div>

                        <div v-if="checkoutProps.form.order_type === orderTypeEnum.DELIVERY" class="mb-5">
                            <div class="flex flex-wrap justify-between gap-5 mb-2.5">
                                <h4 class="capitalize font-medium"> {{ $t('label.delivery_address') }} </h4>
                                <div class="flex gap-3">
                                    <button v-if="Object.keys(localAddress).length !== 0" @click="editAddress"
                                        type="button"
                                        class="group text-xs capitalize font-medium flex items-center rounded-3xl py-1.5 px-3 gap-1 text-[#00749B] bg-[#D6F5FF] transition hover:text-white hover:bg-[#00749B]">
                                        <i class="lab lab-edit-2 lab-font-size-13"></i>
                                        <span>{{ $t('button.edit') }}</span>
                                    </button>
                                    <AddressComponent :getLocation="updateAddress" :props="addressProps" />
                                </div>
                            </div>
                            <div v-if="addresses.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-3 active-group">
                                <label @click="changeAddress(address)"
                                    :class="checkoutProps.form.address_id === address.id ? 'active' : ''"
                                    v-for="address in addresses" :key="address" :for="address.label"
                                    class="p-3 rounded-lg w-full border border-[#F7F7FC] bg-[#F7F7FC]">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2 text-xs text-[#008BBA]">
                                            <i class="icon-home"></i>
                                            <span class="font-medium">{{ address.label }}</span>
                                        </div>
                                        <div class="custom-radio sm">
                                            <input type="radio" :id="address.label"
                                                v-model="checkoutProps.form.address_id" :value="address.id"
                                                class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                    </div>
                                    <div class="text-xs flex gap-2 text-[#1F1F39]">
                                        <i class="icon-location1 mt-0.5"></i>
                                        <span v-if="address.apartment">{{ address.apartment }}, {{
                                            address.address
                                        }}</span>
                                        <span v-else>{{ address.address }}</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <h4 v-if="checkoutProps.form.order_type === orderTypeEnum.DELIVERY" class="font-medium mb-2.5">{{ $t('label.preferred_time') }}</h4>
                            <h4 v-else class="font-medium mb-2.5">{{ $t('label.preferred_time_takeaway') }}</h4>

                            <Swiper :speed="1000" slidesPerView="auto" :spaceBetween="16" class="mb-3">
                                <SwiperSlide class="active-group !w-fit !relative">
                                    <label @click="changeDayTake(dayTakeEnum.TODAY)" for="today"
                                        :class="dayTake === dayTakeEnum.TODAY ? 'active' : ''"
                                        class="w-full db-field-radio px-2.5 py-2 rounded-lg border border-[#F7F7FC] bg-[#F7F7FC]">
                                        <div class="custom-radio sm">
                                            <input type="radio" v-model="dayTake" :value="dayTakeEnum.TODAY" id="today"
                                                class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label for="today" class="db-field-label text-sm text-heading">
                                            {{ $t('label.today') }}
                                        </label>
                                    </label>
                                </SwiperSlide>
                                <SwiperSlide class="active-group !w-fit !relative">
                                    <label @click="changeDayTake(dayTakeEnum.TOMORROW)" for="tomorrow"
                                        :class="dayTake === dayTakeEnum.TOMORROW ? 'active' : ''"
                                        class="db-field-radio px-2.5 py-2 rounded-lg border border-[#F7F7FC] bg-[#F7F7FC]">
                                        <div class="custom-radio sm">
                                            <input type="radio" v-model="dayTake" :value="dayTakeEnum.TOMORROW"
                                                id="tomorrow" class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label for="tomorrow" class="db-field-label text-sm text-heading">
                                            {{ $t('label.tomorrow') }}
                                        </label>
                                    </label>
                                </SwiperSlide>
                            </Swiper>


                            <Swiper v-if="dayTake === dayTakeEnum.TODAY" :speed="1000" slidesPerView="auto"
                                :spaceBetween="16">
                                <SwiperSlide v-for="todayTimeSlot in todayTimeSlots" :key="todayTimeSlot"
                                    class="active-group !w-fit !relative">
                                    <label
                                        :class="todayTimeSlot.time === checkoutProps.form.delivery_time ? 'active' : ''"
                                        :for="todayTimeSlot.label"
                                        class="db-field-radio px-2.5 py-2 rounded-lg border border-[#F7F7FC] bg-[#F7F7FC]">
                                        <div class="custom-radio sm">
                                            <input v-model="checkoutProps.form.delivery_time" type="radio"
                                                :id="todayTimeSlot.label" :value="todayTimeSlot.time"
                                                class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label :for="todayTimeSlot.label" class="db-field-label text-sm text-heading">
                                            {{ todayTimeSlot.label }}
                                        </label>
                                    </label>
                                </SwiperSlide>
                            </Swiper>


                            <Swiper v-if="dayTake === dayTakeEnum.TOMORROW" :speed="1000" slidesPerView="auto"
                                :spaceBetween="16">
                                <SwiperSlide v-for="tomorrowTimeSlot in tomorrowTimeSlots" :key="tomorrowTimeSlot"
                                    class="active-group !w-fit !relative">
                                    <label
                                        :class="tomorrowTimeSlot.time === checkoutProps.form.delivery_time ? 'active' : ''"
                                        :for="tomorrowTimeSlot.label"
                                        class="w-full db-field-radio px-2.5 py-2 rounded-lg border border-[#F7F7FC] bg-[#F7F7FC]">
                                        <div class="custom-radio sm">
                                            <input v-model="checkoutProps.form.delivery_time" type="radio"
                                                :id="tomorrowTimeSlot.label" :value="tomorrowTimeSlot.time"
                                                class="custom-radio-field">
                                            <span class="custom-radio-span"></span>
                                        </div>
                                        <label :for="tomorrowTimeSlot.label"
                                            class="db-field-label text-sm text-heading">
                                            {{ tomorrowTimeSlot.label }}
                                        </label>
                                    </label>
                                </SwiperSlide>
                            </Swiper>

                        </div>
                    </div>
                </div>
                <div class="col-12 md:col-5">
                    <div class="rounded-2xl shadow-xs bg-white">
                        <div class="p-4 border-b">
                            <h3 class="capitalize font-medium mb-3 text-center">{{
                                $t('label.cart_summary')
                            }}</h3>
                            <div class="flex items-center rounded-2xl w-fit mx-auto mb-6 text-[#008BBA] bg-[#BDEFFF]">
                                <div v-if="setting.order_setup_delivery === activityEnum.ENABLE"
                                    class="relative cursor-pointer">
                                    <input @change="changeOrderType(orderTypeEnum.DELIVERY)" id="checkout-delivery"
                                        :checked="orderType === orderTypeEnum.DELIVERY" :value="orderTypeEnum.DELIVERY"
                                        class="cart-switch w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer"
                                        type="radio">
                                    <label
                                        class="py-1.5 px-3.5 rounded-2xl text-xs font-medium capitalize transition cursor-pointer"
                                        for="checkout-delivery">{{ $t('label.delivery') }}</label>
                                </div>
                                <div v-if="setting.order_setup_takeaway === activityEnum.ENABLE"
                                    class="relative cursor-pointer">
                                    <input @change="changeOrderType(orderTypeEnum.TAKEAWAY)" id="checkout-takeaway"
                                        :checked="orderType === orderTypeEnum.TAKEAWAY" :value="orderTypeEnum.TAKEAWAY"
                                        class="cart-switch w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer"
                                        type="radio">
                                    <label
                                        class="py-1.5 px-3.5 rounded-2xl text-xs font-medium capitalize transition cursor-pointer"
                                        for="checkout-takeaway">{{ $t('label.takeaway') }}</label>
                                </div>
                            </div>
                            <div class="pl-3">
                                <div v-for="cart in carts"
                                    class="mb-3 pb-3 border-b last:mb-0 last:pb-0 last:border-b-0 border-gray-2">
                                    <div class="flex items-center gap-3 relative">
                                        <h3
                                            class="absolute top-5 -left-3 text-sm w-[26px] h-[26px] leading-[26px] text-center rounded-full text-white bg-heading">
                                            {{ cart.quantity }}</h3>
                                        <img :src="cart.image" alt="thumbnail"
                                            class="w-16 h-16 rounded-lg flex-shrink-0">
                                        <div class="w-full">
                                            <span class="text-sm font-medium capitalize transition text-heading">
                                                {{ cart.name }}
                                            </span>
                                            <p v-if="Object.keys(cart.item_variations.variations).length !== 0"
                                                class="capitalize text-xs mb-1.5">
                                                <span v-for="(variation, variationName) in cart.item_variations.names">
                                                    {{ variationName }}: {{ variation }}, &nbsp;
                                                </span>
                                            </p>
                                            <h4 class="text-xs font-semibold">
                                                {{
                                                    currencyFormat(cart.total, setting.site_digit_after_decimal_point,
                                                        setting.site_default_currency_symbol, setting.site_currency_position)
                                                }}
                                            </h4>
                                        </div>
                                    </div>

                                    <ul v-if="cart.item_extras.extras.length > 0 || cart.instruction !== ''"
                                        class="flex flex-col gap-1.5 mt-2">
                                        <li v-if="cart.item_extras.extras.length > 0" class="flex gap-1">
                                            <h3 class="capitalize text-xs w-fit whitespace-nowrap">
                                                {{ $t('label.extras') }}:
                                            </h3>
                                            <p class="text-xs">
                                                <span v-for="extra in cart.item_extras.names">
                                                    {{ extra }}, &nbsp;
                                                </span>
                                            </p>
                                        </li>

                                        <li v-if="cart.instruction !== ''" class="flex gap-1">
                                            <h3 class="capitalize text-xs w-fit whitespace-nowrap">
                                                {{ $t('label.instruction') }}:
                                            </h3>
                                            <p class="text-xs">{{ cart.instruction }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <CouponComponent :props="{ total: parseFloat(subtotal) }" :coupon="coupon" />

                            <div class="rounded-xl mb-6 border border-[#EFF0F6]">
                                <ul class="flex flex-col gap-2 p-3 border-b border-dashed border-[#EFF0F6]">
                                    <li class="flex items-center justify-between text-heading">
                                        <span class="text-sm leading-6 capitalize">
                                            {{ $t('label.subtotal') }}
                                        </span>
                                        <span class="text-sm leading-6 capitalize">
                                            {{
                                                currencyFormat(subtotal, setting.site_digit_after_decimal_point,
                                                    setting.site_default_currency_symbol, setting.site_currency_position)
                                            }}
                                        </span>
                                    </li>
                                    <li class="flex items-center justify-between text-heading">
                                        <span class="text-sm leading-6 capitalize">
                                            {{ $t('label.discount') }}
                                        </span>
                                        <span class="text-sm leading-6 capitalize">
                                            {{
                                                currencyFormat(checkoutProps.form.discount,
                                                    setting.site_digit_after_decimal_point,
                                                    setting.site_default_currency_symbol,
                                                    setting.site_currency_position)
                                            }}
                                        </span>
                                    </li>
                                    <li v-if="checkoutProps.form.order_type === orderTypeEnum.DELIVERY"
                                        class="flex items-center justify-between text-heading">
                                        <span class="text-sm leading-6 capitalize">
                                            {{ $t('label.delivery_charge') }}
                                        </span>
                                        <span class="text-sm leading-6 capitalize font-medium text-[#1AB759]">
                                            {{
                                                currencyFormat(checkoutProps.form.delivery_charge,
                                                    setting.site_digit_after_decimal_point,
                                                    setting.site_default_currency_symbol,
                                                    setting.site_currency_position)
                                            }}
                                        </span>
                                    </li>
                                </ul>
                                <div class="flex items-center justify-between p-3">
                                    <h4 class="text-sm leading-6 font-semibold capitalize">
                                        {{ $t('label.total') }}
                                    </h4>
                                    <h5 class="text-sm leading-6 font-semibold capitalize">
                                        {{
                                            currencyFormat(subtotal +
                                                checkoutProps.form.delivery_charge - checkoutProps.form.discount,
                                                setting.site_digit_after_decimal_point, setting.site_default_currency_symbol,
                                                setting.site_currency_position)
                                        }}
                                    </h5>
                                </div>
                            </div>
                            <button v-if="whatsappSetup.status === activityEnum.ENABLE && placeOrderShow" type="button"
                                class="w-full rounded-3xl capitalize font-medium leading-6 py-3 text-white bg-[#1AB759] mb-2"
                                @click="orderSubmit($e, true)">
                                <i class="lab lab-whatsapp text-sm"></i>
                                {{ $t('button.proceed_to_whatsapp') }}
                            </button>
                            <button v-if="whatsappSetup.status !== activityEnum.ENABLE && placeOrderShow" type="button"
                                class="w-full rounded-3xl capitalize font-medium leading-6 py-3 text-white bg-primary"
                                @click="orderSubmit">
                                {{ $t('button.place_order') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import appService from "../../../services/appService";
import alertService from "../../../services/alertService";
import MapComponent from "../components/MapComponent";
import dayTakeEnum from "../../../enums/modules/dayTakeEnum";
import isAdvanceOrderEnum from "../../../enums/modules/isAdvanceOrderEnum";
import sourceEnum from "../../../enums/modules/sourceEnum";
import AddressComponent from "./AddressComponent";
import LoadingComponent from "../components/LoadingComponent";
import labelEnum from "../../../enums/modules/labelEnum";
import activityEnum from "../../../enums/modules/activityEnum";
import orderTypeEnum from "../../../enums/modules/orderTypeEnum";
import CouponComponent from "./CouponComponent";
import router from "../../../router";
import _ from "lodash";
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import statusEnum from "../../../enums/modules/statusEnum";
import env from "../../../config/env";


export default {
    name: "CheckoutComponent",
    components: {
        LoadingComponent,
        AddressComponent,
        CouponComponent,
        MapComponent,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            mapShow: false,
            placeOrderShow: false,
            mapKey: "branch",
            location: {
                lat: null,
                lng: null
            },
            branchAddress: null,
            localAddress: {},
            dayTakeEnum: dayTakeEnum,
            activityEnum: activityEnum,
            activityEnum: activityEnum,
            isAdvanceOrderEnum: isAdvanceOrderEnum,
            labelEnum: labelEnum,
            dayTake: dayTakeEnum.TODAY,
            orderTypeEnum: orderTypeEnum,
            enums: {
                orderTypeEnumArray: {
                    [orderTypeEnum.DELIVERY]: this.$t("label.delivery"),
                    [orderTypeEnum.TAKEAWAY]: this.$t("label.takeaway")
                }
            },
            checkoutProps: {
                form: {
                    branch_id: null,
                    subtotal: 0,
                    discount: 0,
                    delivery_charge: 0,
                    delivery_time: null,
                    total: 0,
                    order_type: null,
                    is_advance_order: null,
                    source: sourceEnum.WEB,
                    address_id: null,
                    coupon_id: null,
                    items: []
                }
            },
            addressProps: {
                form: {
                    address: "",
                    apartment: "",
                    latitude: "",
                    longitude: "",
                    label: "",
                },
                search: {
                    paginate: 0,
                    order_column: 'id',
                    order_type: 'asc'
                },
                status: false,
                switchLabel: "",
                isMap: false,
            },
            branchSettings: {
                itemsToShow: 2.5,
                wrapAround: false,
                snapAlign: "start"
            },
            branchBreakpoints: {
                200: {
                    itemsToShow: 1.1,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                250: {
                    itemsToShow: 1.3,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                300: {
                    itemsToShow: 1.4,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                375: {
                    itemsToShow: 1.7,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                540: {
                    itemsToShow: 2.5,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                700: {
                    itemsToShow: 2.5,
                    wrapAround: false,
                    snapAlign: 'start',
                }
            },
            dayTakeSettings: {
                itemsToShow: 2,
                wrapAround: false,
                snapAlign: "start"
            },
            dayTakeBreakpoints: {
                200: {
                    itemsToShow: 1.1,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                250: {
                    itemsToShow: 1.3,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                300: {
                    itemsToShow: 1.4,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                375: {
                    itemsToShow: 1.7,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                540: {
                    itemsToShow: 2.5,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                700: {
                    itemsToShow: 3.2,
                    wrapAround: false,
                    snapAlign: 'start',
                }
            },
            timeSettings: {
                itemsToShow: 3.2,
                wrapAround: false,
                snapAlign: "start"
            },
            timeBreakpoints: {
                200: {
                    itemsToShow: 1.1,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                250: {
                    itemsToShow: 1.3,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                300: {
                    itemsToShow: 1.4,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                375: {
                    itemsToShow: 1.7,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                540: {
                    itemsToShow: 2.5,
                    wrapAround: false,
                    snapAlign: 'start',
                },
                700: {
                    itemsToShow: 3.2,
                    wrapAround: false,
                    snapAlign: 'start',
                }
            },
            whatsappSetup: {
                status: activityEnum.DISABLE,
                phone: null,
            }
        }
    },
    computed: {
        globalState: function () {
            return this.$store.getters['globalState/lists'];
        },
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
        branches: function () {
            return this.$store.getters['frontendBranch/lists'];
        },
        branch: function () {
            return this.$store.getters['frontendBranch/show'];
        },
        carts: function () {
            return this.$store.getters['frontendCart/lists'];
        },
        subtotal: function () {
            return this.$store.getters['frontendCart/subtotal'];
        },
        todayTimeSlots: function () {
            return this.$store.getters['frontendTimeSlot/today'];
        },
        tomorrowTimeSlots: function () {
            return this.$store.getters['frontendTimeSlot/tomorrow'];
        },
        addresses: function () {
            return this.$store.getters['frontendAddress/lists'];
        },
        orderType: function () {
            return this.$store.getters['frontendCart/orderType'];
        },
        countryCode: function () {
            return this.$store.getters['frontendCountryCode/show'];
        }
    },
    mounted() {
        this.loading.isActive = true;

        this.$store.dispatch("frontendSetting/lists").then(res => {
            if ((res.data.data.order_setup_delivery === activityEnum.DISABLE && res.data.data.order_setup_takeaway === activityEnum.DISABLE) || this.$store.getters['frontendCart/lists'].length === 0) {
                this.$router.push({ name: 'frontend.home' });
            }
        }).catch();

        this.$store.dispatch("frontendTimeSlot/today", {}).then(res => {
            this.loading.isActive = false;
            if (res.data.data.length > 0) {
                if (typeof res.data.data[0] !== "undefined") {
                    this.checkoutProps.form.delivery_time = res.data.data[0].time;
                    this.checkoutProps.form.is_advance_order = isAdvanceOrderEnum.NO
                }
            }
        }).catch((err) => {
            this.loading.isActive = false;
        });

        this.loading.isActive = true;
        this.$store.dispatch("frontendTimeSlot/tomorrow", {}).then(res => {
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });

        this.loading.isActive = true;
        this.$store.dispatch("frontendAddress/lists", this.addressProps).then(res => {
            this.loading.isActive = false;
            if (typeof res.data.data[0] !== "undefined") {
                this.checkoutProps.form.address_id = res.data.data[0].id;
                this.localAddress = res.data.data[0];
            }
        }).catch((err) => {
            this.loading.isActive = false;
        });
        this.checkoutProps.form.branch_id = this.$store.getters['globalState/lists'].branch_id;
        if (this.checkoutProps.form.branch_id > 0) {
            this.loading.isActive = true;
            this.$store.dispatch("frontendBranch/show", this.checkoutProps.form.branch_id).then(res => {
                this.loading.isActive = false;
                this.location = {
                    lat: res.data.data.latitude,
                    lng: res.data.data.longitude
                };
                this.branchAddress = res.data.data.address;
            }).catch((err) => {
                this.loading.isActive = false;
            });

            window.setTimeout(() => {
                this.mapShow = true;
                this.placeOrderShow = true;
            }, 3000);
        }

        this.checkoutProps.form.order_type = this.orderType;

        this.branchWhatsappSetup();
    },
    methods: {
        branchPosition: function (e) {
            window.setTimeout(() => {
                this.deliveryChargeCalculation();
            }, 300);
        },
        currencyFormat: function (amount, decimal, currency, position) {
            return appService.currencyFormat(amount, decimal, currency, position);
        },
        editAddress: function () {
            if (typeof this.localAddress === "object" && this.checkoutProps.form.address_id !== null) {
                this.loading.isActive = true;
                this.$store.dispatch("frontendAddress/edit", this.checkoutProps.form.address_id).then((res) => {
                    this.loading.isActive = false;

                    this.addressProps.form.address = this.localAddress.address;
                    this.addressProps.form.apartment = this.localAddress.apartment;
                    this.addressProps.form.latitude = this.localAddress.latitude;
                    this.addressProps.form.longitude = this.localAddress.longitude;
                    this.addressProps.form.label = this.localAddress.label;

                    if (this.addressProps.form.label !== labelEnum.HOME && this.addressProps.form.label !== labelEnum.WORK) {
                        this.addressProps.status = true;
                        this.addressProps.switchLabel = labelEnum.OTHER;
                    } else {
                        this.addressProps.switchLabel = this.localAddress.label;
                    }

                    this.addressProps.isMap = true;
                    appService.modalShow('.address-modal');
                }).catch((err) => {
                    alertService.error(err.response.data.message);
                });
            }
        },
        updateAddress: function (address) {
            this.localAddress = address;
            this.checkoutProps.form.address_id = address.id;
            this.deliveryChargeCalculation();
        },
        changeBranch: function (branch) {
            this.mapShow = false;
            this.location.lat = branch.latitude;
            this.location.lng = branch.longitude;
            this.branchAddress = branch.address;
            this.checkoutProps.form.branch_id = branch.id;
            window.setTimeout(() => {
                this.mapShow = true;
            }, 3000);
            this.deliveryChargeCalculation();
            this.branchWhatsappSetup();
        },
        changeDayTake: function (id) {
            if (id === dayTakeEnum.TODAY) {
                if (typeof this.todayTimeSlots[0] !== "undefined") {
                    this.checkoutProps.form.delivery_time = this.todayTimeSlots[0].time;
                    this.checkoutProps.form.is_advance_order = isAdvanceOrderEnum.NO;
                } else {
                    this.checkoutProps.form.delivery_time = null;
                    this.checkoutProps.form.is_advance_order = isAdvanceOrderEnum.NO;
                }
            } else if (id === dayTakeEnum.TOMORROW) {
                if (typeof this.tomorrowTimeSlots[0] !== "undefined") {
                    this.checkoutProps.form.delivery_time = this.tomorrowTimeSlots[0].time;
                    this.checkoutProps.form.is_advance_order = isAdvanceOrderEnum.YES;
                } else {
                    this.checkoutProps.form.delivery_time = null;
                    this.checkoutProps.form.is_advance_order = isAdvanceOrderEnum.YES;
                }
            }
        },
        changeAddress: function (address) {
            this.localAddress = address;
            this.deliveryChargeCalculation();
        },
        deliveryChargeCalculation: function () {
            if (this.checkoutProps.form.order_type === orderTypeEnum.DELIVERY) {
                if ((typeof this.localAddress.latitude !== 'undefined' && this.localAddress.latitude !== '') && (typeof this.localAddress.longitude !== 'undefined' && this.localAddress.longitude !== '') && (typeof this.location.lat !== 'undefined' && this.location.lat !== '') && (typeof this.location.lng !== 'undefined' && this.location.lng !== '')) {
                    const distance = appService.distance(parseFloat(this.localAddress.latitude), parseFloat(this.localAddress.longitude), parseFloat(this.location.lat), parseFloat(this.location.lng));
                    if (distance > this.setting.order_setup_free_delivery_kilometer) {
                        let extraDistance = distance - parseFloat(this.setting.order_setup_free_delivery_kilometer);
                        this.checkoutProps.form.delivery_charge = (extraDistance * parseFloat(this.setting.order_setup_charge_per_kilo) + parseFloat(this.setting.order_setup_basic_delivery_charge));
                    } else {
                        this.checkoutProps.form.delivery_charge = parseFloat(this.setting.order_setup_basic_delivery_charge);
                    }
                }
            }
        },
        coupon: function (e) {
            if (Object.keys(e).length !== 0) {
                this.checkoutProps.form.discount = e.convert_discount;
                this.checkoutProps.form.coupon_id = e.id;
            } else {
                this.checkoutProps.form.discount = 0;
                this.checkoutProps.form.coupon_id = null;
            }
        },
        orderSubmit: function (e, is_whats_app = false) {
            this.loading.isActive = true;
            this.checkoutProps.form.subtotal = this.subtotal;
            this.checkoutProps.form.total = parseFloat(this.subtotal + this.checkoutProps.form.delivery_charge - this.checkoutProps.form.discount).toFixed(this.setting.site_digit_after_decimal_point);
            this.checkoutProps.form.items = [];
            _.forEach(this.carts, (item, index) => {
                let item_variations = [];
                if (Object.keys(item.item_variations.variations).length > 0) {
                    _.forEach(item.item_variations.variations, (value, index) => {
                        item_variations.push({
                            "id": value,
                            "item_id": item.item_id,
                            "item_attribute_id": index,
                        });
                    });
                }

                if (Object.keys(item.item_variations.names).length > 0) {
                    let i = 0;
                    _.forEach(item.item_variations.names, (value, index) => {
                        item_variations[i].variation_name = index;
                        item_variations[i].name = value;
                        i++;
                    });
                }

                let item_extras = [];
                if (item.item_extras.extras.length) {
                    _.forEach(item.item_extras.extras, (value) => {
                        item_extras.push({
                            id: value,
                            item_id: item.item_id,
                        });
                    });
                }

                if (item.item_extras.names.length) {
                    let i = 0;
                    _.forEach(item.item_extras.names, (value) => {
                        item_extras[i].name = value;
                        i++;
                    });
                }

                this.checkoutProps.form.items.push({
                    item_id: item.item_id,
                    item_name: item.name,
                    item_price: item.convert_price,
                    branch_id: this.checkoutProps.form.branch_id,
                    instruction: item.instruction,
                    quantity: item.quantity,
                    discount: item.discount,
                    total_price: item.total,
                    item_variation_total: item.item_variation_total,
                    item_extra_total: item.item_extra_total,
                    item_variations: item_variations,
                    item_extras: item_extras
                });
            });
            this.checkoutProps.form.items = JSON.stringify(this.checkoutProps.form.items);
            this.$store.dispatch('frontendOrder/save', this.checkoutProps.form).then(orderResponse => {

                if (is_whats_app) {
                    this.whatsAppOrderSubmit(orderResponse.data.data);
                }

                this.mapShow = false;
                this.location.lat = null;
                this.location.lng = null;
                this.branchAddress = null;
                this.localAddress = {};

                this.checkoutProps.form.branch_id = null;
                this.checkoutProps.form.subtotal = null;
                this.checkoutProps.form.discount = 0;
                this.checkoutProps.form.delivery_charge = 0;
                this.checkoutProps.form.delivery_time = null;
                this.checkoutProps.form.total = 0;
                this.checkoutProps.form.order_type = null;
                this.checkoutProps.form.is_advance_order = null;
                this.checkoutProps.form.address_id = null;
                this.checkoutProps.form.coupon_id = null;
                this.checkoutProps.form.items = [];

                this.$store.dispatch('frontendCart/resetCart').then(res => {
                    this.loading.isActive = false;
                    if (!is_whats_app) {
                        router.push({ name: "frontend.myOrder", query: { id: orderResponse.data.data.id } });
                    } else if (env.DEMO === "true" || env.DEMO === true || env.DEMO === "1" || env.DEMO === 1) {
                        router.push({ name: "frontend.myOrder" });
                    }
                }).catch();

            }).catch((err) => {
                this.loading.isActive = false;
                if (typeof err.response.data.errors === 'object') {
                    _.forEach(err.response.data.errors, (error) => {
                        alertService.error(error[0]);
                    });
                }
            });
        },
        whatsAppOrderSubmit: function (order) {


            let text = `
${this.$t('menu.order')} - ${this.setting.company_name}
****************************************************
${this.$t('label.order_id')}#  : ${order.order_serial_no}
${this.$t("label.order_type")}  : ${this.enums.orderTypeEnumArray[order.order_type]}
${this.$t('label.delivery_time')}   :   ${order.delivery_date} (${order.delivery_time})
--------------------------
`;

            text += `
${this.$t('label.order_details')}
--------------------------
`;

            for (let i = 0; i < order.order_items.length; i++) {
                const item = order.order_items[i];

                text += `
${i + 1})  ${item.item_name}
`;

                //item variations
                if (item.item_variations.length > 0) {
                    for (let j = 0; j < item.item_variations.length; j++) {
                        const variation = item.item_variations[j];
                        text += `
    ${variation.variation_name} :   ${variation.name}
    `;
                    }
                }
                text += `
    --------------------------
    ${this.$t('label.price')}       : ${item.price}
    ${this.$t('label.quantity')}    : ${item.quantity}
    ${this.$t('label.discount')}    : ${item.discount}
    --------------------------
    ${this.$t('label.total')}       : ${item.total_currency_price}
    --------------------------
                    `;

                // item extras
                if (item.item_extras.length > 0) {
                    text += `
    ${this.$t('label.item')} ${this.$t('label.extras')}
    --------------------------
                        `;
                    for (let j = 0; j < item.item_extras.length; j++) {
                        const extra = item.item_extras[j];
                        text += `
        ${j + 1}    :   ${extra.name}
                            `;
                    }
                    text += `
    --------------------------
                        `;
                }
                if (item.instruction) {
                    text += `
    ${this.$t('label.instruction')}    :   ${item.instruction}
    `;
                }

            }


            text += `
${this.$t('label.subtotal')}        : ${order.subtotal_currency_price}
${this.$t('label.discount')}        : ${order.discount_currency_price}
${this.$t('label.delivery_charge')} :    ${order.delivery_charge_currency_price}
${this.$t('label.total')}           :   ${order.total_currency_price}
--------------------------
`;


            text += `
${this.$t('label.customer')}
--------------------------
${this.$t('label.name')}    :   ${order.user?.name}
${this.$t('label.email')}   :   ${order.user?.email}
${this.$t('label.mobile_number')}  : ${this.countryCode.calling_code}${order.user?.phone}
${this.$t('label.apartment')}  : ${order.order_address?.apartment}
${this.$t('label.address')}  : ${order.order_address?.address}
`;



            //send to whats app
            text = encodeURIComponent(text);

            if (env.DEMO === "true" || env.DEMO === true || env.DEMO === "1" || env.DEMO === 1) {
                window.open("https://api.whatsapp.com/send?phone=" + this.countryCode.calling_code + '' + this.whatsappSetup.phone + "&text=" + text, "_blank");
            } else {
                window.location = "https://api.whatsapp.com/send?phone=" + this.countryCode.calling_code + '' + this.whatsappSetup.phone + "&text=" + text;
            }
        },
        changeOrderType: function (e) {
            this.checkoutProps.form.order_type = e;
            this.$store.dispatch('frontendCart/updateOrderType', this.checkoutProps.form.order_type).then().catch();
            if (this.checkoutProps.form.order_type === orderTypeEnum.TAKEAWAY) {
                this.checkoutProps.form.delivery_charge = 0;
            } else {
                this.deliveryChargeCalculation();
            }
        },
        branchWhatsappSetup: function () {
            this.whatsappSetup = {
                status: activityEnum.DISABLE,
                phone: null
            }
            this.$store.dispatch('frontendBranch/whatsappSetup', this.checkoutProps.form.branch_id)
                .then((res) => {
                    const setup = res.data.data;
                    this.whatsappSetup = {
                        status: setup?.status,
                        phone: setup?.phone
                    }
                })
        }
    },
    watch: {
        globalState: {
            deep: true,
            handler(global) {
                if (global.branch_id !== "undefined") {
                    this.loading.isActive = true;
                    this.checkoutProps.form.branch_id = global.branch_id;
                    this.$store.dispatch("frontendBranch/show", this.checkoutProps.form.branch_id).then(res => {
                        this.loading.isActive = false;
                        this.location.lat = res.data.data.latitude;
                        this.location.lng = res.data.data.longitude;
                        this.branchAddress = res.data.data.address;
                    }).catch();

                    window.setTimeout(() => {
                        this.mapShow = true;
                    }, 3000);
                }
            }
        },
        orderType: {
            deep: true,
            handler(orderTypeObject) {
                this.checkoutProps.form.order_type = orderTypeObject;
                if (orderTypeObject === orderTypeEnum.TAKEAWAY) {
                    this.checkoutProps.form.delivery_charge = 0;
                } else {
                    this.deliveryChargeCalculation();
                }
            }
        }
    }
}
</script>