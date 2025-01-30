<template>
    <LoadingComponent :props="loading" />
    <SmModalCreateComponent :props="addButton" />

    <div id="modal" class="modal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">{{ $t("menu.whatsapp_order_setup") }}</h3>
                <button class="modal-close fa-solid fa-xmark text-xl text-slate-400 hover:text-red-500"
                    @click="reset"></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="save">
                    <div class="form-row">

                        <div class="form-col-12 sm:form-col-6">
                            <label for="branch_id" class="db-field-title required">{{ $t("label.branch") }}</label>
                            <vue-select class="db-field-control f-b-custom-select" id="branch_id"
                                v-bind:class="errors.branch_id ? 'invalid' : ''" v-model="props.form.branch_id"
                                :options="branches" label-by="name" value-by="id" :closeOnSelect="true" :searchable="true"
                                :clearOnClose="true" placeholder="--" search-placeholder="--" />
                            <small class="db-field-alert" v-if="errors.branch_id">{{
                                errors.branch_id[0]
                            }}</small>
                        </div>

                        <div class="form-col-12 sm:form-col-6">
                            <label for="phone" class="db-field-title required">
                                {{ $t("label.phone") }}

                            </label>
                            <div class="w-full h-10 rounded-lg border px-4 flex items-center border-[#D9DBE9]"
                                :class="errors.phone ? 'invalid' : ''">
                                <div class="w-fit flex-shrink-0 dropdown-group">
                                    <button type="button" class="flex items-center gap-1 dropdown-btn">
                                        {{ countryCode.flag_emoji }}
                                        <span class="whitespace-nowrap flex-shrink-0 text-xs">
                                            {{ countryCode.calling_code }}
                                        </span>
                                    </button>
                                </div>
                                <input v-on:keypress="phoneNumber($event)" v-model="props.form.phone" type="text" id="phone"
                                    class="pl-4 text-sm w-full h-full text-heading" />
                            </div>


                            <small class="db-field-alert" v-if="errors.phone">{{
                                errors.phone[0]
                            }}</small>
                        </div>
                        <div class="form-col-12 sm:form-col-6">
                            <label class="db-field-title required" for="enable">{{ $t("label.status") }}</label>
                            <div class="db-field-radio-group">
                                <div class="db-field-radio">
                                    <div class="custom-radio">
                                        <input :value="enums.activityEnum.ENABLE" v-model="props.form.status" id="enable"
                                            type="radio" class="custom-radio-field" />
                                        <span class="custom-radio-span"></span>
                                    </div>
                                    <label for="enable" class="db-field-label">{{ $t("label.enable") }}</label>
                                </div>
                                <div class="db-field-radio">
                                    <div class="custom-radio">
                                        <input :value="enums.activityEnum.DISABLE" v-model="props.form.status" type="radio"
                                            id="disable" class="custom-radio-field" />
                                        <span class="custom-radio-span"></span>
                                    </div>
                                    <label for="disable" class="db-field-label">{{ $t("label.disable") }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-col-12">
                            <div class="modal-btns">
                                <button type="button" class="modal-btn-outline modal-close" @click="reset">
                                    <i class="lab lab-close"></i>
                                    <span>{{ $t("button.close") }}</span>
                                </button>

                                <button type="submit" class="db-btn py-2 text-white bg-primary">
                                    <i class="lab lab-save"></i>
                                    <span>{{ $t("button.save") }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import SmModalCreateComponent from "../../components/buttons/SmModalCreateComponent";
import LoadingComponent from "../../components/LoadingComponent";
import activityEnum from "../../../../enums/modules/activityEnum";
import alertService from "../../../../services/alertService";
import appService from "../../../../services/appService";

export default {
    name: "WhatsappCreateComponent",
    components: { SmModalCreateComponent, LoadingComponent },
    props: ["props"],
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                activityEnum: activityEnum,
            },
            errors: {},
        };
    },
    mounted() {
        this.$store.dispatch("branch/lists", {paginate:0});
    },
    computed: {
        addButton: function () {
            return { title: this.$t("button.add_whatsapp") }
        },
        countryCode: function () {
            return this.$store.getters['frontendCountryCode/show'];
        },
        branches: function () {
            return this.$store.getters["branch/lists"];
        },
    },
    methods: {
        phoneNumber(e) {
            return appService.phoneNumber(e);
        },
        reset: function () {
            appService.modalHide();
            this.$store.dispatch("whatsapp/reset").then().catch();
            this.errors = {};
            this.$props.props.form = {
                branch_id: null,
                phone: "",
                status: activityEnum.ENABLE
            };
        },

        save: function () {
            try {
                const tempId = this.$store.getters["whatsapp/temp"].temp_id;
                this.loading.isActive = true;
                this.$store.dispatch("whatsapp/save", this.props).then((res) => {
                    appService.modalHide();
                    this.loading.isActive = false;
                    alertService.successFlip(
                        tempId === null ? 0 : 1,
                        this.$t("menu.whatsapp_order_setup")
                    );
                    this.props.form = {
                        branch_id: null,
                        phone: "",
                        status: activityEnum.DISABLE
                    };
                    this.errors = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = err.response.data.errors;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },
    },
};
</script>
