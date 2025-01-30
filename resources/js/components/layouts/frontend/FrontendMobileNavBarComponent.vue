<template>
    <nav
        class="flex items-center justify-between py-3 px-5 fixed bottom-0 left-0 z-20 w-full rounded-tr-3xl rounded-tl-3xl shadow-xl-top bg-white lg:hidden">
        <router-link :class="checkIsPathAndRoutePathSame('/home') ? 'text-primary' : ''"
            class="flex flex-col items-center gap-1" :to="{ name: 'frontend.home' }">
            <i class="fa-solid fa-house text-sm leading-none"></i>
            <span class="text-xs capitalize">{{ $t('menu.home') }}</span>
        </router-link>

        <router-link :class="checkIsPathAndRoutePathSame('/menu') ? 'text-primary' : ''"
            class="flex flex-col items-center gap-1" :to="{ name: 'frontend.menu', query: { s: categoryProps.slug } }">
            <i class="fa-solid fa-layer-group text-base leading-none"></i>
            <span class="text-xs capitalize">{{ $t('label.menu') }}</span>
        </router-link>

        <button class="mobcart fa-solid fa-bag-shopping text-base w-12 h-12 leading-[48px] text-center rounded-full -mt-12 text-white bg-primary
        relative after:absolute after:top-3 ltr:after:right-2.5 rtl:after:left-2.5 after:w-2 after:h-2 after:rounded-full
        after:shadow after:bg-[#FFDB1F]"></button>

        <router-link :class="checkIsPathAndRoutePathSame('/offers') ? 'text-primary' : ''"
            class="flex flex-col items-center gap-1" :to="{ name: 'frontend.offers' }">
            <i class="fa-solid fa-tags text-base leading-none"></i>
            <span class="text-xs capitalize">{{ $t('label.offers') }}</span>
        </router-link>

        <router-link :class="checkIsPathAndRoutePathSame('/login') ? 'text-primary' : ''" v-if="!logged"
            class="flex flex-col items-center gap-1" :to="{ name: 'auth.login' }">
            <i class="fa-solid fa-circle-user text-base leading-none"></i>
            <span class="text-xs capitalize">{{ $t('label.login') }}</span>
        </router-link>

        <button type="button" v-else class="user-profile-dropdown-box flex flex-col items-center gap-1">
            <i class="fa-solid fa-circle-user text-base leading-none"></i>
            <span class="text-xs capitalize">{{ $t('label.profile') }}</span>
        </button>
        <div v-if="!isPwaViewed" ref="pwaStickyFooter"
            class="lg:hidden border-none bg-white p-4 fixed bottom-0 left-0 w-full z-50 rounded-tl-3xl rounded-tr-3xl shadow-paper">
            <div class="flex items-start gap-3 mb-3">
                <img :src="setting.theme_favicon_logo" alt="theme-favicon-logo"
                    class="w-8 h-8 rounded-lg flex-shrink-0 shadow-xl">
                <h3 class="text-sm flex-auto text-[#008BBA]">
                    {{ $t('message.add') }}
                    {{ setting.company_name }}
                    {{ $t('message.app_to_your_home_screen') }} ?
                </h3>
            </div>
            <div class="flex items-center justify-end gap-2">
                <button @click.prevent="closePwaModal"
                    class="py-2 px-3 rounded-md capitalize text-sm border border-gray-200 text-primary">{{ $t('button.cancel') }}</button>
                <button @click.prevent="closePwaModal" id="installPWAsm"
                    class="py-2 px-3 rounded-md capitalize text-sm bg-primary text-white">{{ $t('button.install') }}</button>
            </div>
        </div>
    </nav>
</template>

<script>
import statusEnum from "../../../enums/modules/statusEnum";
export default {
    name: "FrontendMobileNavBarComponent",
    data() {
        return {
            loading: {
                isActive: false,
            },
            currentRoute: "",
            categoryProps: {
                search: {
                    paginate: 0,
                    order_column: 'sort',
                    order_type: 'asc',
                    status: statusEnum.ACTIVE
                },
                slug: '',
            },
        };
    },
    watch: {
        $route(to, from) {
            this.currentRoute = to.path;
        },
        categories: {
            deep: true,
            handler(category) {
                if (category.length > 0) {
                    if (category[0].slug !== "undefined") {
                        this.categoryProps.slug = category[0].slug;
                    }
                }
            }
        }
    },
    computed: {
        logged: function () {
            return this.$store.getters.authStatus;
        },
        categories: function () {
            return this.$store.getters['frontendItemCategory/lists'];
        },
        isPwaViewed: function () {
            return localStorage.getItem('pwa_viewed') ? true : false;
        },
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
    },
    mounted() {
        this.currentRoute = this.$route.path;
        this.loading.isActive = true;
        this.$store.dispatch('frontendItemCategory/lists', this.categoryProps.search).then().catch();
        this.loading.isActive = false;
    },
    methods: {
        checkIsPathAndRoutePathSame(path) {
            if (this.currentRoute === path) {
                return true;
            }
        },
        closePwaModal: function () {
            const modalTarget = this.$refs.pwaStickyFooter;
            modalTarget?.classList?.add("hidden");
            localStorage.setItem('pwa_viewed', true);
        }
    }

}
</script>
