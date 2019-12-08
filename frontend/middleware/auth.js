import { LOCAL_STORAGE_KEY } from '~/store/auth'

export default async function ({ store, redirect }) {
  if (store.state.auth.user) {
    return null
  }

  let token = localStorage.getItem(LOCAL_STORAGE_KEY)

  if (!token) {
    return redirect('/signin')
  }

  token = JSON.parse(token)

  store.commit('auth/addToken', token)

  const user = await store.dispatch('auth/fetchUser', token)
  if (!user) {
    return redirect('/signin')
  }
}
