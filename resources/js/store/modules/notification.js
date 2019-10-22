import * as types from '../mutation-types'
import axios from "axios";

// state
export const state = {
    notifications: [],
};

// getters
export const getters = {
    notifications: state => state.notifications,
};

// mutations
export const mutations = {
    //Busca todas as notificações
    [types.FETCH_NOTIFICATIONS] (state, { notifications }) {
        state.notifications = notifications
    },
    //Marca uma notificação como lida
    [types.MARK_AS_READ] (state, params) {
        let index = state.notifications.filter(notification => notification.id === params.id);
        state.notifications.splice(index, 1)
    },
    //Marca todas as notificações como lida
    [types.MARK_ALL_AS_READ] (state) {
        state.notifications = []
    },
    //Adiciona uma otificação na store
    [types.ADD_NOTIFICATION] (state, notification) {
        state.notifications.unshift(notification)
    },
};

// actions
export const actions = {
    async fetchNotifications({commit}) {
        try {
            const {data} = await axios.get('/api/notifications');
            commit(types.FETCH_NOTIFICATIONS, { notifications: data.notifications })
        }catch (e) {
            alert('Alguma coisa não deu certo!')
        }
    },

    async markAsRead({commit}, params) {
        try {
            await axios.put('/api/notification-read', params);
            commit(types.MARK_AS_READ, params)
        }catch (e) {
            alert('Erro no MarkAsRead da action!')
        }
    },

    async markAllAsRead({commit}) {
        try {
            await axios.put('/api/notification-all-read');
            commit(types.MARK_ALL_AS_READ)
        }catch (e) {
            alert('Erro no limpar todas MarkAsRead da action!')
        }
    },

    addNotification({commit}, notification){
        commit(types.ADD_NOTIFICATION, notification)
    }
};
