import store from '~/store'

export default (to, from, next) => {
    // store.getters['auth/permission']
    // console.warn(store.getters['auth/permissions'].indexOf('sssadmin'));
    //console.log(store.getters['auth/user'].role);

  if (store.getters['auth/user'].role !== 'admin') {
    next({ name: 'not_permission' })
  } else {
    next()
  }
}
