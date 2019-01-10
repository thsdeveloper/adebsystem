import store from '~/store'

export default (to, from, next) => {
    console.warn(store.getters['auth/user'].isRoleAdmin);
  if (store.getters['auth/user'].isRoleAdmin === false) {
    next({ name: 'not_permission' })
  } else {
    next()
  }
}
