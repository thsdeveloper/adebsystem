import store from '~/store'

export default (to, from, next) => {

  console.log('TO', to);
  console.log('from', from);
  console.log('next', next);
  console.log('Permissoes do user', store.getters['auth/user'].permissions);
  console.log('nome da rota', to.name);
  console.log('Tem permissção:', store.getters['auth/user'].permissions.indexOf(to.name) !== -1);

  if (store.getters['auth/user'].permissions.indexOf(to.name) !== -1) {
    next();
  } else {
    next({name: 'not_permission'});
  }
}
