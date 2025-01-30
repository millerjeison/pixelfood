<template>
    <LoadingComponent :props="loading"/>

    <div class="db-card db-tab-div active">
        <div class="db-card-header border-none">
            <h3 class="db-card-title">{{ $t("menu.whatsapp_order_setup") }}</h3>
            <div class="db-card-filter">
                <WhatsappCreateComponent :props="props"/>
            </div>
        </div>

        <div class="db-table-responsive">
            <table class="db-table stripe">
                <thead class="db-table-head">
                <tr class="db-table-head-tr">
                    <th class="db-table-head-th">{{ $t("label.branch") }}</th>
                    <th class="db-table-head-th">
                        {{ $t("label.phone") }}
                    </th>
                    <th class="db-table-head-th">
                        {{ $t("label.status") }}
                    </th>
                    <th class="db-table-head-th">
                        {{ $t("label.action") }}
                    </th>
                </tr>
                </thead>
                <tbody class="db-table-body" v-if="whatsapps.length > 0">
                <tr class="db-table-body-tr" v-for="whatsapp in whatsapps" :key="whatsapp">

                    <td class="db-table-body-td">
                        {{ whatsapp.branch?.name }}
                    </td>
                    <td class="db-table-body-td">
                        {{ whatsapp.phone }}
                    </td>
                    <td class="db-table-body-td">
                            <span :class="statusClass(whatsapp.status)">
                                {{ enums.activityEnumArray[whatsapp.status] }}
                            </span>
                    </td>
                    <td class="db-table-body-td">
                        <div class="flex justify-start items-center sm:items-start sm:justify-start gap-1.5">
                            <SmModalEditComponent @click="edit(whatsapp)"/>
                            <SmDeleteComponent @click="destroy(whatsapp.id)" />
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "../../components/LoadingComponent";
import WhatsappCreateComponent from "./WhatsappCreateComponent";
import alertService from "../../../../services/alertService";
import appService from "../../../../services/appService";
import activityEnum from "../../../../enums/modules/activityEnum";
import TableLimitComponent from "../../components/TableLimitComponent";
import SmDeleteComponent from "../../components/buttons/SmDeleteComponent";
import SmModalEditComponent from "../../components/buttons/SmModalEditComponent";

export default {
    name: "WhatsappListComponent",
    components: {
        TableLimitComponent,
        WhatsappCreateComponent,
        LoadingComponent,
        SmDeleteComponent,
        SmModalEditComponent,
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                activityEnum: activityEnum,
                activityEnumArray: {
                    [activityEnum.ENABLE]: this.$t("label.enable"),
                    [activityEnum.DISABLE]: this.$t("label.disable"),
                },
            },
            props: {
                form: {
                    branch_id: null,
                    phone:"",
                    status: activityEnum.ENABLE,
                },
                search: {
                    order_column: "id",
                    order_type: "desc",
                },
            }
        };
    },
    mounted() {
        this.list();
    },
    computed: {
        whatsapps: function () {
            return this.$store.getters["whatsapp/lists"];
        }
    },
    methods: {
        statusClass: function (status) {
            return appService.statusClass(status);
        },
        list: function () {
            this.loading.isActive = true;
            this.$store.dispatch("whatsapp/lists", this.props.search).then((res) => {
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
        edit: function (whatsapp) {
            appService.modalShow();
            this.loading.isActive = true;
            this.$store.dispatch("whatsapp/edit", whatsapp.id);
            this.props.form = {
                branch_id: whatsapp.branch.id,
                phone: whatsapp.phone,
                status: whatsapp.status,
            };
            this.loading.isActive = false;
        },
        destroy: function (id) {
            appService
                .destroyConfirmation()
                .then((res) => {
                    try {
                        this.loading.isActive = true;
                        this.$store
                            .dispatch("whatsapp/destroy", {
                                id: id,
                                search: this.props.search,
                            })
                            .then((res) => {
                                this.loading.isActive = false;
                                alertService.successFlip(null, this.$t("menu.whatsapp_order_setup"));
                            })
                            .catch((err) => {
                                this.loading.isActive = false;
                                alertService.error(err.response.data.message);
                            });
                    } catch (err) {
                        this.loading.isActive = false;
                        alertService.error(err.response.data.message);
                    }
                })
                .catch((err) => {
                    this.loading.isActive = false;
                });
        },
    },
};
</script>
