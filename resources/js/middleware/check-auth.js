import store from '~/store';

export default async (to, from, next) => {
  if (!store.getters['auth/check'] && store.getters['auth/token']) {
    await store.dispatch('auth/fetchUser');
  }

  next();
};
