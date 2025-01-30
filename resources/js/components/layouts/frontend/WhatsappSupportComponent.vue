<template>
    <button v-if="whatsappSetup.status === activityEnum.ENABLE && currentRoute !== 'frontend.checkout'" type="button"
        class="fixed bottom-20 lg:bottom-10 ltr:right-10 rtl:left-10 rounded-full w-12 h-12 text-center capitalize leading-12 text-white bg-[#16BE45]"
        @click="submit($e, true)">
        <i class="lab lab-whatsapp  !text-2xl"> </i>
    </button>
</template>

<script>
import activityEnum from '../../../enums/modules/activityEnum';
import router from '../../../router';
import env from "../../../config/env";

export default {
    name: 'WhatsappSupportComponent',
    data() {
        return {
            activityEnum: activityEnum,
            currentRoute:''
        }
    },
    computed: {
        branch: function () {
            return this.$store.getters['frontendBranch/show'];
        },
        countryCode: function () {
            return this.$store.getters['frontendCountryCode/show'];
        },
        whatsappSetup: function() {
            return this.$store.getters['frontendBranch/whatsappSetup'];
        }
    },
    mounted() {

        setTimeout(() => {
            if (this.branch) {
                this.$store.dispatch('frontendBranch/whatsappSetup', this.branch.id)
                    .then((res) => {

                    })
            }
        }, 2000);
    },
    methods: {
        submit: function(){
            let text = encodeURIComponent("Hi There !");

            if ( env.DEMO === "true" || env.DEMO === true || env.DEMO === "1" || env.DEMO === 1) {
                window.open("https://api.whatsapp.com/send?phone=" + this.countryCode.calling_code + '' + this.whatsappSetup.phone + "&text=" + text, "_blank");
             }else{
                 window.location = "https://api.whatsapp.com/send?phone=" + this.countryCode.calling_code + '' + this.whatsappSetup.phone + "&text=" + text;
             }
        }
    },
    watch: {
        $route(to, from) {
            if (to.query.s !== "undefined") {
                this.currentRoute =  to.name;
            }
        }
    }
}

</script>