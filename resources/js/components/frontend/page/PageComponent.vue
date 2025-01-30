<template>
    <section class="pt-8 pb-16">
        <div class="container max-w-3xl">
            <div class="mb-6">
                <h2 class="text-[26px] leading-10 font-semibold capitalize mb-2"> {{ page.title }}</h2>
                <div v-if="page.image" class="w-full mb-6">
                    <img :src="page.image" alt="image">
                </div>
                <p v-html="page.description" class="text-xs text-heading !whitespace-pre-wrap"> </p>
            </div>
            <TemplateManagerComponent :templateId="page.template_id" />
            <div class="mb-12 md:mb-20">
                <h2 class="text-[22px] leading-[34px] font-medium capitalize mb-3"> {{ $t("label.support") }} </h2>
                <ul class="flex flex-col gap-2">
                    <li class="flex items-center gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.33334 5.66634C1.33334 3.33301 2.66668 2.33301 4.66668 2.33301H11.3333C13.3333 2.33301 14.6667 3.33301 14.6667 5.66634V10.333C14.6667 12.6663 13.3333 13.6663 11.3333 13.6663H4.66668"
                                stroke="#6E7191" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M11.3333 6L9.24665 7.66667C8.55999 8.21333 7.43332 8.21333 6.74665 7.66667L4.66666 6"
                                stroke="#6E7191" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M1.33334 11H5.33334" stroke="#6E7191" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1.33334 8.33301H3.33334" stroke="#6E7191" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-sm leading-6 text-heading">{{ setting.company_email }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 5.25C12 3.92392 11.4732 2.65215 10.5355 1.71447C9.59785 0.776784 8.32608 0.25 7 0.25C5.69021 0.249764 4.43263 0.763487 3.49763 1.68072C2.56264 2.59795 2.02489 3.84545 2 5.155C1.60218 5.155 1.22064 5.31304 0.93934 5.59434C0.658035 5.87564 0.5 6.25718 0.5 6.655V8.655C0.5 9.05282 0.658035 9.43436 0.93934 9.71566C1.22064 9.99696 1.60218 10.155 2 10.155H3C3.39782 10.155 3.77936 9.99696 4.06066 9.71566C4.34196 9.43436 4.5 9.05282 4.5 8.655V6.655C4.5 6.25718 4.34196 5.87564 4.06066 5.59434C3.77936 5.31304 3.39782 5.155 3 5.155C3.02481 4.11069 3.45716 3.11751 4.20464 2.38779C4.95211 1.65807 5.95539 1.24971 7 1.25C8.06087 1.25 9.07828 1.67143 9.82843 2.42157C10.5786 3.17172 11 4.18913 11 5.25C10.6022 5.25 10.2206 5.40804 9.93934 5.68934C9.65804 5.97064 9.5 6.35218 9.5 6.75V8.75C9.50134 9.08062 9.61187 9.40153 9.81441 9.66285C10.017 9.92417 10.3002 10.1112 10.62 10.195C10.242 10.8817 9.6103 11.3932 8.86 11.62C8.73986 11.3604 8.54799 11.1406 8.30703 10.9864C8.06607 10.8323 7.78605 10.7502 7.5 10.75H6.5C6.10218 10.75 5.72064 10.908 5.43934 11.1893C5.15804 11.4706 5 11.8522 5 12.25C5 12.6478 5.15804 13.0294 5.43934 13.3107C5.72064 13.592 6.10218 13.75 6.5 13.75H7.5C7.83128 13.7484 8.1527 13.6371 8.4141 13.4336C8.67551 13.2301 8.86218 12.9458 8.945 12.625C9.55924 12.475 10.1292 12.1816 10.6081 11.7688C11.087 11.3559 11.4612 10.8354 11.7 10.25H12C12.3978 10.25 12.7794 10.092 13.0607 9.81066C13.342 9.52936 13.5 9.14782 13.5 8.75V6.75C13.5 6.35218 13.342 5.97064 13.0607 5.68934C12.7794 5.40804 12.3978 5.25 12 5.25ZM3.5 6.655V8.655C3.5 8.78761 3.44732 8.91479 3.35355 9.00855C3.25979 9.10232 3.13261 9.155 3 9.155H2C1.86739 9.155 1.74021 9.10232 1.64645 9.00855C1.55268 8.91479 1.5 8.78761 1.5 8.655V6.655C1.5 6.52239 1.55268 6.39521 1.64645 6.30145C1.74021 6.20768 1.86739 6.155 2 6.155H3C3.13261 6.155 3.25979 6.20768 3.35355 6.30145C3.44732 6.39521 3.5 6.52239 3.5 6.655ZM7.5 12.75H6.5C6.36739 12.75 6.24021 12.6973 6.14645 12.6036C6.05268 12.5098 6 12.3826 6 12.25C6 12.1174 6.05268 11.9902 6.14645 11.8964C6.24021 11.8027 6.36739 11.75 6.5 11.75H7.5C7.63261 11.75 7.75979 11.8027 7.85355 11.8964C7.94732 11.9902 8 12.1174 8 12.25C8 12.3826 7.94732 12.5098 7.85355 12.6036C7.75979 12.6973 7.63261 12.75 7.5 12.75ZM12.5 8.75C12.5 8.88261 12.4473 9.00979 12.3536 9.10355C12.2598 9.19732 12.1326 9.25 12 9.25H11C10.8674 9.25 10.7402 9.19732 10.6464 9.10355C10.5527 9.00979 10.5 8.88261 10.5 8.75V6.75C10.5 6.61739 10.5527 6.49021 10.6464 6.39645C10.7402 6.30268 10.8674 6.25 11 6.25H12C12.1326 6.25 12.2598 6.30268 12.3536 6.39645C12.4473 6.49021 12.5 6.61739 12.5 6.75V8.75Z"
                                fill="#6E7191" />
                        </svg>
                        <span class="text-sm font-medium leading-6 text-heading">{{ setting.company_phone }}</span>
                    </li>
                </ul>
            </div>
            <ContactUsFormComponent v-if="page.template_id === 1"/>
        </div>
    </section>
</template>

<script>
import TemplateManagerComponent from "../components/TemplateManagerComponent";
import ContactUsFormComponent from "./ContactUsFormComponent";
import ENV from "../../../config/env";

export default {
    name: "PageComponent",
    components: { TemplateManagerComponent,ContactUsFormComponent },
    data() {
        return {
            APP_URL: ENV.API_URL,
        }
    },
    computed: {
        page: function () {
            return this.$store.getters['frontendPage/show'];
        },
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        },
    },
    mounted() {
        this.pageSetup();
    },
    methods: {
        pageSetup: function () {
            if (Object.keys(this.$route.params).length > 0 && typeof this.$route.params.slug === 'string') {
                this.$store.dispatch('frontendPage/show', this.$route.params.slug).then(res => {

                }).catch((err) => { })
            }
        }
    },
    watch: {
        $route() {
            this.pageSetup();
        }
    }
}
</script>
