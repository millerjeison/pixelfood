<template>
    <div class="py-6 px-4 md:flex md:items-end md:justify-between md:gap-16 rounded-2xl shadow-xs bg-white">
        <form @submit.prevent="contact" class="block w-full md:w-[350px] md:flex-shrink-0">
            <h3 class="mb-6 text-[22px] font-semibold"> {{ $t("label.lets_get_in_touch") }}</h3>
            <div class="mb-4">
                <label class="text-sm capitalize mb-1 text-heading"> {{ $t("label.name") }} </label>
                <input type="text" v-model="form.name" :class="errors.name ? 'invalid' : ''" class="w-full h-12 rounded-lg border px-4 border-[#D9DBE9]">
                <small class="db-field-alert" v-if="errors.name">{{ errors.name[0] }}</small>
            </div>
            <div class="mb-4">
                <label class="text-sm capitalize mb-1 text-heading"> {{ $t("label.email") }} </label>
                <input type="email" v-model="form.email" :class="errors.email ? 'invalid' :''" class="w-full h-12 rounded-lg border px-4 border-[#D9DBE9]">
                <small class="db-field-alert" v-if="errors.email">{{ errors.email[0] }}</small>
            </div>
            <div class="mb-4">
                <label class="text-sm capitalize mb-1 text-heading"> {{ $t("label.message") }} </label>
                <textarea v-model="form.message" :class="errors.message ? 'invalid' : ''" class="w-full h-28 rounded-lg border py-2 px-4 resize-none border-[#D9DBE9]"></textarea>
                <small class="db-field-alert" v-if="errors.message">{{ errors.message[0] }}</small>
            </div>
            <button
                class="rounded-3xl text-center capitalize text-base h-12 leading-[48px] px-3 w-full text-white bg-primary">
                {{ $t("label.send_message") }}
            </button>
        </form>
        <figure class="md:flex-auto mt-9 md:mt-0 md:mb-[70px]">
            <img class="w-full" :src="APP_URL + '/images/contact/contact.png'" alt="contact">
        </figure>
    </div>
</template>

<script>
import ENV from "../../../config/env";
import axios from "axios";
import LoadingComponent from "../components/LoadingComponent";
import alertService from "../../../services/alertService";


export default {
    name: "ContactUsFormComponent",
    components: { LoadingComponent },

    data() {
        return {
            APP_URL: ENV.API_URL,
            loading: {
                isActive: false,
            },
            form: {
                name: '',
                email: '',
                message: ''
            },
            errors: {},
        }
    },
    methods: {
        contact: function () {
            const url = '/frontend/contact';
            this.loading.isActive = true;
            axios.post(url, this.form).then(res => {
                this.loading.isActive = false;
                this.form.name = "";
                this.form.email = "";
                this.form.message = "";
                this.errors = {};
                alertService.success(this.$t("message.message_send"));
            }).catch((err) => {
                this.loading.isActive = false;
                this.errors = err.response.data.errors;
            });
        }
    }
}
</script>
