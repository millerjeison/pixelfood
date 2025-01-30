import axios from "axios";
import appService from "../../../services/appService";

export const frontendBranch = {
    namespaced: true,
    state: {
        lists: [],
        show: {},
        whatsappSetup:{
            status:null,
            phone:null
        }
    },
    getters: {
        lists: function (state) {
            return state.lists;
        },
        show: function (state) {
            return state.show;
        },
        whatsappSetup: function(state) {
            return state.whatsappSetup;
        }
    },
    actions: {
        lists: function (context, payload) {
            return new Promise((resolve, reject) => {
                let url = "frontend/branch";
                if (payload) {
                    url = url + appService.requestHandler(payload);
                }
                axios.get(url).then((res) => {
                    if (typeof payload.vuex === "undefined" || payload.vuex === true) {
                        context.commit("lists", res.data.data);
                    }
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        show: function (context, payload) {
            if(payload) {
                return new Promise((resolve, reject) => {
                    axios.get(`frontend/branch/show/${payload}`).then((res) => {
                        context.commit("show", res.data.data);
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    });
                });
            }
        },
        whatsappSetup: function(context,payload) {
            return new Promise((resolve,reject) => {
                axios.get(`frontend/branch/whatsapp-setup/${payload}`)
                .then((res) => {
                    resolve(res);
                    context.commit("whatsappSetup", res.data.data);
                })
                .catch((err) => {
                    reject(err);
                })
            })
        },
    },
    mutations: {
        lists: function (state, payload) {
            state.lists = payload;
        },
        show: function (state, payload) {
            state.show = payload;
        },
        whatsappSetup: function (state, payload){
            state.whatsappSetup = {
                status:payload.status,
                phone:payload.phone

            }
        }
    },
};
