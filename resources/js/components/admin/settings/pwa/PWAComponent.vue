<template>
    <LoadingComponent :props="loading" />
    <div class="db-card db-tab-div active">
        <div class="db-card-header">
            <h3 class="db-card-title">{{ $t("menu.progressive_web_app") }}</h3>
        </div>
        <div class="mb-4 bg-red-100 p-2 pl-4 ">
            <h2 class="mb-1">{{ $t('label.reminder') }}</h2>
            <p>{{ $t('message.pwa_image_remainder') }}</p>
        </div>
        <div class="db-card-body">
            <form @submit.prevent="save">
                <div class="form-row">
                    <div class="form-col-12  sm:form-col-5">
                        <label for="splash" class="db-field-title required">
                            {{ $t("label.splash") }} (2048px,2732px)
                        </label>
                        <input @change="changeSplash" v-bind:class="errors.pwa_splash ? 'invalid' : ''" id="splash"
                            type="file" class="db-field-control" ref="splashProperty"
                            accept="image/png, image/jpeg, image/jpg" />
                        <small class="db-field-alert" v-if="errors.pwa_splash">{{
                            errors.pwa_splash[0]
                        }}</small>
                    </div>
                    <div class="form-col-12  sm:form-col-5">
                        <label for="icon" class="db-field-title required">
                            {{ $t("label.icon") }} (512px,512px)
                        </label>
                        <input @change="changeIcon" v-bind:class="errors.pwa_icon ? 'invalid' : ''" id="icon" type="file"
                            class="db-field-control" ref="iconProperty" accept="image/png, image/jpeg, image/jpg" />
                        <small class="db-field-alert" v-if="errors.pwa_icon">{{
                            errors.pwa_icon[0]
                        }}</small>
                    </div>

                    <div class="form-col-2 sm:form-col-2 mt-6">
                        <button type="submit" class="db-btn text-white bg-primary">
                            <i class="lab lab-fill-save"></i>
                            <span>{{ $t("button.save") }}</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="row mt-4">
                <div class="col-6 sm:col-3">
                    <h3 class="text-lg font-medium capitalize mb-2 text-paragraph">
                        {{ $t("label.splash") }}
                    </h3>
                    <img class="db-image" alt="splash" :src="pwa.splash" />
                </div>
                <div class="col-6 sm:col-3">
                    <h3 class="text-lg font-medium capitalize mb-2 text-paragraph">
                        {{ $t("label.icon") }}
                    </h3>
                    <img class="db-image" alt="icon" :src="pwa.icon" />
                </div>
            </div>

        </div>
    </div>
</template>
<script lang="js">
import LoadingComponent from "../../components/LoadingComponent";
import alertService from "../../../../services/alertService";
export default {
    name: 'PWAComponent',
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            splash: "",
            icon: "",
            errors: {},
        }
    },
    mounted() {
        this.$store.dispatch("pwa/lists");
    },
    computed: {
        pwa: function () {
            return this.$store.getters["pwa/lists"];
        }
    },
    methods: {
        changeSplash: function (e) {
            this.splash = e.target.files[0];
        },
        changeIcon: function (e) {
            this.icon = e.target.files[0];
        },
        save: function () {
            try {
                const form = new FormData();
                form.append('pwa_splash', this.splash);
                form.append('pwa_icon', this.icon)

                this.loading.isActive = true;
                this.$store
                    .dispatch("pwa/save", {
                        form: form,
                    })
                    .then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(1, this.$t("menu.progressive_web_app"));
                        this.errors = {};
                        this.$refs.splashProperty.value = null;
                        this.$refs.iconProperty.value = null;
                    })
                    .catch((err) => {
                        this.loading.isActive = false;
                        this.errors = err.response.data.errors;
                    });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        }
    }
}
</script>