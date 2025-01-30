<template>
  <section class="mb-24 sm:mb-16 mt-4 sm:mt-8">
    <div class="container">
      <h2 class="capitalize text-lg sm:text-2xl font-semibold mb-4 sm:mb-6 text-primary">
        {{ $t("label.all_offers") }}
      </h2>
      <OfferComponent :limit="limit" />
    </div>
  </section>
</template>

<script>
import OfferComponent from "../components/OfferComponent";

export default {
    name: "OffersComponent",
    components: {
        OfferComponent,
    },
    data() {
        return {
            limit: null,
        };
    },
};
</script>
