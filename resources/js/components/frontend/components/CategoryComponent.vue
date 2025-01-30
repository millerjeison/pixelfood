<template>
    <Swiper dir="ltr" :speed="1000" slidesPerView="auto" :spaceBetween="16" class="menu-slides">
        <SwiperSlide v-for="category in categories" :key="category" class="!w-fit">
            <router-link v-if="design === categoryDesignEnum.FIRST"
                :to="{ name: 'frontend.menu', query: { s: category.slug } }"
                class="w-[5.5rem] sm:w-32 h-[5.5rem] sm:h-32 flex flex-col items-center justify-center text-center gap-2 sm:gap-4 px-1.5 sm:p-3 rounded-2xl border-b-2 border-transparent transition hover:bg-[#D8FFFC] bg-[#F7F7FC]">
                <img class="h-7 sm:h-12 drop-shadow-category" :src="category.thumb" alt="category">
                <h3 class="text-[9px] leading-[14px] sm:leading-4 sm:text-xs font-medium">{{ category.name }}</h3>
            </router-link>

            <router-link :class="checkIsQueryAndRouteQuerySame(category.slug) ? 'menu-category-active' : ''"
                v-else-if="design === categoryDesignEnum.SECOND"
                :to="{ name: 'frontend.menu', query: { s: category.slug } }"
                class="w-[5.5rem] sm:w-32 h-[5.5rem] sm:h-32 flex flex-col items-center justify-center text-center gap-2 sm:gap-4 px-1.5 sm:p-3 rounded-2xl border-b-2 border-transparent transition hover:bg-[#D8FFFC]">
                <img class="h-7 sm:h-12 drop-shadow-category" :src="category.thumb" alt="category">
                <h3 class="text-[9px] leading-[14px] sm:leading-4 sm:text-xs font-medium">{{ category.name }}</h3>
            </router-link>
        </SwiperSlide>
    </Swiper>
</template>

<script>

import categoryDesignEnum from "../../../enums/modules/categoryDesignEnum";
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

export default {
    name: "CategoryComponent",
    props: {
        categories: Object,
        design: Number
    },
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            currentCategory: "",
            categoryDesignEnum: categoryDesignEnum,
        }
    },
    mounted() {
        if (this.$route.query.s !== "undefined") {
            this.currentCategory = this.$route.query.s;
        }
    },
    methods: {
        submit: function (msg, e) {
            e.stopPropagation()
        },
        checkIsQueryAndRouteQuerySame(query) {
            if (this.currentCategory === query) {
                return true;
            }
        },
    },
    watch: {
        $route(to, from) {
            if (to.query.s !== "undefined") {
                this.currentCategory = to.query.s;
            }
        }
    }
}
</script>