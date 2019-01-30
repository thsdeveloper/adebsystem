import store from '~/store'

export default (to, from, next) => {
    if (store.getters['auth/user'].role !== 'admin') {
        next({ name: 'not_permission' })
    } else {
        next()
    }
}
