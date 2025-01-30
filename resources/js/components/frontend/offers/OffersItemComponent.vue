<template>
    <LoadingComponent :props="loading" />
    <section class="mb-24 sm:mb-16 mt-4 sm:mt-8">
        <div class="container">
            <div class="flex gap-2 sm:gap-4 items-start justify-between mb-4 sm:mb-6">
                <h2 class="capitalize text-lg sm:text-2xl font-semibold text-primary">
                    {{ offer.name }}
                </h2>
                <div class="flex items-center gap-3">
                    <button type="button" class="lab lab-row-vertical lab-font-size-20 text-xl"
                        v-on:click="itemProps.design = itemDesignEnum.LIST"
                        :class="itemProps.design === itemDesignEnum.LIST ? 'text-heading' : 'text-[#A0A3BD]'"></button>
                    <button type="button" class="lab lab-element-3 lab-font-size-20 text-xl"
                        v-on:click="itemProps.design = itemDesignEnum.GRID"
                        :class="itemProps.design === itemDesignEnum.GRID ? 'text-heading' : 'text-[#A0A3BD]'"></button>
                </div>
            </div>
            <ItemComponent :items="items.items" :type="itemProps.type" :design="itemProps.design" />
        </div>
    </section>
</template>

<script>
import ItemComponent from "../components/ItemComponent";
import itemDesignEnum from "../../../enums/modules/itemDesignEnum";
import alertService from "../../../services/alertService";
import LoadingComponent from "../components/LoadingComponent";

export default {
    name: "OffersItemComponent",
    components: {
        ItemComponent, LoadingComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            itemDesignEnum: itemDesignEnum,
            offer: {},
            items: {},
            itemProps: {
                design: itemDesignEnum.LIST,
                type: null,
            },
            route: null,
        };
    },
    mounted() {
        if (typeof this.$route.params.slug !== "undefined") {
            this.loading.isActive = true;
            this.$store.dispatch("frontendOffer/offerItems", {
                slug: this.$route.params.slug,
                vuex: false,
            }).then((res) => {
                this.offer = res.data.data;
                this.items = res.data.data;
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        }
    },
    methods: {
        itemTypeSet: function (e) {
            this.itemProps.type = e;
        },
        itemTypeReset: function () {
            this.itemProps.type = null;
        },
    },
};
</script>
